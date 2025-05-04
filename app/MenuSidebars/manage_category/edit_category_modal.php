<!-- Edit Category Modal -->
<div id="editCategoryModal" class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center hidden z-50">
    <div class="bg-white w-full max-w-md rounded-lg shadow-lg p-6">
        <h2 class="text-lg font-semibold mb-4">Edit Category</h2>
        <form id="editCategoryForm">
            <input type="hidden" id="edit_category_id">

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Category Name</label>
                <input type="text" id="edit_category_name"
                    class="w-full px-3 py-2 border rounded-md focus:ring focus:ring-blue-200">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Description</label>
                <textarea id="edit_description" rows="3"
                    class="w-full px-3 py-2 border rounded-md focus:ring focus:ring-blue-200"></textarea>
            </div>

            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeEditModal()"
                    class="bg-gray-300 hover:bg-red-400 text-gray-800 px-4 py-2 rounded">Cancel</button>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Update</button>
            </div>
        </form>
    </div>
</div>