<?php

/**
 * كلاس CreatePaymentIntent
 * ------------------------
 * هذا الكلاس مسؤول عن إنشاء عملية دفع جديدة (Payment Intent) وحفظها في قاعدة البيانات.
 * يقوم بتنفيذ الخطوات التالية:
 *   1. جلب العنصر القابل للدفع (Payable) من السيشن.
 *   2. بناء بيانات الدفع الأساسية (Payload).
 *   3. تحديد استراتيجية الدفع المناسبة وتطبيقها.
 *   4. التواصل مع بوابة الدفع (Gateway) للحصول على استجابة الدفع.
 *   5. حفظ عملية الدفع في قاعدة البيانات بشكل آمن (داخل Transaction).
 *
 * مثال استخدام:
 * --------------
 * $action = new \App\Actions\Payment\CreatePaymentIntent();
 * $payment = $action->execute($paymentRequest);
 * // $payment هو كائن Payment تم حفظه في قاعدة البيانات.
 */

namespace App\Actions\Payment;

use App\Contract\User\Request\PaymentRequest;
use App\DTOs\Payment\PaymentPayloadDTO;
use App\DTOs\Payment\PaymentResponseDTO;
use App\Exceptions\Payment\PayableNotFoundException;
use App\Exceptions\Payment\PaymentGatewayException;
use App\Services\Payment\Strategies\PaymentMethodStrategy;
use App\Models\Payment;
use App\Services\Payment\Strategies\PaymentMethodStrategyFactory;
use App\Services\PaymentGateway;
use App\Services\Coupon\CouponCalculator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Exception;

// =========================
// Refactored Action
// =========================
class CreatePaymentIntent implements \App\Contract\Actions\CreatePaymentIntent
{
    /**
     * @var int|null $payable_id
     * معرف العنصر القابل للدفع (مثلاً: رقم الطلب أو المنتج)، يتم جلبه من السيشن.
     */
    protected ?int $payable_id;

    /**
     * @var string|null $payable_type
     * نوع العنصر القابل للدفع (اسم الكلاس الكامل)، يتم جلبه من السيشن.
     */
    protected ?string $payable_type;

    /**
     * المُنشئ (Constructor)
     * يقوم بجلب معرف ونوع العنصر القابل للدفع من السيشن وتخزينها في الخصائص.
     */
    public function __construct()
    {
        $this->payable_id = session('payable_id');
        $this->payable_type = session('payable_type');
    }

    /**
     * execute
     * -------
     * ينفذ عملية إنشاء الدفع وحفظها في قاعدة البيانات.
     *
     * @param PaymentRequest $request
     *      كائن يحتوي على بيانات الطلب الخاصة بالدفع (مثل نوع البطاقة، رقم الجوال، إلخ).
     * @return Payment
     *      كائن الدفع الذي تم حفظه في قاعدة البيانات.
     *
     * خطوات التنفيذ:
     *   1. جلب بيانات الطلب والمستخدم.
     *   2. جلب العنصر القابل للدفع أو رمي استثناء إذا لم يوجد.
     *   3. بناء بيانات الدفع الأساسية.
     *   4. تحديد استراتيجية الدفع وتطبيقها.
     *   5. التواصل مع بوابة الدفع.
     *   6. حفظ عملية الدفع في قاعدة البيانات.
     */
    public function execute(PaymentRequest $request): Payment
    {
        $data = $request->all();
        $user = auth()->user();

        $payable = $this->getPayableOrFail();

        $pricing = app(CouponCalculator::class)->calculate($data['coupon_code'] ?? null, $payable);

        // 1) بناء بيانات الدفع الأساسية
        $payload = $this->buildBasePayload(
            $data,
            $payable,
            $user?->name,
            $user?->email,
            $user?->phone,
            $pricing['final_price_halalas'],
            $pricing,
        );

        // 2) تحديد استراتيجية الدفع وتطبيقها
        $strategy = $this->resolveStrategy($data['cc_type'] ?? null);
        $payload = $strategy->apply($payload, $data);

        // 3) أستدعاء بوابة الدفع خارج معاملة قاعدة البيانات
        $responseDTO = $this->callGateway($payload);

        // 4) تحفظ الدفع في قاعدة البيانات بشكل آمن
        return $this->persistPayment($responseDTO, $payable, $user?->id, $pricing);
    }

