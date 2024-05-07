<script>
export default {
    name: 'LessonForm'
}
</script>

<script setup>
import FormSection from '@/Components/FormSection.vue'
import InputError from '@/Components/InputError.vue'
import InputLabel from '@/Components/InputLabel.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import TextInput from '@/Components/TextInput.vue'
import Checkbox from '../Checkbox.vue'
import FileSelector from '../Common/FileSelector.vue'
import CollectionSelector from '../Common/CollectionSelector.vue'
import { ref } from 'vue'

defineProps({
    form: {
        type: Object,
        required: true
    },
    updating: {
        type: Boolean,
        required: false,
        default: false
    },
    categories: {
        type: Object,
        required: true
    },
    levels: {
        type: Object,
        required: true
    },  
    content: {
        type: Object,
        required: false
    },
    image:{
        type: Object,
        required: false
    },
    pdf: {
        type: Object,
        required: false
    }
})

const emit = defineEmits(['changeSelected', 'submit', 'fileSelected', 'imageSelect', 'contentSelect'])
const imageSelected = ref([])
const categoriesSelected = ref([])
const pdfFile = ref([])
const file_select = ref([])

const handleFileChange = (event) => {
    pdfFile.value = event.target.files[0];
    emit('fileSelected', pdfFile.value)
}

const handleImageChange = (event) => {
    imageSelected.value = event.target.files[0];
    emit('imageSelect', imageSelected.value)
}

const handleFileContent = (_file_selected) => {
    file_select.value = _file_selected
    emit('contentSelect', file_select.value)
}

const onCategories = (_categories) => {
    categoriesSelected.value = _categories
    emit('changeSelected', categoriesSelected.value)
}

</script>

<template>
    <FormSection>
        <template #title>
            {{ updating ? 'Update Lesson' : 'Create New Lesson' }} {{ form.is_free }}
        </template>
        <template #description>
            {{ updating ? 'Update The Selected Lesson' : 'Create a New Lesson from Scratch' }} {{ $page.props }}
        </template>
        <template #form>
            <div class="col-span-6 sm:col-span-6">
                <div class="w-full mt-5">
                    <InputLabel for="name" value="Name" />
                    <TextInput id="name" v-model="form.name" type="text" class="mt-1 block w-full" autocomplete="name" />
                    <InputError :message="$page.props.errors.name" class="mt-2" />
                </div>
                <br>
                <InputLabel for="description" value="Description" />
                <TextInput id="description" v-model="form.description" type="text" class="mt-1 block w-full" autocomplete="description" />
                <InputError :message="$page.props.errors.description" class="mt-2" />

                <div class="w-full mt-5">
                    <div class="flex mt-5">
                        <div class="w-1/2">
                            <InputLabel for="level_id" value="Level" />
                            <select name="level_id" id="level_id" v-model="form.level_id" 
                            class="w-full px-4 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">  
                                <option v-if="updating" :value="form.level_id" selected>{{ form.level }}</option>
                                <option v-for="level in levels" :value="level.id"> {{ level.name }}
                                </option>
                            </select>
                            <InputError :message="$page.props.errors.level_id" class="mt-2" />
                        </div>
                        <div class="w-1/2">
                            <InputLabel value="Category" for="_categories" />
                            <CollectionSelector class="w-full px-2" id="_categories" name="_categories" :collection="categories" 
                            :selected="form.categories" :updating="updating"
                            @onCategories="onCategories"></CollectionSelector>
                            <InputError :message="$page.props.errors.categories" class="mt-2" />
                        </div>
                    </div>
                </div>

                <div class="w-full mt-5">
                    <div class="flex mt-5">
                        <div class="w-1/2"> 
                            <InputLabel for="content_uri" value="Content" />
                            <FileSelector id="content_uri" name="content_uri" :extension="'application/x-zip-compressed'" :extensionFile="'.zip'" 
                            @fileSelection="handleFileContent"></FileSelector>
                            <InputError :message="$page.props.errors.content" class="mt-2" />
                        </div>
                        <div class="w-1/2">
                            <InputLabel for="pdf" value="PDF" />
                            <input name="pdf" id="pdf" 
                            class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150" 
                            type="file" @change="handleFileChange" />
                            <InputError :message="$page.props.errors.pdf" class="mt-2" />
                        </div>
                    </div>
                </div>

                <div class="w-full mt-5">
                    <div class="flex mt-5">
                        <div class="w-1/2"> 
                            <InputLabel for="image" value="Imagen" />
                            <input name="image" id="image"
                            class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150" 
                            type="file" @change="handleImageChange" />
                            <InputError :message="$page.props.errors.image" class="mt-2" />
                        </div>
                        <div class="w-1/2 inline-flex mt-7">
                            <Checkbox class="py-2 mx-3" name="is_free" id="is_free" v-model:checked="form.is_free" />
                            <InputLabel for="is_free" value="Is free?" />
                        </div>
                    </div>
                </div>
                
            </div>
        </template>
        <template #actions>
            <PrimaryButton @click="$emit('submit')">
                {{ updating ? 'Update' : 'Create' }}
            </PrimaryButton>
        </template> 
    </FormSection>
</template>


