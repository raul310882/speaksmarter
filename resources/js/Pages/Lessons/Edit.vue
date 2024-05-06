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

if (props.lesson.is_free === 1){
    props.lesson.is_free = true
} else {
    props.lesson.is_free = false
}
 
const form = useForm({
    name: props.lesson.name,
    description: props.lesson.description,
    content_uri: props.lesson.content_uri,
    pdf_uri: props.lesson.pdf_uri,
    level_id: props.lesson.level_id,
    level: props.lesson.level.name,
    categories: props.lesson.categories,
    is_free: props.lesson.is_free

})

const categories_select = ref([])

const handleSelect = (_categories_selected) => {
    categories_select.value = _categories_selected
    form.categories = categories_select.value
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
                            @submit="form.put(route('lessons.update', lesson.id))" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>