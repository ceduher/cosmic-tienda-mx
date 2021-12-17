<template>
<div>
    <div v-for="(item,index) in Items" :key="index" class="flex flex-row my-2">
        <div class="text-black font-normal cursor-pointer hover:text-red-600 w-1/6">
            <i class="fas fa-trash-alt mr-1" @click="removeItem(index)"></i>
        </div>        
        <div class="text-black font-normal w-1/6">
            <img :src='item.imagesrc'  alt="image" class="image-cart"/>
        </div>                                              
        <div class="text-black font-normal w-3/6">
            {{item.name}}
        </div>
        <div class="quantity buttons_added">
            <input type="button" @click="decrement(item, index)" value="-" class="minus">
            <input type="number" step="1" min="1" max="" name="quantity" v-model="item.qty" title="Qty" class="input-text qty text" size="4" pattern="" inputmode="">
            <input type="button" @click="increment(item, index)" value="+" class="plus">
        </div>                           
        <div class="text-black font-bold w-1/6 text-right">$ {{item.price}}</div>
    </div>
     <div class="py-3 px-4 flex flex-col">
        <div class="flex flex-row justify-between my-2">
            <div class="text-black font-normal">Subtotal</div>
            <div class="text-black font-bold">$ {{ this.getSubtotal}}</div>
        </div>
        <div class="flex flex-row justify-between my-2">
            <div class="text-black font-normal">Envío</div>
            <div class="text-black font-bold">$ {{deliveryFee}}</div>
        </div>
        <div class="flex flex-row justify-between my-2 text-red-600 text-xl font-semibold">
            <div>Total</div>
            <div>$ {{ getTotal + deliveryFee}}</div>
        </div>
    </div>
    <div v-show="getSubtotal < 350" class="my-3 flex flex-row justify-around p-6 bg-green-200">
        <span class="text-center font-semibold">Compra minima $ 350</span>
    </div>
    <div v-show="getTotal && freeDelivery > 0" class="my-3 flex flex-row justify-around p-6 bg-green-200">
        <span class="text-center font-semibold">Te faltan $ {{ freeDelivery }} para tener envio gratis</span>
    </div>
    <div class="py-3 px-4 flex flex-col">
        <div class="flex flex-left">
            <a class="button" href="/">Regresar</a>             
            <a class="button" 
                @click.prevent="makeOrder"
                v-if="getTotal > 350" style="cursor: pointer;">Comprar</a>             
        </div>
    </div>
</div>    
</template>

<script>
export default {
    props: {
        cartid: {
            type: Number,
            default: 0
        },
        market: {
            type: Object
        },
        products: {
            type: Array
        }
    },
    data() {
        return {
            Items:[],
        }
    },
    computed: {
        getSubtotal: function () {
            var total = 0;
            this.Items.forEach(element => {
                total = total + (element.qty * element.price);
            });

            if(total.toFixed(2) >= 350){
                // console.log("Aqui");
            }else{
                // console.log("Aca");
            }

            return total.toFixed(2);
        },
        getTotal: function () {
            return Number(this.getSubtotal);
        },
        freeDelivery() {
            return Number((400 - this.getTotal).toFixed(2))
        },
        deliveryFee() {
            return this.freeDelivery <= 0 ? 0: this.market.delivery_fee
        }
    },    
    mounted(){
        this.getCart();
    },
    methods: {
        decrement(item, index){
            item.qty--;
            if (item.qty>0){

                const product = { 
                    qty: item.qty,
                    user_id : this.cartid                        
                }; 
                axios
                    .post(`/api/cart/update/${item.id}`,product)
                    .then(response => response.data )
                    .then(response => {         
                        var basketCount = document.getElementById('cart-count-nav');
                        basketCount.innerHTML = response.count;
                    })
                    .catch((err) => {this.errorNotify(err);})                    
            } else if (item.qty == 0) {
                this.removeItem(index)
            }
        },        
        increment(item, index){
            item.qty++;
            
            if (this.checkAddOrSubStock(item, 'add')) {

                const product = { 
                    qty: item.qty,
                    user_id : this.cartid
                };               
                axios
                    .post(`/api/cart/update/${item.id}`,product)
                    .then(response => response.data )
                    .then(response => {            
                        var basketCount = document.querySelector('.cart-products-count');
                        basketCount.innerHTML = response.count; 
                    })
                    .catch((err) => {this.errorNotify(err);})
            } else {
                item.qty--;

                this.$notify({
                    group: 'bar',
                    type: 'error', 
                    title: 'Stock agotado',
                    text: 'Cantidad de productos excedida'
                });
            }

        },
        async removeItem(index){
            this.$notify({
                group: 'bar',
                type: 'alert', 
                title: 'Eliminando producto de su cesta de compras',
            });

            var id= this.Items[index].id;
            this.Items.splice(index, 1);
            
            await axios.delete(`/api/cart/delete/${id}`)
            .then(response => response.data )
            .then(response => {   
                var basketCount = document.querySelector('.cart-products-count');
                basketCount.innerHTML = response.count;                          
                this.$notify({
                    group: 'bar',
                    type: 'alert', 
                    title: 'Cesta de Compras',
                    text: response.message ?? 'Producto eliminado'
                });                
            })
            .catch((err) => {
                this.$notify({
                    group: 'bar',
                    type: 'err', 
                    title: 'Oops, ha ocurrido un error',
                });
            })

        },
        getCart(){
            axios
            .get(`/api/cart/show/${this.cartid}`)
            .then(response => response.data )
            .then(response => {            
                this.Items=response.data;
            })
            .catch((err) => {
                this.$notify({
                    group: 'bar',
                    type: 'err', 
                    title: 'Oops, ha ocurrido un error',
                });
            })
        },
        
        makeOrder() {
            const orderList = this.Items.map(item => {
                let productData = this.products.find(pi => pi.id == item.product_id)
                if (productData && productData.qty < item.qty) {
                    item.qty = productData.qty;

                    this.$notify({
                        group: 'bar',
                        type: 'info', 
                        title: 'Cantidad de productos actualizada',
                        text: 'A la cantidad maxima que disponemos'
                    });
                }

                return {
                    product_id: item.product_id,
                    product_name: item.name,
                    numberOfMeals: item.qty,
                    oldPrice: item.price ,
                    price: item.price,
                    productMarket: item.market_id,
                    options: [],
                }
            })

            console.log('total', this.getTotal, this.deliveryFee, this.getTotal+ this.deliveryFee)
        
            const order = {
                market: this.market,
                orders: orderList,
                orderType: 'Delivery',
                total: this.getTotal+ this.deliveryFee,
                delivery_fee: this.deliveryFee
            }
            localStorage.removeItem("order");
            localStorage.setItem("order",JSON.stringify(order));
            location.href = location.origin+`/order/market/${this.market.id}`;
        },

        checkAddOrSubStock(product, type = '+') {
            let data = this.products.find(item => item.id == product.product_id)

            // console.log(data.qty >= product.qty)
            if(type == '+' || type == 'add') {
                return data && data.qty >= product.qty
            }

            return false
        }
    }
}
</script>