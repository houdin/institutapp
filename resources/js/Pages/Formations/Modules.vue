<template>

  <!-- {{--<link rel="stylesheet" href="{{asset('plugins/YouTube-iFrame-API-Wrapper/css/main.css')}}">--}} -->

  <!-- Start of formation details section
        ============================================= -->

  <div class="row main-content">
    <div class="col-md-9">
      <!-- @if(session()->has('success'))
            <div class="alert alert-dismissable alert-success fade show">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              {{session('success')}}
            </div>
            @endif -->

      <!-- <alert-message></alert-message> -->

      <div class="formation-details-item border-bottom-0 mb-0">
        <div v-if="module.image" class="formation-single-pic mb30">
          <img :src="$filters.Image.featuredImageUrl(module.image, 5)" :alt="module.title">
        </div>
        <template v-if="test_exists">

          <div class="formation-single-text">
            <div class="formation-title mt10 headline position-relative">
              <h3>
                <b>
                  {{ trans.get('labels.frontend.formation.test') }}
                  : {{ module.title }}</b>
              </h3>
            </div>
            <div class="formation-details-content">
              <p> {{ module.full_text }} </p>
            </div>
          </div>
          <hr />
          <!-- @if (!is_null($test_result)) -->
          <template v-if="test_result !== null">

            <div class="alert alert-info">{{ trans.get('labels.frontend.formation.your_test_score') }}
              : {{ test_result.test_result }}</div>
            <Form v-if="$filters.config('retest')" @submit="onSubmit" :validation-schema="schema" id="loginForm"
              class="contact_form">
              <input type="hidden" name="result_id" :value="test_result.id">
              <button type="submit" class="btn gradient-bg font-weight-bold text-white" href="">
                {{ trans.get('labels.frontend.formation.give_test_again') }}
              </button>
            </Form>

            <template v-if="module.question.length > 0">

              <hr>

              <template v-for="(question, index) in module.question" :key="index">

                <h4 class="mb-0">{{ index + 1 }}
                  . {{ question.question }}
                  <small v-if="isAttempted(question.id, test_result.id)" class="badge badge-danger"> {{
                      trans.get('labels.frontend.formation.not_attempted')
                  }}</small>
                </h4>
                <br />
                <ul class="options-list ps-4">

                  <li v-for="(option, index) in question.options" :key="index"
                    :class="((answered(option.id, test_result.id) != null && answered(option.id, test_result.id) == 1) || (option.correct == true)) ? 'correct' : ((answered(option.id, test_result.id) != null && answered(option.id, test_result.id) == 2) ? 'incorrect' : '')">
                    {{ option.option_text }}

                    <p v-if="option.correct == 1 && option.explanation != null" class="text-dark">
                      <b></b><br>
                      {{ trans.get('labels.frontend.formation.explanation') }}
                      {{ option.explanation }}
                    </p>
                  </li>

                </ul>
                <br />
              </template>

            </template>
            <h3 v-else>{{ trans.get('labels.general.no_data_available') }}</h3>
          </template>

          <!-- if Test result -->
          <div v-else class="test-form">
            <Form v-if="module.questions.length > 0" @submit="onSubmit" :validation-schema="schema" id="loginForm"
              class="contact_form">

              <template v-for="(question, index) in module.questions" :key="index">
                <h4 class="mb-0">{{ index }}. {{ question.question }} </h4>
                <br />
                <div v-for="(option, ind) in question.options" :key="ind" class="form-group">

                  <div class="mb-2">
                    <label>{{ option.option_text }}</label>
                    <Field id="email" type="radio" :name="questions[question.id]" class="form-control mb-0 ps-5"
                      :value="option.id" v-model="email"></Field>
                    <span class="cr"><i class="cr-icon fa fa-circle"></i></span>
                    <ErrorMessage name="email" v-slot="{ message }">
                      <span class="text-danger special-danger" id="email-error">
                        {{ message }}
                      </span>
                    </ErrorMessage>
                  </div>
                </div>
                <br />
                <input class="btn gradient-bg text-white font-weight-bold" type="submit"
                  value=" {{ trans.get('labels.frontend.formation.submit_results') }} " />
              </template>
            </Form>

            <h3 v-else>{{ trans.get('labels.general.no_data_available') }}</h3>

          </div>
          <hr />
        </template>
        <!-- if Test exists -->
        <div v-else class="formation-single-text">
          <div class="formation-title mt10 headline position-relative">
            <h3>
              <b>{{ module.title }}</b>
            </h3>
          </div>
          <div class="formation-details-content">
            {{ module.full_text }}
          </div>
        </div>

        <div v-if="module.mediaPDF" class="formation-single-text mb-5">
          <!-- <iframe src="{{asset('storage/uploads/'.$module->mediaPDF->name)}}" width="100%"
          height="500px">
          </iframe> -->
          <div id="myPDF"></div>

        </div>

        <div v-if="module.mediaVideo && module.mediavideo.count > 0" class="formation-single-text">
          <div v-if="module.mediavideo != ''" class="formation-details-content mt-3">
            <div class="video-container mb-5" :data-id="module.mediavideo.id">

              <div v-if="module.mediavideo.type == 'youtube'" id="player" class="js-player" data-plyr-provider="youtube"
                :data-plyr-embed-id="module.mediavideo.file_name"></div>
              <div v-else-if="module.mediavideo.type == 'vimeo'" id="player" class="js-player"
                data-plyr-provider="vimeo" :data-plyr-embed-id="module.mediavideo.file_name"></div>
              <video v-else-if="module.mediavideo.type == 'upload'" poster="" id="player" class="js-player" playsinline
                controls>
                <source :src="module.mediavideo.url" type="video/mp4" />
              </video>
              <template v-else-if="module.mediavideo.type == 'embed'">
                {{ module.mediavideo.url }}
              </template>
            </div>
          </div>
        </div>

        <div v-if="module.mediaAudio" class="formation-single-text mb-5">
          <audio id="audioPlayer" controls>
            <source :src="module.mediaAudio.url" type="audio/mp3" />
          </audio>
        </div>

        <div v-if="(module.downloadableMedia != '') && (module.downloadableMedia.count > 0)"
          class="formation-single-text mt-4 px-3 py-1 gradient-bg text-white">
          <div class="formation-title mt10 headline position-relative">
            <h4 class="text-white">
              {{ trans.get('labels.frontend.formation.download_files') }}
            </h4>
          </div>

          <div v-for="(media, index) in module.downloadableMedia" :key="index"
            class="formation-details-content text-white">
            <p class="form-group">
              <router-link :to="{ name: 'download', params: { filename: media.name, module: module.id } }"
                class="text-white font-weight-bold"><i class="fa fa-download"></i> {{ media.name }}
                ({{ $filters.Utility.number_format(parseFloat(media.size) / 1024) }} {{
                    trans.get('labels.frontend.formation.mb')
                }}
                )</router-link>

            </p>
          </div>
        </div>
      </div>
      <!-- /formation-details -->

      <!-- /market guide -->

      <!-- /review overview -->
    </div>

    <div class="col-md-3">
      <!-- <sidebar-module></sidebar-module> -->
    </div>
  </div>

