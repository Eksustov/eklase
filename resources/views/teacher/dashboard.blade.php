<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

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
                    <h3 class="text-lg font-semibold mb-2">View Grades by Subject</h3>
                    @if($subjects->count())
                        <ul>
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
                    <h3 class="text-lg font-semibold mb-2">View Grades by Student</h3>
                    @if($students->count())
                        <ul>
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
