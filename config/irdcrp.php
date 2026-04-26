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
    | Hero slider: use high-resolution agriculture / rural field photos; keep style consistent.
    | Local: put files in public/images/ and set paths e.g. 'image' => '/images/hero-1.jpg'
    */
    'hero_slides' => [
        [
            'image' => 'https://images.unsplash.com/photo-1625246333195-78d9c38ad449?w=1920&q=80',
            'caption_en' => 'Strengthening climate-resilient rural livelihoods and sustainable agriculture.',
        ],
        [
            'image' => 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=1920&q=80',
            'caption_en' => 'Inclusive development linking communities with services, markets, and climate-smart practices.',
        ],
        [
            'image' => 'https://images.unsplash.com/photo-1523348837708-99d3599816ac?w=1920&q=80',
            'caption_en' => 'Supporting agriculture, livestock, and community resilience in project areas.',
        ],
    ],

    /*
    | Home: project overview (image + text uses resources/lang).
    */
    'home_overview' => [
        'image' => 'https://images.unsplash.com/photo-1504617069867-0fe7cc4d1af7?w=1200&q=80',
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
    | Optional Google Maps embed (iframe `src` URL). Leave null to hide map.
    | Example: 'https://www.google.com/maps/embed?pb=...'
    */
    'map_embed_url' => null,

    /*
    | Home: programme cards (order = display order). Titles + descriptions: messages.prog_{id} / prog_{id}_desc.
    */
    'programme_cards' => [
        ['id' => 'climate', 'image' => 'https://images.unsplash.com/photo-1563514227147-6d2ff665a6a0?w=800&q=80'],
        ['id' => 'agri', 'image' => 'https://images.unsplash.com/photo-1500937386664-56d1dfef3854?w=800&q=80'],
        ['id' => 'livestock', 'image' => 'https://images.unsplash.com/photo-1500595046743-cd271d694d30?w=800&q=80'],
        ['id' => 'irrigation', 'image' => 'https://images.unsplash.com/photo-1625246333195-78d9c38ad449?w=800&q=80'],
        ['id' => 'market', 'image' => 'https://images.unsplash.com/photo-1605000797499-2a9644d0d405?w=800&q=80'],
        ['id' => 'community', 'image' => 'https://images.unsplash.com/photo-1509099836639-18ba6e4450ee?w=800&q=80'],
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
