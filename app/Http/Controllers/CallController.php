<?php

namespace App\Http\Controllers;

use App\Events\CallMemberAddRequestEvent;
use App\Events\CallMuteUnmuteAudioEvent;
use App\Events\CallMuteUnmuteAudioEventData;
use App\Events\CallShowHideVideoEvent;
use App\Events\CallShowHideVideoEventData;
use App\Events\MemberAcceptedToCallEvent;
use App\Events\MemberDisconnectedOfCallEvent;
use App\Events\MemberRejectedToCallEvent;
use App\Libraries\AuthManager;
use App\Models\Call;
use App\Models\CallInvite;
use App\Models\CallMember;
use Illuminate\Http\Request;

class CallController extends Controller
{
    public function getCallInfosById(Request $request, $id) {
        $model = Call::find($id);
        return response()->json($model);
    }

    public function createCall(Request $request) {
        $host = $request->input('host');

        $model = new Call();
        $model->id = unique_id();
        $model->user_host_id = $host;
        $model->peer_id = unique_id();
        $model->call_ends_at = null;
        $model->save();

        return response()->json($model);
    }

    public function createCallInvite(Request $request) {
        $call = $request->input('call');
        $result = new \stdClass;
        $result->success = true;
        $result->url = "";
        $validInvite = CallInvite::validInvites($call)->first();

        if ( !empty($validInvite) ) {
            $result->url = $validInvite->invite_url;
            return response()->json($result);
        }

        $expireHours = env('CALL_INVITE_EXPIRE_HOURS');

        $start = current_date();
        $end = current_date();
        $end->modify("+{$expireHours} hour");

        $baseUrl = env('CALL_INVITE_URL');
        $inviteId = unique_id();
        $inviteUrl = $baseUrl . $inviteId;

        $model = new CallInvite();
        $model->id = $inviteId;
        $model->call_id = $call;
        $model->valid_start_at = $start;
        $model->valid_ends_at = $end;
        $model->invite_url = $inviteUrl;
        $model->save();

        $result->url = $inviteUrl;

        return response()->json($result);
    }

    public function addMemberToCallThroughInvite(Request $request, $id) {
        $invite = CallInvite::validInviteById($id)->first();
        $result = new \stdClass;
        $result->success = true;

        if ( empty($invite) ) {
            $result->success = false;
            $result->message = 'Expired Invite';
            return response()->json($result);
        }

        $model = new CallMember();
        $model->id = unique_id();
        $model->call_id = $invite->call_id;
        $model->call_invite_id = $invite->id;
        $model->accepted = 'N';
        $model->peer_id = unique_id();
        $model->save();

        $result->member_id = $model->id;
        $result->peer_id = $model->peer_id;
        $model->type = 'call-member';

        AuthManager::setAuthUser($request, $model);

        event(new CallMemberAddRequestEvent($invite->call_id, $model));

        return redirect("/#/call/{$invite->call_id}");
    }

    public function acceptMember(Request $request) {
        $id = $request->input('id');
        $member = CallMember::find($id);
        $member->accepted = 'Y';
        $member->save();

        $obj = $member->fresh([ 'call' ]);
        event(new MemberAcceptedToCallEvent($obj));

        return response()->json($obj);
    }

    public function denyMember(Request $request) {
        $id = $request->input('id');
        $member = CallMember::find($id);
        $member->accepted = 'N';
        $member->save();

        $obj = $member->fresh([ 'call' ]);
        event(new MemberRejectedToCallEvent($obj));

        return response()->json($obj);
    }

    public function disconnectMemberOfCall(Request $request) {
        $peer = $request->input('peer');
        $model = CallMember::getByPeerId($peer)->first();
        $obj = $model->fresh([ 'call' ]);

        event(new MemberDisconnectedOfCallEvent($obj->call_id, $obj));

        return response()->json($obj);
    }

    public function muteUnmuteAudio(Request $request) {
        $member = $request->input('member');
        $call   = $request->input('call');
        $host   = $request->input('host') === 'true';
        $mute   = $request->input('mute') === 'true';

        $data = new CallMuteUnmuteAudioEventData();
        $data->member = $member;
        $data->call = $call;
        $data->host = $host;
        $data->mute = $mute;

        broadcast(new CallMuteUnmuteAudioEvent($data));

        return response()->json(true);
    }

    public function showHideVideo(Request $request) {
        $member = $request->input('member');
        $call   = $request->input('call');
        $host   = $request->input('host') === 'true';
        $show   = $request->input('show') === 'true';

        $data = new CallShowHideVideoEventData();
        $data->member = $member;
        $data->call = $call;
        $data->host = $host;
        $data->show = $show;

        broadcast(new CallShowHideVideoEvent($data));

        return response()->json(true);
    }
}
