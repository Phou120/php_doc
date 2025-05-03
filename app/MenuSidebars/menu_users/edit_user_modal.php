 <!-- Edit User Modal -->
 <div id="editUserModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
     <div class="bg-white rounded-lg p-6 w-full max-w-md shadow-lg relative">
         <button onclick="closeModal()"
             class="absolute top-2 right-2 text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
         <h2 class="text-xl font-semibold mb-4">Update User</h2>
         <form id="editUserForm">
             <input type="hidden" id="edit-id" name="id">
             <div class="mb-4">
                 <label class="block text-sm font-medium text-gray-600">Name</label>
                 <input type="text" id="edit-name" name="name" class="w-full border rounded px-3 py-2 mt-1" required>
             </div>
             <div class="mb-4">
                 <label class="block text-sm font-medium text-gray-600">Email</label>
                 <input type="email" id="edit-email" name="email" class="w-full border rounded px-3 py-2 mt-1" required>
             </div>
             <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Update</button>
         </form>
     </div>
 </div>