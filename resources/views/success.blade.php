<x-layouts.auth :title="__('payments.Payment Successful')">

    <div class="flex flex-col items-center justify-center min-h-[100dvh] bg-gray-100 dark:bg-gray-950 p-4 sm:p-6 md:p-8">
        <div class="max-w-md w-full bg-white dark:bg-gray-900 rounded-xl shadow-lg overflow-hidden">
            <!-- أيقونة نجاح -->
            <div class="px-6 py-12 flex flex-col items-center justify-center space-y-4">
                <div class="bg-green-500 dark:bg-green-600 p-4 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 6L9 17l-5-5" />
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-50">
                    {{ __('payments.Payment Successful') }}
                </h1>
                <p class="text-gray-500 dark:text-gray-400 text-center">
                    {{ __('payments.Thank you, :name! Your payment has been received successfully.', ['name' => $payment->user->name ?? __('payments.Guest')]) }}
                </p>
            </div>

            <!-- تفاصيل الدفع -->
            <div class="bg-gray-100 dark:bg-gray-800 px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">{{ __('payments.Amount Paid') }}</p>
                        <p class="text-gray-900 dark:text-gray-50 font-medium">
                            {{ $payment->amount }} <x-ui.icon name="riyal" class="inline h-4 w-4" />
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">{{ __('payments.Payment Method') }}</p>
                        <p class="text-gray-900 dark:text-gray-50 font-medium">
                            {{ $payment->source_type ?? '-' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">{{ __('payments.Transaction ID') }}</p>
                        <p class="text-gray-900 dark:text-gray-50 font-medium">
                            #{{ $payment->invoice_id }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- زر العودة -->
            <div class="px-6 py-4 flex justify-center">
                <a href="{{ url('/') }}"
                    class="inline-flex h-10 items-center justify-center rounded-md px-6 text-sm font-medium shadow transition-colors bg-primary hover:bg-primary/80 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-primary text-white disabled:pointer-events-none disabled:opacity-50">
                    {{ __('payments.Go to Homepage') }}
                </a>
            </div>

        </div>
    </div>

</x-layouts.auth>
