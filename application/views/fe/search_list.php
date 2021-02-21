<div id="app">
	<!-- Page Title
		============================================= -->
	<section id="page-title">

		<div class="container clearfix">
			<!-- <h1 v-text="submit.sub_name == '' ? submit.main_name : submit.sub_name "></h1> -->
			<ol class="breadcrumb">
				<!-- <li class="breadcrumb-item">{{ submit.menu_name }}</li> -->
				<!-- <li class="breadcrumb-item">{{ submit.main_name }}</li> -->
				<!-- <li v-if="submit.sub_name != ''" class="breadcrumb-item active" aria-current="page">{{ submit.sub_name }}</li> -->
			</ol>
		</div>

	</section><!-- #page-title end -->

	<!-- Content
		============================================= -->
	<section id="content">
		<div class="content-wrap">
			<div class="container clearfix">

				<div class="row gutter-40 col-mb-80">
					<!-- Post Content
						============================================= -->
					<div class="postcontent col-lg-12 order-lg-last">

						<!-- Shop
							============================================= -->
						<div id="shop" class="shop row grid-container gutter-20" data-layout="fitRows">

							<div v-if="product_list.length != 0" v-for="item in product_list" class="product col-md-3 col-sm-6 col-12">
								<div class="grid-inner">
									<div class="product-image">
										<a :href="'./product/' + item.product_id"><img :src="item.main_img" alt="BMO"></a>
										<a v-if="item.slide_imgs != '' " :href="'./product/' + item.product_id"><img :src="item.slide_imgs" alt="BMO"></a>
										<div class="bg-overlay">
											<div class="bg-overlay-content align-items-end justify-content-between animated fadeOut" @mouseleave="mouse_in_out($event)" @mouseenter="mouse_in_out($event)" data-hover-animate="fadeIn" data-hover-speed="400">
												<a href="#" class="btn btn-dark mr-2" @click="add_cart(item.product_id)"><i class="icon-shopping-cart"></i></a>
												<!-- <a href="/public/assets/include/ajax/shop-item.html" class="btn btn-dark" data-lightbox="ajax"><i class="icon-line-expand"></i></a> -->
											</div>
											<div class="bg-overlay-bg bg-transparent"></div>
										</div>
									</div>
									<div class="product-desc">
										<div class="product-title">
											<h3><a :href="'./product/' + item.product_id">{{ item.product_name }}</a></h3>
										</div>
										<div>{{ item.author }} 著</div>
										<div class="product-price">${{ item.price }}</div>
									
									</div>
								</div>
							</div>
							<div v-if="product_list.length == 0" class="col-12 text-center">
								<p>無相符資料</p>
							</div>


						</div><!-- #shop end -->

					</div><!-- .postcontent end -->

				</div>

			</div>
			<nav aria-label="Page navigation" class="mt-5">
				<ul class="pagination justify-content-center">
				</ul>
			</nav>
		</div>
	</section><!-- #content end -->
</div>

<!-- <script>
	$('.fadeOut').mouseover(function () {
		console.log(e);
	})
	$('.fadeOut').mouseout(function () {
		console.log(e);
	})
</script> -->
<script>
	new Vue({
		el: "#app",
		data: {
			submit: {
				search: '<?= $_GET['q'] ?>',
			},
			main_list: [],
			sub_list: [],
			product_list: [],
		},
		mounted() {
			let _this = this;
			// _this.get_url();
			axios({
				url: '/api/get_all_class_name',
				method: 'post',
				responseType: 'json',
				data: Qs.stringify(_this.submit)
			}).then(function(data) {
				if (data.data.sys_code == '200') {
					_this.submit = data.data.data;
				}
			})
			common_func.pageClick(_this.get_product_list);
			_this.get_product_list();

		},
		methods: {
			get_product_list(needPage) {
				let _this = this;
				_this.submit.now_page = needPage;
				axios({
					url: '/api/product_search',
					method: 'post',
					responseType: 'json',
					data: Qs.stringify(_this.submit)
				}).then(function(data) {
					console.log(data)
					_this.product_list = data.data.datalist;
					if (data.data.datalist != '') {
						common_func.pageGen(data.data.current_page, data.data.total_page)
					}
				})
			},
			get_url() {
				let _this = this;


				// 如果有大分類及小分類
				_this.submit.main_id = lid[0];
				_this.submit.sub_id = lid[1];
				_this.call_class_main();
				axios({
					url: '/api/class_sub_list',
					method: 'post',
					responseType: 'json',
					data: Qs.stringify(_this.submit)
				}).then(function(data) {
					_this.sub_list = data.data.data;
				})
				console.log(lid);
	
		},
		call_class_main() {
			let _this = this;
			axios({
				url: '/api/class_main_list',
				method: 'post',
				responseType: 'json',
				data: Qs.stringify(_this.submit)
			}).then(function(data) {
				if (data.data.sys_code == '200') {
					_this.main_list = data.data.data;
				}
			})
		},
		mouse_in_out(e) {
			let _this = this;
			console.log(e.target.classList);
			e.target.classList.toggle('fadeOut');
			e.target.classList.toggle('fadeIn');
		},
		add_cart(id) {
			let _this = this;
			let submit = {
				product_id: id,
				qty: 1,
			}
			axios({
				url: '/api/cart_add',
				method: 'post',
				responseType: 'json',
				data: Qs.stringify(submit)
			}).then(function(data) {
				if (data.data.sys_code == '200') {
					console.log(data.data.sys_msg);
				}
			})
		}
	}
	})
</script>