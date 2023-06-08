<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GroupParticipant extends Model
{
    protected $table = 'group_participants';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'group_id',
        'user_id',

    ];

    protected $hidden = [
        'added_at'
    ];

    public function group() {
        return $this->belongsTo(\App\Models\Group::class, 'id', 'group_id');
    }

    public function user() {
        return $this->hasOne(\App\Models\User::class, 'id', 'user_id');
    }

    /*
    public function save(array $options = [])
    {
        if ( empty($this->id) ) {
            $this->id = unique_id();

            DB::table($this->table)->insert( [
                'id' => $this->id,
                'group_id' => $this->group_id,
                'user_id' => $this->user_id
            ]);
        }
        else {
            DB::table($this->table)
              ->where('id', $this->id)
              ->update([
                'group_id' => $this->group_id,
                'user_id' => $this->user_id
              ]);
        }
    }
    */
}
