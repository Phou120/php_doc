<!-- Beautiful Category Management Table -->
<div class="max-w-6xl mx-auto">
    <!-- Card Header -->
    <!-- <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">
            <i class="fas fa-folder text-teal-600 mr-3"></i>Categories
        </h2>
        <button onclick="openAddModal()"
            class="flex items-center px-5 py-3 bg-gradient-to-r from-teal-500 to-emerald-600 text-white font-medium rounded-xl shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
            <i class="fas fa-plus-circle mr-2"></i>
            Add Category
        </button>
    </div> -->

    <!-- Search Bar -->
    <!-- <div class="bg-white p-4 rounded-t-xl shadow-md border-b border-gray-200">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div class="relative flex items-center">
                <i class="fas fa-search text-gray-400 absolute left-3"></i>
                <input type="text" id="categorySearch" placeholder="Search categories..."
                    class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 w-full sm:w-64">
            </div>
            <div class="flex items-center space-x-3">
                <select
                    class="border border-gray-300 rounded-lg py-2 px-4 focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                    <option value="">All Categories</option>
                    <option value="active">Active</option>
                    <option value="archived">Archived</option>
                </select>
            </div>
        </div>
    </div> -->

    <!-- Table Section -->
    <div class="bg-white rounded-b-xl shadow-[0_0_20px_rgba(0,0,0,0.08)] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            <div class="flex items-center">
                                <span>No</span>
                                <i class="fas fa-sort ml-2 text-gray-400"></i>
                            </div>
                        </th>
                        <th scope="col"
                            class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            <div class="flex items-center">
                                <span>Category Name</span>
                                <i class="fas fa-sort ml-2 text-gray-400"></i>
                            </div>
                        </th>
                        <th scope="col"
                            class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            <div class="flex items-center">
                                <span>Description</span>
                                <i class="fas fa-sort ml-2 text-gray-400"></i>
                            </div>
                        </th>
                        <th scope="col"
                            class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php if ($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div
                                class="w-8 h-8 rounded-full bg-green-100 text-teal-700 flex items-center justify-center font-semibold">
                                <?php echo $counter++; ?>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div
                                    class="h-10 w-10 rounded-lg bg-orange-300 from-teal-500 to-emerald-600 text-white flex items-center justify-center mr-3">
                                    <i class="fas fa-folder"></i>
                                </div>
                                <div class="text-sm font-medium text-gray-900">
                                    <?php echo htmlspecialchars($row['name']); ?>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-600 max-w-md">
                                <?php 
                                $description = htmlspecialchars($row['description']);
                                echo strlen($description) > 100 ? substr($description, 0, 100) . "..." : $description; 
                                ?>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <div class="flex justify-center space-x-2">
                                <button onclick='openEditModal(<?php echo json_encode([
                                        "id" => $row["id"],
                                        "name" => $row["name"],
                                        "description" => $row["description"]
                                    ]); ?>)'
                                    class="p-2 rounded-lg bg-teal-50 text-teal-600 hover:bg-teal-100 transition-colors duration-200 flex items-center tooltip-trigger">
                                    <i class="fas fa-eye"></i>
                                    <span class="tooltip"></span>
                                </button>
                                <button onclick="confirmDeleteCategory(<?php echo $row['id']; ?>)"
                                    class="p-2 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 transition-colors duration-200 flex items-center tooltip-trigger">
                                    <i class="fas fa-trash-alt"></i>
                                    <span class="tooltip"></span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center">
                            <div class="flex flex-col items-center">
                                <div class="bg-gray-100 rounded-full w-16 h-16 flex items-center justify-center mb-3">
                                    <i class="fas fa-folder-open text-3xl text-gray-400"></i>
                                </div>
                                <p class="text-gray-500 text-lg">No categories found.</p>
                                <button onclick="openAddModal()"
                                    class="mt-4 px-4 py-2 bg-teal-600 text-white rounded-lg flex items-center hover:bg-teal-700 transition-colors">
                                    <i class="fas fa-plus mr-2"></i> Add Your First Category
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <?php if ($result && $result->num_rows > 0): ?>
        <div class="bg-gray-50 px-6 py-3 border-t border-gray-200 flex items-center justify-between">
            <div class="text-sm text-gray-500">
                Showing <span class="font-medium"><?php echo min(1, $result->num_rows); ?></span> to <span
                    class="font-medium"><?php echo $result->num_rows; ?></span> of <span
                    class="font-medium"><?php echo $result->num_rows; ?></span> categories
            </div>
            <div class="flex items-center space-x-2">
                <button
                    class="px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 disabled:opacity-50"
                    disabled>
                    Previous
                </button>
                <button
                    class="px-3 py-1 border border-gray-300 bg-teal-500 text-white rounded-md text-sm font-medium hover:bg-teal-600">
                    1
                </button>
                <button
                    class="px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 disabled:opacity-50"
                    disabled>
                    Next
                </button>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>