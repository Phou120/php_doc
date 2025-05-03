            <!-- Table View -->
            <div class="bg-white rounded-b-xl shadow-[0_0_20px_rgba(0,0,0,0.08)] overflow-hidden">
                <div class="mb-6 px-6 pt-6">
                    <form method="GET" action="" class="w-full" id="searchForm">
                        <div id="searchContainer"
                            class="relative flex items-center transition-all duration-300 <?php echo !empty($search_term) ? 'active' : ''; ?>">
                            <div class="pl-4 py-2 text-gray-500">
                                <i class="fas fa-search"></i>
                            </div>
                            <input type="text" id="searchInput" name="search"
                                value="<?php echo htmlspecialchars($search_term); ?>"
                                placeholder="Search by file name or title..." class="w-full px-3 py-3 text-gray-700"
                                onfocus="document.getElementById('searchContainer').classList.add('active'); document.getElementById('searchButton').classList.remove('hidden');"
                                onblur="setTimeout(function() { 
                        if (document.getElementById('searchInput').value === '') {
                            document.getElementById('searchContainer').classList.remove('active');
                            document.getElementById('searchButton').classList.add('hidden');
                        }
                    }, 100);" />
                            <button id="searchButton" type="submit"
                                class="<?php echo empty($search_term) ? 'hidden' : ''; ?> px-4 py-2 mr-1 bg-blue-500 text-white rounded-full text-sm font-medium hover:bg-blue-600 transition-colors duration-200">
                                Search
                            </button>
                            <?php if (!empty($search_term)): ?>
                            <a href="<?php echo strtok($_SERVER["REQUEST_URI"], '?'); ?>"
                                class="px-2 py-2 mr-1 text-gray-500 hover:text-gray-700" title="Clear search">
                                <i class="fas fa-times"></i>
                            </a>
                            <?php endif; ?>
                        </div>
                    </form>

                    <?php if (!empty($search_term)): ?>
                    <div class="search-results-info mt-2 ml-2 text-sm text-gray-500">
                        <?php if ($result->num_rows > 0): ?>
                        Found <?php echo $result->num_rows; ?>
                        document<?php echo $result->num_rows > 1 ? 's' : ''; ?> matching
                        "<?php echo htmlspecialchars($search_term); ?>"
                        <?php else: ?>
                        No documents found matching "<?php echo htmlspecialchars($search_term); ?>"
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="overflow-x-auto">
                    <!-- Enhanced Search Bar -->

                    <?php if ($result->num_rows > 0): ?>
                    <table class="w-full">
                        <thead>
                            <tr class="text-left text-gray-600 text-sm bg-gray-50">
                                <th class="px-6 py-3 font-medium text-center">N</th>
                                <th class="px-6 py-3 font-medium text-center">Document Title</th>
                                <th class="px-6 py-3 font-medium text-center">Type</th>
                                <th class="px-6 py-3 font-medium text-center">Shared With Email </th>
                                <th class="px-6 py-3 font-medium text-center">Date Modified</th>
                                <th class="px-6 py-3 font-medium text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <?php 
                            $counter = 1;
                            while ($row = $result->fetch_assoc()): 
                                $file_extension = strtolower(pathinfo($row['file_name'], PATHINFO_EXTENSION));
                                $date = new DateTime($row['shared_at']);
                                
                                // Determine icon and color based on file type
                                $icon = 'fa-file text-gray-400';
                                $icon_bg = 'bg-gray-100';
                                
                                if (in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                                    $icon = 'fa-file-image text-blue-400';
                                    $icon_bg = 'bg-blue-50';
                                } elseif ($file_extension == 'pdf') {
                                    $icon = 'fa-file-pdf text-red-400';
                                    $icon_bg = 'bg-red-50';
                                } elseif (in_array($file_extension, ['doc', 'docx'])) {
                                    $icon = 'fa-file-word text-blue-500';
                                    $icon_bg = 'bg-blue-50';
                                } elseif (in_array($file_extension, ['xls', 'xlsx'])) {
                                    $icon = 'fa-file-excel text-green-500';
                                    $icon_bg = 'bg-green-50';
                                } elseif (in_array($file_extension, ['ppt', 'pptx'])) {
                                    $icon = 'fa-file-powerpoint text-orange-500';
                                    $icon_bg = 'bg-orange-50';
                                } elseif (in_array($file_extension, ['zip', 'rar', '7z'])) {
                                    $icon = 'fa-file-archive text-yellow-500';
                                    $icon_bg = 'bg-yellow-50';
                                }
                            ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-8 py-5 whitespace-nowrap">
                                    <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                                        <?= $counter++ ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div
                                            class="flex-shrink-0 h-10 w-10 flex items-center justify-center rounded-lg <?= $icon_bg ?>">
                                            <i class="fas <?= $icon ?> text-lg"></i>
                                        </div>
                                        <div class="ml-4">
                                            <div class="font-medium text-gray-900">
                                                <?php 
                                                $title = htmlspecialchars($row['title']);
                                                if (!empty($search_term) && stripos($title, $search_term) !== false) {
                                                    $title = preg_replace('/(' . preg_quote($search_term, '/') . ')/i', '<span class="bg-yellow-100">$1</span>', $title);
                                                }
                                                echo $title;
                                                ?>
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                <?php 
                                        $filename = htmlspecialchars($row['file_name']);
                                        if (!empty($search_term) && stripos($filename, $search_term) !== false) {
                                            $filename = preg_replace('/(' . preg_quote($search_term, '/') . ')/i', '<span class="bg-yellow-100">$1</span>', $filename);
                                        }
                                        echo $filename;
                                    ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        <?= strtoupper($file_extension) ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?= htmlspecialchars($row['shared_with_email']) ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?= $date->format('M j, Y') ?>
                                    <div class="text-xs text-gray-400"><?= $date->format('g:i A') ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center align-middle">
                                    <div class="flex justify-center items-center h-full">
                                        <a href="http://localhost/documentation_system/<?= htmlspecialchars($row['file_path']) ?>"
                                            class="text-green-500 hover:text-green-700 transition-colors view-btn"
                                            data-doc-id="<?= $row['id'] ?>" target="_blank" title="Preview">
                                            <i class="fas fa-eye fa-lg"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                    <?php else: ?>
                    <div class="text-center py-16">
                        <div class="mx-auto w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                            <i class="fas fa-search text-gray-400 text-xl"></i>
                        </div>
                        <h3 class="text-gray-900 font-medium text-lg">No documents share found</h3>
                        <p class="text-gray-500 mt-2">No documents share match your search criteria</p>
                        <div class="mt-6">
                            <a href="<?php echo strtok($_SERVER["REQUEST_URI"], '?'); ?>"
                                class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition-colors">
                                Show all documents share
                            </a>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>