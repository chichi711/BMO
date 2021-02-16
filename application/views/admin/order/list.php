<div id="app">
    <!-- Default box -->
    <div class="card">

        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>訂單編號</th>
                        <th>會員帳號</th>
                        <th>訂單狀態</th>
                        <th>更新時間</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="order_list == '' ">
                        <td colspan="4" align="center">尚未建立資料</td>
                    </tr>
                    <tr v-else v-for=" (item,idx) in order_list">
                        <td>{{ item.order_id }}</td>
                        <td scope="row">{{ item.user_id }}</td>
                        <td>{{ item.order_status_name }}</td>
                        <td>{{ item.update_datetime }}</td>
                        <td>
                            <a :href="'/admin/order_set?oid=' + item.order_id" class="btn btn-outline-info btn-sm">編輯</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->


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
            order_list: []
        },
        mounted() {
            let _this = this;
            _this.get_order_list();
        },
        methods: {
            get_order_list() {
                let _this = this;
                axios({
                    url: '/api/order_list',
                    method: 'get',
                    responseType: 'json'
                }).then(function(data) {
                    _this.order_list = data.data.data;
                })
            },
        }
    })
</script>