<?php

namespace App\Http\Controllers;

use App\Enums\MessageReceiverType;
use App\Events\ChatMessageSentEvent;
use App\Libraries\AuthManager;

use App\Models\Conversation;
use App\Models\Group;
use App\Models\GroupParticipant;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use stdClass;

class ConversationMessageController extends Controller
{
    public function getConversationHistory(Request $request, $user, $skip = 1, $take = 10) {
        $history = Conversation::history($user, $skip, $take);
        return response()->json($history);
    }

    public function getMessagesOfConversation(
        Request $request,
        string $conversation,
        $skip = 1,
        $take = 10
    )
    {
        $model =
            Conversation::where('id', $conversation)
                        ->with([ 'group', 'group.participants', 'group.participants.user' ])
                        ->first();

        $messages = Message::getMessagesOfConversation($conversation, $skip, $take)->get();
        $conversation = json_decode( $model->toJson() );
        $conversation->messages = $messages->toArray();

        return response()->json($conversation);
    }

    public function sendMessageToUser(Request $request) {
        $result = new \stdClass;

        try {
            $conversation = $request->input('conversation');
            $from = $request->input('from');
            $to = $request->input('to');
            $message = $request->input('message');

            $userReceiver = User::find($to);
            $receiverToken = $userReceiver->sesstoken;

            $model = new Message();
            $model->id = unique_id();
            $model->conversation_id = $conversation;
            $model->user_sender_id = $from;
            $model->user_receiver_id = $to;
            $model->sent_via_group = 'N';
            $model->group_id = null;
            $model->message = $message;
            $model->message_read = 'N';
            $model->message_read_at = null;

            $model->save();
            $obj = $model->fresh([ 'sender', 'receiver' ]);
            //$obj->conversation = Conversation::completeConversationById($conversation);

            $result->success = true;
            $result->message = 'Message sent!';
            $result->stored = true;
            $result->messageData = $obj;

            $userReceiver = User::find($to);
            $receiverToken = $userReceiver->sesstoken;

            if( !empty($receiverToken) ) {
                event(new ChatMessageSentEvent($receiverToken, $obj));
                $result->sent = true;
            }
        }
        catch(\Exception $ex) {
            $result->success = false;
            $result->message = $ex->getMessage();
            $result->trace = $ex->getTraceAsString();
            $result->type = get_class($ex);

            $result->stored = false;
            $result->sent = false;
        }

        return response()->json($result);
    }

    public function sendMessageToGroup(Request $request) {
        $result = new \stdClass;
        $result->messages = [];

        try {
            $conversation = $request->input('conversation');
            $from = $request->input('from');
            $group = $request->input('group');
            $message = $request->input('message');

            $groupParticipants =
                GroupParticipant::with([ 'user' ])
                                ->where($group)
                                ->get();

            foreach($groupParticipants as $participant)
            {
                $receiverToken = $participant->user->sesstoken;

                $model = new Message();
                $model->id = unique_id();
                $model->conversation_id = $conversation;
                $model->user_sender_id = $from;
                $model->user_receiver_id = $participant->user_id;
                $model->sent_via_group = 'Y';
                $model->group_id = $group;
                $model->message = $message;
                $model->message_read = 'N';
                $model->message_read_at = null;

                $model->save();
                $obj = $model->fresh([ 'sender', 'receiver' ]);
                //$obj->conversation = Conversation::completeConversationById($conversation);

                $messageData = $obj;
                $messageData->stored = true;
                $messageData->sent = false;

                if( !empty($receiverToken) ) {
                    event(new ChatMessageSentEvent($receiverToken, $obj));
                    $messageData->sent = true;
                }

                $result->messages[] = $messageData;
            }

            $result->success = true;
            $result->messageData = $result->messages[0];
        }
        catch(\Exception $ex) {
            $result->success = false;
            $result->message = $ex->getMessage();
            $result->trace = $ex->getTraceAsString();
            $result->type = get_class($ex);

            $result->stored = false;
            $result->sent = false;
        }

        return response()->json($result);
    }

    public function updateMessageAsRead(Request $request) {
        $result = new \stdClass;

        try {
            $conversartion = $request->input('conversation');
            $message = $request->input('message');

            Message::messageRead($conversartion, $message);
            $unread_messages_count = Message::unreadMessageCount($conversartion);

            $result->success = true;
            $result->message = 'Message read state updated!';
            $result->unread_messages_count = $unread_messages_count;
        }
        catch(\Exception $ex) {
            $result->success = false;
            $result->message = $ex->getMessage();
            $result->exception = get_class($ex);
            $result->trace = $ex->getTraceAsString();
        }

        return response()->json($result);
    }

    public function createUserConversation(Request $request) {
        $to = $request->input('to');
        $from = $request->input('from');

        $model = new Conversation();
        $model->id = unique_id();
        $model->user_owner_id = $from;
        $model->user_receiver_id = $to;
        $model->conversation_in_group ='N';
        $model->group_id = null;
        $model->save();

        $obj = $model->completeConversationById($model->id);

        return response()->json( $obj );
    }

    public function createGroupConversation(Request $request) {
        $from = $request->input('from');
        $group_id = $request->input('group');
        $creator = $request->input('creator');

        if ( empty($group_id) ) {
            $group_id = unique_id();
        }

        $group = new Group();
        $group->id = $group_id;
        $group->user_creator_id = $creator;
        $group->save();

        $model = new Conversation();
        $model->id = unique_id();
        $model->user_owner_id = $from;
        $model->user_receiver_id = null;
        $model->conversation_in_group = 'Y';
        $model->group_id = $group_id;
        $model->save();

        $obj = $model->completeConversationById($model->id);

        return response()->json( $obj );
    }

    public function getConversationDataById(Request $request, $id) {
        $conversation = Conversation::completeConversationById($id);
        return response()->json($conversation);
    }
}
