import { computed, h, resolveComponent } from "vue";
import { createColumnHelper } from "@tanstack/vue-table"
import Checkbox from "../UI/Input/Checkbox.vue";
import { formatDate } from "@/utils";
import { Event } from "@/types";
import ArrowsCollapse from "../Icons/ArrowsCollapse.vue";

const DISPLAY_COLUMN_SIZE = 100
const columnHelper = createColumnHelper<Event>();

export const columns = computed(() => ([
    columnHelper.display({
        id: 'selection',
        header: ({ table }) => {
            return h('div', { class: 'flex justify-center items-center gap-2' }, [
                h(Checkbox, {
                    checked: table?.getIsAllRowsSelected(),
                    indeterminate: table?.getIsSomeRowsSelected(),
                    onChange: (e) => {
                        console.log('[HEADER] Toggle All Clicked');
                        table?.getToggleAllRowsSelectedHandler()?.(e);
                    },
                }),
            ]);
        },
        cell: ({ row }) => {
            return h('div', { class: 'flex justify-center items-center gap-2' }, [
                h(Checkbox, {
                    checked: row?.getIsSelected(),
                    onChange: (e) => {
                        console.log(`[CELL] Toggle Row ${row.id} Clicked`);
                        row?.getToggleSelectedHandler()?.(e);
                    },
                }),
            ]);
        },
        size: DISPLAY_COLUMN_SIZE,
    }),
    columnHelper.display({
        id: 'expand',
        cell: ({ row }) => row.getCanExpand() && (
            h('div', { class: 'flex justify-center items-center' }, [
                h('button', {
                    class: 'text-xs p-1',
                    onClick: row.getToggleExpandedHandler(),
                }, [
                    row.getIsExpanded()
                        ? h(resolveComponent('ArrowsCollapse'))
                        : h(resolveComponent('ArrowsExpand'))
                ])
            ])
        )
    }),
    columnHelper.accessor('name', {
        id: 'name',
        header: 'Name',
        size: DISPLAY_COLUMN_SIZE,
    }),
    columnHelper.accessor('content', {
        id: 'content',
        header: 'Content',
        size: DISPLAY_COLUMN_SIZE,
        cell: ({ row }) => {
            const content = row.getValue("content") as string;
            const truncatedText = content.length > 50 ? content.replace(/^## Tentang Event\s*/, "").slice(0, 50) + "..." : content;

            return h('div', { class: 'flex justify-center items-center gap-2' }, [
                h('span', { class: 'text-sm' }, truncatedText),
            ]);
        }
    }),
    columnHelper.accessor('location', {
        id: 'location',
        header: 'Location',
        size: DISPLAY_COLUMN_SIZE,
    }),
    columnHelper.accessor('detailed_location', {
        id: 'detailed_location',
        header: 'Detail Location',
        size: DISPLAY_COLUMN_SIZE,
    }),
    columnHelper.accessor('estimated_visitors', {
        id: 'estimated_visitors',
        header: 'Estimated Visitors',
        size: DISPLAY_COLUMN_SIZE,
    }),
    columnHelper.accessor('categories', {
        id: 'categories',
        header: 'Category',
        size: DISPLAY_COLUMN_SIZE,
    }),
    columnHelper.accessor('themes', {
        id: 'themes',
        header: 'Themes',
        size: DISPLAY_COLUMN_SIZE,
    }),
    columnHelper.accessor(row => `${formatDate(row.registration_start, true, false)} - ${formatDate(row.registration_end, true, false)}`, {
        id: 'registration',
        header: 'Registration Date',
        size: DISPLAY_COLUMN_SIZE,
    }),
    columnHelper.accessor(row => `${formatDate(row.event_start, true, false)} - ${formatDate(row.event_end, true, false)}`, {
        id: 'event',
        header: 'Event Date',
        size: DISPLAY_COLUMN_SIZE,
    }),
    columnHelper.accessor('time', {
        id: 'time',
        header: 'Time',
        size: DISPLAY_COLUMN_SIZE,
    }),
    columnHelper.accessor('created_at', {
        id: 'created_at',
        header: 'Created ',
        size: DISPLAY_COLUMN_SIZE,
        cell: (info) => formatDate(info.getValue())
    }),
    columnHelper.accessor('updated_at', {
        id: 'updated_at',
        header: 'Updated',
        size: DISPLAY_COLUMN_SIZE,
        cell: (info) => formatDate(info.getValue())
    }),
    columnHelper.display({
        id: 'manage',
        header: () => h('div', { class: 'flex justify-center items-center' }, 'Action'),
        cell: ({ row }) =>
            h('div', { class: 'flex justify-center items-center' }, [
                h('a', {
                    class: 'text-xs p-1 text-blue-500 underline hover:text-blue-700',
                    href: route('dashboard.event.edit', { event: row.original.id }),
                }, 'Manage')
            ]),
        size: DISPLAY_COLUMN_SIZE,
    })    
]))

export const columnIds = computed(() => columns.value.map(column => column.id) as string[])

export const initialColumnVisibility = computed(() =>
    columnIds.value.reduce((acc: Record<string, boolean>, val) => {
        acc[val] = ['selection', 'expand', 'name', 'location', 'estimated_visitors', 'registration', 'event', 'manage'].includes(val);
        return acc;
    }, {})
);