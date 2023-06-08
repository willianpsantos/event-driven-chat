<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('events')->updateOrInsert(
            [ 'name' => 'Event Test 1' ],

            [
                'name' => 'Event Test 1',
                'description' => 'Event for tests',
                'subtitle'=> 'Subtitle tests 1',
                'scheduled_date' => '2020-05-20 00:00',
                'scheduled_time' => '2020-10-20 00:00',
                'image' => 'http://localhost/talktube/images/sign2.png',
                'show_in_home' => 'Y',
                'start_show_at' => '2020-01-01 00:00',
                'ends_show_at' => '2020-12-31 00:00',
                'featured' => 'Y'
            ]
        );

        DB::table('events')->updateOrInsert(
            [ 'name' => 'Event Test 2' ],

            [
                'name' => 'Event Test 2',
                'subtitle'=> 'Subtitle tests 2',
                'description' => 'Event for tests',
                'scheduled_date' => '2020-05-20 00:00',
                'scheduled_time' => '2020-10-20 00:00',
                'image' => 'http://localhost/talktube/images/sign2.png',
                'show_in_home' => 'Y',
                'start_show_at' => '2020-01-01 00:00',
                'ends_show_at' => '2020-12-31 00:00',
                'featured' => 'Y'
            ]
        );

        DB::table('events')->updateOrInsert(
            [ 'name' => 'Event Test 3' ],

            [
                'name' => 'Event Test 3',
                'subtitle'=> 'Subtitle tests 3',
                'description' => 'Event for tests',
                'scheduled_date' => '2020-05-20 00:00',
                'scheduled_time' => '2020-10-20 00:00',
                'image' => 'http://localhost/talktube/images/sign2.png',
                'show_in_home' => 'Y',
                'start_show_at' => '2020-01-01 00:00',
                'ends_show_at' => '2020-12-31 00:00',
                'featured' => 'Y'
            ]
        );

        DB::table('events')->updateOrInsert(
            [ 'name' => 'Event Test 4' ],

            [
                'name' => 'Event Test 4',
                'subtitle'=> 'Subtitle tests 4',
                'description' => 'Event for tests',
                'scheduled_date' => '2020-05-20 00:00',
                'scheduled_time' => '2020-10-20 00:00',
                'image' => 'http://localhost/talktube/images/sign2.png',
                'show_in_home' => 'Y',
                'start_show_at' => '2020-01-01 00:00',
                'ends_show_at' => '2020-12-31 00:00',
                'featured' => 'Y'
            ]
        );

        DB::table('events')->updateOrInsert(
            [ 'name' => 'Event Test 5' ],

            [
                'name' => 'Event Test 5',
                'subtitle'=> 'Subtitle tests 5',
                'description' => 'Event for tests',
                'scheduled_date' => '2020-05-20 00:00',
                'scheduled_time' => '2020-10-20 00:00',
                'image' => 'http://localhost/talktube/images/sign2.png',
                'show_in_home' => 'Y',
                'start_show_at' => '2020-01-01 00:00',
                'ends_show_at' => '2020-12-31 00:00',
                'featured' => 'Y'
            ]
        );

        DB::table('events')->updateOrInsert(
            [ 'name' => 'Event Test 6' ],

            [
                'name' => 'Event Test 6',
                'subtitle'=> 'Subtitle tests 6',
                'description' => 'Event for tests',
                'scheduled_date' => '2020-05-20 00:00',
                'scheduled_time' => '2020-10-20 00:00',
                'image' => 'http://localhost/talktube/images/sign2.png',
                'show_in_home' => 'Y',
                'start_show_at' => '2020-01-01 00:00',
                'ends_show_at' => '2020-12-31 00:00',
                'featured' => 'Y'
            ]
        );

        DB::table('events')->updateOrInsert(
            [ 'name' => 'Event Test 7' ],

            [
                'name' => 'Event Test 7',
                'subtitle'=> 'Subtitle tests 7',
                'description' => 'Event for tests',
                'scheduled_date' => '2020-05-20 00:00',
                'scheduled_time' => '2020-10-20 00:00',
                'image' => 'http://localhost/talktube/images/sign2.png',
                'show_in_home' => 'Y',
                'start_show_at' => '2020-01-01 00:00',
                'ends_show_at' => '2020-12-31 00:00',
                'featured' => 'Y'
            ]
        );

        DB::table('events')->updateOrInsert(
            [ 'name' => 'Event Test 8' ],

            [
                'name' => 'Event Test 8',
                'subtitle'=> 'Subtitle tests 8',
                'description' => 'Event for tests',
                'scheduled_date' => '2020-05-20 00:00',
                'scheduled_time' => '2020-10-20 00:00',
                'image' => 'http://localhost/talktube/images/sign2.png',
                'show_in_home' => 'Y',
                'start_show_at' => '2020-01-01 00:00',
                'ends_show_at' => '2020-12-31 00:00',
                'featured' => 'Y'
            ]
        );

        DB::table('events')->updateOrInsert(
            [ 'name' => 'Event Test 9' ],

            [
                'name' => 'Event Test 9',
                'subtitle'=> 'Subtitle tests 9',
                'description' => 'Event for tests',
                'scheduled_date' => '2020-05-20 00:00',
                'scheduled_time' => '2020-10-20 00:00',
                'image' => 'http://localhost/talktube/images/sign2.png',
                'show_in_home' => 'Y',
                'start_show_at' => '2020-01-01 00:00',
                'ends_show_at' => '2020-12-31 00:00',
                'featured' => 'Y'
            ]
        );

        DB::table('events')->updateOrInsert(
            [ 'name' => 'Event Test 10' ],

            [
                'name' => 'Event Test 10',
                'subtitle'=> 'Subtitle tests 10',
                'description' => 'Event for tests',
                'scheduled_date' => '2020-05-20 00:00',
                'scheduled_time' => '2020-10-20 00:00',
                'image' => 'http://localhost/talktube/images/sign2.png',
                'show_in_home' => 'Y',
                'start_show_at' => '2020-01-01 00:00',
                'ends_show_at' => '2020-12-31 00:00',
                'featured' => 'Y'
            ]
        );

        DB::table('events')->updateOrInsert(
            [ 'name' => 'Event Test 11' ],

            [
                'name' => 'Event Test 11',
                'subtitle'=> 'Subtitle tests 11',
                'description' => 'Event for tests',
                'scheduled_date' => '2020-05-20 00:00',
                'scheduled_time' => '2020-10-20 00:00',
                'image' => 'http://localhost/talktube/images/sign2.png',
                'show_in_home' => 'Y',
                'start_show_at' => '2020-01-01 00:00',
                'ends_show_at' => '2020-12-31 00:00',
                'featured' => 'Y'
            ]
        );

        DB::table('events')->updateOrInsert(
            [ 'name' => 'Event Test 12' ],

            [
                'name' => 'Event Test 12',
                'subtitle'=> 'Subtitle tests 12',
                'description' => 'Event for tests',
                'scheduled_date' => '2020-05-20 00:00',
                'scheduled_time' => '2020-10-20 00:00',
                'image' => 'http://localhost/talktube/images/sign2.png',
                'show_in_home' => 'Y',
                'start_show_at' => '2020-01-01 00:00',
                'ends_show_at' => '2020-12-31 00:00',
                'featured' => 'Y'
            ]
        );

        DB::table('events')->updateOrInsert(
            [ 'name' => 'Event Test 13' ],

            [
                'name' => 'Event Test 13',
                'subtitle'=> 'Subtitle tests 13',
                'description' => 'Event for tests',
                'scheduled_date' => '2020-05-20 00:00',
                'scheduled_time' => '2020-10-20 00:00',
                'image' => 'http://localhost/talktube/images/sign2.png',
                'show_in_home' => 'Y',
                'start_show_at' => '2020-01-01 00:00',
                'ends_show_at' => '2020-12-31 00:00',
                'featured' => 'Y'
            ]
        );

        DB::table('events')->updateOrInsert(
            [ 'name' => 'Event Test 14' ],

            [
                'name' => 'Event Test 14',
                'subtitle'=> 'Subtitle tests 14',
                'description' => 'Event for tests',
                'scheduled_date' => '2020-05-20 00:00',
                'scheduled_time' => '2020-10-20 00:00',
                'image' => 'http://localhost/talktube/images/sign2.png',
                'show_in_home' => 'Y',
                'start_show_at' => '2020-01-01 00:00',
                'ends_show_at' => '2020-12-31 00:00',
                'featured' => 'Y'
            ]
        );

        DB::table('events')->updateOrInsert(
            [ 'name' => 'Event Test 15' ],

            [
                'name' => 'Event Test 15',
                'subtitle'=> 'Subtitle tests 15',
                'description' => 'Event for tests',
                'scheduled_date' => '2020-05-20 00:00',
                'scheduled_time' => '2020-10-20 00:00',
                'image' => 'http://localhost/talktube/images/sign2.png',
                'show_in_home' => 'Y',
                'start_show_at' => '2020-01-01 00:00',
                'ends_show_at' => '2020-12-31 00:00',
                'featured' => 'Y'
            ]
        );
    }
}
