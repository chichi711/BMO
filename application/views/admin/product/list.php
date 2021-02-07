<div id="app">
    <div class="mb-3">
        <a v-for="item in menu_list" :href="'/admin/product_list?mid=' + item.menu_id" 
        :class="[ {'btn-aqua' : item.menu_id == submit.menu_id? true:false }, {'btn-outline-aqua' : item.menu_id == submit.menu_id? false:true },
         'chg_class', 'btn', 'btn-rounded', 'mr-2']">{{ item.menu_name }}</a>
    </div>
    <!-- Default box -->
    <div class="card table-responsive width-100">

        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th class="fit">商品編號</th>
                        <th class="fit">商品名稱</th>
                        <th class="fit">大分類</th>
                        <!-- <th class="fit">小分類</th> -->
                        <th class="fit">商品主圖</th>
                        <th class="fit">庫存量</th>
                        <th class="fit">狀態</th>
                        <th class="fit"><button type="button" class="btn btn-success btn-sm float-right" @click="open('add')">新增</button></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="product == '' ">
                        <td colspan="4" align="center">尚未建立資料</td>
                    </tr>
                    <tr v-else v-for=" (order,idx) in product">
                        <td class="fit">{{ order.product_id }}</td>
                        <td scope="row">{{ order.product_name }}</td>
                        <td>{{ order.main_name }}</td>
                        <!-- <td>{{ order.sub_name }}</td> -->
                        <td><img :src="order.main_img" style="width:30px;" class="img_src m-1"></td>
                        <td>{{ order.stock }}</td>
                        <td>{{ order.status }}</td>
                        <td class="fit">
                            <button type="button" class="btn btn-outline-aqua btn-sm" @click="open('edit',order.product_id)">編輯</button>
                            <button type="button" class="btn btn-outline-danger btn-sm" @click="remove(order.product_id)">刪除</button>
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
                menu_id: '<?= $_GET['mid'] ?>',
                main_id: '',
                sub_id: '',
            },
            product: [],
            menu_list: []
        },
        mounted() {
            let _this = this;
            _this.product_list();
            axios({
                url: '/api/menu_class_list',
                method: 'get',
                responseType: 'json',
            }).then(function(data) {
                _this.menu_list = data.data.data;
            })
        },
        methods: {
            product_list() {
                let _this = this;
                axios({
                    url: '/api/product_list',
                    method: 'post',
                    responseType: 'json',
                    data: Qs.stringify(_this.submit)
                }).then(function(data) {
                    _this.product = data.data.data;
                })
            },
            remove(product_id) {
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
                                url: '/api/product_remove?product_id=' + product_id,
                                responseType: 'json'
                            })
                            .then(function(data) {
                                _this.product_list();
                            })
                    }
                })

            },
            open(type, order = '') {
                var _this = this;
                if (type == 'add') {
                    location.href = '/admin/product_set?mid=' + _this.submit.menu_id;
                } else {
                    location.href = '/admin/product_set?mid=' + _this.submit.menu_id + '&pid=' + order;
                }

            }
        }
    })
</script>