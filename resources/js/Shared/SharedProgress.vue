<template>
  <div class="progress">
    <div
      class="progress-bar"
      role="progressbar"
      aria-valuenow="60"
      aria-valuemin="0"
      aria-valuemax="100"
      :style="progressWidth"
    ></div>
  </div>
</template>
<script>
export default {
  components: {},
  data: {
      project = "",
      progressWidth = (project.completedWeight / project.totalWeight * 100) + '%;',
  },
  methods: {
    getProjects() {
      axios
        .get("api/projects")
        .then((response) => {
          this.projects = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
  created() {
    this.getProjects();
  },
};
</script>

