<script setup>
import Sidebar from "@/components/Sidebar.vue";
import Header from "@/components/Header.vue";
import { ref } from "vue";

const props = defineProps({
  user: Object,
});
const sidebarOpen = ref(false);
</script>

<template>
  <div class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    <Sidebar :sidebarOpen="sidebarOpen" @close-sidebar="sidebarOpen = false" />

    <!-- Content area -->
    <div
      class="relative flex flex-col flex-1 overflow-x-hidden overflow-y-auto"
    >
      <!-- Site header -->
      <Header
        :sidebarOpen="sidebarOpen"
        :user="user"
        @toggle-sidebar="sidebarOpen = !sidebarOpen"
      />

      <main>
        <div class="w-full px-4 py-8 mx-auto sm:px-6 lg:px-8 max-w-9xl">
          <slot></slot>
        </div>
      </main>
    </div>
  </div>
</template>

<style></style>
