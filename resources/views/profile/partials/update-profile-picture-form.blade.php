<form method="POST" action="{{ route('profile-picture.update') }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="flex items-center space-x-6">
        <!-- Profile Image -->
        <div>
            @if(Auth::user()->profilePicture)
                <img src="{{ asset('storage/' . Auth::user()->profilePicture->image) }}" 
                     class="w-24 h-24 rounded-full object-cover border border-gray-300" 
                     alt="Profile Picture">
            @else
                <div class="w-24 h-24 rounded-full bg-gray-200 flex items-center justify-center text-gray-600">
                    No image
                </div>
            @endif
        </div>

        <!-- File Input + Submit Button -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1" for="profile_picture">
                Upload new profile picture
            </label>
            <input 
                type="file" 
                name="profile_picture" 
                id="profile_picture" 
                class="block w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4
                       file:rounded-full file:border-0
                       file:text-sm file:font-semibold
                       file:bg-blue-50 file:text-blue-700
                       hover:file:bg-blue-100"
                required
            >
            <button type="submit" 
                    class="mt-3 px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 transition">
                Update
            </button>
        </div>
    </div>
</form>
