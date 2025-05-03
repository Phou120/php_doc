<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
    /* Custom styles for enhanced visuals */
    .glass-effect {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
    }

    .file-icon {
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        transform: translateY(0);
    }

    .file-card:hover .file-icon {
        transform: translateY(-5px);
        box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
    }

    .pulse-animation {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.5);
        }

        70% {
            box-shadow: 0 0 0 10px rgba(59, 130, 246, 0);
        }

        100% {
            box-shadow: 0 0 0 0 rgba(59, 130, 246, 0);
        }
    }

    .header-gradient {
        background: linear-gradient(120deg, #f0f9ff 0%, #e6f7ff 100%);
    }
    </style>
</head>

<body class="bg-gray-50">
    <?php
    include_once "dashboard_query.php";
    ?>

    <div class="flex h-screen">
        <!-- Sidebar -->
        <?php include 'db_sidebar.php'; ?>

        <main class="flex-1 p-8 overflow-auto bg-gradient-to-br from-gray-50 to-blue-50">

            <?php 
                include 'db_header.php';
                include 'report_document.php'; 
                include 'chart_section.php';
                include 'report_user.php';
            ?>
        </main>
    </div>

    <?php include 'db_modal_structure.php'; ?>
    <script src="js/dashboard.js"></script>
</body>

</html>