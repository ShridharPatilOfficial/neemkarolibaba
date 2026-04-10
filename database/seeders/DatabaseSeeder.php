<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Admin User ────────────────────────────────────────────────────────
        DB::table('admin_users')->insertOrIgnore([
            'name'       => 'Admin',
            'email'      => 'admin@nkbfoundation.org',
            'password'   => Hash::make('Admin@1234'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // ── Site Settings ─────────────────────────────────────────────────────
        $siteSettings = [
            'site_name'        => 'Neem Karoli Baba Foundation Worldwide',
            'site_tagline'     => 'Love All, Serve All',
            'reg_no'           => 'Reg. No. XXXXXX/2024',
            'email'            => 'info@nkbfoundation.org',
            'phone'            => '+91 98765 43210',
            'whatsapp'         => '919876543210',
            'address'          => 'Sector 22, Chandigarh, India – 160022',
            'facebook'         => 'https://facebook.com/',
            'twitter'          => 'https://twitter.com/',
            'instagram'        => 'https://instagram.com/',
            'youtube'          => 'https://youtube.com/',
            'home_youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'mission'          => 'To serve humanity through compassion, education, and healthcare, inspired by the teachings of Neem Karoli Baba — "Love all, serve all."',
            'vision'           => 'A society where every individual, regardless of caste, creed, or background, has access to care, knowledge, and dignity.',
            'objectives'       => 'Provide free/subsidized healthcare; support underprivileged education; run community feeding programs (Bhandara); promote interfaith harmony and mental well-being.',
            'about_text'       => 'The Neem Karoli Baba Foundation is a registered non-profit inspired by the life and teachings of the revered saint Neem Karoli Baba (Maharaj-ji). Rooted in the values of selfless service and unconditional love, we work across North India to uplift communities through healthcare, education, and humanitarian aid.',
            'nkb_image_url'    => 'https://upload.wikimedia.org/wikipedia/commons/thumb/4/46/Neem_Karoli_Baba.jpg/440px-Neem_Karoli_Baba.jpg',
            'ticker_text'      => 'Welcome to Neem Karoli Baba Foundation Worldwide | Love All, Serve All | Join us in our mission of compassion and service',
        ];
        foreach ($siteSettings as $key => $value) {
            DB::table('site_settings')->updateOrInsert(
                ['key' => $key],
                ['value' => $value, 'updated_at' => now(), 'created_at' => now()]
            );
        }

        // ── Sliders ───────────────────────────────────────────────────────────
        $sliders = [
            [
                'image_url'  => 'https://images.unsplash.com/photo-1559027615-cd4628902d4a?w=1400&q=80',
                'caption'    => 'Serving Humanity with Compassion',
                'sort_order' => 1,
                'is_active'  => true,
            ],
            [
                'image_url'  => 'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?w=1400&q=80',
                'caption'    => 'Education for Every Child',
                'sort_order' => 2,
                'is_active'  => true,
            ],
            [
                'image_url'  => 'https://images.unsplash.com/photo-1532629345422-7515f3d16bb6?w=1400&q=80',
                'caption'    => 'Healthcare for All',
                'sort_order' => 3,
                'is_active'  => true,
            ],
        ];
        DB::table('sliders')->insertOrIgnore(array_map(fn($s) => array_merge($s, ['created_at' => now(), 'updated_at' => now()]), $sliders));

        // ── Partners ──────────────────────────────────────────────────────────
        $partners = [
            ['name' => 'UNICEF India',       'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/e/ed/Logo_of_UNICEF.svg/320px-Logo_of_UNICEF.svg.png',   'sort_order' => 1],
            ['name' => 'Red Cross India',    'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/1/1a/Flag_of_the_Red_Cross.svg/160px-Flag_of_the_Red_Cross.svg.png', 'sort_order' => 2],
            ['name' => 'Smile Foundation',  'logo_url' => 'https://www.smilefoundationindia.org/images/smile-logo.png', 'sort_order' => 3],
            ['name' => 'CRY India',         'logo_url' => 'https://www.cry.org/wp-content/uploads/2019/07/CRY-logo.png', 'sort_order' => 4],
        ];
        foreach ($partners as $p) {
            DB::table('partners')->insertOrIgnore(array_merge($p, ['website_url' => null, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()]));
        }

        // ── Impact Stats ──────────────────────────────────────────────────────
        $stats = [
            ['number_value' => '5000+',  'label' => 'Lives Impacted',      'icon_class' => 'fas fa-heart',           'sort_order' => 1],
            ['number_value' => '1200+',  'label' => 'Children Educated',   'icon_class' => 'fas fa-graduation-cap',  'sort_order' => 2],
            ['number_value' => '800+',   'label' => 'Medical Camps',        'icon_class' => 'fas fa-stethoscope',     'sort_order' => 3],
            ['number_value' => '50+',    'label' => 'Partner Organisations', 'icon_class' => 'fas fa-handshake',      'sort_order' => 4],
        ];
        foreach ($stats as $s) {
            DB::table('impact_stats')->insertOrIgnore(array_merge($s, ['is_active' => true, 'created_at' => now(), 'updated_at' => now()]));
        }

        // ── Recent Activities ─────────────────────────────────────────────────
        $recentActivities = [
            [
                'heading'     => 'Bhandara — Community Feeding Drive',
                'description' => 'We organised a free community meal (Bhandara) serving over 500 underprivileged families in Sector 22, Chandigarh. Inspired by Maharaj-ji\'s tradition of feeding all who come.',
                'image_url'   => 'https://images.unsplash.com/photo-1593113598332-cd288d649433?w=800&q=80',
                'youtube_url' => null,
                'sort_order'  => 1,
            ],
            [
                'heading'     => 'Free Medical Camp — Rural Health Drive',
                'description' => 'Our medical volunteers conducted a free health check-up camp for 300+ villagers near Panchkula, providing medicines and specialist consultations at no cost.',
                'image_url'   => 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?w=800&q=80',
                'youtube_url' => null,
                'sort_order'  => 2,
            ],
            [
                'heading'     => 'Scholarship Distribution — Education Drive',
                'description' => 'Distributed scholarships to 120 meritorious students from economically weaker sections to support their higher education aspirations.',
                'image_url'   => 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=800&q=80',
                'youtube_url' => null,
                'sort_order'  => 3,
            ],
        ];
        foreach ($recentActivities as $a) {
            DB::table('recent_activities')->insertOrIgnore(array_merge($a, ['is_active' => true, 'created_at' => now(), 'updated_at' => now()]));
        }

        // ── Activities ────────────────────────────────────────────────────────
        $activities = [
            [
                'heading'     => 'Annadaan — Daily Feeding Program',
                'description' => 'Following Maharaj-ji\'s principle that feeding the hungry is the highest form of worship, we run a daily Annadaan program providing nutritious meals to the homeless and daily-wage workers across Chandigarh.',
                'image_url'   => 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=800&q=80',
                'youtube_url' => null,
                'sort_order'  => 1,
            ],
            [
                'heading'     => 'Shiksha Daan — Education Support',
                'description' => 'Our Shiksha Daan program sponsors school fees, books, uniforms, and tuition for over 500 children from underprivileged backgrounds, ensuring no child is denied education due to poverty.',
                'image_url'   => 'https://images.unsplash.com/photo-1427504494785-3a9ca7044f45?w=800&q=80',
                'youtube_url' => null,
                'sort_order'  => 2,
            ],
            [
                'heading'     => 'Swasthya Seva — Mobile Health Clinics',
                'description' => 'Our fleet of mobile health vans brings free medical consultation, diagnostics, and medicines directly to remote villages and urban slums that lack access to healthcare infrastructure.',
                'image_url'   => 'https://images.unsplash.com/photo-1559757175-5700dde675bc?w=800&q=80',
                'youtube_url' => null,
                'sort_order'  => 3,
            ],
        ];
        foreach ($activities as $a) {
            DB::table('activities')->insertOrIgnore(array_merge($a, ['is_active' => true, 'created_at' => now(), 'updated_at' => now()]));
        }

        // ── Events ────────────────────────────────────────────────────────────
        $events = [
            [
                'heading'     => 'Hanuman Jayanti Celebration & Bhandara',
                'description' => 'Join us for a grand Hanuman Jayanti celebration with kirtan, pravachan, and a free community meal for all. Maharaj-ji\'s deep devotion to Lord Hanuman is honoured through this annual event.',
                'image_url'   => 'https://images.unsplash.com/photo-1606836576983-8b458e75221d?w=800&q=80',
                'youtube_url' => null,
                'sort_order'  => 1,
            ],
            [
                'heading'     => 'Annual Charity Run — Run for a Cause',
                'description' => 'Participate in our 5K and 10K charity run. All proceeds go directly to our education and healthcare programmes. Open to all ages — register now!',
                'image_url'   => 'https://images.unsplash.com/photo-1571008887538-b36bb32f4571?w=800&q=80',
                'youtube_url' => null,
                'sort_order'  => 2,
            ],
            [
                'heading'     => 'Blood Donation Camp',
                'description' => 'Every drop counts. Our quarterly blood donation camp brings together volunteers across Chandigarh and the Tricity region to donate blood for those in critical need.',
                'image_url'   => 'https://images.unsplash.com/photo-1615461066841-6116e61058f4?w=800&q=80',
                'youtube_url' => null,
                'sort_order'  => 3,
            ],
            [
                'heading'     => 'Winter Blanket Distribution Drive',
                'description' => 'As temperatures drop, we distribute warm blankets and winter clothing to the homeless and daily wage workers to help them survive the harsh North Indian winters.',
                'image_url'   => 'https://images.unsplash.com/photo-1512418408487-b72e5c64cb22?w=800&q=80',
                'youtube_url' => null,
                'sort_order'  => 4,
            ],
        ];
        foreach ($events as $e) {
            DB::table('events')->insertOrIgnore(array_merge($e, ['is_active' => true, 'created_at' => now(), 'updated_at' => now()]));
        }

        // ── Future Plans ──────────────────────────────────────────────────────
        $futurePlans = [
            [
                'heading'     => 'NKB Skill Development Centre',
                'description' => 'We plan to establish a Skill Development Centre in Chandigarh to provide free vocational training in IT, tailoring, plumbing, and electrical work to unemployed youth — empowering them with livelihood skills.',
                'image_url'   => 'https://images.unsplash.com/photo-1521737604893-d14cc237f11d?w=800&q=80',
                'youtube_url' => null,
                'sort_order'  => 1,
            ],
            [
                'heading'     => 'Charitable Hospital & Dispensary',
                'description' => 'Our long-term vision includes establishing a full-fledged charitable hospital offering free or subsidised treatment to the poor, with specialist departments for women\'s health, paediatrics, and general medicine.',
                'image_url'   => 'https://images.unsplash.com/photo-1538108149393-fbbd81895907?w=800&q=80',
                'youtube_url' => null,
                'sort_order'  => 2,
            ],
            [
                'heading'     => 'NKB Digital Library & Study Centre',
                'description' => 'A free digital library with computer labs, Wi-Fi, and curated e-learning resources for students from Class 6 to undergraduate level — bridging the digital divide in underserved communities.',
                'image_url'   => 'https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=800&q=80',
                'youtube_url' => null,
                'sort_order'  => 3,
            ],
        ];
        foreach ($futurePlans as $f) {
            DB::table('future_plans')->insertOrIgnore(array_merge($f, ['is_active' => true, 'created_at' => now(), 'updated_at' => now()]));
        }

        // ── Founder Members ───────────────────────────────────────────────────
        $members = [
            ['name' => 'Shri Rajesh Kumar Sharma',  'role' => 'President & Founder',       'photo_url' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=200&q=80', 'sort_order' => 1],
            ['name' => 'Smt. Priya Devi',           'role' => 'Vice President',              'photo_url' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=200&q=80', 'sort_order' => 2],
            ['name' => 'Shri Anil Verma',           'role' => 'Secretary General',          'photo_url' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=200&q=80', 'sort_order' => 3],
            ['name' => 'Shri Mohan Lal Gupta',     'role' => 'Treasurer',                  'photo_url' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=200&q=80', 'sort_order' => 4],
            ['name' => 'Dr. Kavita Singh',          'role' => 'Medical Advisor',            'photo_url' => 'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?w=200&q=80', 'sort_order' => 5],
            ['name' => 'Shri Suresh Chandra',       'role' => 'Joint Secretary',            'photo_url' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?w=200&q=80', 'sort_order' => 6],
        ];
        foreach ($members as $m) {
            DB::table('founder_members')->insertOrIgnore(array_merge($m, ['is_active' => true, 'created_at' => now(), 'updated_at' => now()]));
        }

        // ── Org Profile ───────────────────────────────────────────────────────
        $orgProfile = [
            ['sl_no' => '1',  'document_name' => 'Organisation Name',          'value' => 'Neem Karoli Baba Foundation Worldwide',  'sort_order' => 1],
            ['sl_no' => '2',  'document_name' => 'Registration Number',        'value' => 'XXXXXX/2024',                           'sort_order' => 2],
            ['sl_no' => '3',  'document_name' => 'Type of Organisation',       'value' => 'Non-Governmental Organisation (NGO)',    'sort_order' => 3],
            ['sl_no' => '4',  'document_name' => 'Date of Registration',       'value' => '01 January 2024',                       'sort_order' => 4],
            ['sl_no' => '5',  'document_name' => 'Registered Address',         'value' => 'Sector 22, Chandigarh – 160022, India',  'sort_order' => 5],
            ['sl_no' => '6',  'document_name' => 'PAN Number',                 'value' => 'XXXXXXXXXX',                            'sort_order' => 6],
            ['sl_no' => '7',  'document_name' => '12A Certificate',            'value' => 'Applied',                               'sort_order' => 7],
            ['sl_no' => '8',  'document_name' => '80G Certificate',            'value' => 'Applied',                               'sort_order' => 8],
            ['sl_no' => '9',  'document_name' => 'FCRA Registration',          'value' => 'Pending',                               'sort_order' => 9],
            ['sl_no' => '10', 'document_name' => 'Focus Areas',                'value' => 'Education, Healthcare, Community Feeding, Skill Development', 'sort_order' => 10],
        ];
        foreach ($orgProfile as $o) {
            DB::table('org_profiles')->insertOrIgnore(array_merge($o, ['created_at' => now(), 'updated_at' => now()]));
        }

        // ── President Message ─────────────────────────────────────────────────
        DB::table('president_messages')->insertOrIgnore([
            'president_name'  => 'Shri Rajesh Kumar Sharma',
            'president_title' => 'President, NKB Foundation Worldwide',
            'message'         => "Jai Jai Shri Maharaj-ji!\n\nIn the name of our beloved Neem Karoli Baba, I warmly welcome you to the Neem Karoli Baba Foundation Worldwide.\n\nMaharaj-ji's timeless wisdom — \"Love all, serve all\" — is not merely a saying but the very foundation on which this organisation stands. Every meal we serve, every child we educate, every life we touch is a humble offering at his lotus feet.\n\nI invite you to be a part of this sacred mission. Whether through volunteering, donating, or simply spreading awareness, your contribution matters enormously. Together, we can build a more compassionate, equitable world.\n\nJai Ram Ji Ki.",
            'signature_url'   => null,
            'is_active'       => true,
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);

        // ── Donate Settings ───────────────────────────────────────────────────
        $donateSettings = [
            ['key' => 'description',    'value' => "Your generous donation directly funds our programmes in education, healthcare, and community feeding. Every rupee you contribute transforms a life.\n\nAll donations are eligible for tax exemption under Section 80G of the Income Tax Act.", 'type' => 'text'],
            ['key' => 'bank_name',      'value' => 'State Bank of India',                    'type' => 'text'],
            ['key' => 'branch_name',    'value' => 'Sector 17, Chandigarh',                  'type' => 'text'],
            ['key' => 'account_number', 'value' => 'XXXXXXXXXXXX',                           'type' => 'text'],
            ['key' => 'ifsc_code',      'value' => 'SBIN0001234',                            'type' => 'text'],
            ['key' => 'upi_id',         'value' => 'nkbfoundation@sbi',                      'type' => 'text'],
            ['key' => 'tax_note',       'value' => 'Donations are exempt under Section 80G. Certificate will be provided upon request.', 'type' => 'text'],
            ['key' => 'qr_image',       'value' => '',                                       'type' => 'image'],
        ];
        foreach ($donateSettings as $d) {
            DB::table('donate_settings')->updateOrInsert(
                ['key' => $d['key']],
                array_merge($d, ['created_at' => now(), 'updated_at' => now()])
            );
        }

        // ── Gallery Items ─────────────────────────────────────────────────────
        $gallery = [
            ['headline' => 'Bhandara Community Feast',        'image_url' => 'https://images.unsplash.com/photo-1493770348161-369560ae357d?w=600&q=80', 'youtube_url' => null, 'type' => 'image', 'sort_order' => 1],
            ['headline' => 'Medical Camp 2024',               'image_url' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=600&q=80', 'youtube_url' => null, 'type' => 'image', 'sort_order' => 2],
            ['headline' => 'Scholarship Distribution',        'image_url' => 'https://images.unsplash.com/photo-1427504494785-3a9ca7044f45?w=600&q=80', 'youtube_url' => null, 'type' => 'image', 'sort_order' => 3],
            ['headline' => 'Hanuman Jayanti Celebration',     'image_url' => 'https://images.unsplash.com/photo-1514539079130-25950c84af65?w=600&q=80', 'youtube_url' => null, 'type' => 'image', 'sort_order' => 4],
            ['headline' => 'Blood Donation Camp',             'image_url' => 'https://images.unsplash.com/photo-1615461066841-6116e61058f4?w=600&q=80', 'youtube_url' => null, 'type' => 'image', 'sort_order' => 5],
            ['headline' => 'Winter Blanket Drive',            'image_url' => 'https://images.unsplash.com/photo-1512418408487-b72e5c64cb22?w=600&q=80', 'youtube_url' => null, 'type' => 'image', 'sort_order' => 6],
        ];
        foreach ($gallery as $g) {
            DB::table('gallery_items')->insertOrIgnore(array_merge($g, ['is_active' => true, 'created_at' => now(), 'updated_at' => now()]));
        }

        // ── Principles (Mission / Vision / Objectives) ────────────────────────
        $principles = [
            [
                'title'       => 'Mission',
                'description' => 'To serve humanity through compassion, education, and healthcare — inspired by Neem Karoli Baba\'s teaching: "Love all, serve all." We strive to uplift communities through selfless action and spiritual dedication.',
                'icon'        => 'fa-dove',
                'color_theme' => 'orange',
                'link_url'    => null,
                'sort_order'  => 1,
            ],
            [
                'title'       => 'Vision',
                'description' => 'A society where every individual, regardless of caste, creed or economic background, has access to care, knowledge, and dignity — a world united by love and service.',
                'icon'        => 'fa-eye',
                'color_theme' => 'purple',
                'link_url'    => null,
                'sort_order'  => 2,
            ],
            [
                'title'       => 'Objectives',
                'description' => 'Free healthcare camps, education support for underprivileged children, community feeding programmes, and promoting interfaith harmony — creating lasting positive impact in every life we touch.',
                'icon'        => 'fa-bullseye',
                'color_theme' => 'emerald',
                'link_url'    => null,
                'sort_order'  => 3,
            ],
        ];
        foreach ($principles as $p) {
            DB::table('principles')->insertOrIgnore(array_merge($p, ['is_active' => true, 'created_at' => now(), 'updated_at' => now()]));
        }
    }
}
