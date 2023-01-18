<script setup>
import { ref, onMounted, onUnmounted, watch } from "vue";

const props = defineProps({
  sidebarOpen: Boolean,
});
const emit = defineEmits(["close-sidebar"]);
const trigger = ref(null);
const sidebar = ref(null);
const storedSidebarExpanded = localStorage.getItem("sidebar-expanded");
const sidebarExpanded = ref(
  storedSidebarExpanded === null ? false : storedSidebarExpanded === "true"
);

// close on click outside
const clickHandler = ({ target }) => {
  if (!sidebar.value || !trigger.value) return;
  if (
    !props.sidebarOpen ||
    sidebar.value.contains(target) ||
    trigger.value.contains(target)
  )
    return;
  emit("close-sidebar");
};

// close if the esc key is pressed
const keyHandler = ({ keyCode }) => {
  if (!props.sidebarOpen || keyCode !== 27) return;
  emit("close-sidebar");
};

onMounted(() => {
  document.addEventListener("click", clickHandler);
  document.addEventListener("keydown", keyHandler);
});

onUnmounted(() => {
  document.removeEventListener("click", clickHandler);
  document.removeEventListener("keydown", keyHandler);
});

watch(sidebarExpanded, () => {
  localStorage.setItem("sidebar-expanded", sidebarExpanded.value);
  if (sidebarExpanded.value) {
    document.querySelector("body").classList.add("sidebar-expanded");
  } else {
    document.querySelector("body").classList.remove("sidebar-expanded");
  }
});
</script>

