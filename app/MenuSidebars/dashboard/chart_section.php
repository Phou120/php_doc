<!-- Chart Section -->
<section class="mb-10">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-gray-800 flex items-center">
            <i class="fas fa-chart-line text-blue-500 mr-2"></i>
            Upload Stats
        </h2>
        <div class="flex space-x-2">
            <button
                class="px-3 py-1 text-sm bg-blue-100 text-blue-600 rounded-lg hover:bg-blue-200 transition-colors">Week</button>
            <button
                class="px-3 py-1 text-sm bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200 transition-colors">Month</button>
            <button
                class="px-3 py-1 text-sm bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200 transition-colors">Year</button>
        </div>
    </div>
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <canvas id="uploadChart" height="120"></canvas>
    </div>
</section>