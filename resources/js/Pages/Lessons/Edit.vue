<script>
export default {
    name: 'LessonEdit'
}
</script>

<script setup>
    import { useForm } from '@inertiajs/vue3'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import LessonForm from '../../Components/Lessons/Form.vue'
    import { ref } from 'vue'
    import { router } from '@inertiajs/vue3'
    import { Inertia } from "@inertiajs/inertia";

const props = defineProps({
    lesson: {
        type: Object,
        required: true
    },
    levels: {
        type: Object,
        required: true
    },
    categories: {
        type: Object,
        required: true
    }
    })

const categories_select = ref([])
const file_select = ref([])
const image_select = ref([])
const content_select = ref([])

const form = useForm({
    name: props.lesson.name,
    description: props.lesson.description,
    content_uri: props.lesson.content_uri,
    pdf_uri: props.lesson.pdf_uri,
    image_uri: props.lesson.image_uri,
    level_id: props.lesson.level_id,
    level: props.lesson.level.name,
    categories: props.lesson.categories,
    is_free: props.lesson.is_free,
    updating: true,
    image_update: null,
    pdf_update: null,
    content_update: null,
    image_update_flag: false,
    pdf_update_flag: false,
    content_update_flag: false
})

const handleSelect = (_categories_selected) => {
    categories_select.value = _categories_selected
    form.categories = categories_select.value
}

const handleFile = (_file_selected) => {
file_select.value = _file_selected
form.pdf_update = file_select.value
form.pdf_update_flag = true
}

const handleImage = (_image_selected) => {
image_select.value = _image_selected
form.image_update= image_select.value
form.image_update_flag = true
}

const handleContent = (_content_selected) => {
content_select.value = _content_selected
form.content_update = content_select.value
form.content_update_flag = true
}

const handleSend = id => {
    console.log(form)
    form.post(`/lessons/update/${id}`) 
    /* router.post(`/lessons/${id}`, {
        _method: 'put',
        lesson: form,
    }) */
}


</script>

<template>
    <AppLayout title="Edit Lesson">
        <template #header>
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">Edit Lesson</h1>
        </template>
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <LessonForm :updating="true" :form="form" :levels="levels" 
                            :categories="categories" @changeSelected="handleSelect"
                            @fileSelected="handleFile" @imageSelect="handleImage" 
                            @contentSelect="handleContent"
                            @send="handleSend(lesson.id)" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>