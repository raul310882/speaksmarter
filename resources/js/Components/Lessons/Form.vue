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
import SecondaryButton from '../SecondaryButton.vue'
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
    }
})
const emit = defineEmits(['changeSelected', 'submit'])
const categoriesSelected = ref([])

const onCategories = (_categories) => {
    categoriesSelected.value = _categories
    emit('changeSelected', categoriesSelected.value)
}


</script>

<template>
    <FormSection>
        <template #title>
            {{ updating ? 'Update Lesson' : 'Create New Lesson' }}
        </template>
        <template #description>
            {{ updating ? 'Update The Selected Lesson' : 'Create a New Lesson from Scratch' }}
        </template>
        <template #form>
            <div class="col-span-6 sm:col-span-6">
                <InputLabel for="name" value="Name" />
                <TextInput id="name" v-model="form.name" type="text" class="mt-1 block w-full" autocomplete="name" />
                <InputError :message="$page.props.errors.name" class="mt-2" />
                <br>
                <InputLabel for="description" value="Description" />
                <TextInput id="description" v-model="form.description" type="text" class="mt-1 block w-full" autocomplete="description" />
                <InputError :message="$page.props.errors.description" class="mt-2" />
                <br>
                <InputLabel for="content_uri" value="Content URI" />
                <TextInput id="content_uri" v-model="form.content_uri" type="text" class="mt-1 block w-full" autocomplete="content_uri" />
                <InputError :message="$page.props.errors.content_uri" class="mt-2" />
                <br>
                <SecondaryButton class="mt-2 mr-2" type="button">Upload PDF</SecondaryButton>
                <InputError :message="$page.props.errors.pdf_uri" class="mt-2" />
                <br>
                <div class="w-full mt-5">
                    <div class="flex">
                        <div class="w-1/2">
                            <InputLabel for="level_id" value="Level" />
                            <select name="level_id" id="level_id" v-model="form.level_id" class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option v-for="level in levels" :value="level.id">{{ level.name }}</option>
                            </select>
                            <InputError :message="$page.props.errors.level_id" class="mt-2" />
                        </div>
                        <div class="w-1/2">
                            <InputLabel for="categories" value="Category" />
                            <CollectionSelector name="categories" id="categories" :collection="categories" @onCategories="onCategories"></CollectionSelector>
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