  <div class="relative">
      <form x-data='passwordChange' @submit.prevent="submit" class="relative flex flex-col gap-y-3.5">
          <div class="grid grid-cols-1 gap-4">
              <div>
                  <x-forms.input-password x-model="form.current_password" name="current_password" id="current_password"
                      label="كلمة المرور القديمة" />
                  <span x-show="errors.current_password" class="text-sm font-medium text-destructive"
                      x-text="errors.current_password"></span>
              </div>
              <div>
                  <x-forms.input-password x-model="form.password" name="password" id="password"
                      label="كلمة المرور الجديدة" />
                  <template x-for="(error, index) in errors.password" :key="index">
                      <div class="text-sm font-medium text-destructive" x-text="error"></div>
                  </template>
              </div>
              <div>
                  <x-forms.input-password x-model="form.password_confirmation" name="password_confirmation"
                      id="password_confirmation" label="تأكيد كلمة المرور الجديدة" />
                  <span x-show="errors.password_confirmation" class="text-sm font-medium text-destructive"
                      x-text="errors.password_confirmation"></span>
              </div>
          </div>
          <div class="flex items-center ltr:justify-end rtl:flex-row-reverse gap-3">
              <button type="submit" :disabled='disabled' class="bg-primary flex items-center gap-1 py-2 px-3 rounded-md hover:bg-primary/60 cursor-pointer"
                  aria-label="تغيير كلمة المرور">
                  <text>تغيير كلمة المرور</text>
                  <div class="animate-spin mt-1 size-3.5 bg-transparent rounded-full border-3 border-white border-b-transparent" x-show='disabled'></div>
              </button>
              <span x-show='saved' class="text-sm font-medium text-green-500">تم حفظ!</span>
          </div>
      </form>
  </div>
