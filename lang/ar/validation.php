<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | الرسائل الافتراضية للتحقق من البيانات في Laravel.
    |
    */

    'accepted'             => 'يجب قبول :attribute.',
    'active_url'           => ':attribute ليس رابطًا صالحًا.',
    'after'                => ':attribute يجب أن يكون بعد :date.',
    'after_or_equal'       => ':attribute يجب أن يكون تاريخاً بعد أو مساوي لـ :date.',
    'alpha'                => ':attribute يجب أن يحتوي على حروف فقط.',
    'alpha_dash'           => ':attribute يجب أن يحتوي على حروف، أرقام وشرطات فقط.',
    'alpha_num'            => ':attribute يجب أن يحتوي على حروف وأرقام فقط.',
    'array'                => ':attribute يجب أن يكون مصفوفة.',
    'before'               => ':attribute يجب أن يكون قبل :date.',
    'before_or_equal'      => ':attribute يجب أن يكون تاريخاً قبل أو مساوي لـ :date.',
    'between'              => [
        'numeric' => ':attribute يجب أن يكون بين :min و :max.',
        'file'    => ':attribute يجب أن يكون بين :min و :max كيلوبايت.',
        'string'  => ':attribute يجب أن يكون بين :min و :max حروف.',
        'array'   => ':attribute يجب أن يحتوي على بين :min و :max عناصر.',
    ],
    'boolean'              => 'حقل :attribute يجب أن يكون صحيح أو خاطئ.',
    'confirmed'            => 'تأكيد :attribute لا يطابق.',
    'date'                 => ':attribute ليس تاريخاً صالحاً.',
    'date_equals'          => ':attribute يجب أن يكون تاريخاً مطابقاً لـ :date.',
    'date_format'          => ':attribute لا يتوافق مع الصيغة :format.',
    'different'            => ':attribute و :other يجب أن يكونا مختلفين.',
    'digits'               => ':attribute يجب أن يحتوي على :digits أرقام.',
    'digits_between'       => ':attribute يجب أن يكون بين :min و :max أرقام.',
    'dimensions'           => 'أبعاد :attribute غير صالحة.',
    'distinct'             => 'حقل :attribute له قيمة مكررة.',
    'email'                => ':attribute يجب أن يكون بريد إلكتروني صالح.',
    'ends_with'            => ':attribute يجب أن ينتهي بواحد من القيم التالية: :values.',
    'exists'               => ':attribute المحدد غير صالح.',
    'file'                 => ':attribute يجب أن يكون ملف.',
    'filled'               => 'حقل :attribute مطلوب.',
    'gt'                   => [
        'numeric' => ':attribute يجب أن يكون أكبر من :value.',
        'file'    => ':attribute يجب أن يكون أكبر من :value كيلوبايت.',
        'string'  => ':attribute يجب أن يكون أكبر من :value حروف.',
        'array'   => ':attribute يجب أن يحتوي على أكثر من :value عناصر.',
    ],
    'gte'                  => [
        'numeric' => ':attribute يجب أن يكون أكبر أو يساوي :value.',
        'file'    => ':attribute يجب أن يكون أكبر أو يساوي :value كيلوبايت.',
        'string'  => ':attribute يجب أن يكون أكبر أو يساوي :value حروف.',
        'array'   => ':attribute يجب أن يحتوي على :value عناصر أو أكثر.',
    ],
    'image'                => ':attribute يجب أن يكون صورة.',
    'in'                   => ':attribute المحدد غير صالح.',
    'in_array'             => 'حقل :attribute غير موجود في :other.',
    'integer'              => ':attribute يجب أن يكون رقماً صحيحاً.',
    'ip'                   => ':attribute يجب أن يكون عنوان IP صالح.',
    'ipv4'                 => ':attribute يجب أن يكون عنوان IPv4 صالح.',
    'ipv6'                 => ':attribute يجب أن يكون عنوان IPv6 صالح.',
    'json'                 => ':attribute يجب أن يكون نص JSON صالح.',
    'lt'                   => [
        'numeric' => ':attribute يجب أن يكون أصغر من :value.',
        'file'    => ':attribute يجب أن يكون أصغر من :value كيلوبايت.',
        'string'  => ':attribute يجب أن يكون أصغر من :value حروف.',
        'array'   => ':attribute يجب أن يحتوي على أقل من :value عناصر.',
    ],
    'lte'                  => [
        'numeric' => ':attribute يجب أن يكون أصغر أو يساوي :value.',
        'file'    => ':attribute يجب أن يكون أصغر أو يساوي :value كيلوبايت.',
        'string'  => ':attribute يجب أن يكون أصغر أو يساوي :value حروف.',
        'array'   => ':attribute يجب ألا يحتوي على أكثر من :value عناصر.',
    ],
    'max'                  => [
        'numeric' => ':attribute يجب أن لا يزيد عن :max.',
        'file'    => ':attribute يجب أن لا يزيد عن :max كيلوبايت.',
        'string'  => ':attribute يجب أن لا يزيد عن :max حروف.',
        'array'   => ':attribute يجب أن لا يحتوي على أكثر من :max عناصر.',
    ],
    'mimes'                => ':attribute يجب أن يكون ملف من نوع: :values.',
    'mimetypes'            => ':attribute يجب أن يكون ملف من نوع: :values.',
    'min'                  => [
        'numeric' => ':attribute يجب أن يكون على الأقل :min.',
        'file'    => ':attribute يجب أن يكون على الأقل :min كيلوبايت.',
        'string'  => ':attribute يجب أن يكون على الأقل :min حروف.',
        'array'   => ':attribute يجب أن يحتوي على الأقل :min عناصر.',
    ],
    'not_in'               => ':attribute المحدد غير صالح.',
    'not_regex'            => 'صيغة :attribute غير صحيحة.',
    'numeric'              => ':attribute يجب أن يكون رقماً.',
    'password'             => 'كلمة المرور غير صحيحة.',
    'present'              => 'حقل :attribute يجب أن يكون موجوداً.',
    'regex'                => 'صيغة :attribute غير صحيحة.',
    'required'             => 'حقل :attribute مطلوب.',
    'required_if'          => 'حقل :attribute مطلوب عندما يكون :other بقيمة :value.',
    'required_unless'      => 'حقل :attribute مطلوب إلا إذا كان :other بقيمة :values.',
    'required_with'        => 'حقل :attribute مطلوب عندما يكون :values موجود.',
    'required_with_all'    => 'حقل :attribute مطلوب عندما تكون :values موجودة.',
    'required_without'     => 'حقل :attribute مطلوب عندما لا يكون :values موجود.',
    'required_without_all' => 'حقل :attribute مطلوب عندما لا يكون أي من :values موجود.',
    'same'                 => ':attribute و :other يجب أن يكونا متطابقين.',
    'size'                 => [
        'numeric' => ':attribute يجب أن يكون :size.',
        'file'    => ':attribute يجب أن يكون :size كيلوبايت.',
        'string'  => ':attribute يجب أن يكون :size حروف.',
        'array'   => ':attribute يجب أن يحتوي على :size عناصر.',
    ],
    'starts_with'          => ':attribute يجب أن يبدأ بأحد القيم التالية: :values.',
    'string'               => ':attribute يجب أن يكون نصاً.',
    'timezone'             => ':attribute يجب أن يكون منطقة صالحة.',
    'unique'               => ':attribute موجود مسبقاً.',
    'uploaded'             => 'فشل رفع :attribute.',
    'url'                  => 'صيغة :attribute غير صالحة.',
    'uuid'                 => ':attribute يجب أن يكون UUID صالحًا.',

    // الرسائل المخصصة
    'phone'                => 'رقم الجوال غير صالح أو لا يناسب الدولة المحددة.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | يمكن استخدام هذا القسم لتعريف أسماء حقيقية للحقول بدلاً من :attribute
    |
    */

    'attributes' => [
        'name' => 'الاسم',
        'email' => 'البريد الإلكتروني',
        'password' => 'كلمة المرور',
        'phone' => 'رقم الجوال',
        'birthday' => 'تاريخ الميلاد',
        'country' => 'الدولة',
        'address' => 'العنوان',
        'job_title' => 'المسمى الوظيفي',
        'bio' => 'نبذه عنك',
        'current_password' => 'كلمة المرور الحالية',
        'new_password' => 'كلمة المرور الجديدة',
        'new_password_confirmation' => 'تأكيد كلمة المرور الجديدة',
        'old_password' => 'كلمة المرور القديمة',
        'photo' => 'الصورة الشخصية',
        'title' => 'العنوان',
        'content' => 'المحتوى',
        'g-recaptcha-response' => 'التحقق البشري',
        'terms' => 'الشروط والأحكام'
        
    ],

];
