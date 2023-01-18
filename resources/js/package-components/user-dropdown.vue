<script setup>
import { ref, onMounted, onUnmounted } from "vue";

const props = defineProps({
  align: String,
  user: Object,
});
const dropdownOpen = ref(false);
const trigger = ref(null);
const dropdown = ref(null);

// close on click outside
const clickHandler = ({ target }) => {
  if (
    !dropdownOpen.value ||
    dropdown.value.contains(target) ||
    trigger.value.contains(target)
  )
    return;
  dropdownOpen.value = false;
};

// close if the esc key is pressed
const keyHandler = ({ keyCode }) => {
  if (!dropdownOpen.value || keyCode !== 27) return;
  dropdownOpen.value = false;
};

onMounted(() => {
  document.addEventListener("click", clickHandler);
  document.addEventListener("keydown", keyHandler);
});

onUnmounted(() => {
  document.removeEventListener("click", clickHandler);
  document.removeEventListener("keydown", keyHandler);
});
</script>
<template>
  <div class="relative inline-flex">
    <button
      ref="trigger"
      class="inline-flex items-center justify-center group"
      aria-haspopup="true"
      @click.prevent="dropdownOpen = !dropdownOpen"
      :aria-expanded="dropdownOpen"
    >
      <img
        class="w-8 h-8 rounded-full"
        src="../../images/user-avatar-32.png"
        width="32"
        height="32"
        alt="User"
      />
      <div class="flex items-center truncate">
        <span
          class="ml-2 text-sm font-medium truncate group-hover:text-slate-800"
          >{{ user.firstName }}</span
        >
        <svg
          class="w-3 h-3 ml-1 fill-current shrink-0 text-slate-400"
          viewBox="0 0 12 12"
        >
          <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
        </svg>
      </div>
    </button>
    <transition
      enter-active-class="transition duration-200 ease-out transform"
      enter-from-class="-translate-y-2 opacity-0"
      enter-to-class="translate-y-0 opacity-100"
      leave-active-class="transition duration-200 ease-out"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div
        v-show="dropdownOpen"
        class="origin-top-right z-10 absolute top-full min-w-44 bg-white border border-slate-200 py-1.5 rounded shadow-lg overflow-hidden mt-1"
        :class="align === 'right' ? 'right-0' : 'left-0'"
      >
        <div class="pt-0.5 pb-2 px-3 mb-1 border-b border-slate-200">
          <div class="font-medium text-slate-800">
            {{ user.firstName }} {{ user.lastName }}
          </div>
          <div class="text-xs italic text-slate-500">
            Station: {{ user.station }}
          </div>
          <div class="text-xs italic text-slate-500">Administrator</div>
        </div>
        <ul
          ref="dropdown"
          @focusin="dropdownOpen = true"
          @focusout="dropdownOpen = false"
        >
          <li>
            <a
              class="flex items-center px-3 py-1 text-sm font-medium text-indigo-500 hover:text-indigo-600"
              href="/logout"
              @click="dropdownOpen = false"
              >Sign Out</a
            >
          </li>
        </ul>
      </div>
    </transition>
  </div>
</template>
