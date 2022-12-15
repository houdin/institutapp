<template>
  <div>
    <input
      placeholder="Search projects"
      type="text"
      class="form-control"
      v-model="my_sproject_text"
    />
    <hr />
    <table-component :data="tableProjects">
      <table-column
        show="tableIndex"
        label="#"
        data-type="numeric"
      ></table-column>
      <table-column show="name" label="Name"></table-column>
      <table-column show="progress" label="Progress"></table-column>
    </table-component>
  </div>
</template>
<script>
import { TableComponent, TableColumn } from "vue-table-component";
export default {
  components: {
    TableComponent,
    TableColumn,
  },
  props: ["baseProject"],
  data: function () {
    return {
      my_sproject_text: "",
      projects: [],
      tableProjects: [],
    };
  },
  methods: {
    arrayProjects() {
      for (let index = 0; index < this.projects.length; index++) {
        let project = {};
        project["id"] = index + 1;
        project["name"] =
          '<a href="' +
          this.baseProject +
          "/" +
          project["id"] +
          '">' +
          this.projects[index].name +
          "</a>";
        project["progress"] = this.progressBar(this.projects[index]);

        this.tableProjects.push(project);
      }
    },
    getOwnProjects() {
      axios
        .get("api/projects")
        .then((response) => {
          this.projects = response.data;
        })
        .catch((error) => {
          console.log(error);
        });

      this.arrayProjects();
    },
    progressBar(projectData) {
      let data_bar =
        (projectData.completedWeight / projectData.totalWeight) * 100;

      return `<div class="progress">
            <div
            class="progress-bar"
            role="progressbar"
            aria-valuenow="60"
            aria-valuemin="0"
            aria-valuemax="100"
            style="width:${data_bar}%"
            ></div>
        </div>`;
    },
  },
  created() {
    this.getOwnProjects();
  },
};
</script>
