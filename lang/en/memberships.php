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

    // == General keys for Info-Box Component ==
    'more_details'          => 'More Details',
    'payment_bank_label'    => 'Bank',
    'payment_account_label' => 'Account Number',
    'payment_iban_label'    => 'IBAN',

    // == Registration Section: Top Info Box ==
    'info_box' => [
        'title'         => 'Invitation to Join the Professional Community for Clinical Dietitians',
        'subtitle'      => '🎯 A call for specialists and those interested in clinical nutrition',
        'description'   => 'We announce the launch of the professional community for clinical dietitians, which meets every 3 months to enhance communication and develop professional practice.',
        'highlights'    => [
            'Exchange of experiences and knowledge',
            'Discussion of the latest scientific and clinical updates',
            'Development of nutritional initiatives and projects',
            'Building a strong and supportive professional network',
            'Professional presence on social media platforms',
        ],
        'link_label'    => 'Our LinkedIn Page',
        'payment_title' => '💳 Payment Details',
        'payment_bank'  => 'AlAhli Bank', // The actual bank name
        'payment_note'  => 'Please transfer the registration fee (70 SAR) and attach a photo of the transfer receipt.',
    ],

    // == Registration Section: Form Header ==
    'form_header' => [
        'title'    => 'Join Us',
        'subtitle' => 'A few simple steps to book your seat. Please fill in the data accurately.',
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

    // == Registration Section: Proof of Payment ==
    'proof' => [
        'title'            => 'Proof of Registration',
        'upload_title'     => 'Attach Transfer Receipt',
        'upload_subtitle'  => 'Upload a clear image of the bank transfer receipt (Image or PDF)',
    ],

    // == Registration Section: Submit Button ==
    'submit_button' => 'Complete Registration Now',
];
