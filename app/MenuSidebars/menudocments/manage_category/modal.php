<!-- Modal for adding category -->
<div id="addCategoryModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center">
    <div class="bg-white rounded-lg p-6 w-1/3">
        <h3 class="text-xl font-semibold mb-4">Add New Category</h3>
        <form id="addCategoryForm">
            <div class="mb-4">
                <label for="category_name" class="block text-sm font-medium text-gray-700">Category
                    Name</label>
                <input type="text" name="category_name" id="category_name" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" id="description"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
            </div>
            <div class="flex justify-end">
                <button type="button" id="closeModalButton"
                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-red-400">Cancel</button>
                <button type="submit" class="ml-2 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">Save
                    Category</button>
            </div>

        </form>
    </div>
</div>