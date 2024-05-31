<script>
    export default {
        name: 'LessonCreate'
    }
</script>

<script setup>
    import { useForm } from '@inertiajs/vue3'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import LessonForm from '../../Components/Lessons/Form.vue'
    import { ref } from 'vue'
 
    defineProps({
        categories: {
            type: Object,
            required: true
        },
        levels: {
            type: Object,
            required: true
        }
    })
    const form = useForm({
        name: '',
        description: '',
        content_uri: '',
        level_id: 0,
        categories: [],
        is_free: false,
        image: null,
        pdf: null,
        content: null
    })

    const categories_select = ref([])
    const file_select = ref([])
    const image_select = ref([])
    const content_select = ref([])

    const handleSelect = (_categories_selected) => {
    categories_select.value = _categories_selected
    form.categories = categories_select.value
    }

    const handleFile = (_file_selected) => {
    file_select.value = _file_selected
    form.pdf = file_select.value
    }

    const handleImage = (_image_selected) => {
    image_select.value = _image_selected
    form.image = image_select.value
    }

    const handleContent = (_content_selected) => {
    content_select.value = _content_selected
    form.content = content_select.value
    }

</script>

<template>
    <AppLayout title="Create Lesson">
        <template #header>
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">Create Lesson</h1>
        </template>
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <LessonForm 
                            :form="form" :categories="categories" :levels="levels" 
                            @changeSelected="handleSelect" @fileSelected="handleFile" 
                            @imageSelect="handleImage" @contentSelect="handleContent"
                            @send="form.post(route('lessons.store'))" />   
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>