</template>

<script setup lang="ts">
import { useRoute } from "vue-router";
import { ref } from "@vue/reactivity";
import { inject, onBeforeMount, onMounted } from "@vue/runtime-core";

console.log(this);
import Ply from "plyr";

// import "sticky-kit/dist/sticky-kit";

// import "./../../../../public/plugins/touchpdf-master/pdf.compatibility";
// import "./../../../../public/plugins/touchpdf-master/pdf";
// import "./../../../../public/plugins/touchpdf-master/jquery.touchSwipe";
// import "../../../../public/plugins/touchpdf-master/jquery.panzoom";
// import "../../../../public/plugins/touchpdf-master/jquery.mousewheel";
// import "./../../../../public/plugins/touchpdf-master/jquery.touchPDF";

import Cookies from "js-cookie";

const $filters = inject("$filters");

const route = useRoute();

const data = ref({});

const module = ref([]);

const previous_module = ref([]);
const next_module = ref([]);

const purchased_formation = ref(0);

const modules = ref([]);
const completed_modules = ref([]);
const test_result = ref([]);
const test_exists = ref([]);

/////  INITIAL /////
const storedDuration = ref(0);
const storedModule = ref(null);
const user_module = ref(null);

const student_role = ref(false);

//// END INITIAL //////

onBeforeMount(async () => {
  student_role.value = await $filters.Auth.student_role();
  await getModule();
});

