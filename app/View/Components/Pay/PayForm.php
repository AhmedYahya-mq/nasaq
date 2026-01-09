<?php

namespace App\View\Components\Pay;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PayForm extends Component
{
    public $membershipAction = 'new';
    public $item;
    public $isMembership = false;
    public $startAt;
    public $endsAt;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        if (session('payable_type') !== '\App\Models\Membership') {
            $this->item = session('payable_type')::find(session('payable_id'));
            return;
        }
        $this->item = session('payable_type')::find(session('payable_id'));
        $this->isMembership = true;
        $user = auth()->user();
        $now = now();

        // تحديد نوع العملية: تجديد، ترقية، أو اشتراك جديد
        if ($user && $user->membership_id) {
            $this->membershipAction = ($user->membership_id === $this->item->id) ? 'renewal' : 'upgrade';
        }

        // تحديد مدة العضوية الافتراضية لو لم تتوفر في العنصر
        $durationDays = (int) ($this->item->duration_days ?? $this->item->duration ?? 365);
        if ($durationDays <= 0) {
            $durationDays = 365; // حماية من القيم الفارغة أو الصفرية
        }

        // في التجديد فقط: ابدأ من تاريخ انتهاء الحالية إذا كانت ما زالت فعّالة، وإلا من اليوم
        // في الترقية أو الاشتراك الجديد: ابدأ من اليوم
        $startBase = ($this->membershipAction === 'renewal' && $user && $user->membership_expires_at && $user->membership_expires_at->isFuture())
            ? $user->membership_expires_at
            : $now;

        $this->startAt = $startBase->format('Y-m-d');
        $this->endsAt = $this->membershipAction == 'upgrade' ? $user->upgradeWithBalance($this->item, $user->remaining_days, $now)->addDays($durationDays)->format('Y-m-d') : $startBase->copy()->addDays($durationDays)->format('Y-m-d');
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.pay.pay-form');
    }
}
