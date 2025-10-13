<x-layouts.guest-layout title="{{ __('profile.title') }}">

    @push('scripts')
        @vite(['resources/js/pages/profile.js'])
        @vite(['resources/js/pages/membership-request.js'])
        @vite(['resources/js/pages/library.js'])
    @endpush
    <div class="flex justify-center items-center w-full mb-5">
        <div class="grid grid-cols-1 lg:grid-cols-[0.30fr_1fr] gap-2 container max-sm:px-2 mt-5">
            <div class="flex flex-col">
                <x-ui.card-profile />
            </div>
            <div class="flex flex-col">
                <x-tabs class="w-full" default="{{ request()->get('tab', 'events') }}">
                    <x-slot:header>
                        <x-tabs.tab-button id="personalInfo" label="المعلومات الشخصية" />
                        <x-tabs.tab-button id="library" label="مكتبتي" />
                        <x-tabs.tab-button id="events" label="الفعاليات" />
                        @if (auth()->user()->currentMemberships())
                            <x-tabs.tab-button id="membership" label="عضويتي " />
                        @endif
                        <x-tabs.tab-button id="requests" label="الطلبات" />
                        <x-tabs.tab-button id="invoices" label="الفواتير" />
                        <x-tabs.tab-button id="changePassword" label="تغير كلمة المرور" />
                        <x-tabs.tab-button id="security" label="الأمان" />
                    </x-slot:header>
                    <x-tabs.tab id="personalInfo">
                        <x-tab.tab-profile />
                    </x-tabs.tab>
                    <x-tabs.tab id="library">
                        <x-tab.tab-library />
                    </x-tabs.tab>
                    <x-tabs.tab id="events">
                        <x-tab.tab-event />
                    </x-tabs.tab>
                    @if (auth()->user()->currentMemberships())
                        <x-tabs.tab id="membership">
                            <x-tab.tab-membership />
                        </x-tabs.tab>
                    @endif
                    <x-tabs.tab id="requests">
                        <x-tab.tab-request />
                    </x-tabs.tab>
                    <x-tabs.tab id="invoices">
                        <x-tab.tab-invoices />
                    </x-tabs.tab>
                    <x-tabs.tab id="changePassword">
                        <x-tab.tab-change-password />
                    </x-tabs.tab>
                    <x-tabs.tab id="security">
                        <x-tab.tab-security />
                    </x-tabs.tab>
                </x-tabs>
            </div>
        </div>
    </div>
</x-layouts.guest-layout>
