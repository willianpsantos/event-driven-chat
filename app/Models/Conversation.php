<?php

namespace App\Models;

use App\Enums\MessageReceiverType;
use App\Models\GroupParticipant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Conversation extends Model
{
    protected $table = 'conversations';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'user_owner_id',
        'conversation_in_group',
        'group_id',
        'user_receiver_id',
        'created_at'
    ];

    protected $dates = [ 'created_at' ];

    public function owner() {
        return $this->hasOne(\App\Models\User::class, 'id', 'user_owner_id');
    }

    public function receiver() {
        return $this->hasOne(\App\Models\User::class, 'id', 'user_receiver_id');
    }

    public function group() {
        return $this->hasOne(\App\Models\Group::class, 'id', 'group_id');
    }

    public function messages() {
        return $this->hasMany(\App\Models\Message::class, 'conversation_id', 'id');
    }


    public function scopeHistory($query, $user, $skip = 1, $take = 10 ) {
        $realSkip =
            $skip == 1
              ? null
              : ( ( ($skip - 1) * $take ) + 1 );

        $query =
            DB::table('conversations as c')
              ->join('users  as uo', 'uo.id', '=', 'c.user_owner_id', 'left')
              ->join('users  as ur', 'ur.id', '=', 'c.user_receiver_id', 'left')
              ->join('groups as gp', 'gp.id', '=', 'c.group_id', 'left')
              ->distinct()
              ->select([
                    'c.id',
                    'c.conversation_in_group',
                    'c.created_at',

                    'c.user_owner_id',
                    'uo.name  as user_owner_name',
                    'uo.email as user_owner_email',
                    'uo.image as user_owner_image',

                    'c.user_receiver_id',
                    'ur.name  as user_receiver_name',
                    'ur.email as user_receiver_email',
                    'ur.image as user_receiver_image',

                    'c.group_id',
                    'gp.name  as group_name',

                    DB::raw(
                        ' (SELECT COUNT(*)
                            FROM messages me
                           WHERE me.conversation_id = c.id
                             AND me.message_read_at IS NULL) as unread_messages_count '
                    )
              ])
              ->where(function($q) use($user) {
                    $q->where('user_owner_id', $user)
                      ->orWhere('user_receiver_id', $user);
              })
              ->orderBy('c.created_at', 'desc')
              ->skip( $realSkip )
              ->take($take)
              ->get();

        $participantsModel = new GroupParticipant();
        $data = [];

        foreach( $query as $row ) {
            $item = new \stdClass;
            $item->id = $row->id;
            $item->created_at = $row->created_at;
            $item->unread_messages_count = $row->unread_messages_count;

            $item->owner = new \stdClass;
            $item->owner->id = $row->user_owner_id;
            $item->owner->name = $row->user_owner_name;
            $item->owner->email = $row->user_owner_email;
            $item->owner->image = $row->user_owner_image;

            $item->last_message = Message::lastMessageOfConversation($row->id)->first();
            $item->interval_last_message = "";

            if ( $item->last_message ) {
                $sent_at = new \DateTime($item->last_message->message_sent_at);
                $current_date = current_date();
                $diff = $current_date->diff( $sent_at );
                $item->interval_last_message = interval_desc($diff);
            }

            if ( $row->conversation_in_group == 'Y' ) {
                $item->receiver_type = MessageReceiverType::GROUP;

                $item->receiver = new \stdClass;
                $item->receiver->id = $row->group_id;
                $item->receiver->name = $row->group_name;

                $item->receiver->participants =
                    $participantsModel
                        ->with([ 'user' ])
                        ->where('group_id', $row->group_id)
                        ->get();
            }
            else {
                $item->receiver_type = MessageReceiverType::USER;

                $item->receiver = new \stdClass;
                $item->receiver->id = $row->user_receiver_id;
                $item->receiver->name = $row->user_receiver_name;
                $item->receiver->email = $row->user_receiver_email;
                $item->receiver->image = $row->user_receiver_image;
            }

            $data[] = $item;
        }

        return $data;
    }

    public function scopeCompleteConversationById($query, $id) {
        $query =
            DB::table('conversations as c')
            ->join('users  as uo', 'uo.id', '=', 'c.user_owner_id', 'left')
            ->join('users  as ur', 'ur.id', '=', 'c.user_receiver_id', 'left')
            ->join('groups as gp', 'gp.id', '=', 'c.group_id', 'left')
            ->distinct()
            ->select([
                    'c.id',
                    'c.conversation_in_group',
                    'c.created_at',

                    'c.user_owner_id',
                    'uo.name  as user_owner_name',
                    'uo.email as user_owner_email',
                    'uo.image as user_owner_image',

                    'c.user_receiver_id',
                    'ur.name  as user_receiver_name',
                    'ur.email as user_receiver_email',
                    'ur.image as user_receiver_image',

                    'c.group_id',
                    'gp.name  as group_name',

                    DB::raw(
                        ' (SELECT COUNT(*)
                            FROM messages me
                        WHERE me.conversation_id = c.id
                            AND me.message_read_at IS NULL) as unread_messages_count '
                    )
            ])
            ->where('c.id', $id)
            ->first();

        $participantsModel = new GroupParticipant();
        $row = $query;

        $item = new \stdClass;
        $item->id = $row->id;
        $item->created_at = $row->created_at;
        $item->unread_messages_count = $row->unread_messages_count;

        $item->owner = new \stdClass;
        $item->owner->id = $row->user_owner_id;
        $item->owner->name = $row->user_owner_name;
        $item->owner->email = $row->user_owner_email;
        $item->owner->image = $row->user_owner_image;

        $item->last_message = Message::lastMessageOfConversation($row->id)->first();
        $item->interval_last_message = "";

        if ( $item->last_message ) {
            $sent_at = new \DateTime($item->last_message->message_sent_at);
            $current_date = current_date();
            $diff = $current_date->diff( $sent_at );
            $item->interval_last_message = interval_desc($diff);
        }

        if ( $row->conversation_in_group == 'Y' ) {
            $item->receiver_type = MessageReceiverType::GROUP;

            $item->receiver = new \stdClass;
            $item->receiver->id = $row->group_id;
            $item->receiver->name = $row->group_name;

            $item->receiver->participants =
                $participantsModel
                    ->with([ 'user' ])
                    ->where('group_id', $row->group_id)
                    ->get();
        }
        else {
            $item->receiver_type = MessageReceiverType::USER;

            $item->receiver = new \stdClass;
            $item->receiver->id = $row->user_receiver_id;
            $item->receiver->name = $row->user_receiver_name;
            $item->receiver->email = $row->user_receiver_email;
            $item->receiver->image = $row->user_receiver_image;
        }

        return $item;
    }
}
