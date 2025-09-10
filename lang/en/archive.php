
<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Archive Page Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used for the archive section.
    |
    */

    // Keys for the archive detail page

    // Keys for the main archive listing page
    'page' => [
        'title' => 'Events Archive',
        'subtitle' => 'Explore our rich library of past workshops and meetings.',
    ],
     'no_videos' => '🚫 No videos available to display at the moment.',
    'playlist' =>' ▶ Playlist',


    'filters' => [
        'all' => 'All',
        'search_placeholder' => 'Search in the archive...',
    ],

    // Sample data for archive cards
    'samples' => [
        ['title' => 'First Alumni Meeting'],
        ['title' => 'Workshop: Vue.js Basics'],
        ['title' => 'Monthly Meetup: Latest in AI'],
    ],

    // Keys for the archive detail page
    'details' => [
        'hero_alt' => 'Background image for :title',
        'about_title' => 'About the Event',
        'videos_title' => 'Event Recordings',
        'images_title' => 'Event Highlights',
        'files_title' => 'Files and Resources',
    ],

    // Sample event data (for demo purposes)
    'sample_event' => [
        'title' => 'First Alumni Meeting: Building the Future',
        'description' => 'This historic first meeting brought together graduates from different batches in an open dialogue about the future of the industry, its challenges, and opportunities. It featured highlights of achievements and discussions on collaboration, along with specialized workshops that enhanced participants’ skills and opened new horizons for knowledge and innovation.',

        'tags' => [
            'Annual Meeting',
            'Alumni',
            'Networking',
            'Technology',
        ],

        'videos' => [
            'Event Opening Speech',
            'Discussion Session: Future Challenges and Opportunities',
            'A Look at the Future of Technology and Innovation',
        ],

        'files' => [
            ['name' => 'Summary of Sessions and Discussions.pdf'],
            ['name' => 'Main Presentation.pptx'],
        ],
    ],
];
