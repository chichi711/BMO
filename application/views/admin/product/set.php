<!-- general form elements -->
<div id="app" class="card card-primary">
    <!-- form start -->
    <form role="form">
        <div class="card-body">
            <div class="row">
                <div class="form-group col-12 col-sm-6">
                    <label for="inputProductId">商品編號</label>
                    <input v-model="submit.product_id" type="text" class="form-control require-val" id="inputProductId">
                </div>
                <div class="form-group col-12 col-sm-6">
                    <label for="InputProductName">商品名稱</label>
                    <input v-model="submit.product_name" type="text" class="form-control require-val" id="InputProductName">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-12 col-sm-6">
                    <label>主分類</label>
                    <select v-model="submit.main_id" class="form-control select2bs4 require-val" onchange="chg_main(this)" style="width: 100%;">
                        <option selected="selected">請選擇</option>
                        <option v-for="item in class_main" :value="item.main_id">{{ item.main_name }}</option>
                    </select>
                </div>
                <div class="form-group col-12 col-sm-6">
                    <label>子分類</label>
                    <select v-model="submit.sub_id" class="form-control select2bs4 require-val" onchange="chg_sub(this)" style="width: 100%;">
                        <option selected="selected">請選擇</option>
                        <option v-for="item in class_sub" :value="item.sub_id">{{ item.sub_name }}</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-12 col-sm-6">
                    <label for="InputProductAuthor">作者名稱</label>
                    <input v-model="submit.author" type="text" class="form-control require-val" id="InputProductAuthor">
                </div>
                <div class="form-group col-12 col-sm-6">
                    <label for="InputProductPublisher">出版社</label>
                    <input v-model="submit.publisher" type="text" class="form-control require-val" id="InputProductPublisher">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-12 col-sm-6">
                    <label for="InputProductPublication_date">出版日期</label>
                    <input v-model="submit.publication_date" type="date" class="form-control require-val" id="InputProductPublication_date">
                </div>
                <div class="form-group col-12 col-sm-6">
                    <label for="InputProductPrice">商品價格</label>
                    <input v-model="submit.price" type="number" class="form-control require-val" id="InputProductPrice">
                </div>
            </div>

            <div class="row">

                <div class="form-group col-12 col-sm-6">
                    <label for="InputProductLanguage">語言</label>
                    <input v-model="submit.language" type="text" class="form-control require-val" id="InputProductLanguage">
                </div>
                <div class="form-group col-12 col-sm-6">
                    <label for="InputProductStock">庫存數量</label>
                    <input v-model="submit.stock" type="number" class="form-control" id="InputProductStock">
                </div>
            </div>

            <div class="row">
                <div class="form-group col-12 col-sm-6">
                    <label>商品狀態</label>
                    <select v-model="submit.status" class="form-control require-val" style="width: 100%;">
                        <option value="" disabled selected="selected">請選擇</option>
                        <option v-for="(item,idx) in status_list" :value="idx">{{ item }}</option>
                    </select>
                </div>
                <!-- <div class="form-group col-12 col-sm-6">
                    <label>標籤</label>
                    <select class="select2bs4" multiple="multiple" data-placeholder="Select a State" style="width: 100%;">
                        <option>Alabama</option>
                        <option>Alaska</option>
                        <option>Texas</option>
                    </select>
                </div> -->
            </div>

            <div class="row">
                <div class="form-group col-12 col-sm-6">
                    <label for="product_id">商品主圖</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input image_file" id="main_image_file" @change="upload_img($event, 'main')">
                            <label class="custom-file-label " for="main_image_file">選擇檔案</label>
                        </div>
                    </div>
                    <img :src="submit.main_img" id="main_img" style="width:100px;" class="img_src m-1">
                </div>
                <div class="form-group col-12 col-sm-6">
                    <label for="product_id">列表圖</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input image_file" id="list_image_file" @change="upload_img($event, 'list')">
                            <label class="custom-file-label " for="list_image_file">選擇檔案</label>
                        </div>
                    </div>
                    <span v-for="(item,idx) in submit.slide_imgs">
                        <img :src="item" id="list_img" style="width:100px;" class="img_src m-1">
                        <span aria-hidden="true" @click="del_img(idx)">&times;</span>
                    </span>
                </div>
            </div>

        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <button type="button" class="btn btn-primary" @click="add">送出</button>
        </div>
    </form>
