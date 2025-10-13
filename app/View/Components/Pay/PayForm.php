<?php

namespace App\View\Components\Pay;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PayForm extends Component
{
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
        if (!$user->membership) {
            $this->startAt = now()->format('Y-m-d');
            $this->endsAt = now()->addYear()->format('Y-m-d');
            return;
        }
        $now=now();
        $ends_at = $user->membership_expires_at && $user->membership_expires_at > $now
            ? $user->membership_expires_at
            : $now;
        $this->endsAt = $ends_at->addYear()->format('Y-m-d');
        $this->startAt = $user->membership_started_at->format('Y-m-d');
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.pay.pay-form');
    }
}
