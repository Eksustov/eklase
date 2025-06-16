<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Grades') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">
                @if ($grades->count())

                    <div class="flex justify-end mb-4">
                        <a href="{{ route('grades.export.pdf') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Export as PDF</a>
                    </div>

                    @php
                        $months = $grades->pluck('created_at')->map->format('F Y')->unique();
                        $subjects = $grades->pluck('subject.name')->unique();

                        $gradesMatrix = [];

                        foreach ($grades as $grade) {
                            $month = $grade->created_at->format('F Y');
                            $subject = $grade->subject->name;
                            $gradesMatrix[$subject][$month][] = $grade->grade;
                        }
                    @endphp

                    <table class="w-full table-auto border border-gray-300 text-center">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 border">Subject</th>
                                @foreach ($months as $month)
                                    <th class="px-4 py-2 border">{{ $month }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subjects as $subject)
                                <tr>
                                    <td class="px-4 py-2 border font-medium text-left">{{ $subject }}</td>
                                    @foreach ($months as $month)
                                        <td class="px-4 py-2 border">
                                            @if (isset($gradesMatrix[$subject][$month]))
                                                {{ implode(', ', $gradesMatrix[$subject][$month]) }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                    @endforeach
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
