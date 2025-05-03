<!-- Filters and Search -->
<div class="card bg-white rounded-xl p-6 mb-6">
    <form method="GET" action="" class="space-y-4 md:space-y-0 md:flex md:items-end md:space-x-4">
        <!-- Search Box -->
        <div class="flex-1">
            <!-- <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label> -->
            <div class="search-box flex items-center rounded-lg px-4 py-2 border border-transparent">
                <i class="fas fa-search text-gray-400 mr-2"></i>
                <input type="text" id="search" name="search" value="<?php echo htmlspecialchars($search_term); ?>"
                    placeholder="Search documents, users..."
                    class="flex-1 bg-transparent outline-none text-gray-700 placeholder-gray-400">
                <?php if (!empty($search_term)): ?>
                <a href="<?php echo strtok($_SERVER["REQUEST_URI"], '?'); ?>"
                    class="text-gray-400 hover:text-gray-600 ml-2">
                    <i class="fas fa-times"></i>
                </a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Status Filter -->
        <div class="relative">
            <select id="status" name="status"
                class="peer block w-full appearance-none rounded-lg border border-gray-300 bg-white px-4 py-2 pr-10 text-sm text-gray-700 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                <option value="">Choose Action</option>
                <option value="view" <?php echo $status_filter === 'view' ? 'selected' : ''; ?>>Views
                </option>
                <option value="download" <?php echo $status_filter === 'download' ? 'selected' : ''; ?>>
                    Downloads</option>
                <option value="delete" <?php echo $status_filter === 'delete' ? 'selected' : ''; ?>>
                    Deletes</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-gray-500">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </div>
        </div>


        <!-- Date Filter -->
        <div>
            <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($date_filter); ?>"
                class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm text-gray-700 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
        </div>


        <!-- Action Buttons -->
        <div class="flex space-x-3">
            <button type="submit"
                class="action-btn px-5 py-2.5 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg hover:from-blue-600 hover:to-blue-700 flex items-center shadow-md hover:shadow-lg transition-all duration-200 ease-in-out">
                <i class="fas fa-filter mr-2 text-sm"></i> Apply Filters
            </button>
            <?php if (!empty($search_term) || !empty($status_filter) || !empty($date_filter)): ?>
            <a href="<?php echo strtok($_SERVER["REQUEST_URI"], '?'); ?>"
                class="action-btn px-5 py-2.5 bg-red text-gray-600 border border-gray-300 rounded-lg hover:bg-red-400 flex items-center shadow-sm hover:shadow transition-all duration-200 ease-in-out">
                <i class="fas fa-broom mr-2 text-sm"></i> Clear All
            </a>
            <?php endif; ?>
        </div>
    </form>
</div>