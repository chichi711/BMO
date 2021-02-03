<div id="app">
    <!-- Default box -->
    <div class="card">
        <div class="alert bg-aqua text-white" role="alert">
            <strong>小提示！</strong> 上下拖移列表項目到想要的位置即可進行資料的排序。
        </div>
        <div class="card-body">
            <div>
                <div class="form-group row justify-content-center">
                    <label for="edit_alt" class="col-3 col-lg-3 col-form-label text-right">請先選擇主分類</label>
                    <div class="col-6 col-lg-4">
                        <select class="form-control" style="width:100%" v-model="submit.main_id" @change="chg_main($event)">
                            <option disabled selected value="">請選擇</option>
                            <option :value="order.main_id" v-for="(order,idx) in class_main">{{ order.main_name }}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row justify-content-center">
                    <label for="edit_alt" class="col-3 col-lg-3 col-form-label text-right">選擇次分類</label>
                    <div class="col-6 col-lg-4">
                        <select class="form-control" style="width:100%" v-model="submit.sub_id" @change="chg_sub($event)">
                            <option disabled selected value="">請選擇</option>
                            <option :value="order.sub_id" v-for="(order,idx) in class_sub">{{ order.sub_name }}</option>
                        </select>
                    </div>
                </div>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>分類名稱</th>
                        <th>連結網址</th>
                        <th><button type="button" class="btn btn-success btn-sm float-right" @click="open('add')">新增</button></th>
                    </tr>
                </thead>
                <tbody id="sortable">
                    <tr v-if="class_third == '' ">
                        <td colspan="4" align="center">尚未建立資料</td>
                    </tr>
                    <tr v-else v-for=" (order,idx) in class_third" :data-third_id="order.third_id">
                        <td>{{ order.third_name }}</td>
                        <td>{{ order.third_link }}</td>
                        <td>
                            <button type="button" class="btn btn-outline-info btn-sm" @click="open('edit',order)">編輯</button>
                            <button type="button" class="btn btn-outline-danger btn-sm" @click="remove(order.third_id)">刪除</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

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
                    <div class="form-group">
                        <label>主分類名稱</label>
                        <div v-if="submit.main_name != '' ">
                            <input type="text" :value="submit.main_name" class="form-control" readonly>
                        </div>
                        <div v-else>
                            <input type="text" name="add_alt" value="請先選擇主分類" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>次分類名稱</label>
                        <div v-if="submit.sub_name != '' ">
                            <input type="text" :value="submit.sub_name" class="form-control" readonly>
                        </div>
                        <div v-else>
                            <input type="text" name="add_alt" value="請先選擇次分類" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_name">分類名稱</label>
                        <input type="text" class="form-control require-val" id="edit_name" v-model="submit.third_name">
                    </div>
                    <div class="form-group">
                        <label for="edit_link">連結網址</label>
                        <input type="text" class="form-control" id="edit_link" v-model="submit.third_link">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary" @click="set">確認</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END Modal -->
</div>

<script>
    $(function() {
        // 拖移
        $("#sortable").sortable({
            update: function(event, ui) {
                send_table_sort();
            }
        });

        function send_table_sort() {
            var sort_arr = [];
            $('#sortable tr').each(function(k, v) {
                item = {
                    third_id: $(this).data('third_id'),
                    third_sort: k
                }
                sort_arr.push(item);
            })

            $.post('/api/class_third_sort', JSON.stringify(sort_arr), function(data) {

            }, 'json')
        }
    });
</script>
<script>
    new Vue({
        el: '#app',
        data: {
            submit: {
                third_id: '',
                third_name: '',
                main_id: '',
                main_name: '',
                sub_id: '',
                sub_name: '',
                third_sort: '',
                third_link: ''
            },
            class_main: [],
            class_sub: [],
            class_third: []
        },
        mounted() {
            let _this = this;
            axios({
                url: '/api/class_main_list',
                method: 'get',
                responseType: 'json',
            }).then(function(data) {
                _this.class_main = data.data.data;
            })
        },
        methods: {
            third_list() {
                let _this = this;
                axios({
                    url: '/api/class_third_list',
                    method: 'post',
                    responseType: 'json',
                    data: Qs.stringify(_this.submit)
                }).then(function(data) {
                    _this.class_third = data.data.data;
                })
            },
            set() {
                var _this = this;
                if (common_func.examination('require')) {
                    axios({
                        method: 'post',
                        url: '/api/class_third_set',
                        responseType: 'json',
                        data: Qs.stringify(_this.submit)
                    }).then(function(data) {
                        console.log(data);
                        if (data.data.sys_code == '200') {
                            _this.third_list();
                            $("#show_edit_form").modal("hide");
                        } else {
                            Swal.fire('新增失敗');
                        }
                    })
                }
            },
            remove(third_id) {
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
                                url: '/api/class_third_remove?third_id=' + third_id,
                                responseType: 'json'
                            })
                            .then(function(data) {
                                _this.third_list();
                            })
                    }
                })



            },
            open(type, order = '') {
                var _this = this;
                if (type == 'add') {
                    _this.submit.third_id = '';
                    _this.submit.third_name = '';
                    _this.submit.third_link = '';
                } else {
                    _this.submit.third_id = order.third_id;
                    _this.submit.third_name = order.third_name;
                    _this.submit.third_link = order.third_link;
                    _this.submit.level = order.level;
                }
                $("#show_edit_form").modal("show");
                // 刪除之前必填
                const elements = document.getElementsByClassName("error_span");
                while (elements.length > 0) elements[0].remove();
            },
            chg_main(e = '') {
                let _this = this;
                _this.submit.main_name = e.target.options[e.target.options.selectedIndex].text;
                let data = {
                    main_id : e.target.value
                }
                axios({
                    url: '/api/class_sub_list',
                    method: 'post',
                    responseType: 'json',
                    data: Qs.stringify(data)
                }).then(function(data) {
                    console.log(data.data);
                    _this.class_sub = data.data.data;
                })
            },
            chg_sub(e = '') {
                let _this = this;
                if (e != '') {
                    _this.submit.sub_name = e.target.options[e.target.options.selectedIndex].text;
                }
                _this.third_list();
            }
        }
    })
</script>