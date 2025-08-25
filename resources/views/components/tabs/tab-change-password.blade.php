  <div class="relative">
      <div class="@container relative pb-14 flex flex-col gap-y-3.5">
          <div class="grid grid-cols-1 @md:grid-cols-2 @lg:grid-cols-3 gap-4">
              <x-forms.input-password value="password" id="old_password" label="كلمة المرور القديمة" />
              <x-forms.input-password value="password" id="current_password" label="كلمة المرور الجديدة" />
              <x-forms.input-password value="password" id="confirm_password" label="تأكيد كلمة المرور" />
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
              <x-ui.device-session-item deviceName="Dell Inspiron 14" location="Los Angeles, United States"
                  datetime="March 16 at 2:47PM" icon="system" :isCurrent="true" />

              <!-- جهاز آخر -->
              <x-ui.device-session-item deviceName="iPhone 13" location="New York, United States"
                  datetime="March 15 at 10:30AM" icon="phone" :isCurrent="false" />

              <!-- جهاز آخر -->
              <x-ui.device-session-item deviceName='MacBook Pro 16"' location="London, UK" datetime="March 14 at 5:12PM"
                  icon="system" :isCurrent="false" />

              <!-- جهاز آخر -->
              <x-ui.device-session-item deviceName="iPhone 13" location="New York, United States"
                  datetime="March 15 at 10:30AM" icon="phone" :isCurrent="false" />

              <!-- جهاز آخر -->
              <x-ui.device-session-item deviceName='MacBook Pro 16"' location="London, UK" datetime="March 14 at 5:12PM"
                  icon="system" :isCurrent="false" />

              <!-- جهاز آخر -->
              <x-ui.device-session-item deviceName="iPhone 13" location="New York, United States"
                  datetime="March 15 at 10:30AM" icon="phone" :isCurrent="false" />

              <!-- جهاز آخر -->
              <x-ui.device-session-item deviceName='MacBook Pro 16"' location="London, UK" datetime="March 14 at 5:12PM"
                  icon="system" :isCurrent="false" />

              <!-- جهاز آخر -->
              <x-ui.device-session-item deviceName="iPhone 13" location="New York, United States"
                  datetime="March 15 at 10:30AM" icon="phone" :isCurrent="false" />

              <!-- جهاز آخر -->
              <x-ui.device-session-item deviceName='MacBook Pro 16"' location="London, UK" datetime="March 14 at 5:12PM"
                  icon="system" :isCurrent="false" />

              <!-- جهاز آخر -->
              <x-ui.device-session-item deviceName="iPhone 13" location="New York, United States"
                  datetime="March 15 at 10:30AM" icon="phone" :isCurrent="false" />

              <!-- جهاز آخر -->
              <x-ui.device-session-item deviceName='MacBook Pro 16"' location="London, UK" datetime="March 14 at 5:12PM"
                  icon="system" :isCurrent="false" />

              <!-- جهاز آخر -->
              <x-ui.device-session-item deviceName="iPhone 13" location="New York, United States"
                  datetime="March 15 at 10:30AM" icon="phone" :isCurrent="false" />

              <!-- جهاز آخر -->
              <x-ui.device-session-item deviceName='MacBook Pro 16"' location="London, UK" datetime="March 14 at 5:12PM"
                  icon="system" :isCurrent="false" />

              <!-- جهاز آخر -->
              <x-ui.device-session-item deviceName="iPhone 13" location="New York, United States"
                  datetime="March 15 at 10:30AM" icon="phone" :isCurrent="false" />

              <!-- جهاز آخر -->
              <x-ui.device-session-item deviceName='MacBook Pro 16"' location="London, UK" datetime="March 14 at 5:12PM"
                  icon="system" :isCurrent="false" />

          </div>
      </div>
  </div>