</div>
<!-- /.card -->



<script>
    function chg_main(e) {
        app['_data'].get_sub_class.main_id = e.value;
        app['_data'].submit.main_id = e.value;
        app['_data'].class_sub = '';
        app.call_sub_list();
    }

    function chg_sub(e) {
        app['_data'].submit.sub_id = e.value;
    }
    $(function() {
        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    })
    let app = new Vue({
        el: '#app',
        data: {
            submit: {
                product_id: '<?= "P-" . time() ?>',
                product_name: '',
                menu_id: '',
                main_id: '',
                sub_id: '',
                author: '',
                publisher: '',
                publication_date: '',
                price: '',
                language: '',
                stock: '',
                status: '',
                tag: [],
                main_img: '/public/admin_assets/img/BmoLogo.png',
                slide_imgs: [],
            },
            get_sub_class: {
                menu_id: '',
                main_id: '',
            },
            manager: [],
            class_main: [],
            class_sub: [],
            status_list: []
        },
        mounted() {
            let _this = this;
            _this.get_url();
            axios({
                url: '/api/class_main_list',
                method: 'get',
                responseType: 'json',
                data: Qs.stringify(_this.get_sub_class)
            }).then(function(data) {
                _this.class_main = data.data.data;
            })
            axios({
                url: '/api/product_status_configs',
                method: 'get',
                responseType: 'json',
                data: Qs.stringify(_this.get_sub_class)
            }).then(function(data) {
                _this.status_list = data.data.data;
            })
        },
        methods: {
            add() {
                var _this = this;
                if (common_func.examination('require')) {
                    axios({
                        method: 'post',
                        url: '/api/product_set',
                        responseType: 'json',
                        data: Qs.stringify(_this.submit)
                    }).then(function(data) {
                        console.log(data);
                        if (data.data.sys_code == '200') {
                            location.href = '/admin/product_list?mid=books';
                        } else {
                            Swal.fire('新增失敗');
                        }
                    })
                }
            },
            upload_img(e, type = '') {
                var _this = this;
                var data = new FormData();
                // var show_img = $(e.target).parent().parent().parent().find('.img_src');
                // console.log(show_img);
                data.append("img", e.target.files[0]);

                axios({
                    method: 'post',
                    url: '/api/product_img_upload',
                    responseType: 'json',
                    data: data,
                    method: 'post'
                }).then(function(data) {
                    if (data.data.sys_code == '200') {
                        if (type == 'main') {
                            _this.submit.main_img = data.data.data;
                        } else {
                            _this.submit.slide_imgs.push(data.data.data);
                        }
                        // console.log(show_img.attr('src'));
                        // show_img.attr('src', data.data.data);
                    } else {
                        console.log(data.data);
                        Swal.fire('Oops!', '資料上傳失敗，請稍後再試', 'error');
                    }
                })
            },
            call_sub_list() {
                let _this = this;
                axios({
                    url: '/api/class_sub_list',
                    method: 'post',
                    responseType: 'json',
                    data: Qs.stringify(_this.get_sub_class)
                }).then(function(data) {
                    _this.class_sub = data.data.data;
                })
            },
            get_url() {
                let _this = this;
                let searchParams = new URLSearchParams(window.location.search);
                if (searchParams.has('pid')) {
                    _this.submit.menu_id = searchParams.get('mid');
                    _this.get_sub_class.menu_id = searchParams.get('mid');

                    axios({
                        url: '/api/product_info',
                        method: 'post',
                        responseType: 'json',
                        data: Qs.stringify({
                            product_id: searchParams.get('pid')
                        })
                    }).then(function(data) {
                        _this.submit = data.data.data;
                        _this.get_sub_class.main_id = _this.submit.main_id;
                        _this.call_sub_list();
                    })
                } else {
                    _this.submit.menu_id = searchParams.get('mid');
                    _this.get_sub_class.menu_id = searchParams.get('mid');
                }
            },
            del_img(idx) {
                var _this = this;
                _this.submit.slide_imgs.splice(idx, 1);
            }
        }
    })
</script>