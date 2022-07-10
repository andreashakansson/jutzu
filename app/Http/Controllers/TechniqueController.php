<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class TechniqueController extends Controller
{

    public function index()
    {
        $academy = Auth::user()->academies()->first();
        $techniques = $academy->techniques()->orderBy('created_at', 'desc')->get();
        $out = [];
        foreach ($techniques as $technique) {
            $out[] = [
                'id' => $technique->id,
                'name' => $technique->name,
                'description' => $technique->description,
                'youtube_embed_url' => $technique->youtube_embed_url
            ];
        }
        $data = [
            'academy' => $academy,
            'techniques' => $out
        ];
        return Inertia::render('Technique/Index', $data);
    }

}
