<div class="relative pb-14">
    <div class="@container flex flex-col gap-y-3.5">
        <x-forms.input id="job-title" name="job-title" label="المسمى الوظيفي" type="text" placeholder="أكتب المسمى الوظيفي"
            class="w-full" icon="user" />
        <div class="grid grid-cols-1 @md:grid-cols-2 gap-4">
            <x-forms.input id="last-name" name="last-name" label="الأسم الأخير" type="text"
                placeholder="أدخل الأسم الأخير" class="w-full" icon="user" />
            <x-forms.input id="email" name="email" label="البريد الإلكتروني" type="email"
                placeholder="أدخل البريد الإلكتروني" class="w-full" icon="mail" />
            <x-forms.tel-input id="phone" name="phone" label="رقم الجوال" />
            <x-forms.input id="address" name="address" label="العنوان" type="text" placeholder="أدخل العنوان"
                class="w-full" icon="location" />
            <x-forms.datepicker label="تاريخ الميلاد" value="2025/5/15" name="birthday" />
        </div>
        <x-forms.text-area name="descriptin" label="وصف" placeholder="تحدث عن نفسك" />
    </div>
    <div class="absolute bottom-0 rtl:left-5 ltr:right-5 flex gap-3">
        <button class="bg-primary py-2 px-3 rounded-md hover:bg-primary/60 cursor-pointer" aria-label="تحديث">
            تحديث
        </button>
        <button class="badget badget-red-500 hover:badget-40  py-2 px-3 rounded-md cursor-pointer" aria-label="تحديث">
            الغاء
        </button>
    </div>
</div>
