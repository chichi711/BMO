<style>
	@media (min-width: 992px) {
		.mega-menu-style-2 .mega-menu-column {
			padding: 10px 20px;
		}
	}

	@media (min-width: 992px) {
		.mega-menu-style-2 .sub-menu-container .menu-link {
			padding-left: 5px;
			padding-top: 2px;
			padding-bottom: 2px;
		}
	}
</style>

<body class="stretched">

	<!-- Document Wrapper
	============================================= -->
	<div id="wrapper" class="clearfix">

		<!-- Header
		============================================= -->
		<header id="header">
			<div id="header-wrap">
				<div class="container">
					<div class="header-row">

						<!-- Logo
						============================================= -->
						<div id="logo">
							<a href="/" class="standard-logo" data-dark-logo="/public/assets/images/logo-dark.png"><img src="/public/assets/images/Bmo-logo-black.png" alt="BMO Logo"></a>
							<a href="/" class="retina-logo" data-dark-logo="/public/assets/images/logo-dark@2x.png"><img src="/public/assets/images/Bmo-logo-black@2x.png" alt="BMO Logo"></a>
						</div><!-- #logo end -->

						<div class="header-misc">

							<!-- Top Search
							============================================= -->
							<div id="top-search" class="header-misc-icon">
								<a href="#" id="top-search-trigger"><i class="icon-line-search"></i><i class="icon-line-cross"></i></a>
							</div><!-- #top-search end -->

							<!-- Top Cart
							============================================= -->
							<div id="top-cart" class="header-misc-icon d-none d-sm-block">
								<a href="#" id="top-cart-trigger"><i class="icon-line-bag"></i><span class="top-cart-number">5</span></a>
								<div class="top-cart-content">
									<div class="top-cart-title">
										<h4>購物車</h4>
									</div>
									<div class="top-cart-items">
										<div class="top-cart-item">
											<div class="top-cart-item-image">
												<a href="#"><img src="/public/assets/images/shop/small/6.jpg" alt="Light Blue Denim Dress" /></a>
											</div>
											<div class="top-cart-item-desc">
												<div class="top-cart-item-desc-title">
													<a href="#">Light Blue Denim Dress</a>
													<span class="top-cart-item-price d-block">$24.99</span>
												</div>
												<div class="top-cart-item-quantity">x 3</div>
											</div>
										</div>
									</div>
									<div class="top-cart-action">
										<span class="top-checkout-price">$114.95</span>
										<a href="#" class="button button-3d button-small m-0">查看購物車</a>
									</div>
								</div>
							</div><!-- #top-cart end -->

							<!-- Top login
							============================================= -->
							<!-- <div v-if="login" id="top-login" class="header-misc-icon">
								<a href="/logout"><i class="icon-signout"></i></a>
							</div> -->
							<div v-if="login" id="top-login" class="dropdown header-misc-icon">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><i class="icon-user1"></i></a>
								<ul class="dropdown-menu dropdown-menu-right mt-3" aria-labelledby="dropdownMenu1">
									<!-- <a class="dropdown-item text-left" href="/profile">個人資料</a> -->
									<a class="dropdown-item text-left" href="/logout">登出 <i class="icon-signout"></i></a>
								</ul>
							</div>

							<div v-else id="top-login" class="header-misc-icon">
								<a href="/login"><i class="icon-user1"></i></a>
							</div>

							<!-- #top-login end -->

						</div>

						<div id="primary-menu-trigger">
							<svg class="svg-trigger" viewBox="0 0 100 100">
								<path d="m 30,33 h 40 c 3.722839,0 7.5,3.126468 7.5,8.578427 0,5.451959 -2.727029,8.421573 -7.5,8.421573 h -20"></path>
								<path d="m 30,50 h 40"></path>
								<path d="m 70,67 h -40 c 0,0 -7.5,-0.802118 -7.5,-8.365747 0,-7.563629 7.5,-8.634253 7.5,-8.634253 h 20"></path>
							</svg>
						</div>

						<!-- Primary Navigation
						============================================= -->
						<nav class="primary-menu">

							<ul class="menu-container">
								<!-- Mega Menu
								============================================= -->
								<li v-for="list in menu" class="menu-item mega-menu"><a class="menu-link" href="javascript:void(0)">
										<div>{{ list.menu_name }}</div>
									</a>
									<div v-if="list.mainlist != '' " class="mega-menu-content mega-menu-style-2">
										<div class="container">
											<div class="row">
												<ul v-for="item in list.mainlist" class="sub-menu-container mega-menu-column col-lg-2">
													<li class="menu-item mega-menu-title"><a class="menu-link" :href="'/' + list.menu_id + '?lid=' + item.main_id">
															<div>{{ item.main_name }}</div>
														</a>
														<ul v-if="item.sublist" class="sub-menu-container">
															<li v-for="order in item.sublist" class="menu-item"><a class="menu-link" :href="'/' + list.menu_id + '?lid=' + item.main_id + '.' + order.sub_id">
																	<div>{{ order.sub_name }}</div>
																</a></li>
															<li class="menu-item text-gray"><a class="menu-link" :href="'/' + list.menu_id + '?lid=' + item.main_id">
																	<div>看更多</div>
																</a></li>
														</ul>
													</li>
												</ul>
											</div>
										</div>
									</div>
								</li>
								<!-- .mega-menu end -->

								<li class="menu-item"><a class="menu-link" href="#">
										<div>主題精選</div>
									</a></li>
								<li class="menu-item"><a class="menu-link" href="#">
										<div>線上客服</div>
									</a></li>
							</ul>

						</nav><!-- #primary-menu end -->

						<form class="top-search-form" action="search.html" method="get">
							<input type="text" name="q" class="form-control" value="" placeholder="Type &amp; Hit Enter.." autocomplete="off">
						</form>

					</div>
				</div>
			</div>
			<div class="header-wrap-clone"></div>
		</header><!-- #header end -->

		<script>
			new Vue({
				el: '#header',
				data: {
					login: '',
					menu: [],
				},
				mounted() {
					let _this = this;
					axios({
						url: '/api/menu_list',
						method: 'get',
						responseType: 'json',
					}).then(function(data) {
						_this.menu = data.data.data;
					})
					axios({
						url: '/api/chk_login',
						method: 'get',
						responseType: 'json',
					}).then(function(data) {
						_this.login = data.data.data;
					})
				}
			})
		</script>