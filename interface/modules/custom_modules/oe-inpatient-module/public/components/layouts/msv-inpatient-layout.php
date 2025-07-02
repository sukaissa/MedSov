<?php
$content = isset($content) ? $content : '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="./assets/css/main.css">
    <title>Inpatient Dashboard</title>

    <script src="./assets/js/jquery-3.6.2.js"></script>
    <link href="./assets/css/select2/select2.min.css" rel="stylesheet" />
    <script src="./assets/js/select2/select2.min.js"></script>


    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'coral': '#FF6B5B',
                        'coral-light': '#FF8A7A'
                    }
                }
            }
        }
    </script>

</head>

<body class="bg-[#F0F0F0]">
    <?php include_once __DIR__ . '/../molecules/msv-head.php'; ?>
    <div class="flex flex-1">

        <?php include_once __DIR__ . '/../molecules/msv-sidenav.php'; ?>


        <!-- Main Content Area -->
        <main class="flex-1 overflow-auto">
            <?php
            echo $content;
            ?>
        </main>


    </div>
    <script src="./components/organisms/modals/patient_info/index.js"></script>
</body>