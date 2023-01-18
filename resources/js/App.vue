<script setup>
import DashboardLayout from "@/layouts/DashboardLayout.vue";

const props = defineProps({
  user: Object,
});

console.log(props.user);
</script>

<template>
  <DashboardLayout :user="user">
    <router-view></router-view>
  </DashboardLayout>
</template>
