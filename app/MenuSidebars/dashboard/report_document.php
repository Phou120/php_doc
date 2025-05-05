 <!-- Storage Usage Summary Card -->
 <section class="mb-10">
     <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
         <div class="flex flex-wrap items-center justify-between">
             <div class="mb-4 md:mb-0">
                 <h3 class="text-lg font-semibold text-gray-800 mb-1">Storage Overview</h3>
                 <p class="text-gray-500 text-sm">You've used 65% of your storage</p>
             </div>
             <div class="flex space-x-4">
                 <div class="text-center">
                     <div
                         class="w-12 h-12 rounded-full flex items-center justify-center bg-blue-100 text-blue-600 mx-auto mb-1">
                         <i class="fas fa-file-alt"></i>
                     </div>
                     <p class="text-xs font-medium">Documents</p>
                     <p class="text-sm font-bold text-gray-800">125</p>
                 </div>
                 <div class="text-center">
                     <div
                         class="w-12 h-12 rounded-full flex items-center justify-center bg-green-100 text-green-600 mx-auto mb-1">
                         <i class="fas fa-image"></i>
                     </div>
                     <p class="text-xs font-medium">Images</p>
                     <p class="text-sm font-bold text-gray-800">43</p>
                 </div>
                 <div class="text-center">
                     <div
                         class="w-12 h-12 rounded-full flex items-center justify-center bg-purple-100 text-purple-600 mx-auto mb-1">
                         <i class="fas fa-film"></i>
                     </div>
                     <p class="text-xs font-medium">Media</p>
                     <p class="text-sm font-bold text-gray-800">17</p>
                 </div>
             </div>

             <div class="w-full md:w-1/3 mt-4 md:mt-0">
                 <div class="relative pt-1">
                     <div class="flex mb-2 items-center justify-between">
                         <div>
                             <span class="text-xs font-semibold inline-block text-blue-600">
                                 65% Used
                             </span>
                         </div>
                         <div class="text-right">
                             <span class="text-xs font-semibold inline-block text-blue-600">
                                 6.5 GB / 10 GB
                             </span>
                         </div>
                     </div>
                     <div class="overflow-hidden h-2 mb-1 text-xs flex rounded bg-blue-100">
                         <div style="width: 65%"
                             class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-gradient-to-r from-blue-500 to-blue-600">
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </section>

 <!-- Recent Files with beautiful icons -->
 <section class="mb-10">
     <div class="flex justify-between items-center mb-6">
         <h2 class="text-xl font-bold text-gray-800 flex items-center">
             <i class="fas fa-clock text-blue-600 mr-2"></i>
             Recent Files
         </h2>
         <a href="../../../../documentation_system/app/MenuSidebars/menudocments/documents.php"
             class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center group">
             View All
             <i class="fas fa-arrow-right ml-1 transform group-hover:translate-x-1 transition-transform"></i>
         </a>
     </div>
     <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
         <?php if ($result && $result->num_rows > 0): ?>
         <?php while ($row = $result->fetch_assoc()): 
                        $ext = pathinfo($row['file_name'], PATHINFO_EXTENSION);
                        $iconClass = match (strtolower($ext)) {
                            'pdf' => 'fa-file-pdf text-red-600 bg-red-100',
                            'doc', 'docx' => 'fa-file-word text-blue-600 bg-blue-100',
                            'xls', 'xlsx' => 'fa-file-excel text-green-600 bg-green-100',
                            'ppt', 'pptx' => 'fa-file-powerpoint text-orange-600 bg-orange-100',
                            'jpg', 'jpeg', 'png', 'gif' => 'fa-file-image text-purple-600 bg-purple-100',
                            'mp3', 'wav', 'ogg' => 'fa-file-audio text-yellow-600 bg-yellow-100',
                            'mp4', 'avi', 'mov' => 'fa-file-video text-pink-600 bg-pink-100',
                            'zip', 'rar', '7z' => 'fa-file-archive text-amber-600 bg-amber-100',
                            'html', 'css', 'js' => 'fa-file-code text-indigo-600 bg-indigo-100',
                            default => 'fa-file-alt text-gray-600 bg-gray-100'
                        };
                        ?>
         <div
             class="file-card bg-white p-5 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 group cursor-pointer border border-gray-100">
             <div class="flex items-center gap-4">
                 <div
                     class="file-icon w-14 h-14 flex items-center justify-center rounded-xl <?php echo explode(' ', $iconClass)[1]; ?> group-hover:<?php echo str_replace('100', '200', explode(' ', $iconClass)[1]); ?>">
                     <i
                         class="fas <?php echo explode(' ', $iconClass)[0]; ?> fa-lg <?php echo explode(' ', $iconClass)[2]; ?>"></i>
                 </div>
                 <div class="flex-1 overflow-hidden">
                     <p class="font-semibold text-gray-800 group-hover:text-blue-600 transition-colors duration-300 truncate"
                         title="<?php echo htmlspecialchars($row['title']); ?>">
                         <?php echo htmlspecialchars($row['title']); ?>
                     </p>
                     <div class="text-gray-500 text-sm mt-1">
                         <span><?php echo formatSize($row['file_size']); ?></span>
                         <span class="mx-2">•</span>
                         <span><?php echo timeAgo($row['uploaded_at']); ?></span>
                     </div>
                     <div class="flex items-center mt-2">
                         <span
                             class="text-xs px-2 py-1 rounded-full <?php echo explode(' ', $iconClass)[1]; ?> <?php echo explode(' ', $iconClass)[2]; ?> font-medium">
                             <?php echo getFriendlyType($ext); ?>
                         </span>
                     </div>
                 </div>
             </div>
             <div
                 class="mt-4 pt-3 border-t border-gray-100 flex justify-between opacity-0 group-hover:opacity-100 transition-opacity">
                 <button class="text-gray-500 hover:text-blue-600">
                     <i class="fas fa-eye"></i>
                 </button>
                 <button class="text-gray-500 hover:text-green-600">
                     <i class="fas fa-download"></i>
                 </button>
                 <button class="text-gray-500 hover:text-yellow-600">
                     <i class="fas fa-star"></i>
                 </button>
                 <button class="text-gray-500 hover:text-red-600">
                     <i class="fas fa-trash-alt"></i>
                 </button>
             </div>
         </div>
         <?php endwhile; ?>
         <?php else: ?>
         <div class="col-span-full bg-white p-8 rounded-xl text-center">
             <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-blue-50 flex items-center justify-center">
                 <i class="fas fa-folder-open text-blue-500 text-3xl"></i>
             </div>
             <p class="text-gray-500 mb-4">No recent files found.</p>
             <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                 <i class="fas fa-upload mr-2"></i>Upload Files
             </button>
         </div>
         <?php endif; ?>
     </div>
 </section>

 <!-- Quick Access Shortcuts -->
 <section class="mb-10">
     <h2 class="text-xl font-bold text-gray-800 flex items-center mb-6">
         <i class="fas fa-bolt text-blue-600 mr-2"></i>
         Quick Actions
     </h2>
     <div class="grid grid-cols-2 sm:grid-cols-4 gap-6">
         <a href="../menudocments/documents.php"
             class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 text-center group">
             <div
                 class="w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center mx-auto mb-4 group-hover:bg-blue-500 transition-colors">
                 <i class="fas fa-upload text-blue-600 text-xl group-hover:text-white transition-colors"></i>
             </div>
             <h3 class="font-medium text-gray-800">Upload File</h3>
             <p class="text-gray-500 text-sm mt-1">Add new documents</p>
         </a>
         <a href="../manage_category/manage_categories.php" class=" bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-all duration-300
                        text-center group">
             <div
                 class="w-16 h-16 rounded-full bg-green-100 flex items-center justify-center mx-auto mb-4 group-hover:bg-green-500 transition-colors">
                 <i class="fas fa-folder-plus text-green-600 text-xl group-hover:text-white transition-colors"></i>
             </div>
             <h3 class="font-medium text-gray-800">New Folder</h3>
             <p class="text-gray-500 text-sm mt-1">Organize your files</p>
         </a>
         <a href="../menu_document_share/document_share.php"
             class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 text-center group">
             <div
                 class="w-16 h-16 rounded-full bg-purple-100 flex items-center justify-center mx-auto mb-4 group-hover:bg-purple-500 transition-colors">
                 <i class="fas fa-share-alt text-purple-600 text-xl group-hover:text-white transition-colors"></i>
             </div>
             <h3 class="font-medium text-gray-800">Share</h3>
             <p class="text-gray-500 text-sm mt-1">Collaborate with team</p>
         </a>
         <a href="../../../../documentation_system/app/MenuSidebars/profile/profile.php"
             class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 text-center group">
             <div
                 class="w-16 h-16 rounded-full bg-amber-100 flex items-center justify-center mx-auto mb-4 group-hover:bg-amber-500 transition-colors">
                 <i class="fas fa-cog text-amber-600 text-xl group-hover:text-white transition-colors"></i>
             </div>
             <h3 class="font-medium text-gray-800">Settings</h3>
             <p class="text-gray-500 text-sm mt-1">Configure dashboard</p>
         </a>
     </div>
 </section>