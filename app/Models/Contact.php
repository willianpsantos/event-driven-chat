<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'contacts';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'user_owner_id',
        'user_contact_id',
        'created_at'
    ];

    public function user_owner() {
        return $this->hasOne(\App\Models\User::class, 'id', 'user_owner_id');
    }

    public function user_contact() {
        return $this->hasOne(\App\Models\User::class, 'id', 'user_contact_id');
    }
}
