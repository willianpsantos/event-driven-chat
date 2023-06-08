<template>
    <span>
        <div class="call">
            <video id="video" autoplay></video>

            <div class="call-participants" v-if="members && members.length > 0">
                <video v-for="(member, index) in members"
                       :key="member.id"
                       v-bind:id="member.peer_id"
                       autoplay>
                </video>
            </div>

            <div class="call-options flex-center">
                <button id="audio-button" class="audio denied" @click="audioButtonClick">
                    <i class="zmdi zmdi-mic-off"></i>
                </button>

                <button id="video-button" class="video denied" @click="videoButtonClick">
                    <i class="zmdi zmdi-videocam-off"></i>
                </button>

                <button id="turnoff-call" class="turnoff denied" @click="turnoffCallButtonClick">
                    <i class="fa fa-phone"></i>
                </button>

                <button id="invite" class="allowed" @click="inviteButtonClick">
                    <i class="fa fa-plus"></i>
                </button>
            </div>
        </div>

        <div class="modal fade"
             id="modal-invite-url"
             data-backdrop="static"
             data-keyboard="false"
             tabindex="-1"
             role="dialog"
             aria-labelledby="staticBackdropLabel"
             aria-hidden="true">

            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">
                            <b> Convite para a Chamada </b>
                        </h5>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <p>
                             Envie o link abaixo para as pessoas que deseja convidar para a chamada: <br>
                        </p>

                        <br>

                        <p>
                            <b> {{ inviteUrl }} </b>

                            <input type="text" id="use-for-clipboard" v-model="inviteUrl" style="display:none">
                        </p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Fechar
                        </button>

                        <button type="button" class="btn btn-primary" @click="copyInviteUrlToClipboard">
                            Copiar para Área de Transferência
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade"
             id="modal-accept-member"
             data-backdrop="static"
             data-keyboard="false"
             tabindex="-1"
             role="dialog"
             aria-labelledby="staticBackdropLabel"
             aria-hidden="true">

             <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">
                            <b> Adicionar Membro a Chamada </b>
                        </h5>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <p>
                            Alguém está pedindo para ser adicionado à chamada <br>
                        </p>
                    </div>

                    <div class="modal-footer">
                        <button type="button"
                                class="btn btn-danger"
                                data-dismiss="modal"
                                @click="denyMember">

                            <i class="fa fa-ban"></i>
                            Recusar
                        </button>

                        <button type="button"
                                class="btn btn-primary"
                                @click="allowMember">

                        <i class="fa fa-check-square"></i>
                            Permitir
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade"
             id="modal-waiting-to-be-accepted"
             data-backdrop="static"
             data-keyboard="false"
             tabindex="-1"
             role="dialog"
             aria-labelledby="staticBackdropLabel"
             aria-hidden="true">

             <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">
                            <b> Entrar na Chamada </b>
                        </h5>
                    </div>

                    <div class="modal-body">
                        <p style="float:left; margin-top:15px;">
                            Aguarde para ser aceito na chamada ...
                        </p>

                        <div class="loading-mini" style="width:50px; height:50px; margin-left:50px; float:left;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </span>
</template>

