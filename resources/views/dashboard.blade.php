<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __('You are logged in as ') }}{{ Auth::user()->name }}
                    
                    @if(
                    Auth::check() &&
                    Auth::user()->hasRole('student') &&
                    !Auth::user()->hasRole('admin') &&
                    !Auth::user()->hasRole('teacher') &&
                    !$profileCompleted &&
                    !session('profile_completed')
                )

                        <!-- Popup modal -->
                        <div id="profile-popup" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-50">
                            <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm text-center">
                                <h3 class="text-lg font-bold mb-4">Complete Your Profile</h3>
                                <p class="mb-6">Please complete your student profile to access all features.</p>
                                <a href="{{ route('confirm') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                                    Complete Profile
                                </a>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

