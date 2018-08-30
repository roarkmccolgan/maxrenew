
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

 require('./bootstrap');

window.Vue = require('vue');
import InstantSearch from 'vue-instantsearch'
import { createFromAlgoliaCredentials } from 'vue-instantsearch';
import VueSweetalert2 from 'vue-sweetalert2';

import { library } from '@fortawesome/fontawesome-svg-core'
import { faSearch } from '@fortawesome/pro-regular-svg-icons/faSearch'
import { faTimes } from '@fortawesome/pro-regular-svg-icons/faTimes'
import { faSync } from '@fortawesome/pro-regular-svg-icons/faSync'
import { faShoppingCart } from '@fortawesome/pro-regular-svg-icons/faShoppingCart'
import { faMousePointer } from '@fortawesome/pro-regular-svg-icons/faMousePointer'
import { faSquare } from '@fortawesome/pro-regular-svg-icons/faSquare'
import { faCheckSquare } from '@fortawesome/pro-regular-svg-icons/faCheckSquare'
import { faAngleRight } from '@fortawesome/pro-regular-svg-icons/faAngleRight'
import { faCheck } from '@fortawesome/pro-regular-svg-icons/faCheck'
import { faFilePdf } from '@fortawesome/pro-regular-svg-icons/faFilePdf'
import { Carousel, Slide } from 'vue-carousel';

import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

