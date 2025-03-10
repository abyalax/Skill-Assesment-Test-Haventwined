<script lang="ts" setup>
import { usePage } from '@inertiajs/vue3';

const page = usePage()
console.log(page.props);


</script>

<template>
    <div class="p-20 flex flex-col gap-4">
        Testing for routes Event Detail
        <pre class="text-wrap text-black">
            {{ page.props.event }}
        </pre>
    </div>
</template>
