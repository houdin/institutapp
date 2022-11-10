<template>
    <!-- @if(is_array($item) ) -->

    <li v-if="typeof item == 'object'">
        <a class="" :id="'menu-' +item" :href="item.link">{{ item.label }}</a>
        <ul class="depth-1">
            <nav-dropdown  v-for="(item2, index3) in item" :key="index3" :item="item2" :label="index3" :home="home" ></nav-dropdown>
            <!-- @foreach($item->subs as $item)
                @include('frontend.layouts.partials._dropdown', $item)
            @endforeach -->

        </ul>
    </li>

    <li v-else>
        <router-link :to="'/'+item" :id="'menu-' + item" class="">{{label}}</router-link>
    </li>


</template>

<script>
export default {
    props: [
        'item',
        'label',
        'home'
    ],

    data(){
        return{}
    },
}
</script>
