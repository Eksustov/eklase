<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Grades') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if ($grades->count())
                    <table class="w-full table-auto border border-gray-300 text-left">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 border-b">Subject</th>
                                <th class="px-4 py-2 border-b">Grade</th>
                                <th class="px-4 py-2 border-b">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($grades as $grade)
                                <tr>
                                    <td class="px-4 py-2 border-b">{{ $grade->subject->name }}</td>
                                    <td class="px-4 py-2 border-b">{{ $grade->grade }}</td>
                                    <td class="px-4 py-2 border-b">{{ $grade->created_at->format('Y-m-d') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-gray-500">You don't have any grades yet.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
