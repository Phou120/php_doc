<div id="changePasswordModal"
    class="fixed inset-0 bg-gray-500 bg-opacity-75 flex justify-center items-center hidden z-50">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
        <h2 class="text-xl font-bold mb-4">Change Password</h2>
        <form id="changePasswordForm">
            <input type="hidden" id="userId" name="user_id">

            <input type="text" name="username" autocomplete="username" value="" class="hidden" aria-hidden="true">

            <div class="mb-4">
                <label for="currentPassword" class="block text-gray-700">Current Password</label>
                <div class="relative">
                    <input type="password" id="currentPassword" name="current_password" required
                        autocomplete="current-password"
                        class="w-full mt-1 px-4 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300 pr-10">
                    <span onclick="togglePassword('currentPassword', this)"
                        class="absolute right-3 top-3 cursor-pointer text-gray-500">
                        <i class="fa fa-eye"></i>
                    </span>
                </div>
            </div>

            <div class="mb-4">
                <label for="newPassword" class="block text-gray-700">New Password</label>
                <div class="relative">
                    <input type="password" id="newPassword" name="new_password" required autocomplete="new-password"
                        class="w-full mt-1 px-4 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300 pr-10">
                    <span onclick="togglePassword('newPassword', this)"
                        class="absolute right-3 top-3 cursor-pointer text-gray-500">
                        <i class="fa fa-eye"></i>
                    </span>
                </div>
            </div>

            <div class="mb-4">
                <label for="confirmPassword" class="block text-gray-700">Confirm New Password</label>
                <div class="relative">
                    <input type="password" id="confirmPassword" name="confirm_password" required
                        autocomplete="new-password"
                        class="w-full mt-1 px-4 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300 pr-10">
                    <span onclick="togglePassword('confirmPassword', this)"
                        class="absolute right-3 top-3 cursor-pointer text-gray-500">
                        <i class="fa fa-eye"></i>
                    </span>
                </div>
            </div>

            <div class="pt-4 text-center">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
                    <i class="fa-solid fa-save mr-2"></i>Save New Password
                </button>
            </div>
        </form>

        <button onclick="closeModal()" class="mt-4 text-red-600">Cancel</button>
    </div>
</div>