<?php
    // Define an array of navigation items
    $navItems = [
        [
            'href' => 'admissions.php',
            'icon' => './assets/img/msv-sidenav-icon.svg', // Assuming different icons for different items
            'text' => 'Admissions'
        ],
        [
            'href' => 'inpatient.php',
            'icon' => './assets/img/msv-sidenav-icon.svg',
            'text' => 'Inpatients'
        ],
        [
            'href' => 'surgery.php',
            'icon' => './assets/img/msv-sidenav-icon.svg',
            'text' => 'Surgeries'
        ],
        [
            'href' => 'emergency.php',
            'icon' => './assets/img/msv-sidenav-icon.svg',
            'text' => 'Emergency'
        ],
        [
            'href' => 'beds.php',
            'icon' => './assets/img/msv-sidenav-icon.svg',
            'text' => 'Beds'
        ],
        [
            'href' => 'wards.php',
            'icon' => './assets/img/msv-sidenav-icon.svg',
            'text' => 'Wards'
        ],
    ];

    // Get the current page name to highlight the active link (optional but good practice)
    $currentPage = basename($_SERVER['PHP_SELF']);
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

<body>
    <aside class="w-64 bg-white border-r border-gray-200 min-h-screen">
        <div class="p-4">
            <p class="text-sm text-gray-500 mb-4">Menu</p>
            <nav class="space-y-2">
                <ul class="space-y-2"> <?php foreach ($navItems as $item): ?>
                    <?php
                // Determine if the current link is active
                $isActive = ($currentPage === basename($item['href'])) ?
                            'text-coral bg-coral bg-opacity-10 rounded-lg' :
                            'text-gray-600 hover:bg-gray-100 rounded-lg'; // Adjust classes as needed for inactive state
            ?>
                    <li>
                        <a href="<?php echo htmlspecialchars($item['href']); ?>"
                            class="flex items-center space-x-3 px-3 py-2 <?php echo $isActive; ?>">
                            <img src="<?php echo htmlspecialchars($item['icon']); ?>" alt="nav-icon" class="w-5 h-5" />
                            <span class="font-medium"><?php echo htmlspecialchars($item['text']); ?></span>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>

            </nav>
        </div>
    </aside>
</body>