<script setup>
import { ref } from 'vue';

const props = defineProps({
   extensionFile: {
        type: String,
        required: false
    }
})

const emit = defineEmits(['fileSelection'])
const fileSelect = ref([])

const handleFileChange = (event) => {
   // event, {"Content-Type": "multipart/form-data;"};
    fileSelect.value = event.target.files[0]
    emit('fileSelection', fileSelect.value)
}

</script>


<template>
    <input id="file_upload" name="file_upload" 
    class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150"
    type="file" @change="handleFileChange" :accept="extensionFile" /> 
</template>