    // =========================
    // Helpers
    // =========================

    /**
     * getPayableOrFail
     * ----------------
     * يجلب العنصر القابل للدفع (Payable) من قاعدة البيانات بناءً على النوع والمعرف.
     * إذا لم يوجد العنصر أو النوع غير صحيح، يرمي استثناء PayableNotFoundException.
     *
     * @return Model
     *      كائن العنصر القابل للدفع.
     * @throws PayableNotFoundException
     */
    protected function getPayableOrFail(): Model
    {
        $type = $this->payable_type;
        $id = $this->payable_id;

        if (!$type || !$id || !class_exists($type)) {
            throw new PayableNotFoundException('العنصر القابل للدفع غير موجود.');
        }

        $payable = $type::find($id);
        if (!$payable) {
            throw new PayableNotFoundException('العنصر القابل للدفع غير موجود.');
        }

        return $payable;
    }

    /**
     * buildBasePayload
     * ----------------
     * يبني كائن بيانات الدفع الأساسية (PaymentPayloadDTO) بناءً على بيانات الطلب والمستخدم والعنصر القابل للدفع.
     *
     * @param array $data
     *      بيانات الطلب.
     * @param Model $payable
     *      العنصر القابل للدفع.
     * @param string|null $userName
     *      اسم المستخدم (اختياري).
     * @param string|null $userEmail
     *      بريد المستخدم (اختياري).
     * @param string|null $userPhone
     *      رقم جوال المستخدم (اختياري).
     * @param int $amountInHalalas
     *      المبلغ النهائي المطلوب تحصيله (بالهللات) بعد الخصومات/الكوبون.
     * @param array $pricing
     *      تفاصيل التسعير (السعر الأساسي، الخصومات، الكوبون).
     * @return PaymentPayloadDTO
     *      كائن بيانات الدفع الأساسية.
     */
    protected function buildBasePayload(array $data, Model $payable, ?string $userName, ?string $userEmail, ?string $userPhone, int $amountInHalalas, array $pricing): PaymentPayloadDTO
    {
        return PaymentPayloadDTO::fromBase(
            amount: $amountInHalalas,
            currency: 'SAR',
            description: 'Payment for ' . ($payable->name ?? $payable->title ?? 'Item'),
            callbackUrl: route('client.pay.callback'),
            metadata: [
                'user_name' => $this->formatMetadataValue($userName),
                'user_email' => $this->formatMetadataValue($userEmail),
                'phone' => $this->formatMetadataValue($userPhone ?? ($data['phone'] ?? null)),
                'item' => $this->formatMetadataValue($payable->name ?? $payable->title ?? null),
                'item_id' => $this->formatMetadataValue($payable->id ?? $payable->uuid ?? null),
                'base_price' => $this->formatMetadataValue($pricing['price'] ?? ($payable->price ?? null)),
                'discount' => $this->formatMetadataValue($pricing['discount'] ?? 0),
                'membership_discount' => $this->formatMetadataValue($pricing['membership_discount'] ?? 0),
                'coupon_amount' => $this->formatMetadataValue($pricing['coupon_amount'] ?? 0),
                'coupon_code' => $this->formatMetadataValue($pricing['coupon']?->code ?? ($data['coupon_code'] ?? null)),
            ],
        );
    }

    /**
     * تطبيع قيم الميتاداتا إلى نص لعرضها بوضوح في بوابة الدفع.
     */
    protected function formatMetadataValue($value): string
    {
        if (is_null($value)) {
            return '-';
        }

        if (is_numeric($value)) {
            return (float) $value === 0.0 ? '-' : (string) $value;
        }

        $stringValue = is_string($value) ? trim($value) : (string) $value;

        return $stringValue === '' ? '-' : $stringValue;
    }

    /**
     * resolveStrategy
     * ---------------
     * يحدد استراتيجية الدفع المناسبة بناءً على نوع البطاقة أو طريقة الدفع.
     *
     * @param string|null $type
     *      نوع البطاقة أو طريقة الدفع (مثلاً: mada, visa, applepay).
     * @return PaymentMethodStrategy
     *      كائن الاستراتيجية المناسبة.
     */
    protected function resolveStrategy(?string $type): PaymentMethodStrategy
    {
        return PaymentMethodStrategyFactory::make($type);
    }

