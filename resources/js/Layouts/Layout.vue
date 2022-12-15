<template>

    <Head>
        <title>{{ $page.props.title?.title ? $page.props.title.title : 'Default Title FXinstitut' }}</title>
        <meta name="description" content="This is the description for my App" head-key="description">
    </Head>

    <NavMenuHeader />


    <main class=" relative min-h-screen">
        <div class="relative fx-logo-icon" :class="animator ? slideAnimSmall : ''">
            <svg id="bg-logo-icon"
                class="absolute drop-shadow-[0_35px_35px_rgba(0,0,0,0.1)] left-[50%] translate-x-[-50%] -top-[7rem] text-blender"
                style="width:50rem; height:40rem;">
                <use xlink:href="/sprite.svg?logo#logo-icon"></use>
            </svg>
        </div>

        <JetBanner
            :classes="`sticky top-14 z-30 transition duration-500 ease-in-out ${hideNavbar ? '-translate-y-14' : 'translate-y-0'}`" />
        <AppBanner
            :classes="`sticky top-14 z-30 transition duration-500 ease-in-out ${hideNavbar ? '-translate-y-14' : 'translate-y-0'}`" />

        <div id="page-loader" v-show="showLoading" class="w-full h-full absolute d-slide-big z-20"
            :class="animator ? slideAnimBig : ''">
            <!-- <div class="radial-progress" style="--value:70; --size:12rem; --thickness: 2rem;">70%</div> -->
            <loader />
        </div>
        <div class="container _breadcrumbs min-h-16 flex mx-auto items-center relative z-20">
            <Breadcrumbs v-if="(!route().current('frontend.index'))">
            </Breadcrumbs>
        </div>


        <!-- <transition name="slide-fade"> -->
        <transition @after-enter="onAfterEnter" @after-leave="onAfterLeave" @before-leave="onBeforeLeave"
            @before-appear="onBeforeAppear" @before-enter="onBeforeEnter" @enter="onEnter" @leave="onLeave"
            name="custom-classes" mode="out-in" :duration="800" :enter-active-class="enterClass"
            :leave-active-class="leaveClass" appear>
            <div :key="$page.url" ref="container" class="container _content mx-auto relative z-20 pt-5">

                <slot />
            </div>
        </transition>
    </main>


    <div ref="Modalcontainer" id="modals" class="hidden relative z-50">

    </div>

    <FooterApp></FooterApp>

    <!-- <main>

        <slot />
    </main> -->
</template>


<script setup lang="ts">


import Modal from '@/types/modalType';
import useModal from '@/modules/modal';

const modalProp = computed(() => usePage().props.value.app.modal);

const hideNavbar = ref(false);

const Modalcontainer = ref(null);
const container = ref(null);
const transition = ref('enter');

const modal: Modal = reactive(useModal)

// const containerClassList = computed(() => container.value);

const breadcrumbs = shallowRef([]);
const routeBack = ref(false);

const animator = ref(false)


const onBeforeAppear = (el) => {
}


const onBeforeLeave = (el) => {
    transition.value = 'leave';
    animator.value = true;
    // console.log('//// BEFORE LEAVE ///')
}
const onLeave = (el) => {
    // console.log('//// ON LEAVE ///')
}
const onBeforeEnter = (el) => {
    // console.log('//// BEFORE ENTER ///')
}
const onAfterLeave = async (el) => {
    transition.value = 'enter'
    // console.log('//// AFTER LEAVE ///')
}
const onEnter = (el) => {
    // console.log('//// ON ENTER ///')
}
const onAfterEnter = async (el) => {
    animator.value = false
    routeBack.value = false
    // console.log('//// AFTER ENTER ///')
}



const enterClass = ref("__anim animate__fadeInRight");
const leaveClass = ref("__anim animate__fadeOutLeft");


watch([routeBack, transition], ([routeVal, transitionVal]) => {
    if (routeVal === false) {
        enterClass.value = "__anim animate__fadeInRight";
        leaveClass.value = "__anim animate__fadeOutLeft";

    } else {
        enterClass.value = "__anim animate__fadeInLeft";
        leaveClass.value = "__anim animate__fadeOutRight";
    }
})


const slideAnimBig = ref("__anim __slideEnterBigNext");
const slideAnimSmall = ref("__anim __slideEnterNext");

watch(transition, (transitionVal) => {

    if (routeBack.value === false) {
        if (transitionVal === 'enter') {
            slideAnimSmall.value = "__anim __slideEnterNext";
            slideAnimBig.value = "__anim __slideEnterBigNext";
        } else if (transitionVal === 'leave') {
            slideAnimSmall.value = "__anim __slideLeaveNext";
            slideAnimBig.value = "__anim __slideLeaveBigNext";
        }
    } else {

        if (transitionVal === 'enter') {
            slideAnimSmall.value = "__anim __slideEnterPrev";
            slideAnimBig.value = "__anim __slideEnterBigPrev";
        } else if (transitionVal === 'leave') {
            slideAnimSmall.value = "__anim __slideLeavePrev";
            slideAnimBig.value = "__anim __slideLeaveBigPrev";
        }
    }
})


onMounted(() => {

    modal.container = Modalcontainer.value;


});


watch(modalProp, (val) => {
    if (val?.open === false) modal.close();
    if (val?.open === true && val?.type === 'auth') modal.auth()

})

const showLoading = ref(false);

const EventStart = ref(false);


Inertia.on('start', (event) => {
    // console.log(Inertia);
    showLoading.value = true;
    modal.redirect = event.detail.visit.url.pathname;
    EventStart.value = true;
})

if (!EventStart.value) {

    Inertia.on('finish', (event) => {
        // console.log(event)
        showLoading.value = false;
        modal.close();
    })
}

if (!EventStart.value) {
    modal.redirect = window.location.pathname
}


Inertia.on('navigate', (event) => {
    modal.reset()
    // console.log(event.detail.page.url);
})


provide('modal', modal)
provide('routeBack', routeBack)
provide('breadcrumbs', breadcrumbs)
provide('hideNavbar', hideNavbar)

</script>

<style lang="scss">
body.modal-open {
    overflow: hidden;
}
</style>

