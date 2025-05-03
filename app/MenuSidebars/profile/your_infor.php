<div class="w-full bg-gradient-to-br from-white to-blue-50 p-8 rounded-xl shadow-lg border border-blue-100">
    <div class="flex flex-col items-center mb-8">
        <div class="relative mb-3">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-400 to-blue-600 rounded-full opacity-50 blur-sm">
            </div>
            <div class="relative p-1 bg-white rounded-full">
                <img src="https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&f=y" alt="User Avatar"
                    class="w-28 h-28 rounded-full shadow-md object-cover border-4 border-white">
            </div>
        </div>
        <h1 class="text-3xl font-bold text-gray-800">Your Profile</h1>
        <div class="h-1 w-20 bg-blue-500 rounded-full mt-2"></div>
    </div>

    <?php if ($user): ?>
    <form method="POST" class="space-y-6">
        <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
        <input type="hidden" name="update_user" value="1">

        <div class="transition-all duration-300 hover:shadow-md p-4 rounded-lg bg-white">
            <label class="block text-gray-700 text-sm font-medium mb-2">
                <i class="fa-solid fa-user text-blue-500 mr-2"></i>Name
            </label>
            <input type="text" name="name" required value="<?php echo htmlspecialchars($user['name']); ?>"
                class="w-full mt-1 px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent shadow-sm">
        </div>

        <div class="transition-all duration-300 hover:shadow-md p-4 rounded-lg bg-white">
            <label class="block text-gray-700 text-sm font-medium mb-2">
                <i class="fa-solid fa-envelope text-blue-500 mr-2"></i>Email
            </label>
            <input type="email" name="email" required value="<?php echo htmlspecialchars($user['email']); ?>"
                class="w-full mt-1 px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent shadow-sm">
        </div>

        <div class="transition-all duration-300 hover:shadow-md p-4 rounded-lg bg-white">
            <label class="block text-gray-700 text-sm font-medium mb-2">
                <i class="fa-solid fa-calendar text-blue-500 mr-2"></i>Created At
            </label>
            <p class="text-gray-700 bg-blue-50 p-3 rounded-lg border border-blue-100">
                <i class="fa-solid fa-clock text-blue-400 mr-2"></i>
                <?php echo date('F d, Y \a\t h:i A', strtotime($user['created_at'])); ?>
            </p>
        </div>

        <div class="pt-6 flex flex-col sm:flex-row gap-4">
            <button type="submit"
                class="bg-gradient-to-r from-blue-500 to-blue-700 text-white px-6 py-3 rounded-lg hover:shadow-lg hover:from-blue-600 hover:to-blue-800 transition-all duration-300 flex-1 flex items-center justify-center">
                <i class="fa-solid fa-save mr-2"></i>Update Profile
            </button>
            <button type="button" id="changePasswordButton"
                class="bg-white text-blue-600 border border-blue-500 px-6 py-3 rounded-lg hover:bg-blue-50 hover:shadow-md transition-all duration-300 flex-1 flex items-center justify-center"
                onclick="openModal(<?php echo $user['id']; ?>)">
                <i class="fa-solid fa-lock mr-2"></i>Change Password
            </button>
        </div>
    </form>
    <?php else: ?>
    <div class="text-center py-12 bg-white rounded-lg shadow-sm">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-blue-100 text-blue-500 mb-4">
            <i class="fa-solid fa-exclamation-circle text-2xl"></i>
        </div>
        <p class="text-gray-600 mb-6">User information not available. Please try reloading the page.</p>
        <button onclick="loadUserFromStorage()"
            class="bg-gradient-to-r from-blue-500 to-blue-700 text-white px-6 py-3 rounded-lg hover:shadow-lg hover:from-blue-600 hover:to-blue-800 transition-all duration-300 flex items-center mx-auto">
            <i class="fa-solid fa-sync mr-2"></i>Load Profile
        </button>
    </div>
    <?php endif; ?>
</div>