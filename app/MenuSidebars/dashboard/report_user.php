<section class="px-4 py-6">
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-2xl font-bold text-gray-900 flex items-center">
            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-blue-100 mr-3">
                <i class="fas fa-users text-blue-600"></i>
            </span>
            User Directory
        </h2>
        <a href="../../MenuSidebars/menu_users/users.php"
            class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-blue-50 hover:border-blue-300 transition-all duration-300 text-blue-600 font-medium">
            View All Users
            <i class="fas fa-arrow-right ml-2 text-sm"></i>
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        <?php if ($result2 && $result2->num_rows > 0): ?>
        <?php while ($row = $result2->fetch_assoc()):
                $userInitials = strtoupper(substr($row['name'], 0, 2));
                $userName = htmlspecialchars($row['name']);
                $userEmail = htmlspecialchars($row['email']);
                // Generate a random gradient for variety
                $gradients = [
                    'from-purple-500 to-blue-500',
                    'from-pink-500 to-rose-500',
                    'from-teal-500 to-emerald-500',
                    'from-amber-500 to-yellow-500',
                    'from-indigo-500 to-violet-500'
                ];
                $randomGradient = $gradients[array_rand($gradients)];
            ?>
        <!-- User Card -->
        <div
            class="group relative bg-white p-5 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 border border-gray-100 overflow-hidden">
            <!-- Decorative element -->
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r <?php echo $randomGradient; ?>"></div>

            <div class="flex items-center gap-4">
                <div
                    class="w-14 h-14 rounded-full bg-gradient-to-r <?php echo $randomGradient; ?> text-white flex items-center justify-center font-bold text-xl shadow-md">
                    <?php echo $userInitials; ?>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-bold text-gray-900 truncate"><?php echo $userName; ?></p>
                    <div class="flex items-center text-gray-500 text-sm mt-1 truncate">
                        <i class="fas fa-envelope mr-2 text-xs opacity-70"></i>
                        <span class="truncate"><?php echo $userEmail; ?></span>
                    </div>
                </div>
                <div class="relative">
                    <button
                        class="p-2 hover:bg-gray-100 rounded-full text-gray-400 hover:text-blue-600 transition-colors group-hover:opacity-100 opacity-0">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                    <!-- Dropdown menu (hidden by default) -->
                    <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10 hidden">
                        <div class="py-1">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">View Profile</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Send Message</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hover actions -->
            <div
                class="mt-4 pt-3 border-t border-gray-100 flex justify-between opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                <button
                    class="text-xs bg-gray-100 hover:bg-gray-200 px-3 py-1 rounded-full text-gray-600 transition-colors">
                    <i class="fas fa-user-plus mr-1"></i> Connect
                </button>
                <button
                    class="text-xs bg-blue-50 hover:bg-blue-100 px-3 py-1 rounded-full text-blue-600 transition-colors">
                    <i class="fas fa-paper-plane mr-1"></i> Message
                </button>
            </div>
        </div>
        <?php endwhile; ?>
        <?php else: ?>
        <!-- Empty state -->
        <div class="col-span-full py-12 text-center">
            <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                <i class="fas fa-user-slash text-gray-400 text-2xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-700 mb-1">No users found</h3>
            <p class="text-gray-500 max-w-md mx-auto">There are currently no users in the system. Add new users to get
                started.</p>
            <button class="mt-4 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                <i class="fas fa-user-plus mr-2"></i> Add New User
            </button>
        </div>
        <?php endif; ?>
    </div>
</section>