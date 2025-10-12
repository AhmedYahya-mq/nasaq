<?php

return [
    'employment_status' => [
        'student'      => 'Student',
        'graduate'     => 'Graduate',
        'licensed'     => 'Licensed',
        'academic'     => 'Academic',
        'entrepreneur' => 'Entrepreneur',
        'employed'     => 'Employed',
        'unemployed'   => 'Unemployed',
    ],
    'membership_status' => [
        'none'    => 'No Membership',
        'active'  => 'Active',
        'expired' => 'Expired',
    ],
    'membership_application' => [
        'draft'     => 'Draft',
        'pending'  => 'Pending',
        'approved' => 'Approved',
        'rejected' => 'Rejected',
        'cancelled' => 'Cancelled',
        'Holded' => 'Holded',
    ],
    'membership_status_message' => [
        'none'    => 'You do not have an active membership. Please consider subscribing to one of our plans.',
        'active'  => 'Your membership is active. Enjoy the benefits and features available to you!',
        'expired' => 'Your membership has expired. Please renew your membership to continue enjoying the benefits.',
    ],
    'membership_application_message' => [
        'draft' => 'Your application has been successfully saved as a draft. You can review the details and update your application at any time before final submission. Thank you for using our services.',
        'pending' => 'Your application is currently under review by the community management. It may take up to 48 hours to respond. Thank you for your patience!',
        'approved' => 'Congratulations! Your application to join the community has been approved. You can now enjoy all the membership benefits.',
        'rejected' => 'We are sorry, your application to join the community has not been approved at this time. You may review your information and reapply if you wish.',
        'cancelled' => 'Your membership has been cancelled. If you have any questions, please contact support.',
    ],

    'event_type' => [
        'virtual' => 'Virtual',
        'physical' => 'Physical',
    ],
    'event_type_message' => [
        'virtual' => 'This event will be held online. Please ensure you have a good internet connection.',
        'physical' => 'This event will be held at a physical location. Please review the details regarding the venue and time.',
    ],
    'event_status' => [
        'upcoming' => 'Upcoming',
        'ongoing' => 'Ongoing',
        'finished' => 'Finished',
        'cancelled' => 'Cancelled',
    ],
    'event_status_message' => [
        'upcoming' => 'This event is upcoming. Stay tuned for more details soon!',
        'ongoing' => 'This event is currently ongoing. Join us and enjoy the participation!',
        'finished' => 'This event has finished. Thank you for participating with us!',
        'cancelled' => 'This event has been cancelled. We apologize for any inconvenience this  may have caused.',
    ],
    'event_category' => [
        'Workshop' => 'Workshop',
        'Seminar' => 'Seminar',
        'Lecture' => 'Lecture',
        'QandASession' => 'Q&A Session',
        'FieldVisit' => 'Field Visit',
    ],
    'event_category_message' => [
        'Workshop' => 'Join this workshop to enhance your practical skills and learn from experts in the field.',
        'Seminar' => 'Participate in this seminar to gain new insights and engage in fruitful discussions on current topics.',
        'Lecture' => 'Listen to an inspiring lecture by experts in the field and gain new knowledge.',
        'QandASession' => 'Join this Q&A session to get direct answers from the speakers.',
        'FieldVisit' => 'Join the field visit to gain practical experience and a deeper understanding of the field.',
    ],

    'event_method' => [
        'zoom' => 'Zoom',
        'google_meet' => 'Google Meet',
        'microsoft_teams' => 'Microsoft Teams',
        'other' => 'Other',
    ],
    'event_method_message' => [
        'zoom' => 'This event will be held via Zoom. Please ensure you have the Zoom application installed and a stable internet connection.',
        'google_meet' => 'This event will be held via Google Meet. Please ensure you have a Google account and a stable internet connection.',
        'microsoft_teams' => 'This event will be held via Microsoft Teams. Please ensure you have the Microsoft Teams application installed and a stable internet connection.',
        'other' => 'This event will be held using another platform. Please check the event details for more information.',
    ],

    'library_type' => [
        'E-books' => 'E-books',
        'Research Papers' => 'Research Papers',
        'Tutorials' => 'Tutorials',
        'Case Studies' => 'Case Studies',
        'White Papers' => 'White Papers',
    ],
    'library_type_message' => [
        'E-books' => 'Explore our collection of e-books covering various topics and genres.',
        'Research Papers' => 'Access a wide range of research papers from different fields and disciplines.',
        'Tutorials' => 'Find step-by-step tutorials to help you learn new skills and techniques.',
        'Case Studies' => 'Read detailed case studies that provide insights into real-world scenarios.',
        'White Papers' => 'Discover in-depth white papers on industry trends and best practices.',
    ],

    'library_status' => [
        'draft' => 'Draft',
        'published' => 'Published',
        'archived' => 'Archived',
    ],

    'library_status_message' => [
        'draft' => 'This library item is currently in draft status and is not yet available to the public.',
        'published' => 'This library item is published and available for access by users.',
        'archived' => 'This library item has been archived and is no longer actively maintained or updated.',
    ],
    
];
