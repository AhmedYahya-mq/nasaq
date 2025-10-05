<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Enums\PaymentStatus;

/**
 * خدمة التعامل مع Moyasar API.
 *
 * تشمل إنشاء الدفع، جلب التفاصيل، استرجاع الدفع، وعرض جميع العمليات.
 * النتيجة ترجع ككائن يحتوي على الخصائص مباشرة مثل موديل Eloquent.
 *
 * @property bool $success حالة نجاح العملية
 * @property array $data بيانات العملية كما ترجعها API
 * @property string|null $status حالة الدفع مباشرة
 * @property string|null $error رسالة الخطأ إذا وجدت
 */
class PaymentGateway
{
    /**
     * رابط الـ API الأساسي
     * @var string
     */
    protected string $baseUrl;

    /**
     * مفتاح الـ API
     * @var string
     */
    protected string $apiKey;

    // ===== خصائص النتيجة =====

    /**
     * حالة نجاح العملية
     * @var bool
     */
    public bool $success = false;

    /**
     * بيانات العملية كما ترجعها API
     * @var array
     */
    public array $data = [];

    /**
     * حالة الدفع مباشرة
     * @var string|null
     */
    public ?string $status = null;

    /**
     * رسالة الخطأ إذا وجدت
     * @var string|null
     */
    public ?string $error = null;

    /**
     * إنشاء كائن جديد من الخدمة.
     *
     * @param array $attributes خصائص يمكن تعبئتها عند الإنشاء
     */
    public function __construct(array $attributes = [])
    {
        $this->baseUrl = config('moyasar.base_url', 'https://api.moyasar.com/v1');
        $this->apiKey  = config('moyasar.secret_key');
        $this->fill($attributes);
    }

    /**
     * تعبئة خصائص الكائن من مصفوفة.
     *
     * @param array $attributes
     * @return $this
     */
    public function fill(array $attributes): static
    {
        foreach (['success', 'data', 'status', 'error'] as $field) {
            if (array_key_exists($field, $attributes)) {
                $this->$field = $attributes[$field];
            }
        }

        // توحيد التعامل مع status: إذا كان موجود داخل data أو attributes
        $this->status = $attributes['status'] ?? $this->data['status'] ?? null;

        // يمكن إضافة خصائص مستقبلية هنا بسهولة

        return $this;
    }

    /**
     * توليد مصفوفة الفلاتر لدالة all() بشكل ديناميكي وقابل للتوسعة.
     *
     * @param array $filters مصفوفة الفلاتر (مفتاح => قيمة)
     * @return array
     */
    public static function filters(array $filters = []): array
    {
        $result = [];
        $map = [
            'page' => 'page',
            'id' => 'id',
            'status' => 'status',
            'createdGt' => 'created[gt]',
            'createdLt' => 'created[lt]',
            'updatedGt' => 'updated[gt]',
            'updatedLt' => 'updated[lt]',
            'cardLastDigits' => 'card_last_digits',
            'receiptNo' => 'receipt_no',
        ];

        foreach ($map as $key => $apiKey) {
            if (isset($filters[$key])) {
                $result[$apiKey] = $filters[$key];
            }
        }

        // فلترة metadata بشكل ديناميكي
        if (!empty($filters['metadata']) && is_array($filters['metadata'])) {
            foreach ($filters['metadata'] as $metaKey => $metaValue) {
                $result["metadata[{$metaKey}]"] = $metaValue;
            }
        }

        // يمكن إضافة فلاتر جديدة بسهولة هنا

        return $result;
    }

    /**
     * تحويل الكائن إلى مصفوفة.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'success' => $this->success,
            'data'    => $this->data,
            'status'  => $this->status,
            'error'   => $this->error,
        ];
    }

    // ===================== Static Methods =====================

    /**
     * إنشاء عملية دفع جديدة.
     *
     * @param array $payload بيانات الدفع
     * @return static
     */
    public static function create(array $payload): static
    {
        return (new static())->request('POST', (new static())->baseUrl . '/payments', $payload);
    }

