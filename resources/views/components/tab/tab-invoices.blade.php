
@props([
    'invoices' => [
        [
            'id' => 'pay_01F8MECHZX3TBDSZ5X0G4X6Q6Y',
            'invoice' => 'inv_01F8MECHZX3TBDSZ5X0G4X6Q6Y',
            'service' => 'خدمة استضافة المواقع - خطة أساسية',
            'paidAt' => '2024-06-15 14:30',
            'amount' => '$29.99',
            'url' => '#',
        ],
        [
            'id' => 'pay_01F8MECHZX3TBDSZ5X0G4X6Q7Z',
            'invoice' => 'inv_01F8MECHZX3TBDSZ5X0G4X6Q7Z',
            'service' => 'خدمة استضافة المواقع - خطة متقدمة',
            'paidAt' => '2024-05-10 09:15',
            'amount' => '$49.99',
            'url' => '#',
        ],
        // يمكن إضافة المزيد من الفواتير هنا
    ],
])

<div class="w-full bg-card border border-border rounded-xl shadow-sm">
    <div class="p-4 sm:p-6 border-b border-border">
        <h2 class="text-lg font-semibold text-foreground">📑 فواتير الدفع</h2>
    </div>

    <div class="flow-root">
        <div class="divide-y divide-border">
            @forelse ($invoices as $invoice)
                <a href="{{ $invoice['url'] ?? '#' }}"
                   class="block p-4 sm:p-6 hover:bg-accent/50 transition-colors duration-200">

                    <div class="flex flex-wrap items-center justify-between gap-y-4 gap-x-6">

                        {{-- ================================================== --}}
                        {{-- تم إزالة الـ Checkbox من هنا --}}
                        {{-- ================================================== --}}
                        <div class="min-w-[150px]">
                            <div class="text-xs text-muted-foreground">معرّف الدفع</div>
                            <div class="text-sm  text-foreground">{{ $invoice['id'] }}</div>
                        </div>

                        {{-- العمود الثاني: معرف الفاتورة --}}
                        <div class="min-w-[150px]">
                            <div class="text-xs text-muted-foreground">معرّف الفاتورة</div>
                            <div class="text-sm  text-foreground">{{ $invoice['invoice'] }}</div>
                        </div>

                        {{-- العمود الثالث: الخدمة --}}
                        <div class="flex-1 min-w-[200px]">
                            <div class="text-xs text-muted-foreground">الخدمة</div>
                            <div class="text-sm text-foreground">{{ $invoice['service'] }}</div>
                        </div>

                        {{-- العمود الرابع: تاريخ الدفع --}}
                        <div class="min-w-[120px]">
                            <div class="text-xs text-muted-foreground">تم الدفع في</div>
                            <div class="text-sm text-muted-foreground">{{ $invoice['paidAt'] }}</div>
                        </div>

                        {{-- العمود الخامس: القيمة --}}
                        <div class="min-w-[100px]">
                            <div class="text-xs text-muted-foreground">الكمية</div>
                            <div class=" text-primary">{{ $invoice['amount'] }}</div>
                        </div>

                        {{-- العمود السادس: أيقونة السهم (للانتقال) --}}
                        <div class="text-muted-foreground">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </div>

                    </div>
                </a>
            @empty
                {{-- حالة عدم وجود فواتير --}}
                <div class="text-center py-12 px-6 text-muted-foreground">
                    <p>لا توجد فواتير لعرضها حالياً.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
