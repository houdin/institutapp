<template>
    <div class="row">
        <div class="col-sm-12 col-sm-offset-1">
            <ul class="progress-step-bar">
                <!-- <li v-for="(item,index) in list" :key="index"
                    :class="[getClass(item.step, item.complete)]"
                    @click="updateCurrent(item.step)">
                    {{ item.name }}
                </li> -->
                <li
                    >
                    <router-link to="/order/order-edit">order-edit</router-link>
                    <router-link to="/order/select-address">select-address</router-link>
                    <router-link to="/order/payment">payment</router-link>
                    <router-link to="/order/invoice">Invoice</router-link>

                </li>
            </ul>
        </div><!-- /.col -->
    </div><!-- /.row -->
</template>

<script>
    export default {
        props : [
            'current', 'list'
        ],

        methods: {
            /**
             * gets the class based on the step and if its complete
             * @param step
             * @param complete
             * @return {string}
             */
            getClass(step, complete) {
                if(step === this.current) {
                    return 'active';
                }
                if(complete && step !== this.current) {
                    return 'complete'
                }
                if(!complete && step < this.current && step !== this.current) {
                    return 'incomplete';
                }
                return '';
            },

            /**
             * update the current
             * @param current
             * @return {void}
             */
            updateCurrent(current) {
                this.$emit('update-current', current)
            }
        }
    }
</script>