    /**
     * جلب تفاصيل عملية دفع.
     *
     * @param string $paymentId معرف الدفع
     * @return static
     */
    public static function find(string $paymentId): static
    {
        return (new static())->request('GET', (new static())->baseUrl . "/payments/{$paymentId}");
    }

    /**
     * عرض جميع العمليات مع إمكانية التصفية.
     *
     * @param array $filters مصفوفة الفلاتر
     * @return static
     */
    public static function all(array $filters = []): static
    {
        $query = static::filters($filters);
        return (new static())->request('GET', (new static())->baseUrl . '/payments', [], $query);
    }

    /**
     * استرجاع عملية دفع.
     *
     * @param string $paymentId معرف العملية
     * @param int|null $amount المبلغ المراد استرجاعه (اختياري)
     * @return static
     */
    public static function refund(string $paymentId, ?int $amount = null): static
    {
        $payload = $amount ? ['amount' => $amount] : [];
        return (new static())->request('POST', (new static())->baseUrl . "/payments/{$paymentId}/refund", $payload);
    }

    // ===================== Internal Request =====================

    /**
     * إرسال الطلب إلى API ومعالجة الأخطاء بشكل آمن ومرن.
     *
     * @param string $method طريقة الطلب ('GET', 'POST', ...)
     * @param string $url رابط الطلب
     * @param array $data بيانات body (لـ POST/PUT)
     * @param array $query بيانات query string (لـ GET)
     * @return static
     */
    protected function request(string $method, string $url, array $data = [], array $query = []): static
    {
        try {
            $method = strtoupper($method);
            $http = Http::withBasicAuth($this->apiKey, '')
                ->acceptJson()
                ->withOptions([
                    'http_errors' => false,
                    'verify' => false,
                ]);

            if ($method === 'GET') {
                $response = $http->get($url, $query);
            } elseif ($method === 'POST') {
                $response = $http->post($url, $data);
            } elseif ($method === 'PUT') {
                $response = $http->put($url, $data);
            } elseif ($method === 'DELETE') {
                $response = $http->delete($url, $data);
            } else {
                throw new \InvalidArgumentException("طريقة HTTP غير مدعومة: {$method}");
            }

            $json = $response->json();

            // استخراج رسالة الخطأ بشكل واضح
            $errorMsg = null;
            if (!$response->successful()) {
                $errorMsg = $json['message'] ?? $json['error'] ?? $response->body() ?? 'خطأ غير معروف';
            }

            return new static([
                'success' => $response->successful(),
                'data'    => $json,
                'status'  => $json['status'] ?? null,
                'error'   => $errorMsg,
            ]);
        } catch (\Throwable $e) {
            return new static([
                'success' => false,
                'data'    => [],
                'status'  => null,
                'error'   => 'استثناء: ' . $e->getMessage(),
            ]);
        }
    }

    // ===================== Payment Status Helpers =====================

    /**
     * جلب حالة الدفع الحالية.
     *
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * تحقق إذا كانت العملية مدفوعة.
     *
     * @return bool
     */
    public function isPaid(): bool
    {
        return $this->status === PaymentStatus::Paid;
    }

    /**
     * تحقق إذا كانت العملية مبدئية (Initiated).
     *
     * @return bool
     */
    public function isInitiated(): bool
    {
        return $this->status === PaymentStatus::Initiated;
    }

    /**
     * تحقق إذا فشلت العملية.
     *
     * @return bool
     */
    public function isFailed(): bool
    {
        return $this->status === PaymentStatus::Failed;
    }

    /**
     * تحقق إذا تم استرجاع العملية.
     *
     * @return bool
     */
    public function isRefunded(): bool
    {
        return $this->status === PaymentStatus::Refunded;
    }

    // ===================== قابلية التوسعة =====================
    // يمكن إضافة خصائص أو دوال جديدة بسهولة هنا مستقبلاً
}
