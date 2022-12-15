<template>
    <Teleport to="#modals">
        <div class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">

            <div :class="(modal.isOpen ? 'opacity-100' : 'opacity-0') + ' ' + classAnim"
                class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity backdrop-blur-sm overflow-hidden">
            </div>

            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div class="flex justify-center p-4 text-center sm:p-0"
                    :class="{ 'sm:items-center items-end': (modal.type !== 'search') }">

                    <div v-on:keyup.esc="modal.close()" v-click-outside="outsideClose" id="modal"
                        :class="(modal.isOpen ? 'opacity-100 translate-y-0 sm:scale-95 ' : 'opacity-0 translate-y-4 sm:translate-y-[-3rem] sm:scale-95 ') + classAnim + ' ' + modal.class"
                        class="relative transform-gpu overflow-hidden rounded-lg bg-gray-800  text-left shadow-xl transition-all border border-gray-600">


                        <div class="sm:mx-auto sm:w-full sm:max-w-md">
                            <slot name="header" />
                        </div>
                        <div class="">
                            <slot />
                        </div>

                        <div class="sm:mx-auto sm:w-full sm:max-w-md">
                            <slot name="action" />
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </Teleport>

</template>

<script setup lang="ts">

const props = defineProps({
    outside: Boolean
})

const modal = inject('modal');

const classAnim = ref('ease-out duration-500');

const outsideClose = () => {
    if (props.outside == true && modal.isOpen == true) modal.close()
}


const searchToggle = () => {
    modal.close();

};


watch(modal, (current) => {

    if (current.isOpen == true) {
        classAnim.value = 'ease-out duration-500'
    } else {
        classAnim.value = 'ease-in duration-400'
    }

})

// const backdrop = (open)=> {

// }

// var counter = 10;
// var intervalId = null;
// function finish() {
//     clearInterval(intervalId);
//     document.getElementById("bip").innerHTML = "TERMINE!";
// }
// function bip() {
//     counter--;
//     if (counter == 0) finish();
//     else {
//         document.getElementById("bip").innerHTML = counter + " secondes restantes";
//     }
// }
// function start() {
//     intervalId = setInterval(bip, 1000);
// }

</script>

