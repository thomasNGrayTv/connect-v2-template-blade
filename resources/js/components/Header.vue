<script setup>
import StationsDropdown from "@/package-components/station-dropdown.vue";
import UserMenu from "@/package-components/user-dropdown.vue";

const props = defineProps({
  sidebarOpen: Boolean,
  user: Object,
});
</script>
<template>
  <header class="sticky top-0 z-30 bg-white border-b border-slate-200">
    <div class="px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-16 -mb-px">
        <!-- Header: Left side -->
        <div class="flex">
          <!-- Hamburger button -->
          <button
            class="text-slate-500 hover:text-slate-600 lg:hidden"
            @click.stop="$emit('toggle-sidebar')"
            aria-controls="sidebar"
            :aria-expanded="sidebarOpen"
          >
            <span class="sr-only">Open sidebar</span>
            <svg
              class="w-6 h-6 fill-current"
              viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg"
            >
              <rect x="4" y="5" width="16" height="2" />
              <rect x="4" y="11" width="16" height="2" />
              <rect x="4" y="17" width="16" height="2" />
            </svg>
          </button>
        </div>

        <!-- Header: Right side -->
        <div class="flex items-center space-x-3">
          <StationsDropdown :user="user" />
          <UserMenu :user="user" align="right" />
        </div>
      </div>
    </div>
  </header>
</template>
