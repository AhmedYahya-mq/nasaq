<x-layouts.guest-layout title="الملف الشخصي">
    <div class="grid grid-cols-1 lg:grid-cols-[0.30fr_1fr] gap-2 container max-sm:px-2">
        <div class="flex flex-col">
            <x-ui.card-profile />
        </div>
        <div class="flex flex-col">
            <x-tabs class="w-full" default="changePassword">

                <x-slot:header>
                    <x-tabs.tab-button id="personal-info" label="المعلومات الشخصية" />
                    <x-tabs.tab-button id="changePassword" label="تغير كلمة المرور" />
                    <x-tabs.tab-button id="settings" label="الإعدادات" />
                </x-slot:header>

                <x-tabs.tab id="personal-info">
                    <div class="relative pb-14">
                        <div class="@container flex flex-col gap-y-3.5">
                            <div class="grid grid-cols-1 @md:grid-cols-2 gap-4">
                                <x-forms.input id="first-name" name="first-name" label="الأسم الأول" type="text"
                                    placeholder="أدخل الأسم الأول" class="w-full" icon="user" />
                                <x-forms.input id="last-name" name="last-name" label="الأسم الأخير" type="text"
                                    placeholder="أدخل الأسم الأخير" class="w-full" icon="user" />
                                <x-forms.input id="email" name="email" label="البريد الإلكتروني" type="email"
                                    placeholder="أدخل البريد الإلكتروني" class="w-full" icon="mail" />
                                <x-forms.tel-input id="phone" name="phone" label="رقم الجوال" />
                                <x-forms.input id="address" name="address" label="العنوان" type="text"
                                    placeholder="أدخل العنوان" class="w-full" icon="location" />
                                <x-forms.datepicker label="تاريخ الميلاد" value="2025/5/15" name="birthday" />
                            </div>
                            <x-forms.text-area name="descriptin" label="وصف" placeholder="تحدث عن نفسك" />
                        </div>
                        <div class="absolute bottom-0 rtl:left-5 ltr:right-5 flex gap-3">
                            <button class="bg-primary py-2 px-3 rounded-md hover:bg-primary/60 cursor-pointer"
                                aria-label="تحديث">
                                تحديث
                            </button>
                            <button class="badget badget-red-500 hover:badget-40  py-2 px-3 rounded-md cursor-pointer"
                                aria-label="تحديث">
                                الغاء
                            </button>
                        </div>
                    </div>
                </x-tabs.tab>

                <x-tabs.tab id="changePassword">
                    <div class="relative">
                        <div class="@container relative pb-14 flex flex-col gap-y-3.5">
                            <div class="grid grid-cols-1 @md:grid-cols-2 @lg:grid-cols-3 gap-4">
                                <x-forms.input-password value="password" label="كلمة المرور القديمة" />
                                <x-forms.input-password value="password" label="كلمة المرور الجديدة" />
                                <x-forms.input-password value="password" label="تأكيد كلمة المرور" />
                            </div>
                            <div class="absolute bottom-0 rtl:left-0 ltr:right-0 flex gap-3">
                                <button class="bg-primary py-2 px-3 rounded-md hover:bg-primary/60 cursor-pointer"
                                    aria-label="تغيير كلمة المرور">
                                    تغيير كلمة المرور
                                </button>
                            </div>
                        </div>
                        <div class="mt-3">
                            <div class="flex justify-between py-4 border-b border-border">
                                <h2 class="text-md font-semibold">
                                    سجل تسجيل الدخول
                                </h2>
                                <span class="badget badget-red-600 text-sm rounded-sm py-1 px-2">
                                    تسجيل الخروج لكل
                                </span>
                            </div>
                            <div class="flex flex-col gap-3 py-5 scrollbar !overflow-hidden hover:!overflow-y-scroll max-h-80">
                                <!-- الجهاز الحالي -->
                                <x-ui.device-session-item deviceName="Dell Inspiron 14"
                                    location="Los Angeles, United States" datetime="March 16 at 2:47PM" icon="system"
                                    :isCurrent="true" />

                                <!-- جهاز آخر -->
                                <x-ui.device-session-item deviceName="iPhone 13" location="New York, United States"
                                    datetime="March 15 at 10:30AM" icon="phone" :isCurrent="false" />

                                <!-- جهاز آخر -->
                                <x-ui.device-session-item deviceName='MacBook Pro 16"' location="London, UK"
                                    datetime="March 14 at 5:12PM" icon="system" :isCurrent="false" />

                                <!-- جهاز آخر -->
                                <x-ui.device-session-item deviceName="iPhone 13" location="New York, United States"
                                    datetime="March 15 at 10:30AM" icon="phone" :isCurrent="false" />

                                <!-- جهاز آخر -->
                                <x-ui.device-session-item deviceName='MacBook Pro 16"' location="London, UK"
                                    datetime="March 14 at 5:12PM" icon="system" :isCurrent="false" />

                                <!-- جهاز آخر -->
                                <x-ui.device-session-item deviceName="iPhone 13" location="New York, United States"
                                    datetime="March 15 at 10:30AM" icon="phone" :isCurrent="false" />

                                <!-- جهاز آخر -->
                                <x-ui.device-session-item deviceName='MacBook Pro 16"' location="London, UK"
                                    datetime="March 14 at 5:12PM" icon="system" :isCurrent="false" />

                                <!-- جهاز آخر -->
                                <x-ui.device-session-item deviceName="iPhone 13" location="New York, United States"
                                    datetime="March 15 at 10:30AM" icon="phone" :isCurrent="false" />

                                <!-- جهاز آخر -->
                                <x-ui.device-session-item deviceName='MacBook Pro 16"' location="London, UK"
                                    datetime="March 14 at 5:12PM" icon="system" :isCurrent="false" />

                                <!-- جهاز آخر -->
                                <x-ui.device-session-item deviceName="iPhone 13" location="New York, United States"
                                    datetime="March 15 at 10:30AM" icon="phone" :isCurrent="false" />

                                <!-- جهاز آخر -->
                                <x-ui.device-session-item deviceName='MacBook Pro 16"' location="London, UK"
                                    datetime="March 14 at 5:12PM" icon="system" :isCurrent="false" />

                                <!-- جهاز آخر -->
                                <x-ui.device-session-item deviceName="iPhone 13" location="New York, United States"
                                    datetime="March 15 at 10:30AM" icon="phone" :isCurrent="false" />

                                <!-- جهاز آخر -->
                                <x-ui.device-session-item deviceName='MacBook Pro 16"' location="London, UK"
                                    datetime="March 14 at 5:12PM" icon="system" :isCurrent="false" />

                                <!-- جهاز آخر -->
                                <x-ui.device-session-item deviceName="iPhone 13" location="New York, United States"
                                    datetime="March 15 at 10:30AM" icon="phone" :isCurrent="false" />

                                <!-- جهاز آخر -->
                                <x-ui.device-session-item deviceName='MacBook Pro 16"' location="London, UK"
                                    datetime="March 14 at 5:12PM" icon="system" :isCurrent="false" />

                            </div>
                        </div>
                    </div>
                </x-tabs.tab>

                <x-tabs.tab id="settings">
                    <div class="relative pb-14">
                        <div class="@container flex flex-col gap-y-3.5">
                            <div class="grid grid-cols-1 @md:grid-cols-2 gap-4">
                                <x-forms.input id="first-name" name="first-name" label="الأسم الأول" type="text"
                                    placeholder="أدخل الأسم الأول" class="w-full" icon="user" />
                                <x-forms.input id="last-name" name="last-name" label="الأسم الأخير" type="text"
                                    placeholder="أدخل الأسم الأخير" class="w-full" icon="user" />
                                <x-forms.input id="email" name="email" label="البريد الإلكتروني"
                                    type="email" placeholder="أدخل البريد الإلكتروني" class="w-full"
                                    icon="mail" />
                                <x-forms.tel-input id="phone" name="phone" label="رقم الجوال" />
                                <x-forms.input id="address" name="address" label="العنوان" type="text"
                                    placeholder="أدخل العنوان" class="w-full" icon="location" />
                                <x-forms.datepicker label="تاريخ الميلاد" value="2025/5/15" name="birthday" />
                            </div>
                            <x-forms.text-area name="descriptin" label="وصف" placeholder="تحدث عن نفسك" />
                        </div>
                        <div class="absolute bottom-0 rtl:left-5 ltr:right-5 flex gap-3">
                            <button class="bg-primary py-2 px-3 rounded-md hover:bg-primary/60 cursor-pointer"
                                aria-label="تحديث">
                                تحديث
                            </button>
                            <button class="badget badget-red-500 hover:badget-40  py-2 px-3 rounded-md cursor-pointer"
                                aria-label="تحديث">
                                الغاء
                            </button>
                        </div>
                    </div>
                </x-tabs.tab>

            </x-tabs>
        </div>
    </div>
</x-layouts.guest-layout>
