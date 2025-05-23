<div id="passwordModal" class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-sm flex items-center justify-center px-4">
    <div class="bg-white rounded-xl shadow-lg w-full max-w-lg p-6 relative">
        <!-- Header -->
        <div class="flex justify-between items-center border-b pb-3 mb-4">
            <h2 class="text-xl font-semibold text-gray-800">Change Password</h2>
            <button onclick="closeModal()" class="text-lg hover:scale-110 transition-transform">
                <i class="fa-solid fa-xmark text-red-600 text-2xl"></i>
            </button>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('update.password') }}" class="space-y-4">
            @csrf
            <input type="hidden" name="agent_id" id="agentIdInput">
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                <input type="password" value="{{ old('current_password') }}" name="current_password" class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
            @error('current_password')
                <span class="text-danger text-sm">{{ $message }}</span>
            @enderror
            </div>

            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                <input type="password" value="{{ old('new_password') }}" name="new_password" class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-400" >
            @error('new_password')
                <span class="text-danger text-sm">{{ $message }}</span>
            @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>