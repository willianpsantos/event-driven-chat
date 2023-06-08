<?php

namespace App\Models;

use App\Libraries\UserInterface;
use Illuminate\Database\Eloquent\Model;

class CallMember extends Model implements UserInterface
{
    protected $table = 'call_members';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'call_id',
        'call_invite_id',
        'peer_id',
        'user_id',
        'created_at'
    ];

    public function call() {
        return $this->hasOne(\App\Models\Call::class, 'id', 'call_id');
    }

    public function invite() {
        return $this->hasOne(\App\Models\CallInvite::class, 'id', 'call_invite_id');
    }

    public function user() {
        return $this->hasOne(\App\Models\User::class, 'id', 'user_id');
    }

    public function getEmail() {
        return $this->id;
    }

    public function getPassword(){
        $this->call_id;
    }

    public function scopeGetByPeerId($query, $peerId) {
        return $query->where('peer_id', $peerId);
    }
}
