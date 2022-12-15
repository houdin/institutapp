<template>
    <div class="shopping-cart-form" :product-id="productId" :type="type">
        <button class="btn btn-sm shadow-none bg-gray-7 border-gray-5" @click="getNow">
            <span v-if="cartText" class="color-gray-4">Obtenir</span>
            <material-icon v-else name="CartOutline" size="1.5em" classes="color-base-1"></material-icon>
        </button>
    </div>
</template>

<script setup lang="ts">


// const cart = reactive({});

const props = defineProps({
    productId: {
        type: Number,
    },
    type: {
        type: String,
    },
    cartText: {
        type: Boolean,
        default: false,
    },
});

// const postData = {
//   product_id: props.productId,
//   type: props.type,
// };
const emit = defineEmits(["getnow", "update-user-message"]);
//const emit = defineEmits(["add-to-cart"]);

const getNow = async (url, data) => {
    try {
        const res = await axios.post(url, data);
        if (res.data.success) {
            emit("getnow", true);
        }
        emit("update-user-message", response.data.message);
    } catch (error) { }
};
</script>
