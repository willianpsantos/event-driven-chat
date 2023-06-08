<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupParticipant;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function addOrUpdateGroup(Request $request) {
        $name = $request->input('name');
        $description = $request->input('description');
        $id = $request->input('id');
        $creator = $request->input('creator');

        if ( !empty($id) ) {
            $model = Group::find($id);
        }
        else {
            $model = new Group();
        }

        $model->id = !empty($id) ? $id : unique_id();
        $model->name = $name;
        $model->description = $description;
        $model->user_creator_id = $creator;

        $model->save();

        return response()->json($model);
    }

    public function addParticipantToGroup(Request $request) {
        $group = $request->input('group');
        $user = $request->input('user');

        $model = new GroupParticipant();
        $model->id = unique_id();
        $model->group_id = $group;
        $model->user_id = $user;
        $model->save();

        $obj = $model->fresh([ 'user' ]);

        return response()->json($obj);
    }
}