<template>
  <div>
    <!-- Sidebar backdrop (mobile only) -->
    <div
      class="fixed inset-0 z-40 transition-opacity duration-200 bg-slate-900 bg-opacity-30 lg:hidden lg:z-auto"
      :class="sidebarOpen ? 'opacity-100' : 'opacity-0 pointer-events-none'"
      aria-hidden="true"
    ></div>

    <!-- Sidebar -->
    <div
      id="sidebar"
      ref="sidebar"
      class="flex flex-col absolute z-40 left-0 top-0 lg:static lg:left-auto lg:top-auto lg:translate-x-0 h-screen overflow-y-scroll lg:overflow-y-auto no-scrollbar w-64 lg:w-20 lg:sidebar-expanded:!w-64 2xl:!w-64 shrink-0 bg-slate-800 p-4 transition-all duration-200 ease-in-out"
      :class="sidebarOpen ? 'translate-x-0' : '-translate-x-64'"
    >
      <!-- Sidebar header -->
      <div class="flex justify-between mb-10">
        <!-- Close button -->
        <button
          ref="trigger"
          class="lg:hidden text-slate-500 hover:text-slate-400"
          @click.stop="emit('close-sidebar')"
          aria-controls="sidebar"
          :aria-expanded="sidebarOpen"
        >
          <span class="sr-only">Close sidebar</span>
          <svg
            class="w-6 h-6 fill-current"
            viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              d="M10.7 18.7l1.4-1.4L7.8 13H20v-2H7.8l4.3-4.3-1.4-1.4L4 12z"
            />
          </svg>
        </button>
        <div class="flex items-center justify-center w-full h-40">
          <img
            class="absolute z-0 object-contain w-full"
            src="https://connect-service-touchboard.s3.amazonaws.com/assets/logo/Ghost_G.png"
            alt="image background"
          />
          <!-- Logo -->
          <router-link class="absolute block" to="/">
            <div class="flex flex-col items-center justify-center">
              <img
                src="../../images/GRAY-horizontal-logo-280x140-white.png"
                alt="logo"
                class="z-10"
                :class="sidebarExpanded ? '' : 'w-1/3'"
              />
            </div>
          </router-link>
        </div>
      </div>

      <!-- Links -->
      <div class="space-y-8">
        <!-- Pages group -->
        <div>
          <h3 class="pl-3 text-xs font-semibold uppercase text-slate-500">
            <span
              class="hidden w-6 text-center lg:block lg:sidebar-expanded:hidden 2xl:hidden"
              aria-hidden="true"
              >•••</span
            >
            <span class="lg:hidden lg:sidebar-expanded:block 2xl:block"
              >Pages</span
            >
          </h3>
          <ul class="mt-3">
            <!-- Apps -->
            <router-link
              to="/"
              custom
              v-slot="{ href, navigate, isExactActive }"
            >
              <li
                class="px-3 py-2 rounded-sm mb-0.5 last:mb-0"
                :class="isExactActive && 'bg-slate-900'"
              >
                <a
                  class="block truncate transition duration-150 text-slate-200 hover:text-white"
                  :class="isExactActive && 'hover:text-slate-200'"
                  :href="href"
                  @click="navigate"
                >
                  <div class="flex items-center">
                    <svg class="w-6 h-6 shrink-0" viewBox="0 0 24 24">
                      <path
                        class="fill-current text-slate-400"
                        :class="isExactActive && 'text-indigo-500'"
                        d="M12 0C5.383 0 0 5.383 0 12s5.383 12 12 12 12-5.383 12-12S18.617 0 12 0z"
                      />
                      <path
                        class="fill-current text-slate-600"
                        d="M12 3c-4.963 0-9 4.037-9 9s4.037 9 9 9 9-4.037 9-9-4.037-9-9-9z"
                      />
                      <path
                        class="fill-current text-slate-400"
                        d="M12 15c-1.654 0-3-1.346-3-3 0-.462.113-.894.3-1.285L6 6l4.714 3.301A2.973 2.973 0 0112 9c1.654 0 3 1.346 3 3s-1.346 3-3 3z"
                      />
                    </svg>
                    <span
                      class="ml-3 text-sm font-medium duration-200 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100"
                      >Home</span
                    >
                  </div>
                </a>
              </li>
            </router-link>
            <!-- Devices -->
            <router-link
              to="/about"
              custom
              v-slot="{ href, navigate, isExactActive }"
            >
              <li
                class="px-3 py-2 rounded-sm mb-0.5 last:mb-0"
                :class="isExactActive && 'bg-slate-900'"
              >
                <a
                  class="block truncate transition duration-150 text-slate-200 hover:text-white"
                  :class="isExactActive && 'hover:text-slate-200'"
                  :href="href"
                  @click="navigate"
                >
                  <div class="flex items-center">
                    <svg class="w-6 h-6 shrink-0" viewBox="0 0 24 24">
                      <path
                        class="fill-current text-slate-400"
                        :class="isExactActive && 'text-indigo-500'"
                        d="M13 15l11-7L11.504.136a1 1 0 00-1.019.007L0 7l13 8z"
                      />
                      <path
                        class="fill-current text-slate-700"
                        :class="isExactActive && 'text-indigo-500'"
                        d="M13 15L0 7v9c0 .355.189.685.496.864L13 24v-9z"
                      />
                      <path
                        class="fill-current text-slate-600"
                        :class="isExactActive && 'text-indigo-500'"
                        d="M13 15.047V24l10.573-7.181A.999.999 0 0024 16V8l-11 7.047z"
                      />
                    </svg>
                    <span
                      class="ml-3 text-sm font-medium duration-200 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100"
                      >About</span
                    >
                  </div>
                </a>
              </li>
            </router-link>
          </ul>
        </div>
      </div>

      <!-- Expand / collapse button -->
      <div class="justify-end pt-3 mt-auto lg:inline-flex 2xl:hidden">
        <div class="px-3 py-2">
          <button @click.prevent="sidebarExpanded = !sidebarExpanded">
            <span class="sr-only">Expand / collapse sidebar</span>
            <svg
              class="w-6 h-6 fill-current sidebar-expanded:rotate-180"
              viewBox="0 0 24 24"
            >
              <path
                class="text-slate-400"
                d="M19.586 11l-5-5L16 4.586 23.414 12 16 19.414 14.586 18l5-5H7v-2z"
              />
              <path class="text-slate-600" d="M3 23H1V1h2z" />
            </svg>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
