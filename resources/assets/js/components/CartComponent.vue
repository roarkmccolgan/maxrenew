<template>
    <div class="relative order-0 sm:order-1 p-1">
        <button class="relative bg-max-secondary text-white whitespace-no-wrap font-bold py-2 px-4 border-b-4 hover:border-b-2 hover:border-t-2 border-teal-darker hover:border-max-secondary rounded" @click.prevent="showHideCart()">
            <font-awesome-icon :icon="icons.cart"></font-awesome-icon>
            <span class="hidden sm:inline-block text-sm">Your Cart</span>
            <transition name="bounce" appear>
                <span class="absolute rounded-full bg-indigo uppercase px-2 py-1 text-xs font-bold pin-r pin-t -mr-2 -mt-2" v-show="Object.keys(cart.items).length">{{ Object.keys(cart.items).length }}</span>
            </transition>
        </button>
        <transition name="fade">
            <div class="absolute bg-white border shadow-lg mt-2 p-4 z-40" style="top:100%;right:0;min-width: 20rem" v-show="showCart">
                <div class="text-center" v-show="Object.keys(cart.items).length == 0">
                    No Items in your cart
                </div>
                <div class="flex flex-col">
                    <div class="flex items-start border-b py-2" v-for="(item, key) in cart.items">
                        <div class="mr-1">{{item.qty}} x</div>
                        <div class="mr-1">{{item.name}}</div>
                        <div class="flex-grow text-right">{{item.display_price}}</div>
                    </div>
                    <div v-show="Object.keys(cart.items).length">
                        <div class="flex items-start font-bold border-t border-b py-2">
                            <div class="flex-grow mr-1 text-right">Total:</div>
                            <div class="text-right">{{ cart.display_total }}</div>
                        </div>
                        <div class="flex justify-end font-bold mt-2">
                            <a v-if="!loading" href="/checkout" class="inline-block font-normal py-2 px-4 mr-2 text-grey" @click.prevent="clearCart()">Clear Cart</a>
                            <div class="inline-block font-normal py-2 px-4 mr-2 text-grey " v-else>
                                <font-awesome-icon :icon="icons.loading" class="fa-spin"></font-awesome-icon>
                            </div>
                            <a href="/checkout" class="no-underline inline-block py-2 px-4 bg-max-secondary text-white font-bold rounded">Checkout</a>
                        </div>
                    </div>
                </div>

            </div>
        </transition>
    </div>

</template>

<script>
import { library } from '@fortawesome/fontawesome-svg-core'
import { faShoppingCart } from '@fortawesome/pro-regular-svg-icons/faShoppingCart'
import { faSync } from '@fortawesome/pro-regular-svg-icons/faSync'

import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'


export default {
    props: ['cart'],
    data: function() {
        return {
            icons:{
                cart: faShoppingCart,
                loading: faSync,
            },
            showCart: false,
            loading: false,
        };
    },
    components:{
        FontAwesomeIcon
    },
    methods: {
        showHideCart: function(){
            var that = this;
            this.showCart = !this.showCart;
                //setTimeout(function(){ that.showCart = false }, 6000);
            },
            clearCart: function(){
                var that = this;
                that.loading = true;
                axios.get('/api/clearcart')
                .then(function (response) {
                    that.loading = false;
                    that.showCart = false;
                    that.$emit('clear');
                    that.$swal('Success','Cart Cleared','success');
                })
                .catch(function (error) {
                    console.log(error);
                    that.$swal('Error','Unable to clear cart','error');
                });
            }
        },
        created () {
            var that = this;
            /*document.addEventListener('click', function(event){
                that.showCart = false;
            });*/
        },
        destroyed () {
            
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
    </script>
