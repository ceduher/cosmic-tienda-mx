<template>
    <div>
        <section class="container lg:px-32 py-5">
            <!-- Popular Markets -->
            <!-- Top rated Products -->
            <div class="flex flex-col py-2">
                <span class="w-40 h-1 bg-green mt-4"></span>
                <div class="flex align-items-center justify-between">
                    <h2 class="text-black font-bold text-4xl pt-4 pb-2">
                        {{ $t("Top Rated Products") }}
                    </h2>
                    <div></div>
                    <!-- <a  href="/markets/12" class="btn bg-green custom-btn-blue rounded-3xl py-2 px-4 leading-6">
                        Ver más
                    </a> -->
                </div>
                <p class="text-gray-400">
                    {{ $t("Top Rated Products Description") }}
                </p>
                <div class="grid gap-5 grid-cols-1 lg:grid-cols-2 py-4">
                    <div v-for="(product, index) in products" :key="index" class="cursor-pointer box  w-full d-flex flex-column flex-md-row bg-white p-2 mb-2">
                        <div class="h-full md:w-1/3 d-flex justify-content-center">
                            <a :href="'/producto/'+product.product.slug">
                                <img :src="product.cover" alt="image" class="h-full w-full rounded-l-md object-cover"/>
                            </a>
                        </div>
                        <div class="flex-1 relative flex flex-col justify-between rounded-r-md px-2 pt-2 pb-3 bg-white">
                            <div class="flex w-full justify-between align-items-start">
                            <a :href="'/producto/'+product.product.slug" style="text-decoration: none;">
                                <div>
                                    <span class="text-gray-800">{{ product.category.name }}</span>
                                    <h2 class="text-black text-2xl font-bold">{{ product.product.name }}</h2>
                                    <!-- <p class="text-gray-400 text-sm">{{ product.market.name }}</p>
                                    <p class="text-gray-400 text-xs">{{ product.market.address }}</p>-->
                                </div>
                                </a>
                                <div v-if="product.rate" class="bg-gray-200 py-1 px-2 rounded">
                                    <span class="text-gray-700 font-semibold">{{ product.rate }}</span>
                                    <i class="text-gold fas fa-star"></i>
                                </div>
                            </div>
                            <div class="flex w-full justify-between align-items-baseline">
                                <div class="flex flex-row items-center">
                                    <div v-html="product.price" class="text-green text-base font-bold sm py-1 px-2"/>
                                    <span v-if="product.discount" class="bg-red-600 text-white rounded text-sm py-1 px-2">
                                        -{{ product.discount }} %
                                    </span>
                                </div>
                                <!-- <div class="text-sm">
                                     <span class="px-1" :class="{
                                            ['line-through text-gray-400']: !product.market.available_for_delivery,
                                            ['text-gray-600']: product.market.available_for_delivery,
                                            ['line-through text-gray-400']: product.market.closed,
                                            ['text-gray-600']: !product.market.closed,
                                        }">
                                            {{ $t("Delivery") }}
                                            <i class="fas fa-motorcycle"></i>
                                    </span>
                                </div>
                                    -->
                            </div>
                            <cart-add :cartid="cartid" :id="product.product.id" :stock="product.product.qty"></cart-add> 
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>
<script>
    export default {
    props: ["countMarket","app_name", "cartid", "user_id"],
    data() {
        return {
            markets: [],
            products: [],
            disabledAddProductBtn: false,
        };
    },
    created() {
        this.topRatedMarkets();
        this.topRatedProducts();
    },
    methods: {
        topRatedMarkets(){
            axios
            .get(`/api/markets/topRated`)
            .then((response) => response.data)
            .then((response) => {
                response.markets.forEach((element) => {
                    this.markets.push(element);
                });
            })
            .catch((err) => {
                console.log(err);
            });
        },
        topRatedProducts(){
            axios
            .get(`/api/products/topRated`)
            .then((response) => response.data)
            .then((response) => {
                response.products.forEach((element) => {
                    this.products.push(element);
                });
            })
            .catch((err) => {
                console.log(err);
            });
        },
        async goToProduct(market_id, event){
            if(!this.cartid) {
                this.$notify({
                    group: 'bar',
                    type: 'success', 
                    title: 'Inice sesión',
                    text: 'Debe iniciar sesión para guardar productos en su carrito de compra.'
                });
                return null;
            }

            // console.log(`market_id`, market_id)
            this.disabledAddProductBtn = true;
            var _this2 = this;       
            if (event) event.preventDefault();
            const product = { 
                user_id : this.cartid,
                id: market_id,
                qty: 1
            };
            await axios.put(`/api/cart/add`,product)
                .then((response) => response.data)
                .then((response) => {
                    var basketCount = document.getElementById('cart-count-nav');
                    basketCount.innerHTML = response.records;
                    this.$notify({
                        group: 'bar',
                        type: 'success', 
                        title: 'Cesta de Compras',
                        text: response.status ?? 'Producto añadido a su carrito de compras.'
                    });
                    this.disabledAddProductBtn = false;
                })
                .catch((err) => {
                    console.log(err);
                    this.$notify({
                        group: 'bar',
                        type: 'error', 
                        title: 'Ops!',
                        text: 'Ha ocurrido un error al añadir este producto, intente nuevamente.'
                    });
                });            
        },
        goToMarket(market_id){
           // location.href=window.location.origin+'/markets/'+market_id;
        }
    },
    };
</script>