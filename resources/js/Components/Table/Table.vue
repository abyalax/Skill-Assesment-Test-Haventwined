<script lang="ts" setup>

import { useVueTable, FlexRender, getCoreRowModel, getPaginationRowModel, getSortedRowModel, getFilteredRowModel, ColumnDef } from '@tanstack/vue-table'
import { computed, onMounted, onUnmounted, ref, Ref } from 'vue'
import { columnIds, columns, initialColumnVisibility } from './Columns';
import { SortingState } from "@tanstack/vue-table";
import { fuzzyFilter } from './Utils';
import { Search } from '@element-plus/icons-vue'
import { Event } from '@/types';
import RowDetails from './RowDetails.vue';
import ColumnSelector from './ColumnSelector.vue';

const props = defineProps<{
    data: Event[],
}>()
const sorting: Ref<SortingState> = ref([])
const filter = ref('')
const table = useVueTable<Event>({
    data: props.data,
    columns: columns.value,
    getCoreRowModel: getCoreRowModel(),
    getPaginationRowModel: getPaginationRowModel(),
    getSortedRowModel: getSortedRowModel(),
    getFilteredRowModel: getFilteredRowModel(),
    filterFns: { fuzzy: fuzzyFilter },
    globalFilterFn: fuzzyFilter,
    enableRowSelection: true,
    getRowCanExpand: () => true,
    state: {
        get sorting() {
            return sorting.value
        },
        get globalFilter() {
            return filter.value
        },
    },
    onSortingChange: updaterOrValue => {
        sorting.value = typeof updaterOrValue === 'function' ? updaterOrValue(sorting.value) : updaterOrValue
    },
    initialState: {
        columnVisibility: initialColumnVisibility.value,
        columnOrder: columnIds.value,
        pagination: {
            pageIndex: 0,
            pageSize: 5
        }
    }
})
const screenWidth = ref(window.innerWidth)
const updateScreenWidth = () => {
    screenWidth.value = window.innerWidth
}
onMounted(() => {
    window.addEventListener('resize', updateScreenWidth)
})
onUnmounted(() => {
    window.removeEventListener('resize', updateScreenWidth)
})
const paginationLayout = computed(() => {
    return screenWidth.value < 768
        ? 'prev, pager, next'
        : 'total, sizes, prev, pager, next, jumper'
})
const currentPage = computed({
    get: () => table.getState().pagination.pageIndex + 1,
    set: (val) => table.setPageIndex(val - 1),
})
const pageSize = computed({
    get: () => table.getState().pagination.pageSize,
    set: (val) => table.setPageSize(val),
})
const totalRows = computed(() => table.getRowCount())
const handleSizeChange = (size: number) => {
    table.setPageSize(size)
}
const handleCurrentChange = (page: number) => {
    table.setPageIndex(page - 1)
}
console.log(columnIds);

</script>

<template>
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flow-root">
            <div class="my-4 flex gap-6">
                <ColumnSelector :table="table" :column-ids="columnIds" />
                <el-input v-model="filter" style="width: 240px;" size="large" placeholder="Search Here..."
                    :prefix-icon="Search" />
            </div>
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead>
                            <tr v-for="headerGroup in table.getHeaderGroups()" :key="headerGroup.id">
                                <th v-for="header in headerGroup.headers" :key="header.id" scope="col"
                                    class="px-3 py-3.5 text-left text-sm font-semibold text-nowrap text-gray-900"
                                    :class="{
                                        'cursor-pointer select-none': header.column.getCanSort(),
                                    }" @click="header.column.getToggleSortingHandler()?.($event)">
                                    <FlexRender :render="header.column.columnDef.header" :props="header.getContext()" />
                                    {{ { asc: '↑', desc: '↓' }[header.column.getIsSorted() as string] }}
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200">

                            <template v-for="row in table.getRowModel().rows" :key="row.id">
                                <tr>
                                    <td v-for="cell in row.getVisibleCells()" :key="cell.id"
                                        class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        <FlexRender :render="cell.column.columnDef.cell" :props="cell.getContext()" />
                                    </td>
                                </tr>

                                <tr v-if="row.getIsExpanded()">
                                    <td :colspan="row.getVisibleCells().length">
                                        <RowDetails :row="row.original" />
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="my-6">
                <el-pagination v-model:current-page="currentPage" v-model:page-size="pageSize"
                    :page-sizes="[5, 10, 15, 20, 25, 30]" size="default"
                    :disabled="!table.getCanNextPage() && !table.getCanPreviousPage()" :background="false"
                    :layout="paginationLayout" :total="totalRows" @size-change="handleSizeChange"
                    @current-change="handleCurrentChange" />
            </div>
        </div>
    </div>
</template>

<style scoped>
::v-deep(.el-input__inner:focus) {
  outline: none !important;
  box-shadow: none !important;
}
</style>

