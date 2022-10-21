<template>
    <div>
        <user-order-item v-for="item in products"
                         :key="item.id"
                         :item="item"
                         :isForm="true">

        </user-order-item>
    </div>
</template>

<script>
    export default {
        props : [
        ],
        computed: {
            products: {
                get(){
                    return this.$store.state.Cart.products
                }
            }
        }

    }
</script>
