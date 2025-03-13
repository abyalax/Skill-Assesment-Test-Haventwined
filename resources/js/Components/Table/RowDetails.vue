<script lang="ts" setup>
import { Event } from '@/types';
import { formatDate } from '@/utils';
import MarkdownContent from '../Markdown/MarkdownContent.vue';

const props = defineProps<{
    row: Event
}>()
const data = props.row

</script>
<template>
    <div class="p-2 h-fit w-full text-gray-600 text-sm">
        <div class="flex gap-2">
            <div>
                <h1>Name</h1>
                <h1>Themes</h1>
                <h1>Categories</h1>
                <h1>Registration</h1>
                <h1>Events Date</h1>
                <h1>Estimated Participants</h1>
                <h1>Location</h1>
                <h1>Contents</h1>
            </div>
            <div>
                <p>: {{ data.name }}</p>
                <p>: {{ data.themes.join(', ') }}</p>
                <p>: {{ data.categories.join(', ') }}</p>
                <p>: {{ formatDate(data.registration_start, false) }} - {{ formatDate(data.registration_end, false) }}</p>
                <p>: {{ formatDate(data.event_start, false) }} - {{ formatDate(data.event_end, false) }}</p>
                <p>: {{ data.estimated_visitors }}</p>
                <p>: {{ data.city }}, {{ data.location }}, {{ data.detailed_location }}</p>
                <span>: <MarkdownContent :content="data.content"/></span>
            </div>
        </div>
    </div>
</template>