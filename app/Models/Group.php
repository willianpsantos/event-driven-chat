<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Group extends Model
{
    protected $table = 'groups';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
        'description',
        'user_creator_id',
        'created_at'
    ];

    public function creator() {
        return $this->hasOne(\App\Models\User::class, 'id', 'user_creator_id');
    }

    public function participants() {
        return $this->hasMany(\App\Models\GroupParticipant::class, 'group_id', 'id');
    }

    public function scopeCreatedByUser($query, $user) {
        return $query->where('user_creator_id', $user);
    }
}
