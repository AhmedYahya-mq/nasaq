<?php

return [
    [
        "name" => "header.home",
        'route' => "client.home",
        'active' => fn() => request()->routeIs(['client.home', 'client.locale.home']),
    ],
    [
        "name" => "header.about",
        'route' => "client.about",
        'active' => fn() => request()->routeIs(['client.about', 'client.locale.about']),
    ],
    [
        'name' => "header.events",
        'route' => "client.events",
        'active' => fn() => request()->routeIs(['client.events', 'client.locale.events']),
    ],
    // library
    [
        'name' => 'header.library',
        'route' => 'client.library',
        'active' => fn() => request()->routeIs(['client.library', 'client.locale.library'])
    ],
    // blogs
    [
        'name' => 'header.blogs',
        'route' => 'client.blogs',
        'active' => fn() => request()->routeIs(['client.blogs', 'client.locale.blogs'])
    ],
    // [
    //     "name" => "header.resources",
    //     "subMenuHeading" => ["header.get_started", "header.programs", "header.recent"],
    //     "subMenu" => [
    //         [
    //             "name" => "header.marketplace",
    //             "desc" => "header.browse_templates",
    //             "icon" => "ShoppingBag",
    //         ],
    //         [
    //             "name" => "header.meetups",
    //             "desc" => "header.upcoming_events",
    //             "icon" => "MapPin",
    //         ],
    //         [
    //             "name" => "header.updates",
    //             "desc" => "header.changelog",
    //             "icon" => "BellDot",
    //         ],
    //         [
    //             "name" => "header.academy",
    //             "desc" => "header.watch_lessons",
    //             "icon" => "Play",
    //         ],
    //         [
    //             "name" => "header.blog",
    //             "desc" => "header.posts",
    //             "icon" => "BookOpenText",
    //         ],
    //         [
    //             "name" => "header.figma",
    //             "desc" => "header.plugin",
    //             "icon" => "Figma",
    //         ],
    //         [
    //             "name" => "header.experts",
    //             "desc" => "header.jobs",
    //             "icon" => "BriefcaseBusiness",
    //         ],
    //         [
    //             "name" => "header.gallery",
    //             "desc" => "header.images",
    //             "icon" => "Images",
    //         ],
    //     ],
    //     "gridCols" => 3,
    // ],
    // [
    //     "name" => "header.support",
    //     "subMenu" => [
    //         [
    //             "name" => "header.help",
    //             "desc" => "header.center",
    //             "icon" => "CircleHelp",
    //         ],
    //         [
    //             "name" => "header.community",
    //             "desc" => "header.project_help",
    //             "icon" => "MessageCircle",
    //         ],
    //         [
    //             "name" => "header.emergency",
    //             "desc" => "header.urgent_issues",
    //             "icon" => "TriangleAlert",
    //         ],
    //     ],
    //     "gridCols" => 1,
    // ],
    // [
    //     "name" => "header.enterprise",
    //     "subMenuHeading" => ["header.overview", "header.features"],
    //     "subMenu" => [
    //         [
    //             "name" => "header.enterprise",
    //             "desc" => "header.overview",
    //             "icon" => "ShieldPlus",
    //         ],
    //         [
    //             "name" => "header.collaboration",
    //             "desc" => "header.design_together",
    //             "icon" => "Users",
    //         ],
    //         [
    //             "name" => "header.customers",
    //             "desc" => "header.stories",
    //             "icon" => "Dessert",
    //         ],
    //         [
    //             "name" => "header.security",
    //             "desc" => "header.your_site_secured",
    //             "icon" => "Lock",
    //         ],
    //     ],
    //     "gridCols" => 2,
    // ],
    // [
    //     "name" => "header.pricing",
    // ],
    // [
    //     "name" => "header.contact",
    // ],
];
