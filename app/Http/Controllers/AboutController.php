<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\FounderMember;
use App\Models\OrgProfile;

class AboutController extends Controller
{
    public function index()
    {
        return view('about.index');
    }

    public function founderMembers()
    {
        $members = FounderMember::where('is_active', true)->orderBy('sort_order')->get();
        return view('about.founder-members', compact('members'));
    }

    public function orgProfile()
    {
        $profiles = OrgProfile::orderBy('sort_order')->orderBy('sl_no')->get();
        return view('about.org-profile', compact('profiles'));
    }

    public function documents()
    {
        $documents = Document::where('is_active', true)->orderBy('sort_order')->get();
        return view('about.documents', compact('documents'));
    }
}
