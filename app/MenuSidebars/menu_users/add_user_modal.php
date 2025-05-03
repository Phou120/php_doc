<div id="addUserModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <button id="closeAddUserModal" class="absolute top-2 right-2 text-gray-600 hover:text-gray-900">
        <i class="fas fa-times"></i>
    </button>

    <div class="bg-white p-10 rounded-2xl shadow-2xl w-full max-w-md">
        <h2 class="text-3xl font-bold text-center text-blue-700 mb-6">Create Your Account</h2>
        <p class="text-center text-gray-500 mb-8 text-sm">It's quick and easy.</p>

        <form id="addUserForm" class="space-y-5">
            <input type="hidden" name="action" value="add-user" />

            <div>
                <label for="name" class="block text-gray-600 font-semibold mb-2">Full Name</label>
                <div
                    class="flex items-center border border-gray-300 rounded-lg px-3 py-2 focus-within:ring-2 focus-within:ring-blue-500">
                    <i class="fas fa-user text-gray-400 mr-2"></i>
                    <input type="text" id="name" name="name" required
                        class="w-full outline-none bg-transparent text-gray-700 placeholder-gray-400"
                        placeholder="John Doe">
                </div>
            </div>

            <div>
                <label for="email" class="block text-gray-600 font-semibold mb-2">Email Address</label>
                <div
                    class="flex items-center border border-gray-300 rounded-lg px-3 py-2 focus-within:ring-2 focus-within:ring-blue-500">
                    <i class="fas fa-envelope text-gray-400 mr-2"></i>
                    <input type="email" id="email" name="email" required
                        class="w-full outline-none bg-transparent text-gray-700 placeholder-gray-400"
                        placeholder="you@example.com">
                </div>
            </div>

            <div>
                <label for="password" class="block text-gray-600 font-semibold mb-2">Password</label>
                <div
                    class="flex items-center border border-gray-300 rounded-lg px-3 py-2 focus-within:ring-2 focus-within:ring-blue-500">
                    <i class="fas fa-lock text-gray-400 mr-2" id="lockIcon"></i>
                    <input type="password" id="password" name="password" required
                        class="w-full outline-none bg-transparent text-gray-700 placeholder-gray-400"
                        placeholder="••••••••">
                    <i class="fas fa-eye text-gray-400 ml-2 cursor-pointer" id="eyeIcon"></i>
                </div>
            </div>


            <div class="mb-4">
                <button type="submit"
                    class="w-full py-3 px-6 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300">
                    Sign Up
                </button>
            </div>
        </form>
    </div>
</div>