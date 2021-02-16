<!-- general form elements -->
<div id="app" class="card card-primary">

    <table class="table cart mb-5">
        <thead>
            <tr>
                <th class="cart-product-thumbnail">&nbsp;</th>
                <th class="cart-product-name">書名</th>
                <th class="cart-product-price">價格</th>
                <th class="cart-product-quantity fit">數量</th>
                <th class="cart-product-subtotal">小計</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(item,idx) in sub" class="cart_item">

                <td class="cart-product-thumbnail">
                    <a href="#"><img width="64" height="64" :src="item.main_img" alt="Pink Printed Dress"></a>
                </td>

                <td class="cart-product-name">
                    <span>{{ item.product_name }}</apan>
                </td>

                <td class="cart-product-price fit">
                    <span class="amount">$ {{ item.price }}</span>
                </td>

                <td class="cart-product-quantity fit">
                    <span>{{ item.qty }}</apan>
                </td>

                <td class="cart-product-subtotal fit">
                    <span class="amount">$ {{ item.sub_total }}</span>
                </td>
            </tr>

            <tr class="cart_item">
                <td class="text-right pr-2" colspan="3">
                    <b class="mb-5">運費： </b><br>
                    <b class="mb-5">總計： </b></span>
                </td>
                <td class="text-right pr-2 fix" colspan="2">
                    <b class="mb-5">$ {{ main.freight }}</b><br>
                    <b class="mb-5">$ {{ main.total_amount }}</b></span>
                </td>
            </tr>

        </tbody>

    </table>

    <!-- form start -->
    <form role="form">
        <div class="card-body">
            <div class="row">
                <div class="form-group col-12 col-sm-6">
                    <label for="inputProductId">訂單編號</label>
                    <input v-model="main.order_id" disabled type="text" class="form-control" id="inputProductId">
                </div>
                <div class="form-group col-12 col-sm-6">
                    <label for="InputProductName">會員帳號</label>
                    <input v-model="main.user_id" disabled type="text" class="form-control" id="InputProductName">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-12 col-sm-6">
                    <label>訂單狀態</label>
                    <select v-model="main.order_status" class="form-control require-val">
                        <?php foreach ($this->config->item('order_status') as $k => $v) : ?>
                            <option value="<?= $k ?>"><?= $v ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group col-12 col-sm-6">
                    <label for="InputProductAuthor">收件人名稱</label>
                    <input v-model="main.receive_name" type="text" class="form-control require-val" id="InputProductAuthor">
                </div>
            </div>

            <div class="row">
                <div class="form-group col-12 col-sm-6">
                    <label for="InputProductPublisher">手機號碼</label>
                    <input v-model="main.receive_mobile" type="text" class="form-control require-val" id="InputProductPublisher">
                </div>
                <div class="form-group col-12 col-sm-6">
                    <label for="InputProductPublication_date">收件地址</label>
                    <input v-model="main.receive_addr" type="text" class="form-control require-val" id="InputProductPublication_date">
                </div>
            </div>

            <div class="row">
                <div class="form-group col-12 col-sm-6">
                    <label for="InputProductPrice">寄送方式</label>
                    <select v-model="main.freight_com" class="form-control require-val">
                        <?php foreach ($this->config->item('freight_com') as $k => $v) : ?>
                            <option value="<?= $k ?>"><?= $v ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group col-12 col-sm-6">
                    <label for="InputProductPrice">付款方式</label>
                    <select v-model="main.payment" class="form-control require-val">
                        <?php foreach ($this->config->item('payment') as $k => $v) : ?>
                            <option value="<?= $k ?>"><?= $v ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <button type="button" class="btn btn-primary" @click="update_order">送出</button>
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
                order_id: ''
            },
            main: [],
            sub: [],
        },
        mounted() {
            let _this = this;
            _this.get_url();

        },
        methods: {
            get_url() {
                let _this = this;
                let searchParams = new URLSearchParams(window.location.search);
                if (searchParams.has('oid')) {
                    _this.submit.order_id = searchParams.get('oid');

                    axios({
                        url: '/api/order_info',
                        method: 'post',
                        responseType: 'json',
                        data: Qs.stringify(_this.submit)
                    }).then(function(data) {
                        console.log(data.data)
                        _this.main = data.data.data.main;
                        _this.sub = data.data.data.sub;
                    })
                }
            },
            update_order() {
                let _this = this;
                axios({
                    url: '/api/order_main_edit',
                    method: 'post',
                    responseType: 'json',
                    data: Qs.stringify(_this.main)
                }).then(function(data) {
                    console.log(data.data)
                    if (data.data.sys_code == '200') {
                            location.href = '/admin/order_list';
                        } else {
                            Swal.fire('編輯失敗');
                        }
                })
            },
            del_img(idx) {
                var _this = this;
                _this.submit.slide_imgs.splice(idx, 1);
            }
        }
    })
</script>