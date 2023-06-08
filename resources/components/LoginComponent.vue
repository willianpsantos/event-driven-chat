<template>
    <div class="login-box">
        <div class="row">
            <div class="form-group fg-line">
                <input type="text"
                       class="form-control"
                       id="login"
                       name="login"
                       placeholder="Usuário ou E-mail"
                       v-model="userOrEmail"
                       @keypress="userOrEmailKeyPress" />
            </div>
        </div>

        <div class="row">
            <div class="form-group fg-line">
                <input type="password"
                       class="form-control"
                       id="senha"
                       name="senha"
                       placeholder="Senha"
                       v-model="password"
                       @keypress="passwordKeyPress" />
            </div>
        </div>

        <div class="row">
            <a href="#" class="forgot-password"> Esqueceu a senha? </a>
        </div>

        <div class="row buttons">
            <div class="form-group">
                <button id="btn-login"
                        class="btn btn-primary"
                        v-bind:disabled="!loginButtonEnabled"
                        @click="loginButtonClick">
                    <i class="fa fa-spinner fa-spin fa-2x" v-if="showLoading"></i> &nbsp;
                    Login
                </button>
            </div>
        </div>

        <div class="row buttons">
            <button class="btn social-network-button facebook-button" type="button">
                <div class="social-button-icon"> &nbsp; </div> &nbsp;
                <span> Facebook </span>
            </button>

            <button class="btn social-network-button google-button" type="button">
                <div class="social-button-icon"> &nbsp; </div>
                <span> Google </span>
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                userOrEmail: '',
                password: '',
                showLoading: false,
                loginButtonEnabled: false
            };
        },

        methods: {
            userOrEmailKeyPress: function(e) {
                this.loginButtonEnabled = this.userOrEmail && this.password;
            },

            passwordKeyPress: function(e) {
                this.loginButtonEnabled = this.userOrEmail && this.password;
            },

            loginButtonClick: function(e) {
                this.showLoading = true;
                this.loginButtonEnabled = false;

                const service = new UserService();
                service.authenticate(this.userOrEmail, this.password);
            }
        }
    }
</script>
