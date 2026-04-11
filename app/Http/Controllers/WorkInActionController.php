<?php

namespace App\Http\Controllers;

use App\Models\WorkVideo;

class WorkInActionController extends Controller
{
    public function index()
    {
        $videos = WorkVideo::where('is_active', true)->latest()->paginate(12);
        return view('work-in-action', compact('videos'));
    }
}
