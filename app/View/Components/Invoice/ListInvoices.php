<?php

namespace App\View\Components\Invoice;

use App\Models\Payment;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ListInvoices extends Component
{
    public $payments;
    public $service;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->payments = auth()->user()
            ->payments()
            ->with([
                'payable' => function ($q) {
                    if (method_exists($q->getModel(), 'scopeWithTranslations')) {
                        $q->withTranslations();
                    }
                }
            ])
            ->orderBy('created_at', 'desc')
            ->paginate(10)->appends(['tab' => 'invoices']);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.invoice.list-invoices');
    }
}
