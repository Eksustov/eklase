<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            Grades for {{ $subject->name }}
        </h2>
    </x-slot>

    <div class="py-12 max-w-5xl mx-auto">
        <div class="bg-white p-6 rounded shadow">
            @if ($grades->count())
                <table class="w-full table-auto border">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2 border">Student</th>
                            <th class="px-4 py-2 border">Grade</th>
                            <th class="px-4 py-2 border">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($grades as $grade)
                            <tr>
                                <td class="px-4 py-2 border">
                                    {{ $grade->student->first_name }} {{ $grade->student->last_name }}
                                </td>
                                <td class="px-4 py-2 border">{{ $grade->grade }}</td>
                                <td class="px-4 py-2 border">{{ $grade->created_at->format('Y-m-d') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>No grades recorded for this subject yet.</p>
            @endif
        </div>
    </div>
</x-app-layout>
