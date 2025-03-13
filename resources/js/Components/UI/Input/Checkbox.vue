<script setup lang="ts">
import { ref, watchEffect, defineEmits, defineProps, withDefaults } from 'vue';

const checkboxRef = ref<HTMLInputElement | null>(null);
const emit = defineEmits(['update:checked']);

const props = withDefaults(
  defineProps<{
    checked: boolean;
    value?: any;
    onChange?: (event: Event) => void;
    indeterminate?: boolean;
    class?: string;
  }>(),
  {
    checked: false,
    class: "rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500",
    onChange: () => {},
    indeterminate: false,
    value: null
  }
);

watchEffect(() => {
  if (checkboxRef.value) {
    checkboxRef.value.checked = props.checked;
    checkboxRef.value.indeterminate = props.indeterminate;
  }
});
</script>

<template>
  <input
    ref="checkboxRef"
    type="checkbox"
    :value="value"
    :checked="checked"
    @change="(e) => {
      const isChecked = (e.target as HTMLInputElement).checked;
      emit('update:checked', isChecked);
      props.onChange?.(e);
    }"
    :class="props.class"
  />
</template>
