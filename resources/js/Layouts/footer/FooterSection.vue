<template>

    <div class="footer-menu ms-0 col-lg-3 col-md-3 col-sm-12 flex-grow-1 flex-lg-grow-0 flex-lg-shrink-1">
        <div class="footer-section">
            <h2 class="widget-title">{{ title }}</h2>
            <ul class="list-inline">
                <li v-for="(value, index) in $page.props.app.footer_menus[title]" :key="index">
                    <!-- <a href="{{$item['link']}}"><i class="fas fa-caret-right"></i>{{$item['label']}}</a> -->
                    <Link :href="'/' + value" :id="'menu-' + value" class=""><i class="fas fa-caret-right"></i>{{ index
                    }}
                    </Link>
                </li>
            </ul>
        </div>
    </div>

</template>
<script setup lang="ts">

const props = defineProps(["title"]);


</script>
