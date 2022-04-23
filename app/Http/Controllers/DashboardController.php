<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function show(): Response
    {
        $academy = Auth::user()->academies()->first();
        $trainingSessions = null;
        if ($academy) {
            $trainingSessions = $academy->trainingSessions()
                ->with(['techniques'])
                ->orderBy('date', 'desc')
                ->get();
        }
        $data = [
            'academy' => $academy,
            'trainingSessions' => $trainingSessions
        ];
        return Inertia::render('Dashboard', $data);
    }
}
