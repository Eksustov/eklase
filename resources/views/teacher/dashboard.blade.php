<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Welcome Message -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Welcome back teacher!") }}
                </div>
            </div>

            <!-- Create Grade Button -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <a href="{{ route('grades.create') }}" 
                       class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                        + Create Grade
                    </a>
                </div>
            </div>

            <!-- View Grades by Subject -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">View Grades by Subject</h3>

                    <form method="GET" class="mb-4 flex gap-2 flex-wrap">
                        <input type="text" name="subject_search" placeholder="Search subjects..." value="{{ request('subject_search') }}"
                               class="border p-2 rounded w-64">
                        <select name="subject_sort" class="border p-2 rounded">
                            <option value="">Sort</option>
                            <option value="asc" {{ request('subject_sort') == 'asc' ? 'selected' : '' }}>A–Z</option>
                            <option value="desc" {{ request('subject_sort') == 'desc' ? 'selected' : '' }}>Z–A</option>
                        </select>
                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                            Apply
                        </button>
                    </form>

                    @if($subjects->count())
                        <ul class="list-disc list-inside">
                            @foreach($subjects as $subject)
                                <li>
                                    <a href="{{ route('grades.bySubject', $subject) }}" class="text-blue-600 hover:underline">
                                        {{ $subject->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>No subjects available.</p>
                    @endif
                </div>
            </div>

            <!-- View Grades by Student -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">View Grades by Student</h3>

                    <form method="GET" class="mb-4 flex gap-2 flex-wrap">
                        <input type="text" name="student_search" placeholder="Search students..." value="{{ request('student_search') }}"
                               class="border p-2 rounded w-64">
                        <select name="student_sort" class="border p-2 rounded">
                            <option value="">Sort</option>
                            <option value="asc" {{ request('student_sort') == 'asc' ? 'selected' : '' }}>A–Z</option>
                            <option value="desc" {{ request('student_sort') == 'desc' ? 'selected' : '' }}>Z–A</option>
                        </select>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                            Apply
                        </button>
                    </form>

                    @if($students->count())
                        <ul class="list-disc list-inside">
                            @foreach($students as $student)
                                <li>
                                    <a href="{{ route('grades.byStudent', $student) }}" class="text-blue-600 hover:underline">
                                        {{ $student->first_name }} {{ $student->last_name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>No students available.</p>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
