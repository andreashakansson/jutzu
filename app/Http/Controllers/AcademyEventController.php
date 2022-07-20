<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Services\AcademyEventService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class AcademyEventController extends Controller
{

    public function index()
    {
        $academy = Auth::user()->academies()->first();
        $events = $academy->events()
            ->where('end_at', '>=', Carbon::now())
            ->orderBy('start_at', 'asc')->get();
        $out = [];
        foreach ($events as $event) {
            $out[] = [
                'id' => $event->id,
                'name' => $event->name,
                'start_at_human' => $event->start_at_human,
                'end_at_human' => $event->end_at_human,
                'description' => $event->description
            ];
        }
        $data = [
            'academy' => $academy,
            'events' => $out
        ];
        return Inertia::render('Event/Index', $data);
    }

    public function create(): Response
    {
        Auth::user()->academies()->firstOrFail();

        $data = [
            'event' => [
                'id' => null,
                'name' => null,
                'start_date' => now()->format('Y-m-d'),
                'start_hour' => 12,
                'start_minute' => 00,
                'end_date' => now()->format('Y-m-d'),
                'end_hour' => 12,
                'end_minute' => 00,
                'description' => null,
            ],
            'hours' => AcademyEventService::getHours(),
            'minutes' => AcademyEventService::getMinutes()
        ];
        return Inertia::render('Event/CreateEdit', $data);
    }

    public function edit($eventId)
    {
        $event = Auth::user()->academies()->first()->events()->findOrFail($eventId);
        $data = [
            'event' => [
                'id' => $event->id,
                'name' => $event->name,
                'start_date' => $event->start_at->format('Y-m-d'),
                'start_hour' => AcademyEventService::removeLeadingZero($event->start_at->format('H')),
                'start_minute' => AcademyEventService::removeLeadingZero($event->start_at->format('i')),
                'end_date' => $event->end_at->format('Y-m-d'),
                'end_hour' => AcademyEventService::removeLeadingZero($event->end_at->format('H')),
                'end_minute' => AcademyEventService::removeLeadingZero($event->end_at->format('i')),
                'description' => $event->description,
            ],
            'hours' => AcademyEventService::getHours(),
            'minutes' => AcademyEventService::getMinutes()
        ];
        return Inertia::render('Event/CreateEdit', $data);
    }

    public function submit(StoreEventRequest $request)
    {
        $user = Auth::user();
        $academy = $user->academies()->firstOrFail();

        $startAt = $request->input('start_date') . ' ' .
            AcademyEventService::addLeadingZero($request->input('start_hour')) .
            ':' .
            AcademyEventService::addLeadingZero($request->input('start_minute'));
        $endAt = $request->input('end_date') . ' ' .
            AcademyEventService::addLeadingZero($request->input('end_hour')) .
            ':' .
            AcademyEventService::addLeadingZero($request->input('end_minute'));

        $id = $request->input('id');
        if ($id) {
            $event = $academy->events()->findOrFail($id);
            $event->fill([
                'name' => $request->input('name'),
                'start_at' => $startAt,
                'end_at' => $endAt,
                'description' => $request->input('description')
            ]);
            $event->save();
            $message = __('Event has been updated!');
        } else {
            $academy->events()->create([
                'academy_id' => $academy->id,
                'name' => $request->input('name'),
                'start_at' => $startAt,
                'end_at' => $endAt,
                'description' => $request->input('description'),
                'created_by' => $user->id
            ]);
            $message = __('Event has been added!');
        }

        return Redirect::route('event.index')->with(['toast' => ['message' => $message]]);
    }

    public function delete($eventId)
    {
        $event = Auth::user()->academies()->first()->events()->findOrFail($eventId);

        $message = __('Event has been deleted!');
        $event->delete();

        return Redirect::route('event.index')->with(['toast' => ['message' => $message]]);
    }
}
