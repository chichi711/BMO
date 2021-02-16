<div id="app">
	<!-- Page Title
		============================================= -->
	<section id="page-title">

		<div class="container">
			<h1><?= $active ?></h1>
			<ol class="breadcrumb">
				<!-- <li class="breadcrumb-item active" aria-current="page">購物車</li> -->
			</ol>
		</div>

	</section><!-- #page-title end -->

	<!-- Content
		============================================= -->
	<section id="content">
		<div class="content-wrap">
			<div class="container">

				<table class="table cart mb-5">
					<thead>
						<tr>
							<th class="cart-product-remove">&nbsp;</th>
							<th class="cart-product-thumbnail">&nbsp;</th>
							<th class="cart-product-name">書名</th>
							<th class="cart-product-price">價格</th>
							<th class="cart-product-quantity">數量</th>
							<th class="cart-product-subtotal">小計</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(item,idx) in cart_list" class="cart_item">
							<td class="cart-product-remove">
								<a href="#" class="remove" title="Remove this item" @click.prevent="del_product(item.sn)"><i class="icon-trash2"></i></a>
							</td>

							<td class="cart-product-thumbnail">
								<a href="#"><img width="64" height="64" :src="item.main_img" alt="Pink Printed Dress"></a>
							</td>

							<td class="cart-product-name">
								<a href="#">{{ item.product_name }}</a>
							</td>

							<td class="cart-product-price fit">
								<span class="amount">$ {{ item.price }}</span>
							</td>

							<td class="cart-product-quantity">
								<div class="quantity" style="width: 152px;">
									<input type="button" value="-" class="plus-minus" @click="calculation(idx,'minus')">
									<input type="text" name="quantity" v-model="item.qty" class="qty" />
									<input type="button" value="+" class="plus-minus" @click="calculation(idx,'plus')">
								</div>
							</td>

							<td class="cart-product-subtotal fit">
								<span class="amount">$ {{ item.sub_total }}</span>
							</td>
						</tr>


						<tr class="cart_item">
							<td colspan="6">
								<div class="row justify-content-between py-2 col-mb-30">
									<div class="col-lg-auto pl-lg-0">
										<div class="row">
											<div class="col-md-8">
												<input type="text" value="" class="sm-form-control text-center text-md-left" placeholder="請輸入折扣碼" />
											</div>
											<div class="col-md-4 mt-3 mt-md-0">
												<a href="#" class="button button-3d button-black m-0">應用折扣</a>
											</div>
										</div>
									</div>
									<div class="col-lg-auto pr-lg-0">
										<a href="#" class="button button-3d m-0" @click="update_cart">更新購物車</a>
									</div>
								</div>
							</td>
						</tr>
					</tbody>

				</table>

				<div class="row col-mb-30">
					<div class="col-lg-6">
						<h4>詳細資料</h4>
						<form class="row">
							<div class="col-6 form-group">
								<select class="form-control require-val" v-model="main.freight_com">
									<option value="" selected disabled>寄送方式</option>
									<option value="0">宅配</option>
									<option value="1">7-11</option>
									<option value="2">全家</option>

								</select>
							</div>
							<div class="col-6 form-group">
								<select class="form-control require-val" v-model="main.payment">
									<option value="" selected disabled>付款方式</option>
									<option value="0">貨到付款</option>
									<option value="1">銀行轉帳</option>

								</select>
							</div>
							<div class="col-12 form-group">
								<label>收件地址</label>
								<input type="text" v-model="main.receive_addr" class="form-control require-val" />
							</div>
							<div class="col-6 form-group">
								<label>姓名</label>
								<input type="text" v-model="main.receive_name" class="form-control require-val" />
							</div>

							<div class="col-6 form-group">
								<label>手機號碼</label>
								<input type="text" v-model="main.receive_mobile" class="form-control require-val" />
							</div>


						</form>
					</div>

					<div class="col-lg-6">
						<h4>總付款金額</h4>

						<div class="table-responsive">
							<table class="table cart cart-totals">
								<tbody>
									<tr class="cart_item">
										<td class="cart-product-name">
											<strong>小計</strong>
										</td>

										<td class="cart-product-name">
											<span class="amount">$ {{ main.sub_total }}</span>
										</td>
									</tr>
									<tr class="cart_item">
										<td class="cart-product-name">
											<strong>運費</strong>
										</td>

										<td class="cart-product-name">
											<span class="amount">$ {{ main.freight }}</span>
										</td>
									</tr>
									<tr class="cart_item">
										<td class="cart-product-name">
											<strong>折扣</strong>
										</td>

										<td class="cart-product-name">
											<span class="amount">$</span>
										</td>
									</tr>
									<tr class="cart_item">
										<td class="cart-product-name">
											<strong>總計</strong>
										</td>

										<td class="cart-product-name">
											<span class="amount color lead"><strong>$ {{ main.total_amount }}</strong></span>
										</td>
									</tr>
								</tbody>

							</table>
						</div>
					</div>
				</div>

				<div class="row col-mb-30 justify-content-end">
					<a href="#" class="button button-3d mt-2 mt-sm-0 mr-0" @click="creat_main">結帳</a>
				</div>
			</div>
		</div>
	</section><!-- #content end -->
