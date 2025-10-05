<?php

// lang/en/memberships.php

return [
    /*
    |--------------------------------------------------------------------------
    | Memberships & Registration Translations
    |--------------------------------------------------------------------------
    |
    | The following lines contain all the text used in the membership
    | and registration pages and forms.
    |
    */



    // == Registration Section: Form Header ==
    'form_header' => [
        'title'    => 'Complete Order Now',
        'subtitle' => 'Complete your membership application now and fill out the form to finalize your registration',
    ],

    // == Registration Section: Personal Information ==
    'personal_info' => [
        'title'     => 'Your Personal Information',
        'full_name' => 'Full Name',
        'email'     => 'Email Address',
        'phone'     => 'Mobile Number',
        'id_number' => 'ID Number',
    ],

    // == Registration Section: Professional Information ==
    'professional_info' => [
        'title'                => 'Your Professional Information',
        'status'               => 'Employment Status',
        'status_placeholder'   => 'Select status...',
        'status_employee'      => 'Employee',
        'status_graduate'      => 'Graduate',
        'status_student'       => 'Student',
        'job_title'            => 'Job Title',
        'workplace'            => 'Current Workplace (if any)',
        'scfhs_number'         => 'SCFHS Number',
    ],

      // == File Upload Component Keys (Professional Design) ==
    'upload' => [
        'default_title'           => 'Attach Documents',
        'default_subtitle'        => 'Upload the required files here.',
        'drop_or_click'           => 'Drop file here or <span class="filepond--label-action"> browse your device </span>',
        'supported_files_detailed'=> 'Supports Images (PNG, JPG) and PDF (Max :size)',
        'processing'              => 'Processing...',
        'complete'                => 'Upload complete',
        'tap_to_undo'             => 'Tap to undo',
        'tap_to_cancel'           => 'Tap to cancel',
    ],

    // == Proof of Registration Section Keys ==
    'proof' => [
        'title'           => 'Proof of Registration',
        'upload_subtitle' => 'To complete your registration, please attach a clear image of the bank transfer receipt.',
    ],
    // == Registration Section: Submit Button ==
    'submit_button' => 'Complete Registration Now',
    'save_percentage' => 'Save (:percentage%)',
    'save_amount' => 'Save :amount SAR',
    // Get 12 months for US$ 124.32 (regular price US$ 575.52). Renewing at US$ 10.99/month.
    'discounted_price_note' => 'Get :months months for :discounted_price SAR (regular price :regular_price SAR). Renewing at :regular_price SAR/month.',
];
