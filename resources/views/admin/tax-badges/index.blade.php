@extends('admin.layouts.app')
@section('title', 'Tax Exemption Badges')

@section('content')
<div class="flex items-center justify-between mb-6">
    <p class="text-sm text-gray-500">Badges shown on the donate page Tax Exemption card. Click a badge → opens linked document.</p>
    <a href="{{ route('admin.tax-badges.create') }}"
       class="inline-flex items-center gap-2 bg-purple-900 hover:bg-purple-800 text-white font-bold py-2 px-5 rounded-lg text-sm transition">
        <i class="fas fa-plus"></i> Add Badge
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="bg-gray-50 border-b border-gray-100 text-left">
                <th class="px-4 py-3 font-semibold text-gray-600 w-12">#</th>
                <th class="px-4 py-3 font-semibold text-gray-600">Label</th>
                <th class="px-4 py-3 font-semibold text-gray-600">Linked Document</th>
                <th class="px-4 py-3 font-semibold text-gray-600 w-20">Order</th>
                <th class="px-4 py-3 font-semibold text-gray-600 w-20">Status</th>
                <th class="px-4 py-3 font-semibold text-gray-600 w-28">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($badges as $badge)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 text-gray-400">{{ $loop->iteration }}</td>
                <td class="px-4 py-3">
                    <span class="bg-orange-100 text-orange-700 font-bold text-xs px-3 py-1 rounded-full border border-orange-200">{{ $badge->label }}</span>
                </td>
                <td class="px-4 py-3 text-gray-600">
                    @if($badge->document)
                        <span class="inline-flex items-center gap-1 text-blue-600 text-xs"><i class="fas fa-file-alt"></i> {{ $badge->document->name }}</span>
                    @else
                        <span class="text-gray-300 text-xs italic">No document linked</span>
                    @endif
                </td>
                <td class="px-4 py-3 text-gray-500">{{ $badge->sort_order }}</td>
                <td class="px-4 py-3">
                    @if($badge->is_active)
                        <span class="text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded-full font-semibold">Active</span>
                    @else
                        <span class="text-xs bg-gray-100 text-gray-500 px-2 py-0.5 rounded-full font-semibold">Hidden</span>
                    @endif
                </td>
                <td class="px-4 py-3">
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.tax-badges.edit', $badge) }}"
                           class="w-7 h-7 flex items-center justify-center rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-600 transition" title="Edit">
                            <i class="fas fa-pen text-xs"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.tax-badges.destroy', $badge) }}"
                              onsubmit="return confirm('Delete this badge?')">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    class="w-7 h-7 flex items-center justify-center rounded-lg bg-red-50 hover:bg-red-100 text-red-500 transition" title="Delete">
                                <i class="fas fa-trash text-xs"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-4 py-10 text-center text-gray-400 text-sm">No badges yet. Add your first one.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
