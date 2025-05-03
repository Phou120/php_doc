<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <div class="card bg-white rounded-xl p-6 flex items-center">
        <div class="p-3 rounded-full bg-blue-50 mr-4">
            <i class="fas fa-file-alt text-blue-500 text-xl"></i>
        </div>
        <div>
            <p class="text-gray-500 text-sm">Total Actions</p>
            <h3 class="text-2xl font-bold text-gray-800"><?php echo $stats['total']; ?></h3>
        </div>
    </div>

    <div class="card bg-white rounded-xl p-6 flex items-center">
        <div class="p-3 rounded-full bg-green-50 mr-4">
            <i class="fas fa-eye text-green-500 text-xl"></i>
        </div>
        <div>
            <p class="text-gray-500 text-sm">Views</p>
            <h3 class="text-2xl font-bold text-gray-800"><?php echo $stats['views']; ?></h3>
        </div>
    </div>

    <div class="card bg-white rounded-xl p-6 flex items-center">
        <div class="p-3 rounded-full bg-purple-50 mr-4">
            <i class="fas fa-download text-purple-500 text-xl"></i>
        </div>
        <div>
            <p class="text-gray-500 text-sm">Downloads</p>
            <h3 class="text-2xl font-bold text-gray-800"><?php echo $stats['downloads']; ?></h3>
        </div>
    </div>

    <div class="card bg-white rounded-xl p-6 flex items-center">
        <div class="p-3 rounded-full bg-red-50 mr-4">
            <i class="fas fa-trash text-red-500 text-xl"></i>
        </div>
        <div>
            <p class="text-gray-500 text-sm">Deletes</p>
            <h3 class="text-2xl font-bold text-gray-800"><?php echo $stats['deletes']; ?></h3>
        </div>
    </div>
</div>