    /**
     * callGateway
     * -----------
     * يتواصل مع بوابة الدفع (Payment Gateway) لإنشاء عملية الدفع.
     * يتحقق من الاستجابة ويرمي استثناء في حال وجود خطأ.
     *
     * @param PaymentPayloadDTO $payload
     *      بيانات الدفع المُجهزة للإرسال للبوابة.
     * @return PaymentResponseDTO
     *      كائن استجابة الدفع من البوابة.
     * @throws PaymentGatewayException
     */
    protected function callGateway(PaymentPayloadDTO $payload): PaymentResponseDTO
    {
        try {
            $rawResponse = PaymentGateway::create($payload->toArray());

            // تحقق من نجاح العملية
            if (!$rawResponse->success) {

                $errorType    = $rawResponse->data['type']    ?? 'unknown_error';
                $errorMessage = $rawResponse->error           ?? 'حدث خطأ غير معروف في بوابة الدفع';

                // حالة Validation Failed
                if (
                    $errorType === 'invalid_request_error'
                    && isset($rawResponse->data['errors'])
                    && is_array($rawResponse->data['errors'])
                ) {

                    $validationErrors = [];

                    foreach ($rawResponse->data['errors'] as $field => $messages) {
                        foreach ((array) $messages as $msg) {
                            $validationErrors[] = "$field: $msg";
                        }
                    }

                    // دمج الأخطاء في رسالة واحدة واضحة
                    $detailedMessage = implode(' | ', $validationErrors);

                    throw new PaymentGatewayException(
                        "$detailedMessage",
                        422,
                    );
                }

                // أي خطأ آخر
                throw new PaymentGatewayException(
                    "خطأ في الدفع [$errorType]: $errorMessage"
                );
            }
        } catch (Exception $e) {
            if ($e->getCode() === 422) {
                throw $e;
            }
            // هذا يمسك فقط أخطاء الاتصال أو الاستثناءات الأخرى
            throw new PaymentGatewayException('فشل الاتصال ببوابة الدفع: ' . $e->getMessage(), $e->getCode());
        }

        $dto = PaymentResponseDTO::fromGatewayResponse($rawResponse);

        // Status-based failure (if provided)
        if (isset($dto->status) && !$dto->status->isInitiated()) {
            $message = $dto->errorMessage ?? 'تم رفض عملية الدفع من قبل بوابة الدفع.';
            throw new PaymentGatewayException($message);
        }

        return $dto;
    }

    /**
     * persistPayment
     * --------------
     * يحفظ عملية الدفع في قاعدة البيانات داخل Transaction لضمان الأمان.
     *
     * @param PaymentResponseDTO $responseDTO
     *      استجابة الدفع من البوابة.
     * @param Model $payable
     *      العنصر القابل للدفع.
     * @param int|null $userId
     *      معرف المستخدم (اختياري).
     * @param array $pricing
     *      تفاصيل التسعير/الخصومات بما فيها الكوبون.
     * @return Payment
     *      كائن الدفع الذي تم حفظه.
     */
    protected function persistPayment(PaymentResponseDTO $responseDTO, Model $payable, ?int $userId, array $pricing): Payment
    {
        return DB::transaction(function () use ($responseDTO, $payable, $userId, $pricing) {
            return Payment::create([
                'user_id' => $userId,
                'moyasar_id' => $responseDTO->id,
                'payable_id' => $payable->id,
                'payable_type' => get_class($payable),
                'amount' => $pricing['final_price'] ?? ($payable->regular_price ?? $payable->final_price),
                'currency' => 'SAR',
                'status' => $responseDTO->status ?: 'initiated',
                'source_type' => $responseDTO->sourceType,
                'company' => $responseDTO->company,
                'description' => $responseDTO->description,
                'raw_response' => $responseDTO->raw,
                'discount' => $pricing['discount'] ?? ($payable->discounted_price ? $payable->price - (int) $payable->discounted_price : 0),
                'membership_discount' => (int) ($pricing['membership_discount'] ?? ($payable->membership_discount ?? 0)),
                'original_price' => $pricing['base_price'] ?? ($payable->price ?? 0),
                'coupon_id' => $pricing['coupon']?->id,
                'coupon_code' => $pricing['coupon']?->code,
                'coupon_amount' => (int) ($pricing['coupon_amount'] ?? 0),
            ]);
        });
    }
}
