<script setup>

import { ref } from 'vue'

defineProps({
    collection: {
        type: Array,
        required: true
    }
})

const currentSelection = ref(1)
const selection = ref([])
const emit = defineEmits(['onCategories'])

const handleAddToSelection = () => {
    if(selection.value.find(item => item.id === currentSelection.value.id)) return // validacion para no agregar elementos duplicados
    selection.value.push(currentSelection.value)   //guardado en el array
    emit('onCategories', selection.value)
}

const handleRemoveSelection = (index) => {
    selection.value = selection.value.filter(item => item.id !== index) //borrado de elementos del array
    emit('onCategories', selection.value)
}

</script>

<template>
    <div class="w-full">
        <div class="flex">
            <select v-model="currentSelection" id="categories" name="categories"
            class="w-full px-4 py-2 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mr-1">
                <option v-for="(item, index) in collection" :key="index" :value="item">{{ item?.name }}</option>
            </select>
            <button class="text-xs bg-indigo-100 rounded-md hover:bg-indigo-300 font-semibold py-2 px-4 uppercase ml-1" @click="handleAddToSelection">Add</button>
        </div>
        <div>
                <ul>
                    <li class="text-xs bg-indigo-100 rounded hover:bg-indigo-300 py-2 px-2 ml-1 mt-1 mb-1" v-for="(item, index) in selection" :key="index" @click="handleRemoveSelection(item.id)">{{ item.name }}
                    <span class="cursor-pointer float-right">X</span>
                    </li>
                </ul>
        </div>
    </div>
</template>