<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Grade') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-md mx-auto bg-white p-6 rounded shadow">
            <form method="POST" action="{{ route('grades.update', $grade) }}">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block">Student</label>
                    <select name="student_id" class="w-full border rounded p-2">
                        @foreach($students as $student)
                            <option value="{{ $student->id }}" {{ $grade->student_id == $student->id ? 'selected' : '' }}>
                                {{ $student->first_name }} {{ $student->last_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block">Subject</label>
                    <select name="subject_id" class="w-full border rounded p-2">
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ $grade->subject_id == $subject->id ? 'selected' : '' }}>
                                {{ $subject->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block">Grade (1–10)</label>
                    <input type="number" name="grade" min="1" max="10" value="{{ $grade->grade }}" class="w-full border rounded p-2">
                </div>

                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update Grade</button>
            </form>
        </div>
    </div>
</x-app-layout>
