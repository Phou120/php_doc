 <!-- Documents Table -->
 <div class="bg-white rounded-b-xl shadow-[0_0_20px_rgba(0,0,0,0.08)] overflow-hidden">
     <?php if (count($data) > 0): ?>
     <div class="overflow-x-auto">
         <table class="w-full">
             <thead class="bg-gray-50">
                 <tr class="text-left text-gray-600 text-sm">
                     <th class="px-4 py-2 font-medium">No</th>
                     <th class="px-6 py-3 font-medium">Document</th>
                     <th class="px-6 py-3 font-medium">User</th>
                     <th class="px-6 py-3 font-medium">Action</th>
                     <th class="px-6 py-3 font-medium">Date</th>
                     <th class="px-6 py-3 font-medium text-center">Details</th>
                 </tr>
             </thead>
             <tbody class="divide-y divide-gray-200">
                 <?php foreach ($data as $doc): 
                                    $file_badge = getFileTypeBadge($doc['file_name'], $doc['file_type']);
                                ?>

                 <tr class="table-row">
                     <td class="px-4 py-5 whitespace-nowrap">
                         <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                             <?= $counter++ ?>
                         </div>
                     </td>
                     <td class="px-6 py-4">
                         <div class="flex items-center">
                             <div
                                 class="flex-shrink-0 h-10 w-10 flex items-center justify-center rounded-lg <?php echo $file_badge['bg']; ?> mr-4">
                                 <i
                                     class="fas <?php echo $file_badge['icon']; ?> <?php echo $file_badge['color']; ?> text-lg"></i>
                             </div>
                             <div>
                                 <p class="font-medium text-gray-900">
                                     <?php echo htmlspecialchars($doc['document_title']); ?>
                                 </p>
                                 <p class="text-sm text-gray-500"><?php echo $doc['file_name']; ?></p>
                             </div>
                         </div>
                     </td>
                     <td class="px-6 py-4">
                         <div class="flex items-center">
                             <div
                                 class="flex-shrink-0 h-9 w-9 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 font-medium">
                                 <?php echo strtoupper(substr($doc['shared_by_name'], 0, 1)); ?>
                             </div>
                             <div class="ml-3">
                                 <p class="text-gray-900 font-medium">
                                     <?php echo htmlspecialchars($doc['shared_by_name']); ?></p>
                                 <p class="text-sm text-gray-500"><?php echo $doc['shared_by_email']; ?>
                                 </p>
                             </div>
                         </div>
                     </td>
                     <td class="px-6 py-4">
                         <?php if ($doc['action'] == 'view'): ?>
                         <span class="badge badge-view text-green-500">
                             <i class="fas fa-eye text-green-500 mr-1"></i> Viewed
                         </span>
                         <?php elseif ($doc['action'] == 'download'): ?>
                         <span class="badge badge-download text-purple-500">
                             <i class="fas fa-download text-purple-500 mr-1"></i> Download
                         </span>
                         <?php elseif ($doc['action'] == 'delete'): ?>
                         <span class="badge badge-delete">
                             <i class="fas fa-trash mr-1"></i> Deleted
                         </span>
                         <?php endif; ?>
                     </td>
                     <td class="px-6 py-4 text-gray-500">
                         <?php echo date('M j, Y', strtotime($doc['shared_date'])); ?><br>
                         <span class="text-sm"><?php echo date('g:i A', strtotime($doc['shared_date'])); ?></span>
                     </td>
                     <td class="px-6 py-4 text-right">
                         <button onclick="showLogDetails(<?php echo htmlspecialchars(json_encode($doc)); ?>)"
                             class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                             View Details <i class="fas fa-chevron-right ml-1"></i>
                         </button>
                     </td>
                 </tr>
                 <?php endforeach; ?>
             </tbody>

         </table>
     </div>
     <?php else: ?>
     <div class="p-12 text-center">
         <div class="mx-auto w-24 h-24 rounded-full bg-gray-100 flex items-center justify-center mb-4">
             <i class="fas fa-folder-open text-gray-400 text-3xl"></i>
         </div>
         <h3 class="text-lg font-medium text-gray-900 mb-1">No documents found</h3>
         <p class="text-gray-500 mb-4">Try adjusting your search or filter to find what you're looking
             for.</p>
         <a href="<?php echo strtok($_SERVER["REQUEST_URI"], '?'); ?>"
             class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
             <i class="fas fa-sync-alt mr-2"></i> Reset Filters
         </a>
     </div>
     <?php endif; ?>
 </div>