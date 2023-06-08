<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CallInvite extends Model
{
    protected $table = 'call_invites';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'call_id',
        'valid_start_at',
        'valid_ends_at',
        'invite_url',
        'created_at'
    ];

    protected $dates= [
        'valid_start_at',
        'valid_ends_at'
    ];

    protected $casts = [
        'valid_start_at' => 'datetime:Y-m-d H:i',
        'valid_ends_at' => 'datetime:Y-m-d H:i',
    ];

    public function call() {
        return $this->hasOne(\App\Models\Call::class, 'id', 'call_id');
    }

    public function scopeValidInvites($query, $call) {
        return $query->where('call_id', $call)
                     ->whereRaw(' CURRENT_TIMESTAMP BETWEEN valid_start_at AND valid_ends_at ');
    }

    public function scopeValidInviteById($query, $id) {
        return $query->where('id', $id)
                     ->whereRaw(' CURRENT_TIMESTAMP BETWEEN valid_start_at AND valid_ends_at ');
    }
}