<script>
export default {
    props: {
        callId: { type: String, required: true }
    },

    data() {
        return {
            user: undefined,
            audio: undefined,
            video: undefined,
            inviteUrl: "",
            callData: undefined,
            peer: undefined,

            pendingMembersRequest: [],
            members: [],

            videoAudioStream: undefined
        };
    },

    async created() {
        const that = this;
        const service = new UserService();
        that.user = await service.getAuthenticatedUser();

        if ( that.user.type == 'call-member' && that.user.accepted != 'Y' ) {
            const pusher = window.createPusher();
            const channel = pusher.subscribe(`member-accepted-rejected-to-call-${that.user.id}`);

            channel.bind('member-accepted-to-call', function(e) {
                $('#modal-waiting-to-be-accepted').modal('hide');

                that.startVideo().then(stream => {
                    that.members.push(e.member.call);
                    that.startPeer(e.member.peer_id);
                    that.makeCall(e.member.call.peer_id, stream);
                });
            });

            channel.bind('member-rejected-to-call', function(e) {
                $('#modal-waiting-to-be-accepted').modal('hide');
                const callOptions = that.$el.querySelector('.call-options');
                callOptions && callOptions.remove();
            });

            $('#modal-waiting-to-be-accepted').modal();
        }
    },

    async mounted() {
        const that = this;
        that.video = this.$el.querySelector('#video');

        if ( !that.user ) {
            const service = new UserService();
            that.user = await service.getAuthenticatedUser();
        }

        that.registerMuteUnmuteAudioEventListener();
        that.registerShowHideVideoEventListener();

        if ( that.user.type == 'call-member' && that.user.accepted != 'Y' ) {
            return;
        }

        if ( !that.callId ) {
            return;
        }

        const service = new CallService();
        that.callData = await service.getById(that.callId);

        that.startVideo().then(stream => {
            that.startPeer(that.callData.peer_id);
            that.registerMemberInviteEventListener();
            that.registerMemberDisconnectedOfCallEventListener();

            that.peer.on('call', function(call) {
                call.answer(stream);

                call.on('stream', function(mediaStream) {
                    const e = this;

                    const interval = window.setTimeout(function() {
                        const peerId = e.peer;

                        that.members.forEach(member => {
                            if ( member.peer_id == peerId ) {
                                that.renderParticipantVideo(peerId, e.remoteStream);
                            }
                        });

                        window.clearTimeout(interval);
                    }, 300);
                });

                call.on('close', function(e) {

                });
            });
        });
    },

    methods: {
        renderParticipantVideo: function(id, stream) {
            const participantsContainer = this.$el.querySelector('.call-participants');

            let videoElement = participantsContainer.querySelector('video[id="' + id + '"]');

            if( videoElement ) {
                videoElement.srcObject = stream;
            }
        },

        makeCall: function(otherPeerId, mediaStream) {
            const options = {
                'constraints': {
                    'mandatory': {
                        'OfferToReceiveAudio': true,
                        'OfferToReceiveVideo': true
                    }
                }
            };

            const that = this;
            const call = that.peer.call(otherPeerId, mediaStream);

            call.on('stream', function(stream) {
                const e = this;

                const interval = window.setTimeout(function() {
                    const peerId = e.peer;

                    that.members.forEach(member => {
                        if ( member.peer_id == peerId ) {
                            that.renderParticipantVideo(peerId, e.remoteStream);
                        }
                    });

                    window.clearTimeout(interval);
                }, 300);
            });
        },

        startPeer: function(peerId) {
            const that = this;
            that.peer = window.createPeer(peerId);

            that.peer.on('open', function(peerId) {
                that.peer.on('disconnected', function(e) {

                });
            });
        },

        startVideo: function() {
            const that = this;

            return new Promise((resolve, reject) => {
                const handleVideo = function(stream) {
                    that.toggleVideoButton(true);
                    that.toggleAudioButton(true);
                    that.video.srcObject = stream;

                    resolve(stream);
                };

                navigator
                    .mediaDevices
                    .getUserMedia({ video: true, audio: true })
                    .then(handleVideo)
                    .catch(reason => reject(reason));
            });

        },

        copyInviteUrlToClipboard: function(e) {
            navigator.clipboard.writeText(this.inviteUrl).then(() => {
                $('#modal-invite-url').modal('hide');
            });
        },

        toggleAudioButton: function(allowed) {
            const buttonAudio = this.$el.querySelector('.call-options button#audio-button');
            const i = buttonAudio.querySelector('i');

            if(allowed) {
                buttonAudio.classList.remove('denied');
                i.classList.remove('zmdi-mic-off');

                buttonAudio.classList.add('allowed');
                i.classList.add('zmdi-mic');
            }
            else {
                buttonAudio.classList.remove('allowed');
                i.classList.remove('zmdi-mic');

                buttonAudio.classList.add('denied');
                i.classList.add('zmdi-mic-off');
            }
        },

        toggleVideoButton: function(allowed) {
            const buttonVideo = this.$el.querySelector('.call-options button#video-button');
            const i = buttonVideo.querySelector('i');

            if(allowed) {
                buttonVideo.classList.remove('denied');
                i.classList.remove('zmdi-videocam-off');

                buttonVideo.classList.add('allowed');
                i.classList.add('zmdi-videocam');
            }
            else {
                buttonVideo.classList.remove('allowed');
                i.classList.remove('zmdi-videocam');

                buttonVideo.classList.add('denied');
                i.classList.add('zmdi-videocam-off');
            }
        },

        audioButtonClick: function(e) {
            const button = e.currentTarget;

            if ( button.classList.contains('allowed') ) {
                this.video.muted = true;
                this.toggleAudioButton(false);
            }
            else {
                this.video.muted = false;
                this.toggleAudioButton(true);
            }

            const request = new MuteUnmutedAudioRequest;
            request.call = this.callId;
            request.member = this.user.type == 'user' ? "" : this.user.id;
            request.host = this.user.type == 'user';
            request.mute = this.video.muted;

            const service = new CallService();
            service.muteUnmuteAudio(request);
        },

        videoButtonClick: function(e) {
            const button = e.currentTarget;
            let show = true;

            if ( button.classList.contains('allowed') ) {
                this.video.hide();
                this.toggleVideoButton(false);
                show = false;
            }
            else {
                this.video.show();
                this.toggleVideoButton(true);
                show = true;
            }

            const request = new ShowHideVideoRequest;
            request.call = this.callId;
            request.member = this.user.type == 'user' ? "" : this.user.id;
            request.host = this.user.type == 'user';
            request.show = show;

            const service = new CallService();
            service.showHideVideo(request);
        },

        turnoffCallButtonClick: async function(e) {
            const button = e.currentTarget;

            this.video && this.video.srcObject && this.video.srcObject.getVideoTracks().forEach(track => {
                track.stop();
            });

            this.video && this.video.srcObject && this.video.srcObject.getAudioTracks().forEach(track => {
                track.stop();
            });

            this.peer && this.peer.disconnect();

            if ( this.user.type == 'call-member' ) {
                window.loading.show();

                const service = new CallService();
                await service.disconnectMember(this.user.peer_id);
                this.members.splice(0, this.members.length);

                window.loading.hide();
            }
        },

        inviteButtonClick: async function(e) {
            window.loading.show();

            const service = new CallService();
            const result = await service.createInvite(this.callId);
            this.inviteUrl = result.url;
            window.loading.hide();

            $('#modal-invite-url').modal();
        },

        openMemberRequestModal: function() {
            const modal = $('#modal-accept-member');
            const data = modal.data('bs.modal');

            if ( data && data._isShown ) {
                return;
            }

            if ( !this.pendingMembersRequest || this.pendingMembersRequest.length == 0 ) {
                return;
            }

            const firstRequest = this.pendingMembersRequest[0];

            modal.on('show.bs.modal', function(e) {
                const modalElement = $(this);
                const footer = modalElement.find('.modal-footer');

                footer.find('button').each(function(index, btn) {
                    const memberId = modalElement.data('member-id');
                    btn.setAttribute('data-member-id', memberId);
                });
            });

            modal.data('member-id', firstRequest.id);
            modal.modal();
        },

        allowOrDenyMember: async function(memberId, allow) {
            let pendingIndex = undefined;
            let pendingRequest = undefined;

            this.pendingMembersRequest.forEach( (item, index) => {
                if ( item.id == memberId ) {
                    pendingIndex = index;
                    pendingRequest = item;
                }
            });

            if( pendingIndex !== undefined ) {
                window.loading.show();
                const service = new CallService();
                let memberInfo;

                if ( allow === true ) {
                    memberInfo = await service.acceptMember(memberId);
                    this.members.push(memberInfo);
                }
                else {
                    memberInfo = await service.denyMember(memberId);
                }

                this.pendingMembersRequest.splice(pendingIndex, 1);
                window.loading.hide();
                $('#modal-accept-member').modal('hide');
            }

            this.openMemberRequestModal();
        },

        allowMember: function(e) {
            const button = e.currentTarget;
            const memberId = button.dataset.memberId;
            this.allowOrDenyMember(memberId, true);
        },

        denyMember: function(e) {
            const button = e.currentTarget;
            const memberId = button.dataset.memberId;
            this.allowOrDenyMember(memberId, false);
        },

        registerMemberInviteEventListener: function() {
            const that = this;
            const pusher = window.createPusher();
            const channelName = `call-member-add-request-${this.callId}`;
            const channel = pusher.subscribe(channelName);

            channel.bind('call-member-add-request', function(e) {
                that.pendingMembersRequest.push(e.member);
                that.openMemberRequestModal();
            });
        },

        registerMemberDisconnectedOfCallEventListener: function() {
            const that = this;
            const pusher = window.createPusher();
            const channelName = `member-disconnected-of-call-${this.callId}`;
            const channel = pusher.subscribe(channelName);

            channel.bind('member-disconnected-of-call', function(e) {
                let memberIndex = undefined;

                that.members.forEach((item,index) => {
                    if ( item.id == e.member.id ) {
                        memberIndex = index;
                    }
                });

                if ( memberIndex !== undefined ) {
                    that.members.splice(memberIndex, 1);
                }
            });
        },

        registerMuteUnmuteAudioEventListener: function() {
            const that = this;
            const pusher = window.createPusher();
            const channelName = `call-mute-unmute-audio-${this.callId}`;
            const channel = pusher.subscribe(channelName);

            channel.bind('call-mute-unmute-audio', function(e) {
                let memberPeerId = undefined;

                that.members.forEach((item,index) => {
                    if ( e.data.host === true ) {
                        if ( item.id == e.data.call ) {
                            memberPeerId = item.peer_id;
                        }
                    }
                    else {
                        if ( item.id == e.data.member ) {
                            memberPeerId = item.peer_id;
                        }
                    }
                });

                if ( !memberPeerId ) {
                    return;
                }

                let videoElem = that.$el.querySelector(`video[id="${memberPeerId}"]`);
                videoElem.muted = e.data.mute;
                that.toggleAudioButton(!e.data.mute);
            });
        },

        registerShowHideVideoEventListener: function() {
            const that = this;
            const pusher = window.createPusher();
            const channelName = `call-show-hide-video-${this.callId}`;
            const channel = pusher.subscribe(channelName);

            channel.bind('call-show-hide-video', function(e) {
                let memberPeerId = undefined;

                that.members.forEach((item,index) => {
                    if ( e.data.host === true ) {
                        if ( item.id == e.data.call ) {
                            memberPeerId = item.peer_id;
                        }
                    }
                    else {
                        if ( item.id == e.data.member ) {
                            memberPeerId = item.peer_id;
                        }
                    }
                });

                if ( !memberPeerId ) {
                    return;
                }

                let videoElem = that.$el.querySelector(`video[id="${memberPeerId}"]`);

                if(e.data.show) {
                    videoElem.show();
                    that.toggleVideoButton(true);
                }
                else {
                    videoElem.hide();
                    that.toggleVideoButton(false);
                }
            });
        }
    }
}
</script>
