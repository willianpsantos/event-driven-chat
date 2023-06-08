<?php

namespace App\Models;

use App\Enums\MessageReceiverType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Message extends Model
{
    protected $table = 'messages';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'conversation_id',
        'user_sender_id',
        'user_receiver_id',
        'sent_via_group',
        'group_id',
        'message',
        'file_attached_path',
        'file_attached_type',
        'message_sent_at'
    ];

    protected $hidden = [
        'message_read',
        'message_read_at',
    ];

    protected $dates = [ 'message_sent_at', 'message_read_at' ];


    public function sender() {
        return $this->hasOne(\App\Models\User::class, 'id', 'user_sender_id');
    }

    public function receiver() {
        return $this->hasOne(\App\Models\User::class, 'id', 'user_receiver_id');
    }

    public function group() {
        return $this->hasOne(\App\Models\Group::class, 'id', 'group_id');
    }

    //public function conversation() {
    //    return $this->hasOne(\App\Models\Conversation::class, 'id', 'conversation_id');
    //}

    public function scopeLastMessageOfConversation($query, $conversation) {
        return $query->where('conversation_id', $conversation)
                     ->orderBy('message_sent_at', 'desc')
                     ->take(1);
    }

    public function scopeGetMessagesOfConversation($query, $conversation, $skip = 1, $take = 10) {
        $realSkip =
            $skip == 1
              ? null
              : ( ( ($skip - 1) * $take ) + 1 );

        return $query->with([ 'sender', 'receiver', 'group' ])
                     ->where('conversation_id', $conversation)
                     ->orderBy('message_sent_at', 'desc')
                     ->take($take)
                     ->skip($realSkip);
    }

    public function scopeMessageRead($query, $conversartion, $message) {

        if ( is_array($message) || strpos($message, ',') > 0 ) {

            if(strpos($message, ',') > 0) {
                $message = explode(',', $message);
            }

            $formattedMessages = array_map(function( $item ) {
                return "'" . $item . "'";
            }, $message);

            $imploded = implode(', ', $formattedMessages);

            DB::statement(
               "UPDATE messages
                   SET message_read_at = CURRENT_TIMESTAMP(6),
                       message_read = 'Y'
                 WHERE id IN ({$imploded})
                   AND conversation_id = '{$conversartion}' "
            );
        }
        else {
            DB::update(
                "UPDATE messages
                    SET message_read_at = CURRENT_TIMESTAMP(6),
                        message_read    = 'Y'
                  WHERE id = ?
                    AND conversation_id = ?",

                [ $message, $conversartion ]
            );
        }

        return true;
    }

    public function scopeUnreadMessageCount($query, $conversartion) {
        return $query->whereNull('message_read_at')
                     ->where('conversation_id', $conversartion)
                     ->count();
    }
}