onMounted(async () => {
  //   media_PDF();

  storedDuration.value = Cookies.get(
    "duration_" +
      $filters.Auth.user().id +
      "_" +
      module.value.id +
      "_" +
      module.value.formation.id
  );
  storedModule.value = Cookies.get(
    "module" +
      $filters.Auth.user().id +
      "_" +
      module.value.id +
      "_" +
      module.value.formation.id
  );

  if (parseInt(storedModule.value) != parseInt(module.value.id)) {
    Cookies.set("module", parseInt(module.value.id));
  }

  media_player();

  $("#sidebar").stick_in_parent();
});

const getModule = async () => {
  try {
    const response = await axios.get(
      Laravel.urls.module_show
        .replace(":formation_id", route.params.formation_id)
        .replace(":slug", route.params.slug)
    );
    data.value = response.data;
    module.value = response.data.module;
    test_result.value = response.data.test_result;
    test_exists.value = response.data.test_exists;

    previous_module.value = response.data.previous_module;
    next_module.value = response.data.next_module;

    purchased_formation.value = response.data.purchased_formation;

    modules.value = response.data.modules;
    completed_modules.value = response.data.completed_modules;
  } catch (error) {}
};

const isAttempted = async (question_id, result_id) => {
  try {
    let url = Laravel.urls.module.question.result.replace(
      ":question_id",
      question_id
    );
    url = url.replace(":result_id", result_id);
    const res = await axios.get(url);
    return res;
  } catch (error) {}
};
const answered = async (option_id, result_id) => {
  try {
    let url = Laravel.urls.module.option.result.replace(
      ":option_id",
      option_id
    );
    url = url.replace(":result_id", result_id);
    const res = await axios.get(url);
    return res;
  } catch (error) {}
};
const getProgress = async (option_id, result_id) => {
  try {
    let url = Laravel.urls.module.media.progress.replace(
      ":option_id",
      option_id
    );
    url = url.replace(":result_id", result_id);
    const res = await axios.get(url);
    return res;
  } catch (error) {}
};

// const media_PDF = () => {
//   if (module.value.mediaPDF) {
//     $(function () {
//       $("#myPDF").pdf({
//         source: $filters.asset(
//           "storage/uploads/modules/" + module.value.mediaPDF.name
//         ),
//         loadingHeight: 800,
//         loadingWidth: 800,
//         loadingHTML: "",
//       });
//     });
//   }
// };

