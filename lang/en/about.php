<?php

return [

    // --- Hero Section ---
    'hero' => [
        'title' => 'About Us - Nasaq Community  ',
        'description' => 'Nasaq is a Saudi professional community for clinical nutrition specialists, dedicated to knowledge sharing, professional growth, and collaboration opportunities.',
        'point1' => 'A professional network with top experts and practitioners.',
        'point2' => 'Access to advanced training and professional development.',
        'point3' => 'A supportive community fostering collaboration and innovation.',
        'cta_primary' => 'Join Now',
        'cta_secondary' => 'Discover Our Vision',
    ],
'vision_title' => 'Our Vision',
    'vision_text'  => 'We aim to be the leading professional platform that reshapes the presence of clinical nutrition specialists and empowers them to make a meaningful impact across diverse pathways: clinical, academic, research, media, and entrepreneurship.',
    'vision_points' => [
        'Enhancing the role of nutrition specialists in society and healthcare.',
        'Advancing professional knowledge and skills with the latest updates.',
        'Fostering opportunities for collaboration and innovation in clinical nutrition.',
        'Building a new generation of leaders in nutrition and public health.',
    ],

    'mission_title' => 'Our Mission',
    'mission_text'  => 'We are committed to providing an interactive professional environment that supports continuous learning, knowledge exchange, and empowers specialists to deliver tangible impact that enhances public health and quality of life.',
    'mission_points' => [
        'Providing reliable scientific content and innovative professional tools.',
        'Organizing specialized training programs and workshops.',
        'Facilitating access to the latest research and digital resources.',
        'Empowering members to build effective professional networks.',
        'Highlighting success stories and supporting entrepreneurial initiatives in nutrition.',
    ],
    // --- Goals Section ---
    'goals' => [
        'title' => 'Our Strategic Goals',
        'list' => [
            'Build a Saudi professional network of clinical dietitians.',
            'Establish quarterly face-to-face meetings for education and discussion.',
            'Enable specialists to build flexible and impactful career paths.',
            'Enhance the professional presence of specialists through media and conferences.',
            'Open opportunities for innovative nutritional initiatives and projects.',
        ],
    ],

    // --- Communication Section ---
    'communication' => [
        'title' => 'Communication Mechanism in Nasaq Community',
        'methods' => [
            [
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m-7.5-2.962a3.75 3.75 0 015.962 0L14.25 18l-2.962 2.962a3.75 3.75 0 01-5.962 0L5.32 18.72m-2.096-2.096a3.75 3.75 0 010-5.962L5.32 8.59l2.962-2.962a3.75 3.75 0 015.962 0L18 8.59l2.096 2.096a3.75 3.75 0 010 5.962l-2.096 2.096" /></svg>',
                'title' => 'Quarterly In-Person Meeting',
                'desc' => 'A meeting every 3 months to build professional relationships and discuss challenges and solutions directly.',
            ],
            [
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" d="M15.75 10.5l4.72-4.72a.75.75 0 011.28.53v11.38a.75.75 0 01-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 002.25-2.25v-9A2.25 2.25 0 0013.5 5.25h-9A2.25 2.25 0 002.25 7.5v9A2.25 2.25 0 004.5 18.75z" /></svg>',
                'title' => 'Monthly Virtual Meeting',
                'desc' => 'An interactive session via Zoom to exchange expertise and discuss emerging professional topics.',
                'note' => 'Mandatory, requires camera and voice participation to ensure maximum benefit.',
            ],
            [
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>',
                'title' => 'Electronic Communication Channels',
                'desc' => 'An exclusive WhatsApp group for members to enhance daily interaction, ask quick questions, and share opportunities.',
            ],
        ],
    ],

    // --- Audience Section ---

'memberships' => [
    'title' => 'Membership Types',
    'subtitle' => 'Choose the membership that best fits your professional journey in Clinical Nutrition.',
    'join_now' => 'Join Now',
    'requirements_title' => 'Requirements',
    'benefits_title' => 'Benefits',
    'billing_cycle' => 'Annually',

    'types' => [
        [
            'title' => 'Student Membership',
            'desc' => 'Undergraduate students in Clinical Nutrition programs',
            'price' => 100,
            'requirements' => [
                'Recent university enrollment proof',
                'Active participation in monthly Zoom meetings (camera on and verbal participation required)',
                'Attend at least one in-person event annually (mandatory only for residents of Makkah/Jeddah)',
            ],
            'benefits' => [
                'Membership certificate',
                'Discount on monthly sessions',
                'Invitation to student-focused events such as career guidance days or educational workshops',
                'Recommended to attend in-person meetings every 3 months',
                'Professional Mentorship program with certified specialists',
                'Access to digital educational resources and the latest research/recommendations',
            ],
        ],
        [
            'title' => 'Graduate / Intern Membership',
            'desc' => 'Clinical Nutrition graduates awaiting license or in internship training',
            'price' => 150,
            'requirements' => [
                'Graduation certificate or proof of internship/rotation',
                'Active participation in monthly Zoom meetings (camera on and verbal participation required)',
                'Attend at least one in-person event annually (mandatory only for residents of Makkah/Jeddah)',
            ],
            'benefits' => [
                'Membership certificate',
                'Discount on monthly sessions',
                'Priority in attending in-person meetings every 3 months',
                'Preparatory sessions for SCFHS exam',
                'Professional Mentorship program with certified specialists',
                'Access to digital educational resources and the latest research/recommendations',
            ],
        ],
        [
            'title' => 'Licensed Specialist Membership',
            'desc' => 'Clinical Nutrition Specialist holding a valid license from the Saudi Commission for Health Specialties (SCFHS)',
            'price' => 250,
            'requirements' => [
                'Valid SCFHS license',
                'Active participation in monthly Zoom meetings (camera on and verbal participation required)',
                'Attend at least one in-person event annually (mandatory only for residents of Makkah/Jeddah)',
            ],
            'benefits' => [
                'Membership certificate',
                'Free access to all sessions and events',
                'Priority in applying as a speaker in events',
                'Voting rights and participation in “Nasaq” committees',
                'Member of exclusive “Nasaq” committee group',
                'Rights to vote and suggest topics',
            ],
        ],
        [
            'title' => 'Researcher / Academic Membership',
            'desc' => 'Faculty members, postgraduate students, and researchers in Clinical Nutrition',
            'price' => 300,
            'requirements' => [
                'Proof of active academic or research affiliation',
                'Published or contributed to a scientific paper within the last two years (recommended)',
                'Active participation in monthly Zoom meetings (camera on and verbal participation required)',
                'Attend at least one in-person event annually (mandatory only for residents of Makkah/Jeddah)',
            ],
            'benefits' => [
                'Membership certificate',
                'Free access to all sessions and events',
                'Priority in applying as a speaker in events',
                'Voting rights and participation in “Nasaq” committees',
                'Member of exclusive “Nasaq” committee group',
                'Rights to vote and suggest topics',
                'Opportunities for collaboration in scientific initiatives',
                'Knowledge-sharing sessions with local and international researchers',
                'Priority in presenting research abstracts at events',
            ],
        ],
        [
            'title' => 'Entrepreneur Membership',
            'desc' => 'For individuals interested in health and nutrition-related businesses to grow their ventures.',
            'price' => 350,
            'requirements' => [
                'Proof of providing services or content related to Clinical Nutrition',
                'Active participation in monthly Zoom meetings (camera on and verbal participation required)',
                'Attend at least one in-person event annually (mandatory only for residents of Makkah/Jeddah)',
            ],
            'benefits' => [
                'Membership certificate',
                'Free access to all sessions and events',
                'Priority in applying as a speaker in events',
                'Voting rights and participation in “Nasaq” committees',
                'Member of exclusive “Nasaq” committee group',
                'Rights to vote and suggest topics',
                'Workshops on marketing and brand building',
                'Listing in Nasaq’s online business directory (promotion for your project)',
            ],
        ],
    ],
],

];
