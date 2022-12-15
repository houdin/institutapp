<template>
    <div>
        <ul>
            <li v-for="item in $page.props.colors" :key="item.index">
                <div class="w-20 h-12" :style="`background-color: #${item.hex};`">
                    {{ item.hex }}
                </div>

            </li>
        </ul>

    </div>
</template>

<script setup lang="ts">



// const colors
// const newColors = [];


// for (let i = 0; i < colors.length; i++) {

//     let aRgbHex = ('' + colors[i]).match(/.{1,2}/g);
//     newColors[i] = {
//         index: i, color: [
//             parseInt(aRgbHex[0], 16),
//             parseInt(aRgbHex[1], 16),
//             parseInt(aRgbHex[2], 16)
//         ],
//         hex: colors[i]
//     };

// }

// newColors.sort((a, b) => {
//     return b.color.reduce((a, b) => {
//         return a + b;
//     }, 0) - a.color.reduce((a, b) => {
//         return a + b;
//     }, 0);
// })

// console.log(newColors); //[21, 2, 190]

</script>

