<script>
export default {
    name: "MailsIndex",
};
</script>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link } from "@inertiajs/vue3";
import { Inertia } from "@inertiajs/inertia";
import { ref } from "vue";

defineProps({
    correos: {
        type: Object,
        required: true
    }
});

const fileSelected = ref("")

const showFile = (_file) => {
    fileSelected.value = "/storage/pdf_temp/"+_file
}

</script>

<template>
    <AppLayout title="Postulantes">
        <template #header>
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                Mails Received
            </h1>
        </template>
        <div class="flex py-6">
            <div class="w-3/4">
                <div class="p-6 bg-white border-b border-gray-700 shadow rounded-lg">
                    <ul role="list" class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <li v-for="(correo, index) in correos" :key="index" class="col-span-1 divide-y divide-gray-200 rounded-lg border-2 shadow-lg border-gray-400">
                        <div class="flex w-full items-center justify-between space-x-6 p-4 rounded bg-cover bg-sky-100">
                        <div class="flex-1">
                            <div class="flex items-center space-x-3">
                            <h3 class="truncate text-sm font-bold text-gray-900">{{ correo.nombre }}</h3>
                            <span class="inline-flex flex-shrink-0 items-center rounded-full bg-green-50 px-1.5 py-0.5 text-xs font-medium text-blue-600 ring-1 ring-inset ring-green-600/20">
                                {{ correo.puesto }}
                            </span>
                            </div>
                            <div class="flex bg-gray-100 p-2">
                                <!-- <textarea class="rounded-lg text-sm border-0 resize-none" name="" id="" rows="5" cols="40" disabled>{{ correo.main }}</textarea> -->
                                <!-- <p class="mt-1 text-clip overflow-hidden text-sm text-gray-500">{{ correo.main }}</p> -->
                                <label class="flex text-xs">{{ correo.main }}</label>   
                            </div>
                        </div>
                        </div>
                        <div>
                        <div class="-mt-px flex divide-x divide-gray-200 h-10">
                            <div class="flex w-0 flex-1">
                            <a href="howpossible17@example.com" class="relative -mr-px inline-flex w-0 flex-1 items-center justify-center gap-x-2 rounded-bl-lg border border-transparent py-4 text-sm font-semibold text-gray-500">
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  
                                stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-device-floppy">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" />
                                    <path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                    <path d="M14 4l0 4l-6 0l0 -4" />
                                </svg>
                                Guardar
                            </a>
                            </div>
                            <div class="-ml-px flex w-0 flex-1">
                            <a href="tel:+1-202-555-0170" class="relative inline-flex w-0 flex-1 items-center justify-center gap-x-3 rounded-br-lg border border-transparent py-4 text-sm font-semibold text-gray-500">
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  
                                stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-phone">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2" />
                                </svg>
                                <!--  <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M2 3.5A1.5 1.5 0 013.5 2h1.148a1.5 1.5 0 011.465 1.175l.716 3.223a1.5 1.5 0 01-1.052 1.767l-.933.267c-.41.117-.643.555-.48.95a11.542 11.542 0 006.254 6.254c.395.163.833-.07.95-.48l.267-.933a1.5 1.5 0 011.767-1.052l3.223.716A1.5 1.5 0 0118 15.352V16.5a1.5 1.5 0 01-1.5 1.5H15c-1.149 0-2.263-.15-3.326-.43A13.022 13.022 0 012.43 8.326 13.019 13.019 0 012 5V3.5z" clip-rule="evenodd" />
                                </svg> -->
                                Seguimiento
                            </a>
                            </div>
                        </div>
                        </div>
                        <div> 
                            <ul>
                                <li v-for="(adjunto, index) in correo.attach" :key="index" class="text-xs bg-indigo-200 rounded hover:bg-indigo-400 py-2 px-2 ml-1 mt-1 mb-1 cursor-pointer"
                                @click="showFile(adjunto)" >
                                   <span>{{ adjunto }}</span>
                                   <span class="float-right"><input type="checkbox"></span>
                                </li>
                            </ul>
                        </div>
                    </li>
                   
                    <!-- More people... -->
                    </ul>

                </div>
            </div>
            <div class="w-1/4 px-2">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg transition-all">
                    <embed class="flex"
                    v-bind:src="fileSelected" width="450" height="700" type="application/pdf">
                </div>
            </div>
        </div>
    </AppLayout>
</template>
