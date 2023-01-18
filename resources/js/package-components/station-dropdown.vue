<script setup>
import { ref, onMounted, onUnmounted, computed } from "vue";
import axios from "axios";

const props = defineProps({
  user: Object,
});

console.log(props.user);

const store = ref({
  stationSelected: "",
  user: {},
  stationSearch: "",
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

store.value.stations = props.user.allowed_stations;
store.value.user = props.user;
store.value.stationSelected = props.user.station;

const stationsBySearch = computed(() => {
  return store.value.stations.filter(function (str) {
    var uppercaseIt = store.value.stationSearch.toUpperCase();
    return str.includes(uppercaseIt);
  });
});

const axiosInstance = axios.create({
  baseURL: "https://api.gdm-connect.com/v1",
  timeout: 25000,
  headers: { "x-api-key": import.meta.env.VITE_GAUTH_API_KEY },
});

function setStation() {
  console.log(store.value.stationSelected);

  axiosInstance
    .put(`/users/${store.value.user.onelogin_id}/station`, {
      station: store.value.stationSelected,
    })
    .then((response) => {
      window.location.replace("/");
    })
    .catch((err) => {
      console.log(err);
    });

  dropdownOpen.value = false;
}

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
  <div class="relative inline-flex pr-3 border-r-2">
    <button
      ref="trigger"
      class="bg-white btn border-slate-200 hover:border-slate-300 text-slate-500 hover:text-slate-600"
      aria-haspopup="true"
      @click.prevent="dropdownOpen = !dropdownOpen"
      :aria-expanded="dropdownOpen"
    >
      <span class="sr-only">Filter</span><wbr />
      <svg
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
        stroke-width="1.5"
        stroke="currentColor"
        class="w-6 h-6"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z"
        />
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
        />
      </svg>
      <span class="ml-1">{{ store.user.station }}</span>
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
        class="origin-top-right z-10 absolute top-full min-w-56 bg-white border border-slate-200 pt-1.5 rounded shadow-lg overflow-hidden mt-1 right-0"
      >
        <div ref="dropdown">
          <div
            class="text-xs font-semibold text-slate-400 uppercase pt-1.5 pb-2 px-4"
          >
            Change Station
          </div>
          <div class="relative mb-2 ml-2">
            <label for="station-search" class="sr-only">Search</label>
            <input
              id="station-search"
              v-model="store.stationSearch"
              class="form-input pl-9 focus:border-slate-300"
              type="search"
              placeholder="Search..."
            />
            <button
              class="absolute inset-0 right-auto group"
              type="submit"
              aria-label="Search"
            >
              <svg
                class="w-4 h-4 ml-3 mr-2 fill-current shrink-0 text-slate-400 group-hover:text-slate-500"
                viewBox="0 0 16 16"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M7 14c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7zM7 2C4.243 2 2 4.243 2 7s2.243 5 5 5 5-2.243 5-5-2.243-5-5-5z"
                />
                <path
                  d="M15.707 14.293L13.314 11.9a8.019 8.019 0 01-1.414 1.414l2.393 2.393a.997.997 0 001.414 0 .999.999 0 000-1.414z"
                />
              </svg>
            </button>
          </div>

          <ul
            class="flex flex-wrap w-full h-32 mb-4 overflow-y-auto md:overflow-x-hidden md:w-96"
          >
            <li
              v-for="(station, index) in stationsBySearch"
              :key="station"
              class="w-1/2 px-3 py-1 md:w-1/3"
            >
              <label class="flex items-center">
                <input
                  v-model="store.stationSelected"
                  type="radio"
                  :value="station"
                  name="station-radio-items"
                  class="form-radio"
                />
                <span class="ml-2 text-sm font-medium">{{ station }}</span>
              </label>
            </li>
          </ul>
          <div class="px-3 py-2 border-t border-slate-200 bg-slate-50">
            <ul class="flex items-center justify-between">
              <li>
                <button
                  class="text-white bg-indigo-500 btn-xs hover:bg-indigo-600"
                  @click="setStation"
                  @focusout="dropdownOpen = false"
                >
                  Apply
                </button>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </transition>
  </div>
</template>
