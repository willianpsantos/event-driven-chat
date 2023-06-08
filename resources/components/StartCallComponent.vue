<template>
    <span>
        <div class="start-call">
            <video id="video" autoplay></video>

            <audio id="audio" autoplay></audio>

            <div class="call-options flex-center">
                <button id="audio-button" class="audio denied" @click="audioButtonClick">
                    <i class="zmdi zmdi-mic-off"></i>
                </button>

                <button id="video-button" class="video denied" @click="videoButtonClick">
                    <i class="zmdi zmdi-videocam-off"></i>
                </button>
            </div>
        </div>

        <div class="row call-buttons">
            <h4>
                Pronto para Iniciar?
            </h4>

            <div class="flex-center" v-show="!callStarted">
                <button class="btn btn-success" @click="startButtonClick">
                    <i class="fa fa-phone-square"></i>
                    Iniciar
                </button>
            </div>
        </div>
    </span>
</template>

<script>
export default {
    data() {
        return {
            callStarted: false,
            call: undefined,
            user: undefined,
            video: undefined,
            audio: undefined
        };
    },

    async created() {
        const service = new UserService();
        this.user = await service.getAuthenticatedUser();
    },

    mounted() {
        const that = this;
        that.video = that.$el.querySelector('video');

        const handleVideo = function(stream) {
            that.video.srcObject = stream;
            that.video.hide();
            that.video.muted = true;

            that.toggleVideoButton(false);
            that.toggleAudioButton(false);
        };

        navigator
            .mediaDevices
            .getUserMedia({ video: true, audio: true })
            .then(handleVideo);

        that.callStarted = false;
    },

    methods: {

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
        },

        videoButtonClick: function(e) {
            const button = e.currentTarget;

            if ( button.classList.contains('allowed') ) {
                this.video.hide();
                this.toggleVideoButton(false);
            }
            else {
                this.video.show();
                this.toggleVideoButton(true);
            }
        },

        startButtonClick: async function(e) {
            window.loading.show();

            this.callStarted = true;
            const service = new CallService();
            const call = await service.createCall(this.user.id);

            window.loading.hide();

            this.video && this.video.srcObject && this.video.srcObject.getVideoTracks().forEach(track => {
                track.stop();
            });

            this.video && this.video.srcObject && this.video.srcObject.getAudioTracks().forEach(track=> {
                track.stop();
            });

            const routePath = `/call/${call.id}`;
            this.$router.replace({ path: routePath }).catch(error => {});
        }
    }
}
</script>