import {Tabs, Tab} from 'vue-tabs-component';
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

 Vue.use(InstantSearch);
 Vue.use(VueSweetalert2);

 const searchStore = createFromAlgoliaCredentials('9PJ4YRKD8R', '70da05b28f4fcec86d4d4197851214af');
 searchStore.indexName = 'maxrenew';

 Vue.component('example-component', require('./components/ExampleComponent.vue'));
 var CartComponent = require('./components/CartComponent.vue');
 var QuestionComponent = require('./components/QuestionComponent.vue');
 var ContactComponent = require('./components/ContactComponent.vue');
 Vue.component('tabs', Tabs);
 Vue.component('tab', Tab);

 const home = new Vue({
    el: '#app',
    data: {
        searchStore,
        icons:{
            search: faSearch,
            times: faTimes,
            cart: faShoppingCart,
            mouse: faMousePointer,
            loading: faSync,
            faSquare: faSquare,
            faCheckSquare: faCheckSquare,
            faAngleRight: faAngleRight,
            faCheck: faCheck,
            faFilePdf: faFilePdf,
        },
        user: window.user ? window.user : false,
        showAskQuestion: false,
        product: {
            sku: window.product ? window.product.sku : false,
            id: window.product ? window.product.id : false,
            name: window.product ? window.product.name : false,
            price: window.product ? window.product.price : false,
            display_price: false,
            price_install: window.product ? window.product.price_install : false,
            display_price_install: false,
            path: window.product ? window.product.path : false,
            strapline: window.product ? window.product.strapline : false,
            questions: window.product && window.product.questions ? window.product.questions : {},
            qty: 1,
            install: false,
        },
        cart: window.cart ? window.cart : {items:{},total:0,display_total: 'R0,00'},
        busyAdding: false,
        busySaving: false,
        wizard: {
            same: false,
            basic: {
                'fname': window.checkout && window.checkout.basic && window.checkout.basic.fname ? window.checkout.basic.fname: '',
                'lname': window.checkout && window.checkout.basic && window.checkout.basic.lname ? window.checkout.basic.lname: '',
                'email': window.checkout && window.checkout.basic && window.checkout.basic.email ? window.checkout.basic.email: '',
                'telephone': window.checkout && window.checkout.basic && window.checkout.basic.telephone ? window.checkout.basic.telephone: '',
                'mobile': window.checkout && window.checkout.basic && window.checkout.basic.mobile ? window.checkout.basic.mobile: '',
                'company': window.checkout && window.checkout.basic && window.checkout.basic.company ? window.checkout.basic.company: '',
                'vat': window.checkout && window.checkout.basic && window.checkout.basic.vat ? window.checkout.basic.vat: '',
                'password': '',
                'repeatpass': '',
            },
            billing: {
                'building': window.checkout && window.checkout.billing && window.checkout.billing.building ? window.checkout.billing.building: '',
                'address1': window.checkout && window.checkout.billing && window.checkout.billing.address1 ? window.checkout.billing.address1: '',
                'address2': window.checkout && window.checkout.billing && window.checkout.billing.address2 ? window.checkout.billing.address2: '',
                'address3': window.checkout && window.checkout.billing && window.checkout.billing.address3 ? window.checkout.billing.address3: '',
                'city': window.checkout && window.checkout.billing && window.checkout.billing.city ? window.checkout.billing.city: '',
                'province': window.checkout && window.checkout.billing && window.checkout.billing.province ? window.checkout.billing.province: '',
                'postal': window.checkout && window.checkout.billing && window.checkout.billing.postal ? window.checkout.billing.postal: '',
            },
            delivery: {
                'building': window.checkout && window.checkout.delivery && window.checkout.delivery.building ? window.checkout.delivery.building: '',
                'address1': window.checkout && window.checkout.delivery && window.checkout.delivery.address1 ? window.checkout.delivery.address1: '',
                'address2': window.checkout && window.checkout.delivery && window.checkout.delivery.address2 ? window.checkout.delivery.address2: '',
                'address3': window.checkout && window.checkout.delivery && window.checkout.delivery.address3 ? window.checkout.delivery.address3: '',
                'city': window.checkout && window.checkout.delivery && window.checkout.delivery.city ? window.checkout.delivery.city: '',
                'province': window.checkout && window.checkout.delivery && window.checkout.delivery.province ? window.checkout.delivery.province: '',
                'postal': window.checkout && window.checkout.delivery && window.checkout.delivery.postal ? window.checkout.delivery.postal: '',
            },
            currentStep:1,
            steps: {
                1: {
                    required: {
                        'fname': {
                            min: 1
                        },
                        'lname': {
                            min: 1
                        },
                        'email': {
                            type: 'email'
                        },
                        'telephone': {
                            type: 'tel'
                        },
                        'password': {
                            type: 'tel',
                            min: 6
                        },
                        'repeatpass': {
                            equals: 'password'
                        },
                    },
                    complete: false,
                    errors: {
                        'fname':false,
                        'lname':false,
                        'email':false,
                        'telephone':false,
                        'password':false,
                        'repeatpass':false,
                    },
                },
                2: {
                    required: {
                        'delivery_address1': {
                            min: 9
                        },
                        'delivery_address2': {
                            min: 3
                        },
                        'delivery_city': {
                            min: 5
                        },
                        'delivery_province': {
                            min: 5
                        },
                        'delivery_postal': {
                            min: 3
                        }
                    },
                    complete: false,
                    errors: {
                        'delivery_address1': false,
                        'delivery_address2': false,
                        'delivery_city': false,
                        'delivery_province': false,
                        'delivery_postal': false,
                    },
                },
                3: {
                    required: {
                        'billing_address1': {
                            min: 9
                        },
                        'billing_address2': {
                            min: 3
                        },
                        'billing_city': {
                            min: 5
                        },
                        'billing_province': {
                            min: 5
                        },
                        'billing_postal': {
                            min: 3
                        }
                    },
                    complete: false,
                    errors: {
                        'billing_address1': false,
                        'billing_address2': false,
                        'billing_city': false,
                        'billing_province': false,
                        'billing_postal': false,
                    },
                },
            },
            buttonText: 'Next',
            complete: false
        },
    },
    components: {
        FontAwesomeIcon,
        CartComponent,
        ContactComponent,
        QuestionComponent,
        Carousel,
        Slide
    },
    methods: {
        clearCart: function(){
            this.cart = {items:{},total:0,display_total: 'R0,00'};
        },
        addToCart: function(){
            var that = this;
            that.busyAdding = true;
            axios.post('/api/cart', that.product)
            .then(function (response) {
                setTimeout(function(){
                    that.cart = response.data.cart;
                    that.busyAdding = false;
                },2000);
            })
            .catch(function (error) {
                console.log(error);
            });
        },
        validate: function(step,id){
            var el = document.getElementById(id);
            var curStep = this.wizard.steps[step];
            var validation = curStep.required[id];

            var needsValidation = curStep.required[id]
            if(needsValidation && el){
                this.wizard.steps[step].errors[id] = false;

                if(el.value.trim() == ''){
                    this.wizard.steps[step].errors[id] = true;
                }
                var min = validation.min ? validation.min : 1;
                var max = validation.max ? validation.max : false;
                if(el.value.trim().length < min){
                    this.wizard.steps[step].errors[id] = true;
                }
                if(max!==false && el.value.trim().length > max){
                    this.wizard.steps[step].errors[id] = true;
                }
                var equals = validation.equals ? validation.equals : false;
                if(equals && el.value.trim() !== document.getElementById(equals).value.trim()){
                    this.wizard.steps[step].errors[id] = true;
                }
            }
        },
        checkStep: function(step){
            console.log(step);
            for (var required in this.wizard.steps[step].required) {
                this.validate(step, required);
            }
            var noErrors = true;
            for (var error in this.wizard.steps[step].errors) {
                noErrors = !this.wizard.steps[step].errors[error];
            }
            if(noErrors){
                this.saveCheckout(step);
            }
        },
        setSame: function(event){
            console.log(event.target.checked);
            if(event.target.checked){
                var that = this;
                this.wizard.billing = this.wizard.delivery;
            }else{
                this.wizard.billing = {'building': '', 'address1': '', 'address2': '', 'city': '', 'province': '', 'postal': '' };
            }
        },
        saveCheckout: function(step){
            var that = this;
            that.busySaving = true;
            axios.post('/api/checkout', that.wizard)
            .then(function (response) {
                setTimeout(function(){
                    that.wizard.currentStep = Number(step+1);
                    that.busySaving = false;
                    if(step === 3){
                        that.wizard.complete = true;
                        return;
                    }
                },500);
            })
            .catch(function (error) {
                console.log(error);
            });
        },
    },
    mounted: function(){
        var that = this;
        if(this.$refs.autocomplete){
            var componentForm = {
                delivery_address1: 'short_name',
                delivery_address2: 'long_name',
                delivery_address3: 'long_name',
                delivery_city: 'long_name',
                delivery_province: 'long_name',
                delivery_postal: 'long_name'
            };
            this.autocomplete = new google.maps.places.Autocomplete(
                (this.$refs.autocomplete),
                {
                    types: ['geocode'],
                    componentRestrictions: {country: "za"}
                }
            );
            this.autocomplete.addListener('place_changed', () => {
                let place = this.autocomplete.getPlace();
                console.log(place);
                for (var component in componentForm) {
                    document.getElementById(component).value = '';
                    document.getElementById(component).disabled = false;
                }
                var streetNumber = '';
                var streetName = '';
                for (var i = 0; i < place.address_components.length; i++) {
                    var addressType = place.address_components[i].types[0];
                    if (addressType == 'street_number') {
                        streetNumber = place.address_components[i]['short_name'];
                    }
                    if (addressType == 'route') {
                        streetName = place.address_components[i]['long_name'];
                    }
                    if (addressType == 'sublocality_level_1' || addressType == 'sublocality') {
                        that.wizard.delivery.address2 = place.address_components[i]['long_name'];
                    }
                    if (addressType == 'locality' || addressType == 'political') {
                        that.wizard.delivery.city = place.address_components[i]['long_name'];
                    }
                    if (addressType == 'administrative_area_level_1') {
                        that.wizard.delivery.province = place.address_components[i]['long_name'];
                    }
                    if (addressType == 'postal_code') {
                        that.wizard.delivery.postal = place.address_components[i]['long_name'];
                    }
                }
                that.wizard.delivery.address1 = streetNumber+' '+streetName;
            });
        }else{
            console.log('noref')
        }
    }
});
