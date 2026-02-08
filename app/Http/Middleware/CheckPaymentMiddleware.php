<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Support\PaymentIntentFactory;
use Symfony\Component\HttpFoundation\Response;

class CheckPaymentMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $application = $request->route('application');
        $user = $request->user();
        // 1. تأكد من وجود الطلب
        if (!$application) {
            return $this->deny('Membership application not found.', 404);
        }
        // 2. تحقق أن الطلب يخص المستخدم المسجل
        if (!$user || $application->user_id !== $user->id) {
            return $this->deny('You do not have permission to access this membership application.', 403);
        }
        // 3. تحقق من الحالة يجب ان تكون draft
        if (!$application->status->isDreft()) {
            return $this->deny('This membership application cannot proceed to payment.', 403);
        }
        // 4. تأكد من وجود الدفع
        $payment = $application->payment;
        if (!$payment) {
            return $this->redirectToPayment($application, $user->id, 'You need to complete the payment before proceeding.');
        }

        // 5. تحقق أن الدفع تم فعلاً
        if (!$application->isPaymentDone()) {
            return $this->redirectToPayment($application, $user->id, 'Payment is not completed yet.');
        }
        // 6. تحقق أن الدفع يخص نفس العضوية
        if (
            $payment->payable_type !== \App\Models\Membership::class ||
            $payment->payable_id !== $application->membership_id
        ) {
            return $this->redirectToPayment($application, $user->id, 'Payment record does not match this membership.');
        }
        return $next($request);
    }

    /**
     * إعادة توجيه لصفحة الدفع مع رسالة
     */
    protected function redirectToPayment($application, int $userId, string $message): Response
    {
        // Membership payment is tied to the selected membership.
        $membership = $application->membership;
        if ($membership) {
            $intent = PaymentIntentFactory::prepare($userId, $membership);
            return redirect()
                ->route('client.pay.show', ['token' => $intent->token])
                ->with('error', $message);
        }

        return redirect()
            ->route('login')
            ->with('error', $message);
    }

    /**
     * رد بالمنع (403 أو 404)
     */
    protected function deny(string $message, int $status = 403): Response
    {
        abort($status, $message);
    }
}
