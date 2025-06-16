<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            My Grades for {{ $subject->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="w-full table-auto border">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-4 py-2 border text-center">Student</th>
                                <th class="px-4 py-2 border text-center">Grade</th>
                                <th class="px-4 py-2 border text-center">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($grades as $grade)
                                <tr>
                                    <td class="px-4 py-2 border text-center">{{ $grade->student->first_name }} {{ $grade->student->last_name }}</td>
                                    <td class="px-4 py-2 border text-center">{{ $grade->grade }}</td>
                                    <td class="px-4 py-2 border text-center">{{ $grade->created_at->format('F j, Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
