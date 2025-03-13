import { Event } from "@/types";
import { rankItem } from "@tanstack/match-sorter-utils";
import { FilterFn } from "@tanstack/vue-table"

export const fuzzyFilter: FilterFn<Event> = (row, columnId, value, addMeta) => {
    const itemRank = rankItem(row.getValue(columnId), value);
    addMeta({ itemRank });
    return itemRank.passed;
};

export const reorder = (list: string[],startIndex: number,endIndex: number): string[] => {
    const result = Array.from(list);
    const [removed] = result.splice(startIndex, 1);
    result.splice(endIndex, 0, removed);
    return result;
};

export const convertCamelToTitleCase = (text: string) => {
    if (!text) return "";
    const result = text.replace(/([A-Z])/g, " $1");
    return result.charAt(0).toUpperCase() + result.slice(1);
  };