<?php

return [

    /*
    | Public header / partner logos (files in public/images).
    */
    'logos' => [
        'irdcrp' => 'images/irdcrp-logo.png',
        'emblem' => 'images/sri-lanka-emblem.png',
        // Official World Bank PNG logo with white background
        'world_bank' => 'images/world-bank.png',
    ],

    /*
    | Trilingual project titles shown together on the home page.
    | Edit these to match official wording in each language.
    */
    'project_name' => [
        'si' => 'ඒකාබද්ධ ග්රාම-නගර සංවර්ධන සහ දේශගුණික තත්ත්වයන්ට ඔරොත්තුදීමේ ව්යාපෘතිය',
        'ta' => 'ஒருங்கிணைந்த கிராம-நகர அபிவிருத்தி மற்றும் காலநிலை மீள்திறன் செயற்றிட்டம்',
        'en' => 'Integrated Rurban Development and Climate Resilience Project',
    ],

    'ministry_line_en' => 'Ministry of Agriculture, Livestock, Land, and Irrigation',

    'contact' => [
        'phone' => '011 2877 550',
        'email' => 'pmuirdcrp@gmail.com',
        'address' => 'No 123/2, Pannipitiya Road, Battaramulla, Sri Lanka',
        'location' => [
            'title' => 'Our Location',
            'unit' => 'Project Management Unit',
            'project' => 'Integrated Rurban Development and Climate Resilience Project (IRDCRP)',
            'place_name' => 'Integrated Rurban Development and Climate Resilience Project',
            'latitude' => 6.899084155589944,
            'longitude' => 79.9232443227406,
            'map_zoom' => 19,
            'maps_url' => 'https://maps.app.goo.gl/mZs7sKe5QPZhr9gR8',
            'image' => '/images/contact/pmu-office.png',
            'image_caption' => 'Office entrance — look for this sign when you arrive',
        ],
    ],

    'social' => [
        'facebook' => 'https://www.facebook.com/',
        'twitter' => 'https://twitter.com/',
        'youtube' => 'https://www.youtube.com/',
        'linkedin' => 'https://www.linkedin.com/',
        'instagram' => 'https://www.instagram.com/',
    ],

    'social_icons' => [
        'facebook' => 'images/social/facebook.png',
        'youtube' => 'images/social/youtube.png',
        'twitter' => 'images/social/twitter.png',
        'linkedin' => 'images/social/linkedin.png',
        'instagram' => 'images/social/instagram.png',
    ],

    /*
    | Launching soon mode.
    | When enabled, public frontend routes show the launch page while admin/login
    | routes remain available for website updates.
    */
    'launching_soon' => [
        'enabled' => env('IRDCRP_LAUNCHING_SOON', true),
    ],

    /*
    | Locked super-admin account for website maintenance.
    */
    'super_admin' => [
        'name' => env('IRDCRP_SUPER_ADMIN_NAME', 'Super Admin'),
        'login' => env('IRDCRP_SUPER_ADMIN_LOGIN', 'irdcrpadmin.lk'),
        'password' => env('IRDCRP_SUPER_ADMIN_PASSWORD', 'irdcrp123@123'),
    ],

    /*
    | Hero slider: local files in public/images/hero/ (leading / = site root).
    */
    'hero_slides' => [
        [
            'image' => '/images/hero/sky.jpeg',
            'caption_en' => 'Climate-smart agriculture — resilient landscapes and productive farming systems across project areas.',
        ],
        [
            'image' => '/images/hero/hero-home-02.png',
            'caption_en' => 'Quality harvests from the field — growers proudly showcase fresh, healthy produce.',
        ],
        [
            'image' => '/images/hero/hero-home-03.png',
            'caption_en' => 'Vegetable farming and resilient livelihoods — vibrant fields and inclusive rural development.',
        ],
        [
            'image' => '/images/hero/hero-home-04.png',
            'caption_en' => 'Organised plots from above — good agricultural practices and productive land use.',
        ],
        [
            'image' => '/images/hero/hero-home-05.png',
            'caption_en' => 'Plantation and coconut livelihoods — carrying the harvest with pride.',
        ],
        [
            'image' => '/images/hero/hero-home-06.png',
            'caption_en' => 'Hands-on cultivation — high-value crops like chillies grown with care in the field.',
        ],
        [
            'image' => '/images/hero/hero-home-07.png',
            'caption_en' => 'On-farm equipment and green practices — processing biomass for climate-smart agriculture.',
        ],
    ],

    /*
    | Home: project overview (image + text uses resources/lang).
    */
    'home_overview' => [
        'image' => '/images/hero/hero-home-02.png',
    ],

    /*
    | Home: impact / statistics (edit numbers as implementation progresses).
    */
    'home_stats' => [
        'districts' => '—',
        'beneficiaries' => '—',
        'farmers' => '—',
        'duration' => '—',
    ],

    /*
    | Fallback key leaders when the database table is empty (after migrate, use Admin → Key leaders).
    | Optional: php artisan db:seed --class=KeyLeaderSeeder copies these message keys into the DB.
    */
    'key_leaders' => [
        [
            'id' => 'minister',
            'image' => '/images/leaders/minister.jpg',
            'fallback' => '/images/hero/hero-home-02.png',
            'role' => 'leader_role_minister',
            'org' => 'leader_org_malla',
        ],
        [
            'id' => 'secretary',
            'image' => '/images/leaders/secretary.jpg',
            'fallback' => '/images/hero/hero-home-03.png',
            'role' => 'leader_role_secretary',
            'org' => 'leader_org_malla',
        ],
        [
            'id' => 'project_director',
            'image' => '/images/leaders/project-director.jpg',
            'fallback' => '/images/hero/hero-home-04.png',
            'role' => 'leader_role_project_director',
            'org' => 'leader_org_irdcrp_pmu',
        ],
        [
            'id' => 'world_bank',
            'image' => '/images/leaders/world-bank-representative.jpg',
            'fallback' => '/images/hero/hero-home-05.png',
            'role' => 'leader_role_wb_representative',
            'org' => 'leader_org_world_bank',
        ],
        [
            'id' => 'additional_key_leader',
            'image' => '/images/leaders/additional-key-leader.jpg',
            'fallback' => '/images/hero/hero-home-06.png',
            'role' => 'leader_role_additional_key_leader',
            'org' => 'leader_org_irdcrp_pmu',
        ],
    ],

    /*
    | Optional Google Maps embed (iframe `src` URL). Leave null to hide map.
    | Example: 'https://www.google.com/maps/embed?pb=...'
    */
    'map_embed_url' => null,

    /*
    | Home weather strip: district list + Open-Meteo (no API key). Optional per-area `image` path under /public.
    */
    'weather_default_image' => 'images/weather/implementation-area.png',

    'weather_areas' => [
        ['id' => 'ampara', 'lat' => 7.297, 'lon' => 81.679, 'name' => ['en' => 'Ampara', 'si' => 'අම්පාර', 'ta' => 'அம்பாறை']],
        ['id' => 'anuradhapura', 'lat' => 8.311, 'lon' => 80.404, 'name' => ['en' => 'Anuradhapura', 'si' => 'අනුරාධපුර', 'ta' => 'அனுராதபுரம்']],
        ['id' => 'batticaloa', 'lat' => 7.731, 'lon' => 81.675, 'name' => ['en' => 'Batticaloa', 'si' => 'මඩකලපුව', 'ta' => 'மட்டக்களப்பு']],
        ['id' => 'hambantota', 'lat' => 6.124, 'lon' => 81.119, 'name' => ['en' => 'Hambantota', 'si' => 'හම්බන්තොට', 'ta' => 'அம்பாந்தோட்டை']],
        ['id' => 'kilinochchi', 'lat' => 9.396, 'lon' => 80.398, 'name' => ['en' => 'Kilinochchi', 'si' => 'කිලිනොච්චි', 'ta' => 'கிளிநொச்சி']],
        ['id' => 'kurunegala', 'lat' => 7.504, 'lon' => 80.399, 'name' => ['en' => 'Kurunegala', 'si' => 'කුරුණෑගල', 'ta' => 'குருணாகல்']],
        ['id' => 'moneragala', 'lat' => 6.890, 'lon' => 81.346, 'name' => ['en' => 'Moneragala', 'si' => 'මොනරාගල', 'ta' => 'மொனராகலை']],
        ['id' => 'mullaitivu', 'lat' => 9.267, 'lon' => 80.814, 'name' => ['en' => 'Mullaitivu', 'si' => 'මුලතිව්', 'ta' => 'முல்லைத்தீவு']],
        ['id' => 'polonnaruwa', 'lat' => 7.940, 'lon' => 81.019, 'name' => ['en' => 'Polonnaruwa', 'si' => 'පොළොන්නරුව', 'ta' => 'பொலன்னறுவை']],
        ['id' => 'puttalam', 'lat' => 8.025, 'lon' => 79.828, 'name' => ['en' => 'Puttalam', 'si' => 'පුත්තලම', 'ta' => 'புத்தளம்']],
        ['id' => 'trincomalee', 'lat' => 8.587, 'lon' => 81.215, 'name' => ['en' => 'Trincomalee', 'si' => 'ත්‍රිකුණාමලය', 'ta' => 'திருகோணமலை']],
    ],

    /*
    | Home: programme cards (order = display order). Titles + descriptions: messages.prog_{id} / prog_{id}_desc.
    */
    'programme_cards' => [
        ['id' => 'climate', 'image' => '/images/hero/hero-home-01.png'],
        ['id' => 'agri', 'image' => '/images/hero/hero-home-02.png'],
        ['id' => 'livestock', 'image' => '/images/hero/hero-home-03.png'],
        ['id' => 'irrigation', 'image' => '/images/hero/hero-home-04.png'],
        ['id' => 'market', 'image' => '/images/hero/hero-home-05.png'],
        ['id' => 'community', 'image' => '/images/hero/hero-home-06.png'],
    ],

    /*
    | Krushi TV / YouTube: channel URL and video IDs to embed (admin-driven later).
    */
    'youtube' => [
        'channel_url' => 'https://www.youtube.com/',
        // Public embed IDs to show on the home page; replace with Krushi TV / project channel clips.
        'embed_ids' => [
            'M7lc1UVf-VE',
        ],
    ],

    /*
    | About Us page defaults (used until admin publishes custom content).
    */
    'about_page' => [
        'status' => 'published',
        'hero_title' => 'About Us',
        'hero_subtitle' => 'Learn More About Our Mission & Goals',
        'mission_title' => 'Our Mission',
        'mission_text' => 'To enhance the resilience and livelihoods of rural communities through sustainable development, water resource management, and climate adaptation.',
        'objectives_title' => 'Our Objectives',
        'objectives_text' => 'To resolve rural challenges, improve infrastructure, and foster inclusive growth through practical and climate-smart project interventions.',
        'grievance_heading' => 'Conflicts Mediation & Grievance Redressal',
        'grievance_lead' => 'We provide a transparent and systematic approach to addressing grievances and resolving conflicts within project areas.',
        'grievance_cards' => [
            ['title' => 'Fair Process', 'text' => 'Ensuring impartial and timely redress for all stakeholders.'],
            ['title' => 'Safe & Secure', 'text' => 'Protecting the rights and confidentiality of all participants.'],
            ['title' => 'Community Trust', 'text' => 'Building confidence and cooperation through responsive grievance handling.'],
        ],
        'why_heading' => 'Why Choose Us?',
        'why_cards' => [
            ['title' => 'Experienced Team', 'text' => 'Expertise you can trust across agriculture and climate resilience.'],
            ['title' => 'Proven Results', 'text' => 'Positive impact and measurable outcomes in partner communities.'],
            ['title' => 'Sustainable Approach', 'text' => 'Long-term, inclusive development with strong local ownership.'],
        ],
    ],
];
