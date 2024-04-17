<script>
export default {
    name: "LessonsIndex",
};
</script>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link } from "@inertiajs/vue3";
import { Inertia } from "@inertiajs/inertia";

defineProps({
    lessons: {
        type: Object,
        required: true
    }
});

const deleteLesson = id => {
    if (confirm('Are you sure you want to delete this lesson?')) {
        Inertia.delete(route('lessons.destroy', id));
    }
}

</script>

<template>
    <AppLayout title="Lessons">
        <template #header>
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                Lessons
            </h1>
        </template>

        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between" v-if="$page.props.user.permissions.includes('create lessons')">
                        <Link :href="route('lessons.create')" class="text-white text-xs font-bold bg-indigo-500 hover:bg-indigo-700 py-2 px-4 rounded">
                            CREATE LESSON
                        </Link>
                    </div>
                
                <div class="mt-4">
                    <ul role="list" class="divide-y divide-gray-100">
                        <li class="flex justify-between gap-x-6 py-3" v-for="lesson in lessons.data">
                            <div class="flex min-w-0 gap-x-4">
                                <div class="min-w-0 flex-auto">
                                    <p class="text-md font-semibold leading-6 text-gray-900">{{ lesson.name }}</p>
                                </div>
                            </div>
                            <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
                                <p class="text-sm leading-6 text-gray-900  space-x-1.5">
                                    <Link class="py-2 px-4 bg-indigo-100 rounded-md hover:bg-indigo-300 font-semibold text-xs uppercase" :href="route('lessons.edit', lesson.id)" v-if="$page.props.user.permissions.includes('update lessons')">Edit</Link>
                                    <Link class="py-2 px-4 text-red-600 font-semibold text-xs uppercase bg-indigo-100 rounded-md hover:bg-indigo-300" @click="deleteLesson(lesson.id)" v-if="$page.props.user.permissions.includes('delete lessons')">Delete</Link>
                                </p>
                            </div>
                        </li>
                    </ul>
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
