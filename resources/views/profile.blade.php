<x-layouts.guest-layout title="الملف الشخصي">
    <div class="grid grid-cols-1 lg:grid-cols-[0.30fr_1fr] gap-2 container max-sm:px-2 mt-5">
        <div class="flex flex-col">
            <x-ui.card-profile />
        </div>
        <div class="flex flex-col">
            <x-tabs class="w-full" default="experince">

                <x-slot:header>
                    <x-tabs.tab-button id="personal-info" label="المعلومات الشخصية" />
                    <x-tabs.tab-button id="changePassword" label="تغير كلمة المرور" />
                    <x-tabs.tab-button id="experince" label="الإعدادات" />
                </x-slot:header>

                <x-tabs.tab id="personal-info">
                    <x-tabs.tab-profile />
                </x-tabs.tab>

                <x-tabs.tab id="changePassword">
                  <x-tabs.tab-change-password />
                </x-tabs.tab>

                <x-tabs.tab id="experince">
                    <x-tabs.tab-experince />

                </x-tabs.tab>

            </x-tabs>
        </div>
    </div>
</x-layouts.guest-layout>
