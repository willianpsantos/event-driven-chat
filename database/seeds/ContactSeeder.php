<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('contacts')->updateOrInsert(
            [
                'user_owner_id' => 1,
                'user_contact_id' => 2,
            ],

            [
                'user_owner_id' => 1,
                'user_contact_id' => 2,
                'can_phone' => 'Y',
                'can_video' => 'Y',
                'can_message' => 'Y'
            ]
        );

        DB::table('contacts')->updateOrInsert(
            [
                'user_owner_id' => 1,
                'user_contact_id' => 3,
            ],

            [
                'user_owner_id' => 1,
                'user_contact_id' => 3,
                'can_phone' => 'Y',
                'can_video' => 'Y',
                'can_message' => 'Y'
            ]
        );

        DB::table('contacts')->updateOrInsert(
            [
                'user_owner_id' => 1,
                'user_contact_id' => 4,
            ],

            [
                'user_owner_id' => 1,
                'user_contact_id' => 4,
                'can_phone' => 'Y',
                'can_video' => 'Y',
                'can_message' => 'Y'
            ]
        );

        DB::table('contacts')->updateOrInsert(
            [
                'user_owner_id' => 1,
                'user_contact_id' => 5,
            ],

            [
                'user_owner_id' => 1,
                'user_contact_id' => 5,
                'can_phone' => 'Y',
                'can_video' => 'Y',
                'can_message' => 'Y'
            ]
        );

        DB::table('contacts')->updateOrInsert(
            [
                'user_owner_id' => 1,
                'user_contact_id' => 6,
            ],

            [
                'user_owner_id' => 1,
                'user_contact_id' => 6,
                'can_phone' => 'Y',
                'can_video' => 'Y',
                'can_message' => 'Y'
            ]
        );

        DB::table('contacts')->updateOrInsert(
            [
                'user_owner_id' => 1,
                'user_contact_id' => 7,
            ],

            [
                'user_owner_id' => 1,
                'user_contact_id' => 7,
                'can_phone' => 'Y',
                'can_video' => 'Y',
                'can_message' => 'Y'
            ]
        );

        DB::table('contacts')->updateOrInsert(
            [
                'user_owner_id' => 1,
                'user_contact_id' => 8,
            ],

            [
                'user_owner_id' => 1,
                'user_contact_id' => 8,
                'can_phone' => 'Y',
                'can_video' => 'Y',
                'can_message' => 'Y'
            ]
        );

        DB::table('contacts')->updateOrInsert(
            [
                'user_owner_id' => 1,
                'user_contact_id' => 9,
            ],

            [
                'user_owner_id' => 1,
                'user_contact_id' => 9,
                'can_phone' => 'Y',
                'can_video' => 'Y',
                'can_message' => 'Y'
            ]
        );

        DB::table('contacts')->updateOrInsert(
            [
                'user_owner_id' => 1,
                'user_contact_id' => 10,
            ],

            [
                'user_owner_id' => 1,
                'user_contact_id' => 10,
                'can_phone' => 'Y',
                'can_video' => 'Y',
                'can_message' => 'Y'
            ]
        );

        DB::table('contacts')->updateOrInsert(
            [
                'user_owner_id' => 1,
                'user_contact_id' => 11,
            ],

            [
                'user_owner_id' => 1,
                'user_contact_id' => 11,
                'can_phone' => 'Y',
                'can_video' => 'Y',
                'can_message' => 'Y'
            ]
        );

        DB::table('contacts')->updateOrInsert(
            [
                'user_owner_id' => 1,
                'user_contact_id' => 12,
            ],

            [
                'user_owner_id' => 1,
                'user_contact_id' => 12,
                'can_phone' => 'Y',
                'can_video' => 'Y',
                'can_message' => 'Y'
            ]
        );

        DB::table('contacts')->updateOrInsert(
            [
                'user_owner_id' => 1,
                'user_contact_id' => 13,
            ],

            [
                'user_owner_id' => 1,
                'user_contact_id' => 13,
                'can_phone' => 'Y',
                'can_video' => 'Y',
                'can_message' => 'Y'
            ]
        );

        DB::table('contacts')->updateOrInsert(
            [
                'user_owner_id' => 1,
                'user_contact_id' => 14,
            ],

            [
                'user_owner_id' => 1,
                'user_contact_id' => 14,
                'can_phone' => 'Y',
                'can_video' => 'Y',
                'can_message' => 'Y'
            ]
        );

        DB::table('contacts')->updateOrInsert(
            [
                'user_owner_id' => 1,
                'user_contact_id' => 15,
            ],

            [
                'user_owner_id' => 1,
                'user_contact_id' => 15,
                'can_phone' => 'Y',
                'can_video' => 'Y',
                'can_message' => 'Y'
            ]
        );
    }
}