</div>

<script>
	new Vue({
		el: '#app',
		data: {
			submit: {
				user_id: '<?= $_SESSION["user_id"] ?>',
			},
			main: {
				order_id: '<?= "O" . time() ?>',
				user_id: '<?= $_SESSION["user_id"] ?>',
				receive_name: '',
				receive_mobile: '',
				receive_addr: '',
				payment: '',
				freight: 60,
				total_amount: '',
				freight_com: '',
				sub_total: ''
			},
			login: '',
			menu: [],
			cart_list: [],
		},
		mounted() {
			let _this = this;
			_this.get_shopping_cart();
		},
		methods: {
			get_shopping_cart() {
				let _this = this;
				axios({
					url: '/api/cart_list',
					method: 'post',
					responseType: 'json',
					data: Qs.stringify(_this.submit)
				}).then(function(data) {
					_this.cart_list = data.data.datalist;
					_this.main.sub_total = data.data.total_amount;
					_this.main.total_amount = _this.main.sub_total + _this.main.freight;
				})

			},
			del_product(item) {
				let _this = this;
				let data = {
					sn: item
				}
				axios({
					url: '/api/cart_remove',
					method: 'post',
					responseType: 'json',
					data: Qs.stringify(data)
				}).then(function(data) {
					if (data.data.sys_code == '200') {
						location.reload();
					}
				})
			},
			calculation(idx, type) {
				var _this = this;
				if (type == 'plus') {
					_this.cart_list[idx].qty++;
				} else {
					if (_this.cart_list[idx].qty > 1) {
						_this.cart_list[idx].qty--;
					}
				}
				_this.main.sub_total -= parseInt(_this.cart_list[idx].sub_total);
				_this.cart_list[idx].sub_total = (parseInt(_this.cart_list[idx].price) * parseInt(_this.cart_list[idx].qty));
				_this.main.sub_total += parseInt(_this.cart_list[idx].sub_total);
				_this.main.total_amount = _this.main.sub_total + _this.main.freight;
			},
			update_cart() {
				var _this = this;
				axios({
					url: '/api/cart_edit',
					method: 'post',
					responseType: 'json',
					data: JSON.stringify(_this.cart_list)
				}).then(function(data) {
					if (data.data.sys_code == '200') {
						Swal.fire('更新成功');
					}
				})
			},
			creat_main() {
				var _this = this;
				if (common_func.examination('require')) {
					axios({
						url: '/api/order_main_add',
						method: 'post',
						responseType: 'json',
						data: Qs.stringify(_this.main)
					}).then(function(data) {
						if (data.data.sys_code == '200') {
							_this.creat_sub();
						}
					})
				}
			},
			creat_sub() {
				var _this = this;
				if (common_func.examination('require')) {
					_this.cart_list[0].order_id = _this.main.order_id;
					axios({
						url: '/api/order_sub_add',
						method: 'post',
						responseType: 'json',
						data: JSON.stringify(_this.cart_list)
					}).then(function(data) {
						if (data.data.sys_code == '200') {
							Swal.fire('下訂成功');
							axios({
								url: '/api/user_cart_remove',
								method: 'post',
								responseType: 'json',
								data: Qs.stringify(_this.submit)
							}).then(function(data) {
								if (data.data.sys_code == '200') {
									location.href = "./";
								}
							})
						} else {
							Swal.fire('下訂失敗，請稍候重試');
						}
					})
				}
			}
		}
	})
</script>