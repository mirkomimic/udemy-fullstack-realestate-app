<template>
  <div v-for="(listing, index) in listings" :key="listing.id">
    <div>
      <!-- ziggy rute -->
      <Link :href="route('listing.show', listing.id)">
        <ListingAddress :listing="listing"/>
      </Link>
    </div>
    <div>
      <Link :href="route('listing.edit', {listing: listing.id})">Edit</Link>
    </div>
    <div>
      <Link :href="route('listing.destroy', [listing.id])" method="DELETE" as="button">Delete</Link>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import ListingAddress from '@/Components/ListingAddress.vue';
defineProps({
  listings: Array,
})
</script>