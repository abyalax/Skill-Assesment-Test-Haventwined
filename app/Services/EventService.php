<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class EventService {

    /**
     * @name FULL TEXT SEARCH
     * @description This function generates a full-text search query to search for events by name, content, location, city and detailed location.
     * @description The query uses the MATCH() function to search the index, and the AGAINST() function to specify the search term.
     * @description The search term is escaped and wrapped in quotes, and the IN NATURAL LANGUAGE MODE argument is used to specify the search mode.
     * @description The results are ordered by relevance using the MATCH() function in the ORDER BY clause.
     */
    public function fullTextSearch($search, $query) {
        $search = trim($search);
        $search = preg_replace('/\s+/', '* ', $search) . '*';

        $query->whereRaw(
            "MATCH(name, content, location, city, detailed_location) AGAINST (? IN NATURAL LANGUAGE MODE)",
            [$search]
        )->orderByRaw(
            "MATCH(name, content, location, city, detailed_location) AGAINST (?) DESC",
            [$search]
        );

        Log::debug('🔎 Search Query Active:', ['search' => $search]);
        return $query;
    }

    public function filtering($query, $filters) {
        foreach (['categories', 'themes'] as $filter) {
            if (!empty($filters[$filter])) {
                $query->where(function ($q) use ($filter, $filters) {
                    foreach ((array) $filters[$filter] as $value) {
                        $q->orWhereJsonContains($filter, $value);
                    }
                });
            }
        }

        foreach (['location'] as $filter) {
            if (!empty($filters[$filter])) {
                $query->where($filter, $filters[$filter]);
            }
        }

        if (!empty($filters['status'])) {
            if ($filters['status'] === 'active') {
                $query->where('event_start', '>', now()); // Event belum dimulai
            } elseif ($filters['status'] === 'passive') {
                $query->where('event_end', '<', now()); // Event sudah berakhir
            }
        }

        $sortOptions = [
            'newest_events' => ['created_at', 'desc'],
            'nearby_events' => ['registration_start', 'asc'],
            'most_estimated_visitors' => ['estimated_visitors', 'desc'],
        ];

        $sortKey = $filters['sort'] ?? 'newest_events';
        $sortColumn = $sortOptions[$sortKey][0] ?? 'created_at';
        $sortDirection = $sortOptions[$sortKey][1] ?? 'desc';
        $query->orderBy($sortColumn, $sortDirection);

        Log::debug('⚡ Sorting Applied:', ['sort' => $sortOptions[$sortKey]]);

        return $query;
    }
}