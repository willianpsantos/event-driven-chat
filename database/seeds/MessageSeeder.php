<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $query = DB::table('groups')->where('name', '=', 'Grupo Designer')->select([ 'id' ])->first();

        if ( $query && $query->id ) {
            $idGroup1 = $query->id;
        }

        if ( $idGroup1 ) {
            $conversationId = unique_id();

            DB::table('conversations')->insertOrIgnore([
                'id' => $conversationId,
                'user_owner_id' => 1,
                'conversation_in_group' => 'Y',
                'group_id' => $idGroup1
            ]);

            DB::table('messages')->insertOrIgnore([
                'id' => unique_id(),
                'conversation_id' => $conversationId,
                'user_sender_id' => 1,
                'user_receiver_id' => 2,
                'sent_via_group' => 'Y',
                'group_id' => $idGroup1,
                'message'  => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged',
                'file_attached_path' => null,
                'file_attached_type' => null,
            ]);

            sleep(1);

            DB::table('messages')->insertOrIgnore([
                'id' => unique_id(),
                'conversation_id' => $conversationId,
                'user_sender_id' => 1,
                'sent_via_group' => 'Y',
                'user_receiver_id' => 3,
                'group_id' => $idGroup1,
                'message'  => 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source',
                'file_attached_path' => null,
                'file_attached_type' => null,
            ]);

            DB::table('messages')->insertOrIgnore([
                'id' => unique_id(),
                'conversation_id' => $conversationId,
                'user_sender_id' => 1,
                'sent_via_group' => 'Y',
                'user_receiver_id' => 4,
                'group_id' => $idGroup1,
                'message'  => 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source',
                'file_attached_path' => null,
                'file_attached_type' => null,
            ]);

            DB::table('messages')->insertOrIgnore([
                'id' => unique_id(),
                'conversation_id' => $conversationId,
                'user_sender_id' => 4,
                'sent_via_group' => 'Y',
                'user_receiver_id' => 1,
                'group_id' => $idGroup1,
                'message'  => 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source',
                'file_attached_path' => null,
                'file_attached_type' => null,
            ]);

            DB::table('messages')->insertOrIgnore([
                'id' => unique_id(),
                'conversation_id' => $conversationId,
                'user_sender_id' => 4,
                'sent_via_group' => 'Y',
                'user_receiver_id' => 3,
                'group_id' => $idGroup1,
                'message'  => 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source',
                'file_attached_path' => null,
                'file_attached_type' => null,
            ]);

            sleep(1);
        }


        //------------------------------------------------------------------------------------------------------------------------
        $query = DB::table('groups')->where('name', '=', 'Vagas de Emprego')->select([ 'id' ])->first();

        if ( $query && $query->id ) {
            $idGroup2 = $query->id;
        }

        if ( $idGroup2 ) {
            $conversationId = unique_id();

            DB::table('conversations')->insertOrIgnore([
                'id' => $conversationId,
                'user_owner_id' => 1,
                'conversation_in_group' => 'Y',
                'group_id' => $idGroup2
            ]);

            DB::table('messages')->insertOrIgnore([
                'id' => unique_id(),
                'conversation_id' => $conversationId,
                'user_sender_id' => 5,
                'sent_via_group' => 'Y',
                'user_receiver_id' => 2,
                'group_id' => $idGroup2,
                'message'  => 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source',
                'file_attached_path' => null,
                'file_attached_type' => null,
            ]);

            DB::table('messages')->insertOrIgnore([
                'id' => unique_id(),
                'conversation_id' => $conversationId,
                'user_sender_id' => 5,
                'sent_via_group' => 'Y',
                'user_receiver_id' => 7,
                'group_id' => $idGroup2,
                'message'  => 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source',
                'file_attached_path' => null,
                'file_attached_type' => null,
            ]);

            DB::table('messages')->insertOrIgnore([
                'id' => unique_id(),
                'conversation_id' => $conversationId,
                'user_sender_id' => 5,
                'sent_via_group' => 'Y',
                'user_receiver_id' => 9,
                'group_id' => $idGroup2,
                'message'  => 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source',
                'file_attached_path' => null,
                'file_attached_type' => null,
            ]);

            DB::table('messages')->insertOrIgnore([
                'id' => unique_id(),
                'conversation_id' => $conversationId,
                'user_sender_id' => 7,
                'sent_via_group' => 'Y',
                'user_receiver_id' => 5,
                'group_id' => $idGroup2,
                'message'  => 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source',
                'file_attached_path' => null,
                'file_attached_type' => null,
            ]);

            DB::table('messages')->insertOrIgnore([
                'id' => unique_id(),
                'conversation_id' => $conversationId,
                'user_sender_id' => 7,
                'sent_via_group' => 'Y',
                'user_receiver_id' => 5,
                'group_id' => $idGroup2,
                'message'  => 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source',
                'file_attached_path' => null,
                'file_attached_type' => null,
            ]);


            sleep(1);
        }


        // --------------------------------------------------------------------------------------------------------------------------------------
        $conversationId = unique_id();

        DB::table('conversations')->insertOrIgnore([
            'id' => $conversationId,
            'user_owner_id' => 1,
            'user_receiver_id' => 2,
            'conversation_in_group' => 'N',
            'group_id' => null,
        ]);

        DB::table('messages')->insertOrIgnore([
            'id' => unique_id(),
            'conversation_id' => $conversationId,
            'user_sender_id' => 1,
            'user_receiver_id' => 2,
            'sent_via_group' => 'N',
            'group_id' => null,
            'message'  => 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which dont look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isnt anything embarrassing hidden in the middle of text.',
            'file_attached_path' => null,
            'file_attached_type' => null,
        ]);

        sleep(1);

        DB::table('messages')->insertOrIgnore([
            'id' => unique_id(),
            'conversation_id' => $conversationId,
            'user_sender_id' => 2,
            'user_receiver_id' => 1,
            'sent_via_group' => 'N',
            'group_id' => null,
            'message'  => 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which dont look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isnt anything embarrassing hidden in the middle of text.',
            'file_attached_path' => null,
            'file_attached_type' => null,
        ]);

        DB::table('messages')->insertOrIgnore([
            'id' => unique_id(),
            'conversation_id' => $conversationId,
            'user_sender_id' => 2,
            'user_receiver_id' => 1,
            'sent_via_group' => 'N',
            'group_id' => null,
            'message'  => 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which dont look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isnt anything embarrassing hidden in the middle of text.',
            'file_attached_path' => null,
            'file_attached_type' => null,
        ]);

        DB::table('messages')->insertOrIgnore([
            'id' => unique_id(),
            'conversation_id' => $conversationId,
            'user_sender_id' => 1,
            'user_receiver_id' => 2,
            'sent_via_group' => 'N',
            'group_id' => null,
            'message'  => 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which dont look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isnt anything embarrassing hidden in the middle of text.',
            'file_attached_path' => null,
            'file_attached_type' => null,
        ]);

        DB::table('messages')->insertOrIgnore([
            'id' => unique_id(),
            'conversation_id' => $conversationId,
            'user_sender_id' => 1,
            'user_receiver_id' => 2,
            'sent_via_group' => 'N',
            'group_id' => null,
            'message'  => 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which dont look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isnt anything embarrassing hidden in the middle of text.',
            'file_attached_path' => null,
            'file_attached_type' => null,
        ]);

        DB::table('messages')->insertOrIgnore([
            'id' => unique_id(),
            'conversation_id' => $conversationId,
            'user_sender_id' => 1,
            'user_receiver_id' => 2,
            'sent_via_group' => 'N',
            'group_id' => null,
            'message'  => 'Urna neque viverra justo nec ultrices. At varius vel pharetra vel turpis nunc. Eu augue ut lectus arcu bibendum at varius. Adipiscing at in tellus integer feugiat scelerisque varius',
            'file_attached_path' => null,
            'file_attached_type' => null,
        ]);

        DB::table('messages')->insertOrIgnore([
            'id' => unique_id(),
            'conversation_id' => $conversationId,
            'user_sender_id' => 2,
            'user_receiver_id' => 1,
            'sent_via_group' => 'N',
            'group_id' => null,
            'message'  => 'Enim neque volutpat ac tincidunt vitae semper quis lectus',
            'file_attached_path' => null,
            'file_attached_type' => null,
        ]);

        DB::table('messages')->insertOrIgnore([
            'id' => unique_id(),
            'conversation_id' => $conversationId,
            'user_sender_id' => 1,
            'user_receiver_id' => 2,
            'sent_via_group' => 'N',
            'group_id' => null,
            'message'  => 'Ipsum dolor sit amet consectetu',
            'file_attached_path' => null,
            'file_attached_type' => null,
        ]);

        DB::table('messages')->insertOrIgnore([
            'id' => unique_id(),
            'conversation_id' => $conversationId,
            'user_sender_id' => 2,
            'user_receiver_id' => 1,
            'sent_via_group' => 'N',
            'group_id' => null,
            'message'  => ' aliquam ultrices sagittis orci a. Eget est lorem ipsum dolor sit amet consectetur adipiscing',
            'file_attached_path' => null,
            'file_attached_type' => null,
        ]);

        DB::table('messages')->insertOrIgnore([
            'id' => unique_id(),
            'conversation_id' => $conversationId,
            'user_sender_id' => 2,
            'user_receiver_id' => 1,
            'sent_via_group' => 'N',
            'group_id' => null,
            'message'  => ' Felis eget nunc lobortis mattis aliquam faucibus purus in massa',
            'file_attached_path' => null,
            'file_attached_type' => null,
        ]);

        DB::table('messages')->insertOrIgnore([
            'id' => unique_id(),
            'conversation_id' => $conversationId,
            'user_sender_id' => 1,
            'user_receiver_id' => 2,
            'sent_via_group' => 'N',
            'group_id' => null,
            'message'  => 'met consectetur adipiscing. In cursus turpis massa tincidunt dui',
            'file_attached_path' => null,
            'file_attached_type' => null,
        ]);

        DB::table('messages')->insertOrIgnore([
            'id' => unique_id(),
            'conversation_id' => $conversationId,
            'user_sender_id' => 1,
            'user_receiver_id' => 2,
            'sent_via_group' => 'N',
            'group_id' => null,
            'message'  => 'Tellus orci ac auctor augue. Id venenatis a condimentum vitae sapien pellentesque habitant',
            'file_attached_path' => null,
            'file_attached_type' => null,
        ]);

        DB::table('messages')->insertOrIgnore([
            'id' => unique_id(),
            'conversation_id' => $conversationId,
            'user_sender_id' => 2,
            'user_receiver_id' => 1,
            'sent_via_group' => 'N',
            'group_id' => null,
            'message'  => 'Libero nunc consequat interdum varius. Ante in nibh mauris cursus mattis molestie a iaculis. Commodo elit at imperdiet dui accumsan sit amet nulla',
            'file_attached_path' => null,
            'file_attached_type' => null,
        ]);

        DB::table('messages')->insertOrIgnore([
            'id' => unique_id(),
            'conversation_id' => $conversationId,
            'user_sender_id' => 1,
            'user_receiver_id' => 2,
            'sent_via_group' => 'N',
            'group_id' => null,
            'message'  => 'In eu mi bibendum neque egestas congue quisque egestas diam',
            'file_attached_path' => null,
            'file_attached_type' => null,
        ]);

        DB::table('messages')->insertOrIgnore([
            'id' => unique_id(),
            'conversation_id' => $conversationId,
            'user_sender_id' => 1,
            'user_receiver_id' => 2,
            'sent_via_group' => 'N',
            'group_id' => null,
            'message'  => 'Non blandit massa enim nec dui nunc mattis enim ut. Auctor elit sed vulputate mi sit amet.',
            'file_attached_path' => null,
            'file_attached_type' => null,
        ]);

        DB::table('messages')->insertOrIgnore([
            'id' => unique_id(),
            'conversation_id' => $conversationId,
            'user_sender_id' => 1,
            'user_receiver_id' => 2,
            'sent_via_group' => 'N',
            'group_id' => null,
            'message'  => 'Et pharetra pharetra massa massa ultricies mi quis hendrerit. Adipiscing tristique risus nec feugiat in fermentum. Pharetra massa massa ultricies mi quis hendrerit dolor magna eget. Egestas purus viverra accumsan in nisl nisi scelerisque. Massa massa ultricies mi quis hendrerit dolor magna eget.',
            'file_attached_path' => null,
            'file_attached_type' => null,
        ]);

        // ---------------------------------------------------------------------------------------------------------------------------
        $conversationId = unique_id();

        DB::table('conversations')->insertOrIgnore([
            'id' => $conversationId,
            'user_owner_id' => 1,
            'user_receiver_id' => 6,
            'conversation_in_group' => 'N',
            'group_id' => null,
        ]);

        DB::table('messages')->insertOrIgnore([
            'id' => unique_id(),
            'conversation_id' => $conversationId,
            'user_sender_id' => 1,
            'user_receiver_id' => 6,
            'sent_via_group' => 'N',
            'group_id' => null,
            'message'  => 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which dont look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isnt anything embarrassing hidden in the middle of text.',
            'file_attached_path' => null,
            'file_attached_type' => null,
        ]);

        DB::table('messages')->insertOrIgnore([
            'id' => unique_id(),
            'conversation_id' => $conversationId,
            'user_sender_id' => 1,
            'user_receiver_id' => 6,
            'sent_via_group' => 'N',
            'group_id' => null,
            'message'  => 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which dont look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isnt anything embarrassing hidden in the middle of text.',
            'file_attached_path' => null,
            'file_attached_type' => null,
        ]);

        DB::table('messages')->insertOrIgnore([
            'id' => unique_id(),
            'conversation_id' => $conversationId,
            'user_sender_id' => 6,
            'user_receiver_id' => 1,
            'sent_via_group' => 'N',
            'group_id' => null,
            'message'  => 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which dont look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isnt anything embarrassing hidden in the middle of text.',
            'file_attached_path' => null,
            'file_attached_type' => null,
        ]);

        DB::table('messages')->insertOrIgnore([
            'id' => unique_id(),
            'conversation_id' => $conversationId,
            'user_sender_id' => 1,
            'user_receiver_id' => 6,
            'sent_via_group' => 'N',
            'group_id' => null,
            'message'  => 'Turpis in eu mi bibendum neque egestas. Mi tempus imperdiet nulla malesuada pellentesque elit eget gravida cum. Nisl nunc mi ipsum faucibus vitae aliquet',
            'file_attached_path' => null,
            'file_attached_type' => null,
        ]);

        DB::table('messages')->insertOrIgnore([
            'id' => unique_id(),
            'conversation_id' => $conversationId,
            'user_sender_id' => 6,
            'user_receiver_id' => 1,
            'sent_via_group' => 'N',
            'group_id' => null,
            'message'  => 'Molestie nunc non blandit massa enim. Faucibus scelerisque eleifend donec pretium vulputate',
            'file_attached_path' => null,
            'file_attached_type' => null,
        ]);

        DB::table('messages')->insertOrIgnore([
            'id' => unique_id(),
            'conversation_id' => $conversationId,
            'user_sender_id' => 1,
            'user_receiver_id' => 6,
            'sent_via_group' => 'N',
            'group_id' => null,
            'message'  => 'Pharetra vel turpis nunc eget lorem dolor sed viverra ipsum',
            'file_attached_path' => null,
            'file_attached_type' => null,
        ]);

        DB::table('messages')->insertOrIgnore([
            'id' => unique_id(),
            'conversation_id' => $conversationId,
            'user_sender_id' => 1,
            'user_receiver_id' => 6,
            'sent_via_group' => 'N',
            'group_id' => null,
            'message'  => 'In fermentum posuere urna nec tincidunt praesent semper. Dolor sed viverra ipsum nunc aliquet bibendum enim facilisis. Fames ac turpis egestas maecenas pharetra. Fringilla urna porttitor rhoncus dolor',
            'file_attached_path' => null,
            'file_attached_type' => null,
        ]);

        sleep(1);

        // ---------------------------------------------------------------------------------------------------------------------------
        $conversationId = unique_id();

        DB::table('conversations')->insertOrIgnore([
            'id' => $conversationId,
            'user_owner_id' => 1,
            'conversation_in_group' => 'N',
            'group_id' => null,
            'user_receiver_id' => 10
        ]);

        DB::table('messages')->insertOrIgnore([
            'id' => unique_id(),
            'user_sender_id' => 1,
            'user_receiver_id' => 10,
            'sent_via_group' => 'N',
            'group_id' => null,
            'message'  => 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which dont look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isnt anything embarrassing hidden in the middle of text.',
            'file_attached_path' => null,
            'file_attached_type' => null,
        ]);

        DB::table('messages')->insertOrIgnore([
            'id' => unique_id(),
            'user_sender_id' => 1,
            'user_receiver_id' => 10,
            'sent_via_group' => 'N',
            'group_id' => null,
            'message'  => 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which dont look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isnt anything embarrassing hidden in the middle of text.',
            'file_attached_path' => null,
            'file_attached_type' => null,
        ]);

        DB::table('messages')->insertOrIgnore([
            'id' => unique_id(),
            'user_sender_id' => 10,
            'user_receiver_id' => 1,
            'sent_via_group' => 'N',
            'group_id' => null,
            'message'  => 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which dont look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isnt anything embarrassing hidden in the middle of text.',
            'file_attached_path' => null,
            'file_attached_type' => null,
        ]);

        DB::table('messages')->insertOrIgnore([
            'id' => unique_id(),
            'user_sender_id' => 10,
            'user_receiver_id' => 1,
            'sent_via_group' => 'N',
            'group_id' => null,
            'message'  => 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which dont look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isnt anything embarrassing hidden in the middle of text.',
            'file_attached_path' => null,
            'file_attached_type' => null,
        ]);

        DB::table('messages')->insertOrIgnore([
            'id' => unique_id(),
            'user_sender_id' => 1,
            'user_receiver_id' => 10,
            'sent_via_group' => 'N',
            'group_id' => null,
            'message'  => 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which dont look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isnt anything embarrassing hidden in the middle of text.',
            'file_attached_path' => null,
            'file_attached_type' => null,
        ]);

    }
}
