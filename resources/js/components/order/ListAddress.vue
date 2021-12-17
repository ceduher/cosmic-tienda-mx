<template>
    <div class="card">
        <div class="" :id="idHeadingAddress">
            <h2 class="mb-0">
                <button class="btn btn-block text-left" 
                    type="button" 
                    data-toggle="collapse" 
                    :data-target="refIdCollapseAddress" 
                    aria-expanded="true" 
                    :aria-controls="idCollapseAddress" 
                    @click="AddAddress = !AddAddress; $emit('selectAddress', address);">
                    <i class="fas fa-minus-circle" v-if="AddAddress"></i>
                    <i class="fas fa-plus-circle" v-else></i> {{address.address}}
                </button>
            </h2>
        </div>

        <div :id="idCollapseAddress" 
            class="collapse" 
            :aria-labelledby="idHeadingAddress" 
            data-parent="#accordionAddressOrder">
            <div class="card-body">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text border-right-0 bg-transparent"><i class="fas fa-map-marker-alt"></i></span>
                    </div>
                    <input type="text" class="form-control border-left-0"
                        placeholder="Calle y número"
                        :value="address.address"
                        readonly>
                </div>

                <div class="row no-gutters mb-3">
                    <div class="col mr-2">
                        <input type="text" 
                            class="form-control"
                            placeholder="Calle"
                            :value="address.calle"
                            readonly>
                    </div>
                    <div class="col ml-2">
                        <input type="text" 
                            class="form-control" 
                            placeholder="No. Exterior"
                            :value="address.numext"
                            readonly>
                    </div>
                </div>

                <div class="row no-gutters mb-3">
                    <div class="col mr-2">
                        <input type="text" 
                            class="form-control" 
                            placeholder="No. Interior (Opcional)"
                            :value="address.numint"
                            readonly>
                    </div>
                    <div class="col ml-2">
                        <input type="text" 
                            class="form-control" 
                            placeholder="Colonia"
                            :value="address.colonia"
                            readonly>
                    </div>
                </div>

                <div class="row no-gutters mb-3">
                    <div class="col mr-2">
                        <input type="text" 
                        class="form-control" 
                        placeholder="Codigo postal"
                        :value="address.codigo_postal"
                        readonly>
                    </div>
                    <div class="col ml-2">
                        <input type="text" 
                        class="form-control" 
                        placeholder="Municipio"
                        :value="address.municipio"
                        readonly>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <input type="text" class="form-control border-right-0" 
                        placeholder="Estado"
                        readonly
                        :value="address.estado">
                    <!-- <div class="input-group-append">
                        <span class="input-group-text border-left-0 "><i class="fas fa-phone"></i>&nbsp; +52</span>
                    </div> -->
                </div>


                <h5>Datos de entrega</h5>
                <input type="text" 
                    class="form-control mb-3" 
                    placeholder="Nombra tu dirección (casa, departamento, oficina)"
                    :value="address.direccion_entrega"
                    readonly>

                <div class="row no-gutters mb-3">
                    <div class="col mr-2">
                        <input type="text" 
                            class="form-control" 
                            placeholder="Nombre"
                            :value="address.nombre"
                            readonly>
                    </div>
                    <div class="col ml-2">
                        <input type="text" 
                            class="form-control"
                            placeholder="Apellido"
                            :value="address.apellido"
                            readonly>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text border-right-0"><i class="fas fa-phone"></i>&nbsp; +52</span>
                    </div>
                    <input type="text" 
                        class="form-control border-left-0" 
                        placeholder="número de teléfono"
                        :value="address.telefono"
                        readonly>
                </div>

                <div>
                    <form @submit.prevent="deleteAddress">

                        <button class="btn btn-block btn-outline-danger"
                            data-toggle="tooltip" data-placement="bottom" title="Eliminar esta dirección"
                            type="submit"
                            :disabled="disabledBtn">
                            <i class="fas fa-trash-alt"></i> Eliminar direccion
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'ListAddress',

    props: ['i', 'address'],

    data: () => ({
        AddAddress: false,
        disabledBtn: false
    }),

    computed: {
        idHeadingAddress() {
            return 'headingAddress-' + this.i
        },
        idCollapseAddress() {
            return 'collapseAddress-' + this.i
        },
        refIdCollapseAddress() {
            return '#'+this.idCollapseAddress
        }
    },

    methods: {
        async deleteAddress() {
            if(this.address.id) {
                this.disabledBtn = true
                this.$notify({
                    group: 'bar',
                    title: 'Eliminando!',
                    type: 'success',
                    text: 'Esta dirección se está eliminando. Espere unos minutos mientras se completa el proceso.',
                });

                await axios.delete(`/api/delivery/${this.address.id}`).then(res => {
                    this.$notify({
                        group: 'bar',
                        title: 'Dirección eliminada',
                        type: 'success',
                        text: 'Dirección de entrega eliminada permanentemente.',
                    });
                    this.$emit('removeLocalAddress', this.address)
                }).catch(err => {
                    this.$notify({
                        group: 'bar',
                        title: 'Error!',
                        type: 'error',
                        text: 'No se ha podido eliminar la dirección',
                    });
                })

                this.disabledBtn = false
            }
        }
    }
}
</script>