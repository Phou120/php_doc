 <!-- Dashboard Header with improved design -->
 <header class="flex justify-between items-center mb-8 p-4 header-gradient rounded-2xl shadow-sm">
     <div>
         <h1 class="text-2xl font-bold text-gray-800">
             <i class="fas fa-tachometer-alt text-blue-600 mr-2"></i>Dashboard
         </h1>
     </div>

     <div class="flex items-center space-x-4">
         <!-- Search with animation -->
         <div class="relative mr-4 hidden md:block">
             <input type="search" placeholder="Search files..."
                 class="w-full px-4 py-2 pl-10 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
             <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
         </div>

         <!-- Notification button with badge -->
         <button
             class="p-2 hover:bg-blue-100 rounded-full relative transition-all duration-300 text-gray-600 hover:text-blue-600">
             <i class="fas fa-bell w-5 h-5"></i>
             <span
                 class="absolute -top-1 -right-1 bg-red-500 text-white text-xs w-5 h-5 flex items-center justify-center rounded-full pulse-animation">3</span>
         </button>

         <!-- User Avatar with gradient -->
         <div onclick="handleLogout()"
             class="cursor-pointer w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-blue-700 text-white flex items-center justify-center hover:shadow-lg transition-all duration-300">
             <span class="font-medium">JD</span>
         </div>
     </div>
 </header>