const media_player = () => {
  if (module.value.mediaVideo && module.value.mediaVideo.type != "embed") {
    var current_progress = 0;

    if (module.value.mediaVideo.getProgress($filters.Auth.user().id) != "") {
      current_progress = module.value.mediaVideo.getProgress(
        $filters.Auth.user().id
      ).progress;
    }

    const player2 = new Plyr("#audioPlayer");

    const player = new Plyr("#player");
    duration = 10;
    var progress = 0;
    var video_id = $("#player").parents(".video-container").data("id");
    player.on("ready", (event) => {
      player.currentTime = parseInt(current_progress);
      duration = event.detail.plyr.duration;

      if (!storedDuration || parseInt(storedDuration) === 0) {
        Cookies.set(
          "duration_" +
            $filters.Auth.user().id +
            "_" +
            module.value.id +
            "_" +
            module.value.formation.id,
          duration
        );
      }
    });

    // if (!storedDuration || (parseInt(storedDuration) === 0)) {
    // Cookies.set("duration_" + $filters.Auth.user().id + "_" + module->id + "_" + module.value.formation.id, player.duration);
    // }

    setInterval(async () => {
      player.on("timeupdate", (event) => {
        if (
          parseInt(current_progress) > 0 &&
          parseInt(current_progress) < parseInt(event.detail.plyr.currentTime)
        ) {
          progress = current_progress;
        } else {
          progress = parseInt(event.detail.plyr.currentTime);
        }
      });
      if (duration !== 0 || parseInt(progress) !== 0) {
        saveProgress(video_id, duration, parseInt(progress));
      }
    }, 3000);

    const saveProgress = (id, duration, progress) => {
      axios
        .post(Laravel.urls.update_video_progress, {
          video: parseInt(id),
          duration: parseInt(duration),
          progress: parseInt(progress),
        })
        .then((response) => {
          if (progress === duration) {
            location.reload();
          }
        });
    };

    $("#notice").on("hidden.bs.modal", function () {
      location.reload();
    });
  }
};

const moduleTimer = () => {
  if ($filters.config("module_timer") != 0) {
    //Next Button enables/disable according to time

    var readTime, totalQuestions, testTime;
    user_module = Cookies.get(
      "user_module_" +
        $filters.Auth.user().id +
        "_" +
        module.value.id +
        "_" +
        module.value.formation.id
    );

    if (test_exists.value) {
      totalQuestions = module.value.questions.length;
      readTime = parseInt(totalQuestions) * 30;
    } else {
      readTime = parseInt(module.value.read_time) * 60;
    }

    if (!module.value.is_completed) {
      storedDuration = Cookies.get(
        "duration_" +
          $filters.Auth.user().id +
          "_" +
          module.value.id +
          "_" +
          module.value.formation.id
      );
      storedModule = Cookies.get(
        "module" +
          $filters.Auth.user().id +
          "_" +
          module.value.id +
          "_" +
          module.value.formation.id
      );

      var totalModuleTime =
        readTime + (parseInt(storedDuration) ? parseInt(storedDuration) : 0);
      var storedCounter = Cookies.get(
        "storedCounter_" +
          $filters.Auth.user().id +
          "_" +
          module.value.id +
          "_" +
          module.value.formation.id
      )
        ? Cookies.get(
            "storedCounter_" +
              $filters.Auth.user().id +
              "_" +
              module.value.id +
              "_" +
              module.value.formation.id
          )
        : 0;
      const counter = ref(0);
      if (user_module) {
        if (user_module === "true") {
          counter.value = 1;
        }
      } else {
        if (storedCounter != 0 && storedCounter < totalModuleTime) {
          counter.value = storedCounter;
        } else {
          counter.value = totalModuleTime;
        }
      }
      const interval = setInterval(() => {
        counter.value--;
        // Display 'counter' wherever you want to display it.
        if (counter.value >= 0) {
          // Display a next button box
          $("#nextButton").html(
            "<a class='btn btn-block bg-danger font-weight-bold text-white' href='#'> " +
              trans.get("labels.frontend.formation.next") +
              " (dans " +
              counter.value +
              " seconds)</a>"
          );
          Cookies.set(
            "duration_" +
              $filters.Auth.user().id +
              "_" +
              module.value.id +
              "_" +
              module.value.formation.id,
            counter.value
          );
        }
        if (counter.value === 0) {
          Cookies.set(
            "user_module_" +
              $filters.Auth.user().id +
              "_" +
              module.value.id +
              "_" +
              module.value.formation.id,
            "true"
          );
          Cookies.remove("duration");

          if (test_exists && is_null(test_result)) {
            $("#nextButton").html(
              "<a class='btn btn-block bg-danger font-weight-bold text-white' href='#'>" +
                trans.get("labels.frontend.formation.complete_test") +
                "</a>"
            );
          } else {
            if (next_module) {
              $("#nextButton").html(
                "<router-link class='btn btn-block gradient-bg font-weight-bold text-white'" +
                  " :to=" +
                  {
                    name: "modules.show",
                    params: {
                      formation_id: next_module.value.formation_id,
                      slug: next_module.value.model.slug,
                    },
                  } +
                  " >" +
                  trans.get("labels.frontend.formation.next") +
                  "<i class='fa fa-angle-double-right'></i> </router-link>"
              );
            } else {
              $("#nextButton").html(
                "<form method='post' action='" +
                  Laravel.urls.admin_certificates_generate +
                  ">" +
                  "<input type='hidden' name='_token' id='csrf-token' value='{{ Session::token() }}' />" +
                  "<input type='hidden' value='{{$module->formation->id}}' name='formation_id'> " +
                  "<button class='btn btn-success btn-block text-white mb-3 text-uppercase font-weight-bold' id='finish'>{{ trans.get('labels.frontend.formation.finish_formation') }}</button></form>"
              );
            }

            if (!module.value.is_completed) {
              formationCompleted(module.value.id, module.value.get_class);
            }
          }
          clearInterval(counter.value);
        }
      }, 1000);
    }
  }
};

