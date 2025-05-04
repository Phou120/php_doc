document.addEventListener('DOMContentLoaded', function() {
    // Enhanced Sidebar toggle functionality
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const mobileSidebarToggle = document.getElementById('mobileSidebarToggle');
    const menuTexts = document.querySelectorAll('.menu-text');
    const toggleIcon = document.getElementById('toggleIcon');

    // Check if sidebar state is saved in localStorage
    const isSidebarCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';

    // Set initial state
    if (isSidebarCollapsed) {
        collapseSidebar();
    } else {
        expandSidebar();
    }

    // Toggle sidebar for desktop
    sidebarToggle.addEventListener('click', function() {
        if (sidebar.classList.contains('w-64')) {
            collapseSidebar();
        } else {
            expandSidebar();
        }
    });

    // Toggle sidebar for mobile
    if (mobileSidebarToggle) {
        mobileSidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('-translate-x-full');
            sidebar.classList.toggle('fixed');
            sidebar.classList.toggle('md:relative');
            sidebar.classList.toggle('z-50');
            sidebar.classList.toggle('h-full');
        });
    }

    function collapseSidebar() {
        // Animate to collapsed state
        sidebar.classList.remove('w-64');
        sidebar.classList.add('w-20', 'sidebar-collapsed');

        // Add a slight delay to hide text for smoother transition
        setTimeout(() => {
            menuTexts.forEach(text => {
                text.classList.add('hidden');
            });
        }, 150);

        // Rotate icon to show collapsed state
        toggleIcon.classList.remove('fa-chevron-left');
        toggleIcon.classList.add('fa-chevron-right');

        // Save state
        localStorage.setItem('sidebarCollapsed', 'true');
    }

    function expandSidebar() {
        sidebar.classList.remove('w-20', 'sidebar-collapsed');
        sidebar.classList.add('w-64');

        // Show menu texts immediately for expansion
        menuTexts.forEach(text => {
            text.classList.remove('hidden');
        });

        // Rotate icon to show expanded state
        toggleIcon.classList.remove('fa-chevron-right');
        toggleIcon.classList.add('fa-chevron-left');

        // Save state
        localStorage.setItem('sidebarCollapsed', 'false');
    }
});