<?php
// Get current page filename
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!-- Sidebar Component -->
<aside id="sidebar" class="w-64 bg-white shadow-lg p-4 transition-all duration-300">
    <div class="flex justify-between items-center mb-8">
        <div class="flex items-center slide-in">
            <div class="bg-blue-600 text-white p-2 rounded-lg shadow-lg">
                <i class="fas fa-file-medical text-2xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-gray-800 ml-3 menu-text">DocManager</h1>
        </div>

        <!-- Toggle button -->
        <div>
            <button id="sidebarToggle" class="p-2 rounded-full hover:bg-gray-100 text-gray-600">
                <i id="toggleIcon" class="fas fa-chevron-left text-xl"></i>
            </button>
        </div>
    </div>

    <nav class="space-y-2">
        <!-- Dashboard Link -->
        <a href="../dashboard/dashboard.php" data-tooltip="Dashboard"
            class="menu-item flex items-center space-x-4 p-3 rounded-xl transition-all duration-300
                       <?php echo ($current_page == 'dashboard.php') ? 'bg-blue-100 text-blue-600 shadow-md' : 'text-gray-600 hover:bg-blue-50'; ?>">
            <div
                class="flex items-center justify-center w-8 h-8 rounded-lg <?php echo ($current_page == 'dashboard.php') ? 'bg-blue-600 text-white' : 'text-gray-600'; ?>">
                <i class="fas fa-tachometer-alt"></i>
            </div>
            <span class="menu-text font-medium">Dashboard</span>
        </a>

        <!-- Documents Link -->
        <a href="../menudocments/documents.php" data-tooltip="Documents"
            class="menu-item flex items-center space-x-4 p-3 rounded-xl transition-all duration-300
                       <?php echo ($current_page == 'documents.php') ? 'bg-blue-100 text-blue-600 shadow-md' : 'text-gray-600 hover:bg-blue-50'; ?>">
            <div
                class="flex items-center justify-center w-8 h-8 rounded-lg <?php echo ($current_page == 'documents.php') ? 'bg-blue-600 text-white' : 'text-gray-600'; ?>">
                <i class="fas fa-file-alt"></i>
            </div>
            <span class="menu-text font-medium">Documents</span>
        </a>

        <!-- Document Shared Link -->
        <a href="../menu_document_share/document_share.php" data-tooltip="Shared Docs"
            class="menu-item flex items-center space-x-4 p-3 rounded-xl transition-all duration-300
                       <?php echo ($current_page == 'document_share.php') ? 'bg-blue-100 text-blue-600 shadow-md' : 'text-gray-600 hover:bg-blue-50'; ?>">
            <div
                class="flex items-center justify-center w-8 h-8 rounded-lg <?php echo ($current_page == 'document_share.php') ? 'bg-blue-600 text-white' : 'text-gray-600'; ?>">
                <i class="fas fa-share-alt"></i>
            </div>
            <span class="menu-text font-medium">Shared Docs</span>
        </a>

        <!-- Document Log Link -->
        <a href="../menu_document_log/document_log.php" data-tooltip="Document Logs"
            class="menu-item flex items-center space-x-4 p-3 rounded-xl transition-all duration-300
                       <?php echo ($current_page == 'document_log.php') ? 'bg-blue-100 text-blue-600 shadow-md' : 'text-gray-600 hover:bg-blue-50'; ?>">
            <div
                class="flex items-center justify-center w-8 h-8 rounded-lg <?php echo ($current_page == 'document_log.php') ? 'bg-blue-600 text-white' : 'text-gray-600'; ?>">
                <i class="fas fa-history"></i>
            </div>
            <span class="menu-text font-medium">Doc Logs</span>
        </a>

        <!-- Users Link -->
        <a href="../menu_users/users.php" data-tooltip="Users"
            class="menu-item flex items-center space-x-4 p-3 rounded-xl transition-all duration-300
                       <?php echo ($current_page == 'users.php') ? 'bg-blue-100 text-blue-600 shadow-md' : 'text-gray-600 hover:bg-blue-50'; ?>">
            <div
                class="flex items-center justify-center w-8 h-8 rounded-lg <?php echo ($current_page == 'users.php') ? 'bg-blue-600 text-white' : 'text-gray-600'; ?>">
                <i class="fas fa-users"></i>
            </div>
            <span class="menu-text font-medium">Users</span>
        </a>
    </nav>

    <div class="mt-8 border-t pt-4">
        <!-- Profile Link -->
        <a href="../profile/profile.php" data-tooltip="Profile"
            class="menu-item flex items-center space-x-4 p-3 rounded-xl transition-all duration-300
                       <?php echo ($current_page == 'profile.php') ? 'bg-blue-100 text-blue-600 shadow-md' : 'text-gray-600 hover:bg-blue-50'; ?>">
            <div
                class="flex items-center justify-center w-8 h-8 rounded-lg <?php echo ($current_page == 'profile.php') ? 'bg-blue-600 text-white' : 'text-gray-600'; ?>">
                <i class="fas fa-user-circle"></i>
            </div>
            <span class="menu-text font-medium">Profile</span>
        </a>
    </div>
</aside>