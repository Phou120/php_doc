<div id="uploadModal"
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden transition-opacity duration-300">
    <div class="bg-white p-6 rounded-lg w-full max-w-lg shadow-2xl transform transition-transform duration-300">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-gray-800">
                <i class="fas fa-file-upload text-blue-500 mr-2"></i>Upload Document
            </h2>
            <button id="closeModalX" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <form id="uploadForm" enctype="multipart/form-data">

            <div class="form-group mb-6">
                <label for="category" class="block text-gray-700 font-medium">Category</label>
                <div class="flex gap-2 items-center">
                    <select id="category" name="category_id"
                        class="w-full p-3 border border-gray-300 rounded-lg mt-2 focus:ring-2 focus:ring-blue-500"
                        required>
                        <?php
                            include_once "../../../configs/connect_db.php";
                            $sql = "SELECT id, name FROM document_categories";
                            $categories = $conn->query($sql);
                            while ($category = $categories->fetch_assoc()) {
                                echo "<option value='{$category['id']}'>{$category['name']}</option>";
                            }
                        ?>
                    </select>
                    <button type="button" id="openModal"
                        class="mt-2 px-3 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">+</button>
                </div>
            </div>

            <div class="form-group mb-6">
                <label for="title" class="block text-gray-700 font-medium mb-2">
                    <i class="fas fa-heading text-blue-400 mr-2"></i>Document Title
                </label>
                <input type="text"
                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                    id="title" name="title" placeholder="Enter a title for your document" required>
            </div>

            <div class="form-group mb-6">
                <label for="fileInput" class="block text-gray-700 font-medium mb-2">
                    <i class="fas fa-file-arrow-up text-blue-400 mr-2"></i>Upload Document
                </label>

                <!-- Updated file upload container -->
                <div class="file-upload-container bg-gradient-to-r from-blue-50 to-indigo-50 p-4 border-2 border-dashed border-blue-300 rounded-lg hover:bg-blue-100 transition-all duration-300 cursor-pointer"
                    id="drop-area">
                    <input type="file" name="file" id="fileInput" class="hidden" required>

                    <!-- Initial state -->
                    <div id="initialState" class="flex flex-col items-center justify-center h-full">
                        <i class="fas fa-cloud-arrow-up text-3xl text-blue-500 mb-2 upload-icon-pulse"></i>
                        <h3 class="text-base font-medium text-gray-700">Drop file here</h3>
                        <p class="text-sm text-gray-500">or click to browse files</p>
                    </div>

                    <!-- Selected file state (hidden by default) -->
                    <div id="selectedState" class="hidden h-full flex flex-col">
                        <div
                            class="file-preview-box bg-white rounded-lg border border-gray-200 flex-grow flex items-center justify-center">
                            <div id="filePreview" class="w-full h-full flex items-center justify-center">
                            </div>
                        </div>
                        <div id="fileNameLabel" class="file-info mt-2 text-sm font-medium text-gray-700 text-center">
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end mt-6">
                <button type="button" id="closeModal"
                    class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-red-400 mr-4 transition-all duration-200">
                    Cancel
                </button>
                <button type="submit" id="submitUploadBtn"
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all duration-200 shadow-md">
                    <i class="fas fa-upload mr-2"></i> Upload Document
                </button>
            </div>
        </form>
    </div>
</div>