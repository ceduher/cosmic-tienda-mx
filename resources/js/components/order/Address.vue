<template>
    <div>
        <div class="accordion" id="accordionAddressOrder">
            <div class="card">
                <div class="" id="headingOne">
                    <h2 class="mb-0">
                        <button class="btn btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"
                            @click="AddAddress = !AddAddress">
                            <i class="fas fa-minus-circle" v-if="AddAddress"></i>
                            <i class="fas fa-plus-circle" v-else></i> Añadir dirección
                        </button>
                    </h2>
                </div>
                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionAddressOrder">
                    <div class="card-body">
                        <div class="input-group mb-3">
                            <!--div class="input-group-prepend">
                                <span class="input-group-text border-right-0 bg-transparent"><i class="fas fa-map-marker-alt"></i></span>
                            </div-->
                            <gmap-loader
                                @setAddress="setAddress"
                                @setUrl="setUrl"
                                :dataAddress="formAddress.address"
                                :restrictions="restrictions"></gmap-loader>
                            <input type="text"
                                name="address"
                                hidden
                                v-model="formAddress.address">
                        </div>
                        <template v-if="formAddress.address">
                            <div class="row no-gutters mb-3">
                                <div class="col mr-2">
                                    <input type="text" class="form-control"
                                        placeholder="Calle"
                                        v-model="formAddress.calle"
                                        name="calle">
                                </div>
                                <div class="col ml-2">
                                    <input type="text" class="form-control"
                                        placeholder="No. Exterior"
                                        v-model="formAddress.numext"
                                        name="numext">
                                </div>
                            </div>
                            <div class="row no-gutters mb-3">
                                <div class="col mr-2">
                                    <input type="text" class="form-control"
                                        placeholder="No. Interior (Opcional)"
                                        v-model="formAddress.numint"
                                        name="numint">
                                </div>
                                <div class="col ml-2">
                                    <input type="text" class="form-control"
                                        placeholder="Colonia"
                                        v-model="formAddress.colonia"
                                        name="colonia">
                                </div>
                            </div>
                            <div class="row no-gutters mb-3">
                                <div class="col mr-2">
                                    <input type="text" class="form-control"
                                        placeholder="Codigo postal"
                                        v-model="formAddress.codigo_postal"
                                        name="codigo_postal">
                                </div>
                                <div class="col ml-2">
                                    <input type="text" class="form-control"
                                        placeholder="Ciudad" readonly
                                        v-model="formAddress.municipio"
                                        name="municipio">
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control border-right-0"
                                    placeholder="Estado" readonly value="Yucatan"
                                    v-model="formAddress.estado"
                                    name="estado">
                            </div>
                            <input hidden name="url" v-model="formAddress.url">
                            <input hidden name="delivery_address_id" v-model="formAddress.id">
                        </template>
                        <div id="msg-country-club" style="display: none">
                            <div class="alert alert-info" role="alert">
                                <p>Su pedido se entregará entre el Colegio Madison y La Universidad Anahuac en una unidad con distintivo de COSMIC, conforme a los siguientes criterios:</p>
                                <ol class="list-decimal">
                                    <li>Pedidos realizados entre <a href="#" class="alert-link">08:00 a.m.</a> y <a href="#" class="alert-link">02:00 p.m.</a> Serán entregados de <a href="#" class="alert-link">04:00 p.m.</a> a <a href="#" class="alert-link">05:00 p.m.</a> del mismo día.</li>
                                    <li>Pedidos realizados después de las <a href="#" class="alert-link">02:00 p.m.</a> y hasta las <a href="#" class="alert-link">08:00 p.m</a>, serán entregados de <a href="#" class="alert-link">09:00 a.m.</a> a <a href="#" class="alert-link">10:00 a.m.</a> del siguiente día hábil.</li>
                                </ol>
                            </div>
                        </div>
                        <div id="msg-check-address" style="display: none">
                            <div class="alert alert-info" role="alert">
                                <p>Por favor confirme su dirección posicionando el marcador en el mapa. <br/> Gracias!!</p>
                            </div>
                        </div>
                        <!-- {{formAddress.url}} -->
                        <div id="map-address"></div>
                        <h5 class="my-2">Datos de entrega</h5>
                        <input type="text" class="form-control mb-3"
                            placeholder="Nombra tu dirección (casa, departamento, oficina)"
                            v-model="formAddress.direccion_entrega"
                            name="direccion_entrega">
                        <div class="row no-gutters mb-3">
                            <div class="col mr-2">
                                <input type="text" class="form-control"
                                    placeholder="Nombre"
                                    v-model="formAddress.nombre"
                                    name="nombre">
                            </div>
                            <div class="col ml-2">
                                <input type="text" class="form-control"
                                    placeholder="Apellido"
                                    v-model="formAddress.apellido"
                                    name="apellido">
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text border-right-0 bg-transparent"><i class="fas fa-phone"></i>&nbsp; +52</span>
                            </div>
                            <input type="text"
                                class="form-control border-left-0"
                                placeholder="Teléfono"
                                v-model="formAddress.telefono"
                                name="telefono"
                                maxlength="12">
                        </div>
                    </div>
                </div>
            </div>
            <list-address v-for="(item, i) in address" :key="i"
                :i="i" :address="item"
                @selectAddress="selectAddress"
                @removeLocalAddress="removeLocalAddress"></list-address>
        </div>
        <div class="mt-2">
            <button type="button" class="btn-block text-xs md:text-base py-2 bg-green text-white rounded px-2"
                @click="addNewAddress">Añadir otra dirección</button>
        </div>
    </div>
