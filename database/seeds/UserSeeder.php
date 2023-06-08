<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->updateOrInsert(
             [ 'email' => 'wsantos.delphi@gmail.com' ],

             [
                'name' => 'Willian Pereira dos Santos',
                'email' => 'wsantos.delphi@gmail.com',
                'password' => sha1('123'),
                'email_verified' => 'Y',
                'email_verified_at' => DB::raw(' CURRENT_TIMESTAMP '),
                'image' => 'http://localhost/talktube/images/users/user-1.png'
            ]
        );

        DB::table('users')->updateOrInsert(
            [ 'email' => 'viviane.araujo@gmail.com' ],

            [
               'name' => 'Viviane Araújo',
               'email' => 'viviane.araujo@gmail.com',
               'password' => sha1('123'),
               'email_verified' => 'Y',
               'email_verified_at' => DB::raw(' CURRENT_TIMESTAMP '),
               'image' => null
           ]
       );

        DB::table('users')->updateOrInsert(
            [ 'email' => 'maria.santos@gmail.com' ],

            [
               'name' => 'Maria Santos',
               'email' => 'maria.santos@gmail.com',
               'password' => sha1('123'),
               'email_verified' => 'Y',
               'email_verified_at' => DB::raw(' CURRENT_TIMESTAMP '),
               'image' => 'http://localhost/talktube/images/users/user-2.png'
           ]
       );

       DB::table('users')->updateOrInsert(
            [ 'email' => 'roberto.santana@gmail.com' ],

            [
                'name' => 'Roberto Santana',
                'email' => 'roberto.santana@gmail.com',
                'password' => sha1('123'),
                'email_verified' => 'Y',
                'email_verified_at' => DB::raw(' CURRENT_TIMESTAMP '),
                'image' => 'http://localhost/talktube/images/users/user-3.png'
            ]
        );

        DB::table('users')->updateOrInsert(
            [ 'email' => 'augusto.alves@gmail.com' ],

            [
                'name' => 'Augusto Alves',
                'email' => 'augusto.alves@gmail.com',
                'password' => sha1('123'),
                'email_verified' => 'Y',
                'email_verified_at' => DB::raw(' CURRENT_TIMESTAMP '),
                'image' => 'http://localhost/talktube/images/users/user-4.png'
            ]
        );

        DB::table('users')->updateOrInsert(
            [ 'email' => 'lara.croft@gmail.com' ],

            [
                'name' => 'Lara Croft',
                'email' => 'lara.croft@gmail.com',
                'password' => sha1('123'),
                'email_verified' => 'Y',
                'email_verified_at' => DB::raw(' CURRENT_TIMESTAMP '),
                'image' => 'http://localhost/talktube/images/users/user-1.png'
            ]
        );

        DB::table('users')->updateOrInsert(
            [ 'email' => 'sandra.maria@gmail.com' ],

            [
                'name' => 'Sandra Maria',
                'email' => 'sandra.maria@gmail.com',
                'password' => sha1('123'),
                'email_verified' => 'Y',
                'email_verified_at' => DB::raw(' CURRENT_TIMESTAMP '),
                'image' => 'http://localhost/talktube/images/users/user-2.png'
            ]
        );

        DB::table('users')->updateOrInsert(
            [ 'email' => 'joao.amoedo@gmail.com' ],

            [
                'name' => 'João Amoêdo',
                'email' => 'joao.amoedo@gmail.com',
                'password' => sha1('123'),
                'email_verified' => 'Y',
                'email_verified_at' => DB::raw(' CURRENT_TIMESTAMP '),
                'image' => 'http://localhost/talktube/images/users/joao-amoedo.jpg'
            ]
        );

        DB::table('users')->updateOrInsert(
            [ 'email' => 'aminadabes.alves@gmail.com' ],

            [
                'name' => 'Aminadabes Alves',
                'email' => 'aminadabes.alves@gmail.com',
                'password' => sha1('123'),
                'email_verified' => 'Y',
                'email_verified_at' => DB::raw(' CURRENT_TIMESTAMP '),
                'image' => null,
            ]
        );

        DB::table('users')->updateOrInsert(
            [ 'email' => 'alessandra.meireles@gmail.com' ],

            [
                'name' => 'Alessandra Meireles',
                'email' => 'alessandra.meireles@gmail.com',
                'password' => sha1('123'),
                'email_verified' => 'Y',
                'email_verified_at' => DB::raw(' CURRENT_TIMESTAMP '),
                'image' => null,
            ]
        );

        DB::table('users')->updateOrInsert(
            [ 'email' => 'osmaria.souza@gmail.com' ],

            [
                'name' => 'Osmaria Souza',
                'email' => 'osmaria.souza@gmail.com',
                'password' => sha1('123'),
                'email_verified' => 'Y',
                'email_verified_at' => DB::raw(' CURRENT_TIMESTAMP '),
                'image' => null,
            ]
        );

        DB::table('users')->updateOrInsert(
            [ 'email' => 'debora.cristina@gmail.com' ],

            [
                'name' => 'Débora Cristina',
                'email' => 'debora.cristina@gmail.com',
                'password' => sha1('123'),
                'email_verified' => 'Y',
                'email_verified_at' => DB::raw(' CURRENT_TIMESTAMP '),
                'image' => null,
            ]
        );

        DB::table('users')->updateOrInsert(
            [ 'email' => 'jane.espindola@gmail.com' ],

            [
                'name' => 'Jane Espindola',
                'email' => 'jane.espindola@gmail.com',
                'password' => sha1('123'),
                'email_verified' => 'Y',
                'email_verified_at' => DB::raw(' CURRENT_TIMESTAMP '),
                'image' => null,
            ]
        );

        DB::table('users')->updateOrInsert(
            [ 'email' => 'terry.crews@gmail.com' ],

            [
                'name' => 'Terry Crews',
                'email' => 'terry.crews@gmail.com',
                'password' => sha1('123'),
                'email_verified' => 'Y',
                'email_verified_at' => DB::raw(' CURRENT_TIMESTAMP '),
                'image' => 'http://localhost/talktube/images/users/terry-crews.jpg',
            ]
        );

        DB::table('users')->updateOrInsert(
            [ 'email' => 'keanu.reeves@gmail.com' ],

            [
                'name' => 'Keanu Reeves',
                'email' => 'keanu.reeves@gmail.com',
                'password' => sha1('123'),
                'email_verified' => 'Y',
                'email_verified_at' => DB::raw(' CURRENT_TIMESTAMP '),
                'image' => 'http://localhost/talktube/images/users/keanu-reeves.jpg',
            ]
        );

        DB::table('users')->updateOrInsert(
            [ 'email' => 'ana.lara@gmail.com' ],

            [
                'name' => 'Ana Lara',
                'email' => 'ana.lara@gmail.com',
                'password' => sha1('123'),
                'email_verified' => 'Y',
                'email_verified_at' => DB::raw(' CURRENT_TIMESTAMP '),
                'image' => null,
            ]
        );
    }
}
