<script setup lang="ts">

defineProps({
    modelValue: String,
});

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input ref="input"
        class="border-gray-500 focus:border-indigo-300 focus:ring focus:ring-indigo-200 bg-gray-600 text-gray-300 focus:ring-opacity-50 rounded-full shadow-sm"
        :value="modelValue" @input="$emit('update:modelValue', $event.target.value)">
</template>
