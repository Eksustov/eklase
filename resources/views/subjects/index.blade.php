<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Subjects') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($subjects->count())
                        @foreach ($subjects as $subject)
                            <div class="mb-4 bg-gray-100 p-4 rounded-lg hover:bg-gray-200">
                                <a href="{{ route('subjects.grades.show', $subject) }}" class="block">
                                    {{ $subject->name }}
                                </a>
                            </div>
                        @endforeach
                    @else
                        <p>No subjects available.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
