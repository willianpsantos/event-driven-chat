<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //-------------------------------------------------------------------------------------------------
        $query = DB::table('groups')->where('name', '=', 'Grupo Designer')->select([ 'id' ])->first();
        $idGroup1 = "";

        if ( $query && $query->id ) {
            $idGroup1 = $query->id;
        }
        else {
            $idGroup1 = unique_id();
        }

        DB::table('groups')->updateOrInsert(
            [ 'name' => 'Grupo Designer' ],

            [
                'id' => $idGroup1,
                'name' => 'Grupo Designer',
                'description' => 'Grupo para discutir assuntos sobre designer',
                'user_creator_id' => 1
            ]
        );


        DB::table('group_participants')->where('group_id', $idGroup1)->delete();

        DB::table('group_participants')->insert([
            [
                'id' => unique_id(),
                'group_id' => $idGroup1,
                'user_id' => 2
            ],

            [
                'id' => unique_id(),
                'group_id' => $idGroup1,
                'user_id' => 4
            ],
        ]);


        //-------------------------------------------------------------------------------------------------
        $query = DB::table('groups')->where('name', '=', 'Vagas de Emprego')->select([ 'id' ])->first();
        $idGroup2 = "";

        if ( $query && $query->id ) {
            $idGroup2 = $query->id;
        }
        else {
            $idGroup2 = unique_id();
        }

        DB::table('groups')->updateOrInsert(
            [ 'name' => 'Vagas de Emprego' ],

            [
                'id' => $idGroup2,
                'name' => 'Vagas de Emprego',
                'description' => 'Grupo para publicar vagas de emprego',
                'user_creator_id' => 1
            ]
        );

        DB::table('group_participants')->where('group_id', $idGroup2)->delete();

        DB::table('group_participants')->insert([
            [
                'id' => unique_id(),
                'group_id' => $idGroup2,
                'user_id' => 3
            ],

            [
                'id' => unique_id(),
                'group_id' => $idGroup2,
                'user_id' => 5
            ],

            [
                'id' => unique_id(),
                'group_id' => $idGroup2,
                'user_id' => 6
            ],
        ]);


        //-------------------------------------------------------------------------------------------------
        $query = DB::table('groups')->where('name', '=', 'Dev')->select([ 'id' ])->first();
        $idGroup3 = "";

        if ( $query && $query->id ) {
            $idGroup3 = $query->id;
        }
        else {
            $idGroup3 = unique_id();
        }

        DB::table('groups')->updateOrInsert(
            [ 'name' => 'Dev' ],

            [
                'id' => $idGroup3,
                'name' => 'Dev',
                'description' => 'Grupo para trocar dicas de desenvolvimento',
                'user_creator_id' => 1
            ]
        );


        DB::table('group_participants')->where('group_id', $idGroup3)->delete();

        DB::table('group_participants')->insert([
            [
                'id' => unique_id(),
                'group_id' => $idGroup3,
                'user_id' => 8
            ],

            [
                'id' => unique_id(),
                'group_id' => $idGroup3,
                'user_id' => 10
            ],

            [
                'id' => unique_id(),
                'group_id' => $idGroup3,
                'user_id' => 11
            ],

            [
                'id' => unique_id(),
                'group_id' => $idGroup3,
                'user_id' => 12
            ],
        ]);
    }
}
