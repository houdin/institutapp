<template>
  <div v-if="mediaVideo != null && (mediaVideo.length > 0)" class="crs-single-text">

    <div v-if="mediaVideo != ''" class="crs-details-content mt-3">
      <div class="video-container mb-5" :data-id="mediaVideo.id">

        <div v-if="mediaVideo.type == 'youtube'" id="player" class="js-player" data-plyr-provider="youtube" :data-plyr-embed-id="mediaVideo.file_name"></div>

        <div v-if="mediaVideo.type == 'vimeo'" id="player" class="js-player" data-plyr-provider="vimeo" :data-plyr-embed-id="mediaVideo.file_name"></div>

        <video v-if="mediaVideo.type == 'upload'" poster="" id="player" class="js-player" playsinline controls>
          <source :src="mediaVideo.url" type="video/mp4" />
        </video>
        <template v-if="mediaVideo.type == 'embed'">
          {{ mediaVideo.url }}
        </template>

      </div>
    </div>

  </div>
</template>

<script>
export default {
  props: ["mediaVideo"],
};
</script>


