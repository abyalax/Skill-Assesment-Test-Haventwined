<script lang="ts" setup>
import VueMarkdown from 'vue-markdown-render'
const props = defineProps<{
    content: string
}>()
</script>
<template>
    <div class="prose">
        <vue-markdown :source="props.content" />
    </div>
</template>