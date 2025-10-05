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

        // 1) بناء بيانات الدفع الأساسية
        $payload = $this->buildBasePayload($data, $payable, $user?->name, $user?->email, $user?->phone);

        // 2) تحديد استراتيجية الدفع وتطبيقها
        $strategy = $this->resolveStrategy($data['cc_type'] ?? null);
        $payload = $strategy->apply($payload, $data);

        // 3) أستدعاء بوابة الدفع خارج معاملة قاعدة البيانات
        $responseDTO = $this->callGateway($payload);

        // 4) تحفظ الدفع في قاعدة البيانات بشكل آمن
        return $this->persistPayment($responseDTO, $payable, $user?->id);
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
     * @return PaymentPayloadDTO
     *      كائن بيانات الدفع الأساسية.
     */
    protected function buildBasePayload(array $data, Model $payable, ?string $userName, ?string $userEmail, ?string $userPhone): PaymentPayloadDTO
    {
        return PaymentPayloadDTO::fromBase(
            amount: (int) ($payable->regular_price_in_halalas ?? 0),
            currency: 'SAR',
            description: 'Payment for ' . ($payable->name ?? 'item'),
            callbackUrl: route('client.pay.callback'),
            metadata: [
                'user_name' => $userName,
                'user_email' => $userEmail,
                'phone' => $userPhone ?? ($data['phone'] ?? null),
                'item' => $payable->name ?? null,
                'item_id' => $payable->id ?? null,
            ],
        );
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
        } catch (Exception $e) {
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
     * @return Payment
     *      كائن الدفع الذي تم حفظه.
     */
    protected function persistPayment(PaymentResponseDTO $responseDTO, Model $payable, ?int $userId): Payment
    {
        return DB::transaction(function () use ($responseDTO, $payable, $userId) {
            return Payment::create([
                'user_id' => $userId,
                'moyasar_id' => $responseDTO->id,
                'payable_id' => $payable->id,
                'payable_type' => get_class($payable),
                'amount' => $payable->regular_price, // keep in SAR if your column expects SAR
                'currency' => 'SAR',
                'status' => $responseDTO->status ?: 'initiated',
                'source_type' => $responseDTO->sourceType,
                'company' => $responseDTO->company,
                'description' => $responseDTO->description,
                'raw_response' => $responseDTO->raw,
            ]);
        });
    }
}
