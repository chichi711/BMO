<div id="app">
	<!-- Page Title
		============================================= -->
	<section id="page-title">

		<div class="container clearfix">
			<h1 class="col-12 col-md-9 col-lg-10">{{ product.product_name }}</h1>
			<ol class="breadcrumb col-md-3 col-lg-2">
				<li class="breadcrumb-item">{{ product.menu_name }}</li>
				<li class="breadcrumb-item">{{ product.main_name }}</li>
				<li class="breadcrumb-item active" aria-current="page">{{ product.sub_name }}</li>
			</ol>
		</div>

	</section><!-- #page-title end -->

	<!-- Content
		============================================= -->
	<section id="content">
		<div class="content-wrap">
			<div class="container clearfix">

				<div class="single-product">
					<div class="product">
						<div class="row gutter-40">

							<div class="col-md-5">

								<!-- Product Single - Gallery
									============================================= -->
								<div class="product-image">
									<div class="fslider" data-pagi="false" data-arrows="false" data-thumbs="true">
										<div class="flexslider">
											<div class="slider-wrap" data-lightbox="gallery">
												<div class="slide" :data-thumb="product.main_img"><a :href="product.main_img" data-lightbox="gallery-item"><img :src="product.main_img" alt="product.product_name"></a></div>
												<div v-for="item in product.slide_imgs" class="slide" :data-thumb="item"><a :href="item" data-lightbox="gallery-item"><img :src="item" alt="product.product_name"></a></div>
											</div>
										</div>
									</div>
									<!-- <div class="sale-flash badge badge-danger p-2">Sale!</div> -->
								</div><!-- Product Single - Gallery End -->

							</div>

							<div class="col-md-7 product-desc">

								<div class="d-flex align-items-center justify-content-between">

									<!-- Product Single - Price
										============================================= -->
									<div class="product-price">${{ product.price }}</div>
									<!-- <div class="product-price"><del>${{ product.price }}</del> <ins>$24.99</ins></div> -->

									<!-- Product Single - Rating
										============================================= -->
									<div class="product-rating">
										<i class="icon-star3"></i>
										<i class="icon-star3"></i>
										<i class="icon-star3"></i>
										<i class="icon-star-half-full"></i>
										<i class="icon-star-empty"></i>
									</div>
									<!-- Product Single - Rating End -->

								</div>

								<div class="line"></div>

								<!-- Product Single - Quantity & Cart Button
									============================================= -->
								<form class="cart mb-0 d-flex justify-content-between align-items-center" method="post" enctype='multipart/form-data'>
									<div class="quantity clearfix">
										<input type="button" value="-" class="plus-minus" @click="submit.qty >= 2 ? submit.qty--:submit.qty">
										<input type="number" step="1" min="1" name="quantity" v-model="submit.qty" title="Qty" class="qty" disabled />
										<input type="button" value="+" class="plus-minus" @click="submit.qty++">
									</div>
									<button type="button" class="add-to-cart button m-0" @click="add_cart">加入購物車</button>
								</form><!-- Product Single - Quantity & Cart Button End -->

								<div class="line"></div>

								<!-- Product Single - Short Description
									============================================= -->
								<ul class="iconlist">
									<li><i class="icon-caret-right"></i> 作者： {{ product.author }}</li>
									<li><i class="icon-caret-right"></i> 語言： {{ product.language }}</li>
									<li><i class="icon-caret-right"></i> 出版社： {{ product.publisher }}</li>
									<li><i class="icon-caret-right"></i> 出版日期： {{ product.publication_date }}</li>
									<li><i class="icon-caret-right"></i> 庫存量： {{ product.stock }}</li>
								</ul><!-- Product Single - Short Description End -->

								<!-- Product Single - Meta
									============================================= -->
								<div class="card product-meta">
									<div class="card-body">
										<span itemprop="productID" class="sku_wrapper">SKU: <span class="sku">8465415</span></span>
										<span class="posted_in">Category: <a href="#" rel="tag">Dress</a>.</span>
										<span class="tagged_as">Tags: <a href="#" rel="tag">Pink</a>, <a href="#" rel="tag">Short</a>, <a href="#" rel="tag">Dress</a>, <a href="#" rel="tag">Printed</a>.</span>
									</div>
								</div><!-- Product Single - Meta End -->

								<!-- Product Single - Share
									============================================= -->
								<div class="si-share border-0 d-flex justify-content-between align-items-center mt-4">
									<span>分享:</span>
									<div>
										<a href="#" class="social-icon si-borderless si-facebook">
											<i class="icon-facebook"></i>
											<i class="icon-facebook"></i>
										</a>
										<a href="#" class="social-icon si-borderless si-twitter">
											<i class="icon-twitter"></i>
											<i class="icon-twitter"></i>
										</a>
										<a href="#" class="social-icon si-borderless si-pinterest">
											<i class="icon-pinterest"></i>
											<i class="icon-pinterest"></i>
										</a>
									</div>
								</div><!-- Product Single - Share End -->

							</div>



							<div class="w-100"></div>

							<div class="col-12 mt-5">

								<div class="tabs tabs-alt tabs-tb clearfix" id="tab-8">

									<ul class="tab-nav clearfix">
										<li><a href="./product/<?= $id ?>#tabs-29"><i class="icon-align-justify2"></i><span class="d-none d-md-inline-block"> 內容簡介</span></a></li>
										<li><a href="./product/<?= $id ?>#tabs-30"><i class="icon-info-sign"></i><span class="d-none d-md-inline-block"> 作者介紹</span></a></li>
										<li><a href="./product/<?= $id ?>#tabs-31"><i class="icon-star3"></i><span class="d-none d-md-inline-block"> 目錄</span></a></li>
									</ul>

									<div class="tab-container">

										<div class="tab-content clearfix" id="tabs-29" v-html="product.info"></div>
										<div class="tab-content clearfix" id="tabs-30" v-html="product.about_author"></div>
										<div class="tab-content clearfix" id="tabs-31" v-html="product.catalog"></div>

									</div>

								</div>

							</div>

						</div>
					</div>
				</div>

				<div class="line"></div>

				<div class="w-100">

					<h4>相關商品</h4>

					<div class="owl-carousel product-carousel carousel-widget" data-margin="30" data-pagi="false" data-autoplay="5000" data-items-xs="1" data-items-md="2" data-items-lg="3" data-items-xl="4">

						<div v-for="item in product_list" class="oc-item">
							<div class="product">
								<div class="product-image">
									<a :href="'./product/' + item.product_id"><img :src="item.main_img" alt="BMO"></a>
									<a v-if="item.slide_imgs != '' " :href="'./product/' + item.product_id"><img :src="item.slide_imgs" alt="BMO"></a>
									<div class="bg-overlay">
										<div class="bg-overlay-content align-items-end justify-content-between fadeOut" @mouseleave="mouse_in_out($event)" @mouseenter="mouse_in_out($event)" data-hover-animate="fadeIn" data-hover-speed="400">
											<a href="#" class="btn btn-dark mr-2" @click="add_cart(item.product_id)"><i class="icon-shopping-cart"></i></a>
										</div>
										<div class="bg-overlay-bg bg-transparent"></div>
									</div>
								</div>
								<div class="product-desc center">
									<div class="product-title">
										<h3><a :href="'/product/' + item.product_id">{{ item.product_name }}</a></h3>
									</div>
									<div>{{ item.author }} 著</div>
									<div class="product-price">${{ item.price }}</div>

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
			submit: {
				product_id: '<?= $id ?>',
				qty: 1,
			},
			main_list: [],
			sub_list: [],
			product: [],
			product_list: [],
		},
		mounted() {
			let _this = this;
			_this.get_product();

		},
		methods: {
			get_product() {
				let _this = this;
				axios({
					url: '/api/product_info',
					method: 'post',
					responseType: 'json',
					data: Qs.stringify(_this.submit)
				}).then(function(data) {
					console.log(data)
					_this.product = data.data.data;
					_this.get_list();
				})
			},
			add_cart(id = '') {
				let _this = this;
				if (id) {
					data = {
						product_id: '<?= $id ?>',
						qty: 1,
					}
				} else {
					data = _this.submit;
				}
				axios({
					url: '/api/cart_add',
					method: 'post',
					responseType: 'json',
					data: Qs.stringify(data)
				}).then(function(data) {
					if (data.data.sys_code == '200') {
						console.log(data.data.sys_msg);
					}
				})
			},
			get_list() {
				let _this = this;
				axios({
					url: '/api/product_list',
					method: 'post',
					responseType: 'json',
					data: Qs.stringify(_this.product)
				}).then(function(data) {
					console.log(data)
					if (data.data.sys_code == '200') {
						_this.product_list = data.data.datalist;
						if (_this.product_list.length > 4) {
							_this.product_list = _this.product_list.slice(0, 4);
						}
					}
				})
			},
			mouse_in_out(e) {
				let _this = this;
				e.target.classList.toggle('fadeOut');
				e.target.classList.toggle('fadeIn');
			},
		}
	})
</script>