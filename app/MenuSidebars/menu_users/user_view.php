<?php if ($result && $result->num_rows > 0): ?>
<!-- Beautiful User Management Table -->
<div class="max-w-7xl mx-auto">
    <!-- Card Header -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">
            <i class="fas fa-users text-indigo-600 mr-3"></i>User Management
        </h2>
    </div>

    <!-- Table Section -->
    <div class="bg-white rounded-b-xl shadow-[0_0_20px_rgba(0,0,0,0.08)] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-8 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            #
                        </th>
                        <th scope="col"
                            class="px-8 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            <div class="flex items-center">
                                <span>Name</span>
                                <i class="fas fa-sort ml-2 text-gray-400"></i>
                            </div>
                        </th>
                        <th scope="col"
                            class="px-8 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            <div class="flex items-center">
                                <span>Email</span>
                                <i class="fas fa-sort ml-2 text-gray-400"></i>
                            </div>
                        </th>
                        <th scope="col"
                            class="px-8 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            <div class="flex items-center">
                                <span>Created At</span>
                                <i class="fas fa-sort ml-2 text-gray-400"></i>
                            </div>
                        </th>
                        <th scope="col"
                            class="px-8 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php 
                    $counter = 1;
                    $result->data_seek(0);
                    while ($row = $result->fetch_assoc()):
                        $date = new DateTime($row['created_at']);
                    ?>
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-8 py-5 whitespace-nowrap">
                            <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                                <?= $counter++ ?>
                            </div>
                        </td>
                        <td class="px-8 py-5 whitespace-nowrap text-sm md:text-base">
                            <div class="flex items-center">
                                <div
                                    class="h-10 w-10 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 text-white flex items-center justify-center font-bold text-lg mr-3">
                                    <?= strtoupper(substr(htmlspecialchars($row['name']), 0, 1)) ?>
                                </div>
                                <div>
                                    <div class="font-medium text-gray-900"><?= htmlspecialchars($row['name']) ?></div>
                                    <div class="text-xs text-gray-500">User ID: <?= $row['id'] ?></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-5 whitespace-nowrap text-sm md:text-base text-gray-700">
                            <div class="flex items-center">
                                <i class="fas fa-envelope text-gray-400 mr-2"></i>
                                <?= htmlspecialchars($row['email']) ?>
                            </div>
                        </td>
                        <td class="px-8 py-5 whitespace-nowrap text-sm md:text-base">
                            <div class="flex flex-col">
                                <div class="flex items-center text-gray-700">
                                    <i class="fas fa-calendar-day text-indigo-500 mr-2"></i>
                                    <?= $date->format('M j, Y') ?>
                                </div>
                                <div class="text-xs text-gray-500 mt-1">
                                    <i class="fas fa-clock mr-1"></i>
                                    <?= $date->format('h:i A') ?>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-5 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end space-x-2">
                                <button
                                    onclick="openEditModal(<?= $row['id'] ?>, '<?= htmlspecialchars($row['name'], ENT_QUOTES) ?>', '<?= htmlspecialchars($row['email'], ENT_QUOTES) ?>')"
                                    class="p-2 rounded-lg bg-green-50 text-green-600 hover:bg-green-100 transition-colors duration-200 flex items-center tooltip-trigger">
                                    <i class="fas fa-eye"></i>
                                    <span class="tooltip">Edit</span>
                                </button>
                                <!-- <button onclick="viewUserDetails(<?= $row['id'] ?>)"
                                    class="p-2 rounded-lg bg-green-50 text-green-600 hover:bg-green-100 transition-colors duration-200 flex items-center tooltip-trigger">
                                    <i class="fas fa-eye"></i>
                                    <span class="tooltip">View</span>
                                </button> -->
                                <button onclick="deleteUser(event, <?= $row['id'] ?>)"
                                    class="p-2 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 transition-colors duration-200 flex items-center tooltip-trigger">
                                    <i class="fas fa-trash-alt"></i>
                                    <span class="tooltip">Delete</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="bg-gray-50 px-8 py-4 border-t border-gray-200 flex items-center justify-between">
            <div class="text-sm text-gray-500">
                Showing <span class="font-medium">1</span> to <span class="font-medium"><?= $counter - 1 ?></span> of
                <span class="font-medium"><?= $counter - 1 ?></span> users
            </div>
            <div class="flex items-center space-x-2">
                <button
                    class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 disabled:opacity-50"
                    disabled>
                    Previous
                </button>
                <button
                    class="px-4 py-2 border border-gray-300 bg-indigo-500 text-white rounded-md text-sm font-medium hover:bg-indigo-600">
                    1
                </button>
                <button
                    class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 disabled:opacity-50"
                    disabled>
                    Next
                </button>
            </div>
        </div>
    </div>
</div>

<?php else: ?>
<!-- Empty State -->
<div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-xl overflow-hidden">
    <div class="p-10 text-center">
        <div class="bg-indigo-50 rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-folder-open text-5xl text-indigo-400"></i>
        </div>
        <h3 class="text-3xl font-semibold text-gray-800 mb-4">No users found</h3>
        <p class="text-lg text-gray-500 mb-8 max-w-md mx-auto">It looks like there are no users in the system yet. Add
            your first user to get started.</p>
        <a href="upload.php"
            class="inline-flex items-center px-8 py-4 border border-transparent text-lg font-medium rounded-xl shadow-sm text-white bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 transition-colors duration-200 transform hover:-translate-y-0.5 hover:shadow-lg">
            <i class="fas fa-user-plus text-2xl mr-3"></i>
            Add Your First User
        </a>
    </div>
    <div class="bg-gray-50 p-6 border-t border-gray-200">
        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <button
                class="flex items-center justify-center px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100 transition-colors">
                <i class="fas fa-file-import mr-2"></i>
                Import Users
            </button>
            <button
                class="flex items-center justify-center px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100 transition-colors">
                <i class="fas fa-question-circle mr-2"></i>
                View Documentation
            </button>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Custom CSS -->
<style>
.tooltip-trigger {
    position: relative;
}

.tooltip {
    display: none;
    position: absolute;
    background-color: #374151;
    color: white;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
    white-space: nowrap;
    top: -30px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 10;
}

.tooltip-trigger:hover .tooltip {
    display: block;
}

.tooltip::after {
    content: "";
    position: absolute;
    top: 100%;
    left: 50%;
    margin-left: -5px;
    border-width: 5px;
    border-style: solid;
    border-color: #374151 transparent transparent transparent;
}
</style>