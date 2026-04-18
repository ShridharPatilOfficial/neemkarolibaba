<?php

namespace App\Http\Controllers;

use App\Models\WorkVideo;

class WorkInActionController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $perPage = in_array((int) $request->input('per_page'), [25, 50, 100]) ? (int) $request->input('per_page') : 25;
        $videos  = WorkVideo::where('is_active', true)->latest()->paginate($perPage)->withQueryString();
        return view('work-in-action', compact('videos', 'perPage'));
    }
}
