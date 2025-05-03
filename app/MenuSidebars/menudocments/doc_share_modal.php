 <!-- Share Modal -->
 <div id="shareModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
     <div class="bg-white p-6 rounded-lg w-full max-w-md">
         <h2 class="text-lg font-bold mb-4">Share Document</h2>
         <form id="shareForm">
             <input type="hidden" id="shareDocId" name="document_id">
             <label class="block mb-2 text-sm font-medium">Recipient Email</label>
             <input type="email" id="shareEmail" name="email" required
                 class="w-full p-2 border border-gray-300 rounded mb-4">
             <div class="text-right">
                 <button type="button" onclick="closeShareModal()"
                     class="mr-2 px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-red-400">Cancel</button>
                 <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Share</button>
             </div>
         </form>
     </div>
 </div>