<?php

namespace App\Http\Controllers;

use App\Models\Events;
use App\Services\EventService;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EventsController extends Controller {
    private EventService $eventService;

    public function __construct(EventService $eventService) {
        $this->eventService = $eventService;
    }

    public function index(Request $request) {
        Log::info('🔍 Request URL:', ['url' => $request->url()]);

        $search = $request->query('search');
        $perPage = (int) $request->query('perPage', 10);
        $page = (int) $request->query('page', 1);
        $filters = $request->only(['categories', 'themes', 'sort', 'status', 'location']);
        $query = Events::query();

        Log::debug('📥 Request Parameters:', [
            'search' => $search,
            'filters' => $filters,
            'pagination' => ['perPage' => $perPage, 'page' => $page],
        ]);

        if (!empty($search)) {
            $query = $this->eventService->fullTextSearch($search, $query);
            $events = $query->paginate($perPage, ['*'], 'page', $page);
            Log::debug('📦 Fetched Events:', [
                'data' => collect($events->items())->map(fn($event) => $event->only(['id', 'name']))->toArray(),
            ]);
            return Inertia::render('Events/Index', ['events' => $events]);
        } else {
            $query = $this->eventService->filtering($query, $filters);
            $events = $query->paginate($perPage, ['*'], 'page', $page);
            Log::debug('📦 Fetched Events:', [
                'data' => collect($events->items())->map(fn($event) => $event->only(['id', 'name']))->toArray(),
            ]);
            return Inertia::render('Events/Index', ['events' => $events]);
        }


    }

    public function getUniqueField() {
        $allThemes = Events::pluck('themes')->flatten()->unique()->values()->all();
        $allCategories = Events::pluck('categories')->flatten()->unique()->values()->all();
        $allLocations = Events::pluck('location')->flatten()->unique()->values()->all();
        return response()->json([
            'themes' => $allThemes,
            'categories' => $allCategories,
            'locations' => $allLocations
        ]);
    }

    public function show($id, Request $request) {
        Log::info('Request URL: ' . $request->url());
        $event = Events::findOrFail($id);
        Log::debug('Fetched event: ', ['event' => $event]);
        return Inertia::render('Events/Event', [
            'event' => $event,
        ]);
    }

    public function edit($id) {

    }

    public function update($id) {
        
    }
}
