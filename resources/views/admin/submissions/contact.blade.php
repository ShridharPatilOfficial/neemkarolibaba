@extends('admin.layouts.app')
@section('title', 'Contact Submissions')

@section('content')
@if(session('success'))
<div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm">{{ session('success') }}</div>
@endif

<div class="flex justify-between items-center mb-5">
    <p class="text-gray-500 text-sm">{{ $submissions->total() }} total submission(s) — new submissions are marked as read when you open this page</p>
</div>
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold">Name</th>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold">Phone</th>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold">Email</th>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold">Message</th>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold w-32">Received</th>
                <th class="py-3 px-4 text-right text-gray-600 font-semibold w-24">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($submissions as $sub)
            <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                <td class="py-3 px-4 font-medium text-gray-800">{{ $sub->first_name }} {{ $sub->last_name }}</td>
                <td class="py-3 px-4 text-gray-600 font-mono">{{ $sub->phone ?? '-' }}</td>
                <td class="py-3 px-4 text-gray-600">{{ $sub->email }}</td>
                <td class="py-3 px-4 text-gray-600 text-xs max-w-xs">{{ Str::limit($sub->message, 80) }}</td>
                <td class="py-3 px-4 text-gray-400 text-xs">{{ \Carbon\Carbon::parse($sub->created_at)->format('d M Y, h:i A') }}</td>
                <td class="py-3 px-4 text-right space-x-2">
                    <button onclick="showDetail({{ $sub->id }})" class="text-blue-600 hover:text-blue-800 text-xs font-semibold">View</button>
                    <form method="POST" action="{{ route('admin.submissions.contact.destroy', $sub->id) }}" class="inline" onsubmit="return confirm('Delete this submission?')">
                        @csrf @method('DELETE')
                        <button class="text-red-500 hover:text-red-700 text-xs font-semibold">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="py-10 text-center text-gray-400">No submissions yet.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-4 py-3 border-t border-gray-100">{{ $submissions->links() }}</div>
</div>

{{-- Detail Modal --}}
<div id="detailModal" class="fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl max-w-lg w-full p-6 relative">
        <button onclick="closeDetail()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
            <i class="fas fa-times text-lg"></i>
        </button>
        <h3 class="font-bold text-gray-800 text-lg mb-4">Contact Submission</h3>
        <div id="detailContent" class="space-y-3 text-sm"></div>
    </div>
</div>

@push('scripts')
<script>
const submissions = @json($submissions->items());
function showDetail(id) {
    const sub = submissions.find(s => s.id === id);
    if (!sub) return;
    document.getElementById('detailContent').innerHTML = `
        <div class="flex gap-2"><span class="font-semibold text-gray-600 w-20 shrink-0">Name:</span><span class="text-gray-800">${sub.first_name} ${sub.last_name}</span></div>
        <div class="flex gap-2"><span class="font-semibold text-gray-600 w-20 shrink-0">Email:</span><span class="text-gray-800">${sub.email}</span></div>
        <div class="flex gap-2"><span class="font-semibold text-gray-600 w-20 shrink-0">Phone:</span><span class="font-mono text-gray-800">${sub.phone || '-'}</span></div>
        <div class="flex gap-2"><span class="font-semibold text-gray-600 w-20 shrink-0">IP:</span><span class="font-mono text-gray-500 text-xs">${sub.ip_address || '-'}</span></div>
        <div><span class="font-semibold text-gray-600 block mb-1">Message:</span><p class="bg-gray-50 rounded-lg p-3 text-gray-700 leading-relaxed">${sub.message}</p></div>
    `;
    document.getElementById('detailModal').classList.remove('hidden');
}
function closeDetail() {
    document.getElementById('detailModal').classList.add('hidden');
}
document.getElementById('detailModal').addEventListener('click', function(e) {
    if (e.target === this) closeDetail();
});
</script>
@endpush
@endsection
