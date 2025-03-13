<script lang="ts" setup>
import { onMounted, ref } from 'vue';
import Vditor from 'vditor'
const editorRef = ref(null)
let vditorInstance: Vditor | null = null

const props = defineProps<{
    onChange: Function
}>()

onMounted(() => {
    if (editorRef.value) {
        vditorInstance = new Vditor(editorRef.value, {
            height: 400,
            mode: 'ir',
            lang: 'en_US',
            cache: { enable: false },
            after: () => {
                console.log('Editor is ready');
                props.onChange('Type something...')
            },
            input: () => {
                console.log('Editor Changes');
                if (vditorInstance) {
                    const content = vditorInstance.getValue()
                    props.onChange(content)
                }
            }
        })
    }
})
</script>

<template>
    <div>
        <div ref="editorRef" class="vditor-container"></div>
    </div>
</template>

<style>
.vditor-container {
    width: 100%;
}
</style>