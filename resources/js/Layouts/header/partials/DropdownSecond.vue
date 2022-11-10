<template>
     <li class="nav-item">
         <router-link :to="'/'+item" class="nav-link">{{label}}</router-link>
     <!-- <a :href="home + '/' + item" class="nav-link ">{{label}}</a> -->
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
