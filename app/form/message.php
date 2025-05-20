<?php if (!empty($success)): ?>
<div class="mb-6 p-4 bg-green-50 text-green-700 rounded-lg border border-green-200 flex items-start">
    <i class="fas fa-check-circle mt-1 mr-3 text-green-500"></i>
    <div>
        <p class="font-medium"><?= htmlspecialchars($success) ?></p>
        <p class="text-sm mt-1">You can now <a href="../../form_login.php"
                class="text-green-600 font-medium hover:underline">login</a> to your account.</p>
    </div>
</div>
<?php endif; ?>