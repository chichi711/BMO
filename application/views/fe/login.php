<div id="app">
    <!-- Page Title
		============================================= -->
    <section id="page-title">

        <div class="container clearfix">
            <h1><?= $active ?></h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page"><?= $active ?></li>
            </ol>
        </div>

    </section><!-- #page-title end -->

    <!-- Content
		============================================= -->
    <section id="content">
        <div class="content-wrap">
            <div class="container clearfix">

                <div class="tabs mx-auto mb-0 clearfix" id="tab-login-register" style="max-width: 500px;">

                    <ul class="tab-nav tab-nav2 center clearfix">
                        <li class="inline-block"><a href="/login#tab-login">登入</a></li>
                        <li class="inline-block"><a href="/login#tab-register">註冊</a></li>
                    </ul>

                    <div class="tab-container">

                        <div class="tab-content" id="tab-login">
                            <div class="card mb-0">
                                <div class="card-body" style="padding: 40px;">
                                    <form id="login-form" name="login-form" class="mb-0" action="#" method="post">


                                        <div class="row">
                                            <div class="col-12 form-group">
                                                <label for="login-form-username">帳號:</label>
                                                <input type="text" id="login-form-username" name="login-form-username" v-model="login.user_id" class="form-control login-val" />
                                            </div>

                                            <div class="col-12 form-group">
                                                <label for="login-form-password">密碼:</label>
                                                <input type="password" id="login-form-password" name="login-form-password" v-model="login.user_pwd" class="form-control login-val" />
                                            </div>

                                            <div class="col-12 form-group">
                                                <button type="button" class="button button-3d button-black m-0" id="login-form-submit" name="login-form-submit" @click="user_login">登入</button>
                                                <a href="#" class="float-right">忘記密碼?</a>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="tab-content" id="tab-register">
                            <div class="card mb-0">
                                <div class="card-body" style="padding: 40px;">

                                    <form id="register-form" name="register-form" class="row mb-0" action="#" method="post">

                                        <div class="col-12 form-group">
                                            <label for="register-form-email">電子郵件:</label>
                                            <input type="text" id="register-form-email" name="register-form-email" v-model="submit.email" class="form-control require-val" />
                                        </div>

                                        <div class="col-12 form-group">
                                            <label for="register-form-username">帳號:</label>
                                            <input type="text" id="register-form-username" name="register-form-username" v-model="submit.user_id" class="form-control require-val" />
                                        </div>

                                        <div class="col-12 form-group">
                                            <label for="register-form-password">密碼:</label>
                                            <input type="password" id="register-form-password" name="register-form-password" v-model="submit.user_pwd" class="form-control require-val" />
                                        </div>

                                        <div class="col-12 form-group">
                                            <label for="register-form-repassword">確認密碼:</label>
                                            <input type="password" id="register-form-repassword" name="register-form-repassword" v-model="submit.chk_pwd" class="form-control require-val" />
                                        </div>

                                        <div class="col-12 form-group">
                                            <button type="button" class="button button-3d button-black m-0" id="register-form-submit" name="register-form-submit" @click="creat_user">確認送出</button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </section><!-- #content end -->
</div>

<script>
    new Vue({
        el: "#app",
        data: {
            login:{
                user_id: '',
                user_pwd: '',
            },
            submit: {
                user_id: '',
                user_pwd: '',
                email: '',
                chk_pwd: '',
            },
            main_list: [],
            sub_list: [],
            product: [],
        },
        mounted() {
            let _this = this;
        },
        methods: {
            creat_user() {
                let _this = this;
                if (common_func.examination('require')) {
                    if (_this.submit.user_pwd == _this.submit.chk_pwd) {
                        axios({
                            url: '/api/user_add',
                            method: 'post',
                            responseType: 'json',
                            data: Qs.stringify(_this.submit)
                        }).then(function(data) {
                            console.log(data)
                            if (data.data.sys_code == '200') {
                                Swal.fire('註冊成功');
                                location.href = '/login';
                            } else {
                                Swal.fire(data.data.sys_msg);
                            }
                        })
                    } else {
                        $('#register-form-repassword').addClass('is-invalid');
                        Swal.fire('密碼不一致');
                    }
                }
            },
            user_login() {
                let _this = this;
                if (common_func.examination('login')) {
                    axios({
                        url: '/api/user_login',
                        method: 'post',
                        responseType: 'json',
                        data: Qs.stringify(_this.login)
                    }).then(function(data) {
                        console.log(data)
                        if (data.data.sys_code == '200') {
                            location.href = '/';
                        } else {
                            Swal.fire(data.data.sys_msg);
                        }
                    })
                }
            }
        }
    })
</script>