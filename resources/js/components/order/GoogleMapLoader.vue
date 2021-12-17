<template>
    <div>
        <input ref="autocompleteInput" type="hidden" class="form-control border-left-0" @keyup="changeAddress()"/>
        <button 
            class="form-control mb-3 p-2 border-none bg-green text-white font-semibold rounded" 
            @click="confirmLocation()">Obtener Direcci&oacute;n actual</button>
    </div>
</template>

<script>
import { Loader } from '@googlemaps/js-api-loader';

export default {
    props: ['restrictions', 'dataAddress'],
    data: () => ({
        google: null,
        map: null,
        marker: null,
        autocomplete: null,
        address: null,
        timer: null,
        shopCoordinates: {lat: 21.013803, lng: -89.571910}
    }),
    watch: {
        dataAddress() {
            if(this.dataAddress && !this.$refs.autocompleteInput.value) {
                this.$refs.autocompleteInput.value = this.dataAddress;
                //console.log(this.$refs.autocompleteInput.value);
            }
        }
    },
    async mounted() {
        const loader = new Loader({
            apiKey: "AIzaSyCGzRxSkLSadhDpD6o9V_K4Ueryiq1PWg8",
            version: "weekly",
            libraries: ["places"]
        });
        this.google = await loader.load();
        
        this.initializeMap();
        this.initMarker();
        //this.initAutocomplete();
        this.getPositionOfMarket(this.marker);
    },
    methods: {
        initializeMap() {
            const mapContainer = document.getElementById("map-address");
            this.map = new google.maps.Map(mapContainer, {
                center: this.shopCoordinates,
                zoom: 15,
                disableDefaultUI: true,
                zoomControl: true,
                //draggable: true,
            });
        },
        confirmLocation(){
            this.$getLocation({
                enableHighAccuracy: true,
            })
            .then((coordinates) => {
                this.shopCoordinates.lat = parseFloat(coordinates.lat);
                this.shopCoordinates.lng = parseFloat(coordinates.lng);
                this.initializeMap();
                this.initMarker();
                this._geocode({ location: this.marker.getPosition(), }, this.marker);
                this.getPositionOfMarket(this.marker);
                this.initAutocomplete();
            })
            .catch(err => this._notify("error", err));
        },
        initMarker() {
            this.marker = new google.maps.Marker();
            this.marker.setDraggable(true);
            this.marker.setMap(this.map);
            this.marker.setPosition(this.shopCoordinates);
        },
        getPositionOfMarket(marker) {
            google.maps.event.addListener(marker, "dragend", ( event ) =>{
                this._geocode({ location: marker.getPosition(), }, marker);
            });
        },
        _clear() {
            this.marker.setMap(null)
        },
        _geocode(request, marker = null) {
            let geocoder = new google.maps.Geocoder();
            geocoder.geocode(request).then((response) => {
                if (response.results[0]) {
                    let isvalid = this._validateGeo(response.results[0]);
                    // console.log(`position`, response.results[0], {lat: response.results[0].geometry.location.lat(), lng: response.results[0].geometry.location.lng()})
                    // console.log(`pos`, response.results[0].geometry.location.lat(), response.results[0].geometry.location.lng())
                    if (isvalid === 'yucatan') {
                        this.changeMapPosition({ lat: 21.1116809, lng: -89.60917719999999 });
                        this.changeInputAddress(response.results[0].formatted_address);
                        this.showCheckAddress();
                        this.$emit('setAddress', response.results[0]);
                        this.$emit('setUrl', this.generateUrl({ lat: 21.1116809, lng: -89.60917719999999 }, "ChIJ0UrFhL7YVY8R-b2Uc4pUiDM"));
                    } else if (isvalid){
                        this.changeMapPosition(marker? marker.getPosition() : response.results[0].geometry.location);
                        this.changeInputAddress(response.results[0].formatted_address);
                        this.showCheckAddress(true);
                        this.$emit('setAddress', response.results[0]);
                        this.$emit('setUrl', this.generateUrl({lat: response.results[0].geometry.location.lat(), lng: response.results[0].geometry.location.lng()}, response.results[0].place_id));
                    } else {
                        //console.log('address invalid geocode', response.results[0]);
                        this.$notify({
                            group: 'bar',
                            title: 'Oops...',
                            type: 'error',
                            text: 'disculpe que por el momento no llegamos a su dirección; próximamente brindaremos nuestros servicios en esta zona. Gracias por su comprensión.',
                        });
                        // this.changeInputAddress('')
                        this.showCheckAddress(false);
                    }
                } 
            })
            .catch((e) => {
                console.error(`error geo`, e)
                this.$notify({
                    group: 'bar',
                    title: 'Oops...',
                    type: 'error',
                    text: 'Por favor corrija su dirección',
                })
            });
        },
        initAutocomplete() {
            const center = this.shopCoordinates; //this.map.getCenter();
            
            const defaultBounds = {
                north: center.lat + 0.01,
                south: center.lat - 0.01,
                east: center.lng + 0.01,
                west: center.lng - 0.01,
            };

            const input = this.$refs.autocompleteInput; //document.getElementById("autocomplete-input");
            const options = {
                bounds: defaultBounds,
                fields: ["address_components", "formatted_address", "geometry", "place_id"],
                strictBounds: false,
                types: ["establishment",],
            };
            this.autocomplete = new google.maps.places.Autocomplete(input, options);
            this.autocomplete.addListener("place_changed", this.fillInAddress)
        },
        fillInAddress() {
            const place = this.autocomplete.getPlace();
            //console.log('address', place.formatted_address)
            let isvalid = this._validateGeo(place);

            if (isvalid === 'yucatan') {
                this.changeMapPosition({ lat: 21.1116809, lng: -89.60917719999999 });
                this.showCheckAddress();
                this.$emit('setAddress', place);
                this.$emit('setUrl', this.generateUrl({ lat: 21.1116809, lng: -89.60917719999999 }, "ChIJ0UrFhL7YVY8R-b2Uc4pUiDM"));
            } else if (place.geometry && isvalid) {
                this.$emit('setAddress', place);
                this.$emit('setUrl', this.generateUrl({lat: place.geometry.location.lat(), lng: place.geometry.location.lng()}, place.place_id));
                this.changeMapPosition(place.geometry.location);
                this.map.setZoom(15);
                this.changeInputAddress(place.formatted_address);
                this.showCheckAddress(true);
            } else {
                this.changeInputAddress('');
                this.showCheckAddress(false);
                this.$notify({
                    group: 'bar',
                    title: 'Oops...',
                    type: 'error',
                    text: 'por el momento no llegamos a su dirección; próximamente brindaremos nuestros servicios en esta zona. Gracias por su comprensión.',
                });
            }
        },
        changeMapPosition(pos){
            this.marker.setPosition(pos);
            this.map.setCenter(pos);
        },
        changeInputAddress (address) {
            this.$refs.autocompleteInput.value = address;
        },
        _validateGeo(place) {
            this._hiddenMsg();
            const currentPostalCode = place.address_components.find(item => item.types.includes("postal_code"));
            const address = place.formatted_address;
            const addressNormalize = address.toLowerCase().normalize('NFD').replace(/([^n\u0300-\u036f]|n(?!\u0303(?![\u0300-\u036f])))[\u0300-\u036f]+/gi,"$1").normalize();
            //const showMsgIn = 'Yucatán Country Club'.toLowerCase().normalize('NFD').replace(/([^n\u0300-\u036f]|n(?!\u0303(?![\u0300-\u036f])))[\u0300-\u036f]+/gi,"$1").normalize();
            //Si la zona es yukatan muestro mensaje
            if (currentPostalCode.long_name == '97308') {
                document.getElementById('msg-country-club').style.display = 'block';
                this.showCheckAddress();
                return 'yucatan'
            }

            if(currentPostalCode && currentPostalCode.long_name) {
                return this.restrictions.postalCode.includes(currentPostalCode.long_name)  
                    || this.restrictions.colonia.some(item => addressNormalize.includes(item.toLowerCase()))
            } else {
                return this.restrictions.colonia.some(item => addressNormalize.includes(item.toLowerCase()))
            }
        },
        _hiddenMsg() {
            document.getElementById('msg-country-club').style.display = 'none';
            document.getElementById('msg-check-address').style.display = 'none';
        },
        showCheckAddress(show = false) {
            document.getElementById('msg-check-address').style.display = show? 'block' : 'none';
        },
        generateUrl(pos, place_id) {
            return `https://www.google.com/maps/search/?api=1&query=${pos.lat}%2C${pos.lng}&query_place_id=${place_id}`
        },
        changeAddress() {
            if (this.timer) {
                clearTimeout(this.timer);
                this.timer = null;
            }
            this.timer = setTimeout(() => {
                this.showCheckAddress(true)
                this.$emit('setAddress', this.$refs.autocompleteInput.value)
                //console.log('cambio', this.marker.getPosition(), this.$refs.autocompleteInput.value)
                this._geocode({ address: this.$refs.autocompleteInput.value })
            }, 4000);
        }
    }
}
</script>
