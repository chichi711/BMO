
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><button type="button" class="btn  float-sm-left btn-default" id="show_btn" data-widget="pushmenu" style="margin-right: 10px;"><i class="fas fa-bars"></i></button>
                            <?= $title ?></h1>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>




    <script src="https://cdn.bootcss.com/qs/6.7.0/qs.min.js"></script>

    <script>
        $(function() {
            $(".show_info").eq(0).show();
            $("body").on("click", ".eye", function() {
                $(".show_info").hide();
                $(this).parent().prev().show(200);
            })
            $("body").on("click", '.eye_subject', function() {
                $(".show_info").hide();
                $(this).next().show(200);
            })
        })

        var app = new Vue({
            el: "#app",
            data: {
                bulletin_board: [],
                text_info: "",
                sn: "",
                subject: "",
                edit_form: {
                    sn: "",
                    subject: "",
                    info: ""
                }


            },
            mounted() {
                var _this = this;
                _this.bulletin_board_list()
            },
            methods: {
                bulletin_board_list() {
                    var _this = this;
                    axios({
                            method: 'post',
                            url: './api/bulletin_board_list',
                            responseType: 'json',
                        })
                        .then(function(data) {
                            data = data.data;
                            console.log(data);
                            _this.bulletin_board = data.data;
                        })
                },
                add(e) {
                    var _this = this;
                    var chk = true;
                    if (_this.text_info == '') {
                        chk = false;
                    }
                    if (_this.subject == "") {
                        chk = false;
                    }
                    if (chk == false) {
                        Swal.fire('Oops!', '所有欄位都要填寫喔', 'error');
                        return false;
                    }
                    send_data = Qs.stringify({
                        manager_id: '<?= session('manager')['manager_id'] ?>',
                        sn: '',
                        info: _this.text_info,
                        subject: _this.subject
                    })
                    _this.send_set(send_data)
                },
                update(e) {
                    var _this = this;
                    var chk = true;
                    if (_this.edit_form.info == '') {
                        chk = false;
                    }
                    if (_this.edit_form.subject == "") {
                        chk = false;
                    }
                    if (chk == false) {
                        Swal.fire('Oops!', '所有欄位都要填寫喔', 'error');
                        return false;
                    }
                    send_data = Qs.stringify({
                        manager_id: '<?= session('manager')['manager_id'] ?>',
                        sn: _this.edit_form.sn,
                        info: _this.edit_form.info,
                        subject: _this.edit_form.subject
                    })
                    _this.send_set(send_data)
                    $("#show_edit_form").modal("hide");
                },
                send_set(send_data) {
                    var _this = this;
                    axios({
                        method: 'post',
                        url: './api/bulletin_board_set',
                        responseType: 'json',
                        data: send_data
                    }).then(function(data) {
                        data = data.data;
                        console.log(data);
                        _this.bulletin_board_list()
                        _this.sn = ''
                        _this.text_info = ''
                        _this.subject = ''
                        _this.edit_form.sn = '',
                            _this.edit_form.subject = '',
                            _this.edit_form.info = ''
                    })
                },
                remove_once(e) {
                    var _this = this;
                    var sn = e.currentTarget.getAttribute('sn');

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            axios({
                                    method: 'post',
                                    url: './api/bulletin_board_remove?sn=' + sn,
                                    responseType: 'json'
                                })
                                .then(function(data) {
                                    _this.bulletin_board_list()
                                })
                            // var api = './api/product_remove';
                            // $.post(api,{
                            //   product_id:$(this).data('product_id')
                            // },function(data){
                            //     if(data.sys_code == '200'){
                            //       Swal.fire('Good job!','資料處理完成','success').then(function(response){location.reload();});
                            //     }else{
                            //       Swal.fire('Oops!','資料錯誤','error');
                            //     }
                            // },'json');
                        }
                    })



                },
                open_edit(e) {
                    var _this = this;
                    _this.edit_form.sn = e.currentTarget.getAttribute('sn');
                    _this.edit_form.subject = e.currentTarget.getAttribute('subject');
                    _this.edit_form.info = e.currentTarget.getAttribute('info');
                    $("#show_edit_form").modal("show");

                }

            }
        })
    </script>