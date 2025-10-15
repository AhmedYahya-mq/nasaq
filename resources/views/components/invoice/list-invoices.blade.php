<div>
    <div class="w-full bg-card border border-border rounded-xl shadow-sm">
        <div class="p-4 sm:p-6 border-b border-border">
            <h2 class="text-lg font-semibold text-foreground">📑 Payment Invoices</h2>
        </div>
        <div class="flow-root">
            <div class="divide-y divide-border">
                @forelse ($payments as $payment)
                    <a href="{{ route('client.invoice.print',['uuid'=> $payment->moyasar_id]) }}"
                        class="block p-4 sm:p-6 hover:bg-accent/50 transition-colors duration-200">

                        <div class="flex flex-wrap items-center justify-between gap-y-4 gap-x-6">

                            {{-- ================================================== --}}
                            {{-- Checkbox removed here --}}
                            {{-- ================================================== --}}
                            <div class="min-w-[150px]">
                                <div class="text-xs text-muted-foreground">Payment ID</div>
                                <div class="text-sm  text-foreground">{{ $payment->moyasar_id }}</div>
                            </div>

                            {{-- Column 2: Invoice ID --}}
                            <div class="min-w-[150px]">
                                <div class="text-xs text-muted-foreground">Invoice ID</div>
                                <div class="text-sm  text-foreground">{{ $payment->invoice_id }}</div>
                            </div>

                            {{-- Column 3: Service --}}
                            <div class="flex-1 min-w-[200px]">
                                <div class="text-xs text-muted-foreground">Service</div>
                                <div class="text-sm text-foreground">
                                    @php
                                        $payable = $payment->payable;
                                    @endphp

                                    @if ($payable instanceof \App\Models\Membership)
                                        Subscribed to membership: <strong>{{ $payable->name ?? 'No title' }}</strong>
                                    @elseif ($payable instanceof \App\Models\Event)
                                        Registered for: <strong>{{ $payable->title }}</strong>
                                    @elseif ($payable instanceof \App\Models\Library)
                                        Purchased: <strong>{{ $payable->title }}</strong>
                                    @else
                                        <span class="text-muted">Unknown service</span>
                                    @endif
                                </div>
                            </div>

                            {{-- Column 4: Payment date --}}
                            <div class="min-w-[120px]">
                                <div class="text-xs text-muted-foreground">Paid on</div>
                                <div class="text-sm text-muted-foreground">{{ $payment->created_at }}</div>
                            </div>

                            {{-- Column 5: Amount --}}
                            <div class="min-w-[100px]">
                                <div class="text-xs text-muted-foreground">Amount</div>
                                <div class="text-primary flex items-center gap-1">
                                    <span>{{ $payment->amount }}</span>
                                    <x-ui.icon name="riyal" class="size-4 fill-primary *:fill-primary" />
                                </div>
                            </div>

                            {{-- Column 6: Arrow icon --}}
                            <div class="text-muted-foreground">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>

                        </div>
                    </a>
                @empty
                    {{-- No invoices --}}
                    <div class="text-center py-12 px-6 text-muted-foreground">
                        <p>You haven't made any purchases yet.</p>
                    </div>
                @endforelse

            </div>
        </div>
    </div>

    <div class="mt-4">
        {{ $payments->links('pagination::tailwind') }}
    </div>
</div>
