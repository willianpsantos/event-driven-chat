<?php

namespace App\Models;

use App\Libraries\UserInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class User extends Model implements UserInterface
{
    protected $table = 'users';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
        'email',
        'image',
        'sesstoken'
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'email_verified',
        'email_verified_at'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getEmail() {
        return $this->email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function contacts() {
        return $this->hasMany(\App\Models\Contact::class, 'user_owner_id', 'id');
    }

    public function scopeByEmail($query, $email) {
        return $query->where('email', $email);
    }

    public function scopeSearchUsers($query, string $text) {
        $lowerSearch = mb_strtolower($text);
        $whereClause = "";

        if ( preg_match("/[^0-9]/", $lowerSearch) ) {
            $whereClause =
               "(
                    LOWER(name)  LIKE CONCAT('%', '$lowerSearch', '%') OR
                    LOWER(email) LIKE CONCAT('%', '$lowerSearch', '%')
                )";
        }
        else {
            $whereClause = " id = $lowerSearch ";
        }

        return $query->whereRaw($whereClause);
    }

    public function scopeSearchUserContacts($query, string $text, $user) {
        $lowerSearch = mb_strtolower($text);
        $whereClause = "";

        if ( preg_match("/[^0-9]/", $lowerSearch) ) {
            $whereClause =
               "(
                    LOWER(name)  LIKE CONCAT('%', '$lowerSearch', '%') OR
                    LOWER(email) LIKE CONCAT('%', '$lowerSearch', '%')
                )";
        }
        else {
            $whereClause = " id = $lowerSearch ";
        }

        return $query->whereRaw($whereClause)
                     ->whereExists(function($q) use($user) {
                         $q->select(DB::raw(1))
                           ->from('contacts')
                           ->whereRaw(' contacts.user_contact_id = users.id ')
                           ->where('contacts.user_owner_id', $user);
                     });
    }

    public function scopeContactsOfUser($query, $id) {
        $contacts =
            DB::table('contacts')
              ->join('users', 'users.id', '=', 'contacts.user_contact_id')
              ->where('contacts.user_owner_id', '=', $id)
              ->orderBy('users.name')
              ->select(
                    'contacts.id as contact_id',
                    'users.id as user_id',
                    'users.name',
                    'users.email',
                    'users.image',
                    'contacts.can_phone',
                    'contacts.can_video',
                    'contacts.can_message',
              )
              ->get();

        return $contacts;
    }

    public function scopeRecentContactsOfUser($query, $id) {
        $contacts =
            DB::table('contacts')
              ->join('users', 'users.id', '=', 'contacts.user_contact_id')
              ->where('contacts.user_owner_id', '=', $id)
              ->where(function($q) {
                    $q->whereNotNull('contacts.last_call_at')
                      ->orWhereNotNull('contacts.last_message_at');
              })
              ->orderBy('contacts.last_call_at', 'desc')
              ->orderBy('contacts.last_message_at', 'desc')
              ->select(
                    'contacts.id as contact_id',
                    'users.id as user_id',
                    'users.name',
                    'users.email',
                    'users.image',
                    'contacts.can_phone',
                    'contacts.can_video',
                    'contacts.can_message',
              )
              ->take(10)
              ->get();

        return $contacts;
    }
}
