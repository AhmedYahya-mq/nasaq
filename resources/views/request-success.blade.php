<x-layouts.auth :title="__('memberships.Request Successful')">

    <div class="flex flex-col items-center justify-center min-h-[100dvh] p-4 sm:p-6 md:p-8">
        <div class="max-w-md w-full card rounded-xl shadow-lg overflow-hidden">

            <!-- أيقونة نجاح -->
            <div class="px-6 py-12 flex flex-col items-center justify-center space-y-4">
                <div class="bg-green-500 dark:bg-green-600 p-4 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 6L9 17l-5-5" />
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-primary text-center">
                    {{ __('memberships.Request Successful') }}
                </h1>
                <p class="text-gray-500 dark:text-gray-400 text-center">
                    {{ __('memberships.Thank you, :name! Your membership request has been submitted successfully.', ['name' => $application->user->name ?? __('memberships.Guest')]) }}
                </p>
            </div>

            <!-- تفاصيل الطلب -->
            <div class="bg-gray-100 dark:bg-gray-800 px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">{{ __('memberships.Membership Type') }}</p>
                        <p class="text-gray-900 dark:text-gray-50 font-medium">
                            {{ $application->membership->name ?? '-' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">{{ __('memberships.Submitted At') }}</p>
                        <p class="text-gray-900 dark:text-gray-50 font-medium">
                            {{ $application->submitted_at?->format('Y-m-d H:i') ?? now() }}
                        </p>
                    </div>
                    <div class="col-span-2 text-center mt-2">
                        <p class="text-gray-500 dark:text-gray-400 text-sm">
                            {{ __('memberships.Status') }}
                        </p>
                        <p class="text-green-600 dark:text-green-400 font-semibold">
                            {{ __('memberships.Pending Review') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- زر العودة -->
            <div class="px-6 py-4 flex justify-center">
                <a href="{{ url('/') }}"
                    class="inline-flex h-10 items-center justify-center rounded-md px-6 text-sm font-medium shadow transition-colors bg-primary hover:bg-primary/80 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-primary text-white disabled:pointer-events-none disabled:opacity-50">
                    {{ __('memberships.Go to Homepage') }}
                </a>
            </div>

        </div>
    </div>

</x-layouts.auth>
