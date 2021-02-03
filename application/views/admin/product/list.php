<div id="app">
    <div class="mb-3">
        <button type="button" value="news" class="chg_class btn btn-outline-success mr-2">最新消息分類</button>
    </div>
    <!-- Default box -->
    <div class="card">

        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>商品名稱</th>
                        <th>主分類</th>
                        <th>次分類</th>
                        <th>數量</th>
                        <th>上架開關</th>
                        <th><button type="button" class="btn btn-success btn-sm float-right" @click="open('add')">新增</button></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="manager == '' ">
                        <td colspan="4" align="center">尚未建立資料</td>
                    </tr>
                    <tr v-else v-for=" (order,idx) in manager">
                        <td v-if="order.level == '0' ">管理者</td>
                        <td v-else-if="order.level == '1' ">行銷企劃</td>
                        <td v-else-if="order.level == '2' ">小編</td>
                        <td scope="row">{{ order.manager_id }}</td>
                        <td>{{ order.manager_name }}</td>
                        <td>{{ order.last_datetime }}</td>
                        <td>
                            <button type="button" class="btn btn-outline-info btn-sm" @click="open('edit',order)">編輯</button>
                            <button type="button" class="btn btn-outline-danger btn-sm" @click="remove(order.manager_id)">刪除</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->



    <!-- 新增 Modal -->
    <div class="modal fade" id="show_new_form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">新增</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="add_id">帳號</label>
                        <input type="text" class="form-control require-val" id="add_id" v-model="submit.manager_id">
                    </div>
                    <div class="form-group">
                        <label for="add_pwd">密碼</label>
                        <input type="password" class="form-control require-val" id="add_pwd" v-model="submit.manager_pwd">
                    </div>
                    <div class="form-group">
                        <label for="add_name">使用者姓名</label>
                        <input type="text" class="form-control require-val" id="add_name" v-model="submit.manager_name">
                    </div>
                    <div class="form-group">
                        <label for="add_level">職位</label>
                        <select class="form-control" id="add_level" v-model="submit.level">
                            <option :value="0">管理者</option>
                            <option :value="1">行銷企劃</option>
                            <option :value="2">小編</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary" @click="add">確認</button>
                </div>
            </div>
        </div>
    </div>
    <!-- END Modal -->



    <!-- 編輯 Modal -->
    <div class="modal fade" id="show_edit_form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">編輯</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" class="sn">
                    <div class="modal-body">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="edit_id">帳號</label>
                                <input readonly type="text" class="form-control require-val" id="edit_id" v-model="submit.manager_id">
                            </div>
                            <div class="form-group">
                                <label for="edit_pwd">密碼</label>
                                <input type="password" class="form-control require-val" id="edit_pwd" v-model="submit.manager_pwd">
                            </div>
                            <div class="form-group">
                                <label for="edit_name">使用者姓名</label>
                                <input type="text" class="form-control require-val" id="edit_name" v-model="submit.manager_name">
                            </div>
                            <div class="form-group">
                                <label for="edit_level">職位</label>
                                <select class="form-control" id="edit_level" v-model="submit.level">
                                    <option :value="0">管理者</option>
                                    <option :value="1">行銷企劃</option>
                                    <option :value="2">小編</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary" @click="update">確認</button>
                </div>
            </div>
        </div>
    </div>
    <!-- END Modal -->
</div>

<script>
    new Vue({
        el: '#app',
        data: {
            submit: {
                manager_id: '',
                manager_name: '',
                manager_pwd: '',
                level: '',
            },
            manager: []
        },
        mounted() {
            let _this = this;
            _this.manager_list();
        },
        methods: {
            manager_list() {
                let _this = this;
                axios({
                    url: '/api/manager_list',
                    method: 'get',
                    responseType: 'json'
                }).then(function(data) {
                    _this.manager = data.data.data;
                })
            },
            add() {
                var _this = this;
                if (common_func.examination('require')) {
                    axios({
                        method: 'post',
                        url: '/api/manager_add',
                        responseType: 'json',
                        data: Qs.stringify(_this.submit)
                    }).then(function(data) {
                        console.log(data);
                        if (data.data.sys_code == '200') {
                            _this.manager_list();
                            $("#show_new_form").modal("hide");
                        } else {
                            Swal.fire('新增失敗');
                        }
                    })
                }
            },
            update() {
                var _this = this;
                if (common_func.examination('require')) {
                    axios({
                        method: 'post',
                        url: '/api/manager_edit',
                        responseType: 'json',
                        data: Qs.stringify(_this.submit)
                    }).then(function(data) {
                        console.log(data);
                        if (data.data.sys_code == '200') {
                            _this.manager_list();
                            $("#show_edit_form").modal("hide");
                        } else {
                            Swal.fire('更新失敗');
                        }
                    })
                }
            },
            remove(manager_id) {
                var _this = this;

                Swal.fire({
                    title: '確定要刪除嗎？',
                    text: "此動作將無法還原",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: '取消',
                    confirmButtonText: '是的, 我要刪除'
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios({
                                method: 'post',
                                url: '/api/manager_remove?manager_id=' + manager_id,
                                responseType: 'json'
                            })
                            .then(function(data) {
                                _this.manager_list();
                            })
                    }
                })



            },
            open(type, order = '') {
                var _this = this;
                if (type == 'add') {
                    _this.submit.manager_id = '';
                    _this.submit.manager_name = '';
                    _this.submit.manager_pwd = '';
                    $("#show_new_form").modal("show");
                } else {
                    _this.submit.manager_id = order.manager_id;
                    _this.submit.manager_name = order.manager_name;
                    _this.submit.manager_pwd = order.manager_pwd;
                    _this.submit.level = order.level;
                    $("#show_edit_form").modal("show");
                }

            }
        }
    })
</script>