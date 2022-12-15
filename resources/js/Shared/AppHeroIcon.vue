<template>
    <Component
        :is="solid ? heroIconsSolid[icon ? icon : $helpers.Utility.rewriter(getHeroIcon(item))] : heroIcons[icon ? icon : $helpers.Utility.rewriter(getHeroIcon(item))]"
        :class="`flex-shrink-0 ${color} ${size} stroke-${stroke}`" aria-hidden="true" />

</template>

<script setup lang="ts">

import getHeroIcon from '@/modules/HeroIcons';
import * as heroIcons from '@heroicons/vue/24/outline';
import * as heroIconsSolid from '@heroicons/vue/24/solid';


const props = defineProps({
    item: {
        type: String,
        default: 'CubeIcon'
    },
    size: {
        type: String,
        default: 'h-6 w-6'
    },
    stroke: {
        type: String,
        default: '2'
    },
    color: {
        type: String,
        default: 'text-yellow-500'
    },
    solid: Boolean,
    icon: String
})



</script>

