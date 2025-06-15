<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Assign Grade') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">

                @if(session('success'))
                    <div class="text-green-600 mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('grades.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="student_id" class="block font-medium">Student</label>
                        <select name="student_id" id="student_id" class="w-full border rounded p-2">
                            @foreach($students as $student)
                                <option value="{{ $student->id }}">
                                    {{ $student->first_name }} {{ $student->last_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="subject_id" class="block font-medium">Subject</label>
                        <select name="subject_id" id="subject_id" class="w-full border rounded p-2">
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="grade" class="block font-medium">Grade</label>
                        <input type="number" name="grade" min="1" max="10" required class="border rounded p-2 w-full">
                    </div>

                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Submit</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
