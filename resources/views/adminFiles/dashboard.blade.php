<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Welcome back admin!") }}
                </div>
            </div>

            <!-- Subject management section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-bold mb-4">Manage Subjects</h3>
                    <a href="{{ route('subjects.create') }}" class="bg-green-500 text-white px-4 py-2 rounded mb-4 inline-block">+ Add Subject</a>

                    @if(session('success'))
                        <div class="text-green-600">{{ session('success') }}</div>
                    @endif

                    <ul class="mt-4 space-y-2">
                        @foreach(\App\Models\Subject::all() as $subject)
                            <li class="flex justify-between items-center border-b pb-1">
                                <span>{{ $subject->name }}</span>
                                <div class="space-x-2">
                                    <a href="{{ route('subjects.edit', $subject) }}" class="text-blue-600">Edit</a>
                                    <form action="{{ route('subjects.destroy', $subject) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600">Delete</button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
