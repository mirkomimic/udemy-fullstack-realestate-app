<template>
  <Link :href="route('listing.index')">Listings</Link>&nbsp;
  <Link :href="route('listing.create')">New Listing</Link>
  <!-- <div>The page with time {{ timer }}</div> -->

  <div v-if="flashSuccess" class="success">
    {{ flashSuccess }}
  </div>

  <slot>Default</slot>
</template>

<script setup>
import { Link, usePage } from "@inertiajs/vue3";
import { computed } from "vue";
// import { ref } from "vue";

// const timer = ref(0);
// setInterval(() => timer.value++, 1000)

const page = usePage();
// for complex logic that includes reactive data, it is recommended to use a computed property
const flashSuccess = computed(() => {
  return page.props.flash.success;
})
</script>

<style scoped>
.success {
  background-color: green;
  color: white;
}
</style>