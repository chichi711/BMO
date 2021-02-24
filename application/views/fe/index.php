<style>
    .revo-slider-emphasis-text {
        font-size: 58px;
        font-weight: 700;
        letter-spacing: 1px;
        font-family: 'Poppins', sans-serif;
        padding: 15px 20px;
        border-top: 2px solid #FFF;
        border-bottom: 2px solid #FFF;
    }

    .revo-slider-desc-text {
        font-size: 20px;
        font-family: 'Lato', sans-serif;
        width: 650px;
        text-align: center;
        line-height: 1.5;
    }

    .revo-slider-caps-text {
        font-size: 16px;
        font-weight: 400;
        letter-spacing: 3px;
        font-family: 'Poppins', sans-serif;
    }

    .tp-video-play-button {
        display: none !important;
    }

    .tp-caption {
        white-space: nowrap;
    }
</style>

<div id="app">
    <!-- Content
============================================= -->
    <section id="content">
        <div class="content-wrap">
            <div class="container clearfix">

                <div class="row align-items-stretch gutter-20 min-vh-60">
                    <div class="col-md-8">

                        <div class="row align-items-stretch gutter-20 h-100">
                            <div class="col-md-6 min-vh-25 min-vh-md-0">
                                <a href="./product/P-1613123768" class="grid-inner d-block h-100" style="background-image: url('./public/assets/images/banners/2.jpg');"></a>
                            </div>

                            <div class="col-md-6 min-vh-25 min-vh-md-0">
                                <a href="./product/P-1613122900" class="grid-inner d-block h-100" style="background-image: url('./public/assets/images/banners/1.jpg'); background-position: right center;"></a>
                            </div>

                            <div class="col-md-12 min-vh-25 min-vh-md-0 pb-md-0">
                                <a href="./product/P-1613125772" class="grid-inner d-block h-100" style="background-image: url('./public/assets/images/banners/4.jpg');"></a>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-4 min-vh-50">
                        <a href="./product/P-1613125916" class="grid-inner d-block h-100" style="background-image: url('./public/assets/images/banners/3.jpg'); background-position: center top;"></a>
                    </div>
                </div>


                <div class="clear"></div>

                <div class="tabs topmargin-lg clearfix">

                    <ul class="tab-nav clearfix">
                        <li><span class="tab-nav-span">暢銷熱賣</span></li>
                        <li><a href="#tabs-7">飲食料理</a></li>
                        <li><a href="#tabs-6">旅遊</a></li>
                    </ul>

                    <div class="tab-container">

                        <div class="tab-content" id="tabs-7">

                            <div class="shop row gutter-30">

                                <div v-for="item in product_list2" class="product col-lg-3 col-md-4 col-sm-6 col-12">
                                    <div class="grid-inner">
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
                                                <h3><a :href="'./product/' + item.product_id">{{ item.product_name }}</a></h3>
                                            </div>
                                            <div>{{ item.author }} 著</div>
                                            <div class="product-price">${{ item.price }}</div>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        
                        <div class="tab-content" id="tabs-6">

                            <div class="shop row gutter-30">

                                <div v-for="item in product_list" class="product col-lg-3 col-md-4 col-sm-6 col-12">
                                    <div class="grid-inner">
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
                                                <h3><a :href="'./product/' + item.product_id">{{ item.product_name }}</a></h3>
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

                <div class="tabs topmargin-lg clearfix">

                    <ul class="tab-nav clearfix">
                        <li><span class="tab-nav-span">新品推薦</span></li>
                        <li><a href="#tabs-9">旅遊</a></li>
                        <li><a href="#tabs-10">飲食料理</a></li>
                    </ul>

                    <div class="tab-container">

                        <div class="tab-content" id="tabs-9">

                            <div class="shop row gutter-30">

                                <div v-for="item in product_list" class="product col-lg-3 col-md-4 col-sm-6 col-12">
                                    <div class="grid-inner">
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
                                                <h3><a :href="'./product/' + item.product_id">{{ item.product_name }}</a></h3>
                                            </div>
                                            <div>{{ item.author }} 著</div>
                                            <div class="product-price">${{ item.price }}</div>

                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="tab-content" id="tabs-10">

                            <div class="shop row gutter-30">

                                <div v-for="item in product_list2" class="product col-lg-3 col-md-4 col-sm-6 col-12">
                                    <div class="grid-inner">
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
                                                <h3><a :href="'./product/' + item.product_id">{{ item.product_name }}</a></h3>
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

            </div>

        </div>
    </section><!-- #content end -->
</div>


<script>
    new Vue({
        el: "#app",
        data: {
            submit: {
                menu_id: '',
                menu_name: '',
                main_id: '',
                main_name: '',
                sub_id: '',
                sub_name: '',
            },
            product_list: [],
            product_list2: [],
        },
        mounted() {
            let _this = this;
            let data = {
                menu_id: 'books',
                main_id: '7',
                sub_id: '44',
            }
            let data2 = {
                menu_id: 'books',
                main_id: '4',
            }
            _this.get_product_list(data);
            _this.get_product_list2(data2);
        },
        methods: {
            get_product_list(item) {
                let _this = this;
                axios({
                    url: '/api/product_list',
                    method: 'post',
                    responseType: 'json',
                    data: Qs.stringify(item)
                }).then(function(data) {
                    console.log(data)
                    _this.product_list = data.data.datalist;
                    if (_this.product_list.length > 4) {
                        _this.product_list = _this.product_list.slice(0, 4);
                    }
                })
            },
            get_product_list2(item) {
                let _this = this;
                axios({
                    url: '/api/product_list',
                    method: 'post',
                    responseType: 'json',
                    data: Qs.stringify(item)
                }).then(function(data) {
                    console.log(data)
                    _this.product_list2 = data.data.datalist;
                    if (_this.product_list2.length > 4) {
                        _this.product_list2 = _this.product_list2.slice(0, 4);
                    }
                })
            },
            mouse_in_out(e) {
                let _this = this;
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