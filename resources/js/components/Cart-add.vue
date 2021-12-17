<template>
    <div>
        <div class="d-flex align-items-end" v-if="stock">
            <div class="flex flex-column">
                <span class="text-gray-400 text-sm mr-4">Cantidad:</span>
                <div class="quantity buttons_added">
                    <input type="button" @click="decrement()" value="-" class="minus">
                    <input type="number" step="1" min="1" max="" v-model="qty" name="quantity" title="Qty" size="4" pattern="" inputmode="" class="input-text qty text">
                    <input type="button" @click="increment()" value="+" class="plus">
                </div>
            </div>
            <div class="ml-1 ml-xl-3">
                <button @click="addProduct()" class="button add-to-cart" 
                    :class="{'adding-to-cart': loading}"
                    style="margin: 0;" :disabled="loading">
                    <div v-if="loading" class="d-flex align-items-center">
                        <span>Agregando</span>
                        <i class="fas fa-spinner fa-pulse mx-1"></i>
                    </div>
                    <div v-else class="d-flex align-items-center">
                        <i class="icon fas fa-shopping-basket mr-md-2"></i>
                        <span class="hidden md:flex">Añadir al carrito</span>
                    </div>
                </button>   
            </div>
        </div>
        <div v-else class="text-gray-400">
            Sin existencias
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
        id: {
            type: Number,
            default: 0
        },
        stock: {
            type: Number,
            default: 0
        }
    },
    data() {
        return {
            qty:1,
            loading: false
        }
    },
    computed: {
    },    
    mounted(){
    },
    methods: {
           decrement(){
               if (this.qty>1){
                    this.qty--;
               }
           },        
           increment(){
               this.qty++;
           },
            async addProduct(event){
                if(!this.cartid) {
                    this.$notify({
                        group: 'bar',
                        type: 'success', 
                        title: 'Inice sesión',
                        text: 'Debe iniciar sesión para guardar productos en su carrito de compra.'
                    });
                    return null;
                }
                if(this.qty == 0) {
                    this.$notify({
                        group: 'bar',
                        type: 'info', 
                        title: 'Seleccione la cantidad',
                        text: 'Debe seleccionar la cantidad que desea comprar'
                    });
                    return null;
                }

                var _this2 = this;       
                if (event) event.preventDefault();
                const product = { 
                    user_id : this.cartid,
                    qty: this.qty,
                    id : this.id
                };
                this.loading = true;

                await axios.put(`/api/cart/add`,product)
                .then((response) => response.data)
                .then((response) => {
                    this.$notify({
                        group: 'bar',
                        type: 'success', 
                        title: 'Cesta de Compras',
                        text: response.status ?? 'Producto añadido a su carrito de compras.'
                    });
                    this.qty = 1;
                    
                    var basketCount = document.getElementById('cart-count-nav');
                    basketCount.innerHTML = response.records;
                })
                .catch((err) => {
                    console.log(err);
                    let dataExist = err.response && err.response.data;
                    let response =  err.response.data.status

                    this.$notify({
                        group: 'bar',
                        type: 'error', 
                        title: 'Ops!',
                        text: dataExist && response? response: 'Ha ocurrido un error al añadir este producto, intente nuevamente.'
                    });
                })
                .finally(() => {this.loading = false;});
            }
    }
}
</script>

<style>
.adding-to-cart {
    padding-right: 7px;
    border-color: #f18726;
    color: #f18726;
}
.adding-to-cart:hover {
    background-color: #f18726;
    color: white;
}
</style>