const formationCompleted = (id, type) => {
  axios.post(Laravel.urls.update_formation_progress, {
    model_id: parseInt(id),
    model_type: type,
  });
};
</script>



<style scoped>
@import "https://cdn.plyr.io/3.5.3/plyr.css";
@import "./../../../../public/plugins/touchpdf-master/jquery.touchPDF.css";

.test-form {
  color: #333333;
}

.formation-details-category ul li {
  width: 100%;
}

.sidebar.is_stuck {
  top: 15% !important;
}

.formation-timeline-list {
  max-height: 300px;
  overflow: scroll;
}

.options-list li {
  list-style-type: none;
}

.options-list li.correct {
  color: green;
}

.options-list li.incorrect {
  color: red;
}

.options-list li.correct:before {
  content: "\f058";
  /* FontAwesome Unicode */
  font-family: "Font Awesome\ 5 Free";
  display: inline-block;
  color: green;
  margin-left: -1.3em;
  /* same as padding-left set on li */
  width: 1.3em;
  /* same as padding-left set on li */
}

.options-list li.incorrect:before {
  content: "\f057";
  /* FontAwesome Unicode */
  font-family: "Font Awesome\ 5 Free";
  display: inline-block;
  color: red;
  margin-left: -1.3em;
  /* same as padding-left set on li */
  width: 1.3em;
  /* same as padding-left set on li */
}

.options-list li:before {
  content: "\f111";
  /* FontAwesome Unicode */
  font-family: "Font Awesome\ 5 Free";
  display: inline-block;
  color: black;
  margin-left: -1.3em;
  /* same as padding-left set on li */
  width: 1.3em;
  /* same as padding-left set on li */
}

.touchPDF {
  border: 1px solid #e3e3e3;
}

.touchPDF>.pdf-outerdiv>.pdf-toolbar {
  height: 0;
  color: black;
  padding: 5px 0;
  text-align: right;
}

.pdf-tabs {
  width: 100% !important;
}

.pdf-outerdiv {
  width: 100% !important;
  left: 0 !important;
  padding: 0px !important;
  transform: scale(1) !important;
}

.pdf-viewer {
  left: 0px;
  width: 100% !important;
}

.pdf-drag {
  width: 100% !important;
}

.pdf-outerdiv {
  left: 0px !important;
}

.pdf-outerdiv {
  padding-left: 0px !important;
  left: 0px;
}

.pdf-toolbar {
  left: 0px !important;
  width: 99% !important;
  height: 30px;
}

.pdf-viewer {
  box-sizing: border-box;
  left: 0 !important;
  margin-top: 10px;
}

.pdf-title {
  display: none !important;
}

@media screen and (max-width: 768px) {}
</style>
