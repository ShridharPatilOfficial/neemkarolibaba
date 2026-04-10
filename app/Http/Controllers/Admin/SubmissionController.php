<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactSubmission;
use App\Models\JoinUsSubmission;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    public function joinUs(Request $request)
    {
        $submissions = JoinUsSubmission::orderByDesc('created_at')->paginate(20);
        JoinUsSubmission::where('is_read', false)->update(['is_read' => true]);
        return view('admin.submissions.join-us', compact('submissions'));
    }

    public function contact(Request $request)
    {
        $submissions = ContactSubmission::orderByDesc('created_at')->paginate(20);
        ContactSubmission::where('is_read', false)->update(['is_read' => true]);
        return view('admin.submissions.contact', compact('submissions'));
    }

    public function destroyJoin(JoinUsSubmission $joinUsSubmission)
    {
        $joinUsSubmission->delete();
        return back()->with('success', 'Submission deleted.');
    }

    public function destroyContact(ContactSubmission $contactSubmission)
    {
        $contactSubmission->delete();
        return back()->with('success', 'Submission deleted.');
    }
}
