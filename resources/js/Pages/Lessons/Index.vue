<script>
export default {
    name: "LessonsIndex",
};
</script>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link } from "@inertiajs/vue3";
import { Inertia } from "@inertiajs/inertia";
import { ref } from "vue";


defineProps({
    lessons: {
        type: Object,
        required: true
    }
});

const deleteLesson = (id, name) => {
    if (confirm('Are you sure you want to delete the '+ name +' lesson?')) {
        Inertia.delete(route('lessons.destroy', id));
    }
}

const srcImage = ref([
    {
        id: 1,
        url: require ("@/storage/image_lessons/1714684080.jpg")
    }
])

console.log(srcImage)

</script>

<template>
    <AppLayout title="Lessons">
        <template #header>
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                Lessons
            </h1>
        </template>
        <img :src="srcImage.url" />
        <pre>
            {{srcImage}}
        </pre>
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between" v-if="$page.props.user.permissions.includes('create lessons')">
                        <Link :href="route('lessons.create')" class="text-white text-xs font-bold bg-indigo-500 hover:bg-indigo-700 py-2 px-4 rounded">
                            CREATE LESSON
                        </Link>
                    </div>

                <div class="mt-4 relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-300 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">ID</th>
                                <th scope="col" class="px-6 py-3">Name</th>
                                <th scope="col" class="px-6 py-3">Description</th>
                                <th scope="col" class="px-6 py-3">Imagen</th>
                                <th scope="col" class="px-6 py-3">ZIP</th>
                                <th scope="col" class="px-6 py-3">PDF</th>
                                <th scope="col" class="px-6 py-3">Level</th>
                                <th scope="col" class="px-6 py-3">Categories</th>
                                <th scope="col" class="px-6 py-3">Free</th>
                                <th scope="col" class="px-6 py-3"></th>
                                <th scope="col" class="px-6 py-3"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="lesson in lessons.data" class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ lesson.id }}</th>
                                <td class="px-6 py-4">{{ lesson.name }}</td>
                                <td class="px-6 py-4">{{ lesson.description }}</td>
                                <td class="px-6 py-4"><img src="" /></td>
                                <td class="px-6 py-4">{{ lesson.content_uri }}</td>
                                <td class="px-6 py-4">{{ lesson.pdf_uri }}</td>
                                <td class="px-6 py-4">{{ lesson.level }}</td>
                                <td class="px-6 py-4">
                                    <ul>
                                        <li v-for="category in lesson.categories">{{ category.name }}</li>
                                    </ul>
                                </td>
                                
                                <td class="px-6 py-4">{{ lesson.is_free ? 'Yes' : 'No' }}</td>
                                <td><Link class="py-2 px-4 bg-indigo-100 rounded-md hover:bg-indigo-300 font-semibold text-xs uppercase" :href="route('lessons.edit', lesson.id)" 
                                    v-if="$page.props.user.permissions.includes('update lessons')">Edit</Link>
                                </td>
                                <td><button class="py-2 px-4 text-red-600 font-semibold text-xs uppercase bg-indigo-100 rounded-md hover:bg-indigo-300" 
                                    @click="deleteLesson(lesson.id, lesson.name)" v-if="$page.props.user.permissions.includes('delete lessons')">Delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                    <div class="flex justify-between mt-2">
                        <Link v-if="lessons.current_page > 1" :href="lessons.prev_page_url" class="py-2 px-4 rounded bg-gray-300">
                            PREVIUS
                        </Link>
                        <div v-else></div>
                        <Link v-if="lessons.current_page < lessons.last_page" :href="lessons.next_page_url" class="py-2 px-4 rounded bg-gray-300">
                            NEXT
                        </Link>
                        <div v-else></div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
