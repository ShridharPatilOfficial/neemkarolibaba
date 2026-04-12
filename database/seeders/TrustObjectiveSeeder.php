<?php

namespace Database\Seeders;

use App\Models\TrustObjective;
use Illuminate\Database\Seeder;

class TrustObjectiveSeeder extends Seeder
{
    public function run(): void
    {
        $objectives = [
            [
                'title'       => 'Holistic Development',
                'description' => 'To establish the Trust primarily for the all-round development of the public through social, cultural, educational, medical, art, sports, intellectual, and charitable perspectives.',
            ],
            [
                'title'       => 'Youth Empowerment & Education',
                'description' => 'To implement training programs for youth in various educational and skill-based sectors. This includes providing free guidance, establishing medical training centers, nursing colleges, and competitive exam guidance centers in both rural and urban areas.',
            ],
            [
                'title'       => 'Cultural & Spiritual Preservation',
                'description' => 'To run value-based education centers (Sanskar Kendras), yoga and meditation centers, and mental peace centers to preserve religious culture. To teach the path of righteousness, devotion, and good conduct through discourses and programs.',
            ],
            [
                'title'       => 'Educational Facilities',
                'description' => 'To provide primary, secondary, higher secondary, and college education. To establish training centers for Anganwadi and Balwadi teachers, computer training centers, and hostels/residential schools for underprivileged and backward-class students.',
            ],
            [
                'title'       => 'Inclusive Education',
                'description' => 'To provide dedicated educational facilities for children with disabilities (Divyang).',
            ],
            [
                'title'       => 'Social Welfare & Nutrition',
                'description' => 'To operate hostels, schools, orphanages, creches, and old age homes. To implement nutrition programs and mid-day meals for children in Anganwadis and primary schools.',
            ],
            [
                'title'       => 'Women\'s Empowerment',
                'description' => 'To run programs aimed at eradicating illiteracy in rural and slum areas and to provide rehabilitation for destitute and abandoned women.',
            ],
            [
                'title'       => 'Affordable Healthcare',
                'description' => 'To provide medical services at subsidized rates for backward classes and the poor. To provide ambulance services for accidents, emergencies, and illnesses to assist the underprivileged.',
            ],
            [
                'title'       => 'Public Health Support',
                'description' => 'To assist government and other social service trusts in programs related to public health and family planning by organizing periodic medical camps.',
            ],
            [
                'title'       => 'Awareness & De-addiction',
                'description' => 'To establish organizations for AIDS and Cancer control, and to run de-addiction centers, rehabilitation centers, and awareness camps in rural and urban areas.',
            ],
            [
                'title'       => 'Medical Infrastructure',
                'description' => 'To strive toward establishing blood banks, medical diagnostic centers, mini-hospitals, polyclinics, and mobile dispensaries. To provide direct medical aid to patients suffering from serious illnesses.',
            ],
            [
                'title'       => 'Ethical Values',
                'description' => 'To promote the philosophy of non-violence (Ahinsa) and establish centers that cultivate high moral values.',
            ],
            [
                'title'       => 'Support for the Vulnerable',
                'description' => 'To start support centers, ashrams, and rehabilitation facilities for senior citizens and widowed women.',
            ],
            [
                'title'       => 'Knowledge Access',
                'description' => 'To open and maintain public libraries for the development of knowledge.',
            ],
            [
                'title'       => 'Yoga Promotion',
                'description' => 'To spread awareness about the importance of Yoga and conduct regular Yoga classes for the public.',
            ],
            [
                'title'       => 'Environmental Protection',
                'description' => 'To promote the importance of tree plantation, conservation, and environmental protection through active programs.',
            ],
            [
                'title'       => 'Disaster Relief',
                'description' => 'To provide aid and support to victims of natural disasters, earthquakes, and accidents, as well as to orphans, the disabled, and the economically weak.',
            ],
            [
                'title'       => 'Emergency Assistance & Rehabilitation',
                'description' => 'To provide financial aid and rehabilitation support to any individual who suffers from sudden disability or is affected by natural disasters.',
            ],
            [
                'title'       => 'Preservation of Art & Culture',
                'description' => 'To preserve art and culture and to establish training classes related to all traditional and cultural art forms.',
            ],
            [
                'title'       => 'National & Heritage Celebrations',
                'description' => 'To celebrate all national festivals and the birth anniversaries (Jayantis) of great national leaders and historical figures.',
            ],
            [
                'title'       => 'Agricultural Guidance',
                'description' => 'To provide guidance and implement innovative new schemes and projects related to agriculture.',
            ],
            [
                'title'       => 'Support for Artists',
                'description' => 'To guide and encourage artists from various fields, providing a platform for their talents. This includes the development, promotion, and dissemination of art through the organization of competitions, exhibitions, camps, conferences, and guidance workshops.',
            ],
            [
                'title'       => 'Sports & Athletics Development',
                'description' => 'To organize competitions for both domestic (traditional) and international sports. To hold conferences on sports literature and promote athletic development. To organize lectures and seminars featuring renowned sports experts from across the country.',
            ],
        ];

        foreach ($objectives as $i => $obj) {
            TrustObjective::create([
                'title'       => $obj['title'],
                'description' => $obj['description'],
                'image'       => null,
                'sort_order'  => $i + 1,
                'is_active'   => true,
            ]);
        }
    }
}
