<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTechniqueRequest;
use App\Services\TechniqueService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class TechniqueController extends Controller
{

    public function index($sortBy = null)
    {
        $academy = Auth::user()->academies()->first();
        $query = $academy->techniques()->withCount('trainingSessions');
        if ($sortBy === 'most-drilled') {
            $query->orderBy('training_sessions_count', 'desc')
                ->orderBy('created_at', 'desc');
        } else {
            $query->orderBy('created_at', 'desc');
        }
        $techniques = $query->get();
        $out = [];
        foreach ($techniques as $technique) {
            $out[] = [
                'id' => $technique->id,
                'name' => $technique->name,
                'description' => $technique->description,
                'youtube_embed_url' => $technique->youtube_embed_url,
                'training_sessions_count' => $technique->training_sessions_count
            ];
        }
        $data = [
            'academy' => $academy,
            'techniques' => $out,
            'sortBy' => $sortBy
        ];
        return Inertia::render('Technique/Index', $data);
    }

    public function create(): Response
    {
        Auth::user()->academies()->firstOrFail();

        $data = [
            'technique' => [
                'id' => null,
                'name' => null,
                'description' => null,
                'youtube_url' => null,
                'has_training_sessions' => false
            ]
        ];
        return Inertia::render('Technique/CreateEdit', $data);
    }

    public function edit($techniqueId)
    {
        $technique = Auth::user()->academies()->first()->techniques()->findOrFail($techniqueId);
        $data = [
            'technique' => [
                'id' => $technique->id,
                'name' => $technique->name,
                'description' => $technique->description,
                'youtube_url' => $technique->youtube_url,
                'has_training_sessions' => (bool) $technique->trainingSessions->count() > 0
            ]
        ];
        return Inertia::render('Technique/CreateEdit', $data);
    }

    public function submit(StoreTechniqueRequest $request)
    {
        $user = Auth::user();
        $academy = $user->academies()->firstOrFail();

        $youtubeUrl = null;
        $youtubeId = null;
        if ($request->input('youtube_url')) {
            $service = new TechniqueService();
            $youtubeUrl = $service->getVideoUrl($request->input('youtube_url'));
            $youtubeId = $service->getYoutubeId($youtubeUrl);
        }

        $id = $request->input('id');
        if ($id) {
            $technique = $academy->techniques()->findOrFail($id);
            $technique->fill([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'youtube_url' => $request->input('youtube_url'),
                'youtube_id' => $youtubeId,
            ]);
            $technique->save();
            $message = __('Technique has been updated!');
        } else {
            $academy->techniques()->create([
                'academy_id' => $academy->id,
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'youtube_url' => $youtubeUrl,
                'youtube_id' => $youtubeId,
                'created_by' => $user->id
            ]);
            $message = __('Technique has been added!');
        }

        return Redirect::route('technique.index')->with(['toast' => ['message' => $message]]);
    }

    public function delete($techniqueId)
    {
        $technique = Auth::user()->academies()->first()->techniques()->findOrFail($techniqueId);

        if ($technique->trainingSessions->count() > 0) {
            $message = __('Technique can not be deleted as it exists on a training session.');
        } else {
            $message = __('Technique has been deleted!');
            $technique->delete();
        }

        return Redirect::route('technique.index')->with(['toast' => ['message' => $message]]);
    }
}
