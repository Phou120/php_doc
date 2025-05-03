<!-- Add Category Modal -->
<div id="categoryModal" class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center z-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">
        <h2 class="text-lg font-bold mb-4">Add New Category</h2>
        <input type="text" id="modalCategoryName" placeholder="Category Name"
            class="w-full p-2 border border-gray-300 rounded mb-3" />
        <textarea id="modalCategoryDescription" placeholder="Description (optional)"
            class="w-full p-2 border border-gray-300 rounded mb-3"></textarea>
        <div class="flex justify-end gap-2">
            <button id="closeCategoryModal"
                class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-red-400">Cancel</button>
            <button id="saveModalCategory"
                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Save</button>
        </div>
    </div>
</div>