</template>

<style scoped>
    #map-address {
        height: 250px;
        margin-bottom: 20px;
    }
</style>

<script>
export default {
    name: 'OrderAddress',

    props: ['restrictions', 'deliveryaddress', 'user_id'],
    data: () => ({
        AddAddress: true,
        address: [],
        formAddress: {
            address: '',
            calle: '',
            numext: '',
            numint: '',
            colonia: '',
            codigo_postal: '',
            municipio: 'Mérida',
            estado: 'Yucatan',
            direccion_entrega: '',
            nombre: '',
            apellido: '',
            telefono: '',
            url: '',
        }
    }),
    computed: {
        disabledAddMore() {
            return this.formAddress.address == '',
                this.formAddress.calle == '',
                this.formAddress.numext == '',
                this.formAddress.numint == '',
                this.formAddress.colonia == '',
                this.formAddress.codigo_postal == '',
                this.formAddress.municipio == '',
                this.formAddress.direccion_entrega == '',
                this.formAddress.nombre == '',
                this.formAddress.apellido == '',
                this.formAddress.telefono == ''
        }
    },
    methods: {
        setAddress(mapData) {
            this.formAddress.numext = '';
            this.formAddress.calle = '';
            this.formAddress.codigo_postal = '';
            this.formAddress.colonia = '';
            this.formAddress.municipio = 'Mérida';

            if(mapData.address_components && mapData.address_components.length > 0) {
                this.formAddress.address = mapData.formatted_address;
                
                for (const component of mapData.address_components) {
                    const componentType = component.types[0];
                    switch (componentType) {
                        case "street_number":
                            if(component.long_name) this.formAddress.numext = component.long_name;
                        break;
                        case "route":
                            if(component.short_name)  this.formAddress.calle = component.short_name;
                        break;
                        case "postal_code":
                            if (component.long_name) this.formAddress.codigo_postal = component.long_name;
                        break;
                    }
                    let sizeObj = Object.keys(mapData.address_components).length;
                    if(sizeObj <= 6 ){
                        if(componentType == "locality"){
                            if (component.long_name) this.formAddress.colonia = component.long_name;
                        }
                    } 
                    if(sizeObj >= 7 ){
                        if(componentType == "political"){
                            if (component.long_name) this.formAddress.colonia = component.long_name;
                        }
                    }
                }
            } else {
                this.formAddress.address = mapData;
            }
        },
        setUrl(value) {
            this.formAddress.url = value;
        },
        addNewAddress() {
            let msgDefaultDisplay = document.getElementById('msg-check-address').style.display;
            let msgCountryDisplay = document.getElementById('msg-country-club').style.display;

            if(msgDefaultDisplay === 'none' && msgCountryDisplay === 'none'){
                if(this.address.length != 0){
                    this.$notify({
                        group: 'bar',
                        type: 'info', 
                        title: 'Direccion Registradas en su Cuenta',
                        text: 'Disculpe, usted tiene direcciones registradas.<br/>Si desea, use la opcion con el nombre del marcador.'
                    });
                }
            }else if(this._validateAddress()){
                this.saveIntoApi();
            }
        },
        async saveIntoApi() {
            this.formAddress.user_id = this.user_id;
            await axios.post(`/api/delivery/address`, this.formAddress)
                .then(response => {
                    this.address.push(this.formAddress);
                    this._resetForm();
                    this.$notify({
                        group: 'bar',
                        title: 'Dirección guardada!',
                        type: 'success',
                        text: 'Ya puede agregar los datos de pago.',
                    });
                })
                .catch((err) => {
                    this.$notify({
                        group: 'bar',
                        title: 'Error!',
                        type: 'error',
                        text: 'Debe completar todos los datos para poder continuar',
                    });
                });
        },
        _validateAddress() {
            if(this.formAddress.numext === this.formAddress.numint){
                this.$notify({
                    group: 'bar',
                    title: 'Disculpe!',
                    type: 'error',
                    text: 'El numero de exterior y de interior no pueden ser iguales',
                });
                return false;
            }
            if(this.formAddress.direccion_entrega.length === 0){
                this.$notify({
                    group: 'bar',
                    title: 'Disculpe!',
                    type: 'error',
                    text: 'La direccion de entrega no puede estar vacia',
                });
                return false;
            }
            if(this.formAddress.nombre.length === 0){
                this.$notify({
                    group: 'bar',
                    title: 'Disculpe!',
                    type: 'error',
                    text: 'El nombre de la persona de entrega no puede estar vacio',
                });
                return false;
            }
            if(this.formAddress.apellido.length === 0){
                this.$notify({
                    group: 'bar',
                    title: 'Disculpe!',
                    type: 'error',
                    text: 'El apellido de la persona de entrega no puede estar vacio',
                });
                return false;
            }
            if(this.formAddress.telefono.length === 0){
                this.$notify({
                    group: 'bar',
                    title: 'Disculpe!',
                    type: 'error',
                    text: 'El telefono de la persona de entrega no puede estar vacio',
                });
                return false;
            }
            if(this.address.length != 0){
                if (this.address.some(item => 
                    item.calle == this.formAddress.calle &&
                    item.numext == this.formAddress.numext && 
                    item.numint == this.formAddress.numint)){
                    this.$notify({
                        group: 'bar',
                        title: 'Disculpe!',
                        type: 'error',
                        text: 'Esta dirección ya se encuentra registrada',
                    });
                    return false;
                }
            }
            return true;
        },
        _resetForm() {
            this.formAddress= {
                address: '',
                calle: '',
                numext: '',
                numint: '',
                colonia: '',
                codigo_postal: '',
                municipio: '',
                estado: '',
                direccion_entrega: '',
                nombre: '',
                apellido: '',
                telefono: '',
            }
        },
        selectAddress(address) {
            Object.assign(this.formAddress, address);
            if(address.id) this.formAddress.id = address.id;

            this.$notify({
                group: 'bar',
                title: 'Dirección seleccionada',
                type: 'success',
                text: this.formAddress.address,
            })
        },
        removeLocalAddress(address) {
            this.address = this.address.filter(item => item.id != address.id)
        }
    },
    created() {
        if(this.deliveryaddress) {
            this.address = this.deliveryaddress;
            this.AddAddress = false;
        }
    }
}
</script>