<?php

return [

    /*
    | Public header / partner logos (files in public/images).
    */
    'logos' => [
        'irdcrp' => 'images/irdcrp-logo.png',
        'emblem' => 'images/sri-lanka-emblem.png',
        // SVG: sharp on all screens; replace with official press-kit PNG if you prefer
        'world_bank' => 'images/world-bank.svg',
    ],

    /*
    | Trilingual project titles shown together on the home page.
    | Edit these to match official wording in each language.
    */
    'project_name' => [
        // Replace with officially approved wording when available.
        'si' => 'ඒකාබද්ධ ග්‍රාමීය-නාගරික සංවර්ධන සහ දේශගුණ ඔරොත්තුව ව්‍යාපෘතිය',
        'ta' => 'ஒருங்கிணைந்த ஊரக-நகர்ப்புற வளர்ச்சி மற்றும் காலநிலை மீட்சித் திட்டம்',
        'en' => 'Integrated Rurban Development and Climate Resilience Project',
    ],

    'ministry_line_en' => 'Ministry of Agriculture, Livestock, Land, and Irrigation',

    'contact' => [
        'phone' => '+94-11 000 0000',
        'email' => 'info@irdcrp.lk',
        'address' => 'IRDCRP Project Management Unit, Colombo, Sri Lanka',
    ],

    'social' => [
        'facebook' => 'https://www.facebook.com/',
        'twitter' => 'https://twitter.com/',
        'youtube' => 'https://www.youtube.com/',
        'linkedin' => 'https://www.linkedin.com/',
    ],

    /*
    | Hero slider: local files in public/images/hero/ (leading / = site root).
    */
    'hero_slides' => [
        [
            'image' => '/images/hero/hero-07-solar-farm.png',
            'caption_en' => 'Clean energy and climate-smart farming — linking productivity with sustainability across project areas.',
        ],
        [
            'image' => '/images/hero/hero-01-drip-seedlings.png',
            'caption_en' => 'Efficient water use and good agricultural practices for resilient crops and soils.',
        ],
        [
            'image' => '/images/hero/hero-05-farmer-tiller.png',
            'caption_en' => 'Supporting smallholders with tools, training, and market links in the field.',
        ],
        [
            'image' => '/images/hero/hero-06-aerial-paddies.png',
            'caption_en' => 'Landscape-scale resilience — water, land, and communities working together.',
        ],
        [
            'image' => '/images/hero/hero-03-tractor-field.png',
            'caption_en' => 'Strengthening agriculture and rural livelihoods where it matters most.',
        ],
        [
            'image' => '/images/hero/hero-02-rural-hut.png',
            'caption_en' => 'Inclusive rural and rurban development rooted in local communities.',
        ],
        [
            'image' => '/images/hero/hero-04-smart-agriculture.png',
            'caption_en' => 'Digital tools and innovation to monitor, learn, and scale climate-smart approaches.',
        ],
    ],

    /*
    | Home: project overview (image + text uses resources/lang).
    */
    'home_overview' => [
        'image' => '/images/hero/hero-07-solar-farm.png',
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
            'fallback' => '/images/hero/hero-05-farmer-tiller.png',
            'role' => 'leader_role_minister',
            'org' => 'leader_org_malla',
        ],
        [
            'id' => 'secretary',
            'image' => '/images/leaders/secretary.jpg',
            'fallback' => '/images/hero/hero-03-tractor-field.png',
            'role' => 'leader_role_secretary',
            'org' => 'leader_org_malla',
        ],
        [
            'id' => 'project_director',
            'image' => '/images/leaders/project-director.jpg',
            'fallback' => '/images/hero/hero-01-drip-seedlings.png',
            'role' => 'leader_role_project_director',
            'org' => 'leader_org_irdcrp_pmu',
        ],
        [
            'id' => 'world_bank',
            'image' => '/images/leaders/world-bank-representative.jpg',
            'fallback' => '/images/hero/hero-07-solar-farm.png',
            'role' => 'leader_role_wb_representative',
            'org' => 'leader_org_world_bank',
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
        ['id' => 'climate', 'image' => '/images/hero/hero-07-solar-farm.png'],
        ['id' => 'agri', 'image' => '/images/hero/hero-01-drip-seedlings.png'],
        ['id' => 'livestock', 'image' => '/images/hero/hero-05-farmer-tiller.png'],
        ['id' => 'irrigation', 'image' => '/images/hero/hero-06-aerial-paddies.png'],
        ['id' => 'market', 'image' => '/images/hero/hero-03-tractor-field.png'],
        ['id' => 'community', 'image' => '/images/hero/hero-02-rural-hut.png'],
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
];
