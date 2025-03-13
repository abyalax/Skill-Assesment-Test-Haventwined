<script setup lang="ts">
import { ref, computed } from "vue";
import { Table } from "@tanstack/vue-table";
import { Event } from "@/types";
import { convertCamelToTitleCase } from "./Utils";
import FilterSquare from "../Icons/FilterSquare.vue";

interface Props {
    table: Table<Event>;
    columnIds: string[];
}

const props = defineProps<Props>();
const isPopoverOpen = ref(false);

const columnVisibilityCheckboxState = computed(() =>
    Object.entries(props.table.getState().columnVisibility)
        .filter(([_, value]) => value)
        .map(([key]) => key)
);

const togglePopover = () => {
    isPopoverOpen.value = !isPopoverOpen.value;
};

const setColumnVisibility = (visible: boolean) => {
    props.table.setColumnVisibility(
        props.columnIds.reduce((acc: Record<string, boolean>, val) => {
            acc[val] = visible;
            return acc;
        }, {})
    );
};
</script>

<template>
    <div class="relative z-10">
        <!-- Trigger Button -->
        <el-button type="default" size="large" @click="togglePopover">
            <FilterSquare :width="20" :height="20" class="mr-2"/>
            Filter Columns
        </el-button>

        <!-- Popover -->
        <div v-if="isPopoverOpen" class="absolute z-10 w-64 bg-white border rounded-md shadow-md p-4 top-10">
            <div class="mb-4">
                <fieldset class="flex items-center gap-4">
                    <label class="flex items-center gap-2">
                        <input type="radio" name="column-visibility" value="all" class="form-radio" checked
                            @change="setColumnVisibility(true)" />
                        Show All
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="radio" name="column-visibility" value="none" class="form-radio"
                            @change="setColumnVisibility(false)" />
                        Show None
                    </label>
                </fieldset>
            </div>

            <!-- Column Checkbox Group -->
            <div class="flex flex-col gap-2">
                <label v-for="id in props.columnIds" :key="id" class="flex items-center gap-2">
                    <input type="checkbox" class="form-checkbox" :value="id"
                        :checked="columnVisibilityCheckboxState.includes(id)" @change="(e) => {
                            const target = e.target as HTMLInputElement;
                            const selectedOptions = target.checked ? [...columnVisibilityCheckboxState, id] : columnVisibilityCheckboxState.filter((key) => key !== id);
                            props.table.setColumnVisibility(props.columnIds.reduce((acc: Record<string, boolean>, val) => {
                                acc[val] = selectedOptions.includes(val);
                                return acc;
                            }, {})
                            );
                        }" />
                    {{ convertCamelToTitleCase(id) }}
                </label>
            </div>
        </div>
    </div>
</template>
