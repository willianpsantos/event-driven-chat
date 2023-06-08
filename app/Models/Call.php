<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Call extends Model
{
    protected $table = 'calls';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'user_host_id',
        'peer_id',
        'call_started_at',
        'call_ends_at',
        'created_at'
    ];

    public function host(){
        return $this->hasOne(\App\Models\User::class, 'id', 'user_host_id');
    }
}
