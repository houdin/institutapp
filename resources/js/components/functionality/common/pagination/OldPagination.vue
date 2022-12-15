<template>

  <div v-if=" totalPages > 1 && !axiosLoading" class="d-flex justify-content-center m-2 px-0 mb-4">

    <ul class="pagination">
      <!-- <slot :buttons="buttons" name="buttons">
        <pagination-button v-for="(button, key) in buttons" :key="key" v-bind="button" @page-change="emit('page-change', button.page)" />
      </slot> -->
      <li v-for="(button, key) in buttons" :key="key" class="page-item me-1">
        <i v-if="button.loading" class="fa fa-spinner fa-spin" />
        <!-- <router-link v-else :to="{ name:'formations.index', query: {page : button.html}}" :class="buttonClasses(button)" :disabled="button.disabled" :title="button.title" @click="pageAtChange(button)" v-html="button.html"></router-link> -->
        <button v-else :class="buttonClasse s(button)" :disabled="button.disabled" :title="button.title"
          @click="pageChange(button)" v-html="button.html" />
      </li>
    </ul>

  </div>
</template>

<script setup lang="ts">
const {
  watch,
  computed,
  watchEffect,
  ref,
  inject,
} = require("@vue/runtime-core");
const { useRoute, useRouter } = require("vue-router");

const props = defineProps({
  page: {
    type: Number,
    default: 0,
    validator: (page) => {
      return page >= 0;
    },
  },

  itemsPerPage: {
    type: Number,
    default: 10,
    validator: (itemsPerPage) => {
      return itemsPerPage > 0;
    },
  },

  maxVisiblePages: {
    type: Number,
    default: 5,
    validator: (maxVisiblePages) => {
      return maxVisiblePages > 0;
    },
  },

  totalItems: {
    type: Number,
    required: true,
    validator: (totalItems) => {
      return totalItems >= 0;
    },
  },

  loading: {
    type: Boolean,
    default: false,
  },
});

const axiosLoading = inject("axiosLoading");

const emit = defineEmits(["page-change"]);

const totalPages = computed(() => {
  if (props.itemsPerPage === 0) {
    return 0;
  }
  return Math.ceil(props.totalItems / props.itemsPerPage);
});

const filteredPages = computed(() => {
  let diff = props.maxVisiblePages / 2;
  let toFilterPages = [...Array(totalPages.value).keys()].slice(2, -2);

  if (toFilterPages.length > props.maxVisiblePages) {
    let diffFirst = props.page - toFilterPages[0];
    let diffLast = props.page - toFilterPages[toFilterPages.length - 1];

    if (diffFirst < diff) {
      return toFilterPages.slice(0, props.maxVisiblePages);
    } else if (diffLast >= -diff) {
      return toFilterPages.slice(-props.maxVisiblePages);
    } else {
      return toFilterPages.filter((page) => {
        let diffPage = props.page - page;

        return diffPage < 0 ? Math.abs(diffPage) <= diff : diffPage < diff;
      });
    }
  }

  return null;
});

const pages = computed(() => {
  let xFilteredPages = filteredPages.value;
  let let_pages = xFilteredPages
    ? [
        xFilteredPages[0] - 1 === 1 ? 1 : "...",
        ...xFilteredPages,
        xFilteredPages[xFilteredPages.length - 1] + 1 === totalPages.value - 2
          ? totalPages.value - 2
          : "...",
      ]
    : [...Array(totalPages.value - 2).keys()].map((page) => page + 1);

  return [
    props.page - 1,
    0,
    ...let_pages,
    totalPages.value - 1,
    props.page + 1,
  ];
});

const buttons = computed(() => {
  return pages.value.map((page, key) => {
    return {
      page,
      active: page === props.page,
      disabled: disabled(page, key),
      html: html(page, key),
      title: title(key),
      loading: props.loading && page === props.page,
    };
  });
});

const propsPage = ref(props.page);
const propsItemsPerPage = ref(props.itemsPerPage);
const propsTotalItems = ref(props.totalItems);

const route = useRoute();
const router = useRouter();

const pageChange = (val) => {
  if (val.page === "..." || val.disabled || val.active) {
    return;
  }

  emit("page-change", val.page);
  router.push({ name: route.name, query: { page: val.page + 1 } });
};

function html(page, key) {
  if (key === 0) {
    return '<i class="fa fa-angle-left"></i>';
  }

  if (key === pages.value.length - 1) {
    return '<i class="fa fa-angle-right"></i>';
  }

  if (page === "...") {
    return page;
  }

  return page + 1 + "";
}

function disabled(page, key) {
  return (
    (key === 0 && props.page === 0) ||
    (key === pages.value.length - 1 && props.page === totalPages.value - 1) ||
    page === "..."
  );
}

function title(key) {
  if (key === 0) {
    return "previous";
  }

  if (key === pages.value.length - 1) {
    return "next";
  }

  return "";
}

const buttonClasses = (btn) => {
  if (btn.disableStyling) {
    return {};
  }

  return {
    // "focus:outline-none": true,
    "page-link": true,
    "bg-base-2": btn.active,
    "color-gray-6": btn.active,
    "cursor-default": btn.active || btn.disabled,
    "bg-gray-3": btn.disabled && btn.page !== "...",
    "color-gray-4": btn.disabled && btn.page !== "...",
    "hover:bg-gray-300": !btn.active && !btn.disabled,
  };
};
</script>

