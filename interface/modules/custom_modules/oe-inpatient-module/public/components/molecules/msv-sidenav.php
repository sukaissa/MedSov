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
        'text' => 'Surgeries',
        'children' => [
            [
                'text' => 'Surgeries',
                'children' => [
                    ['href' => 'surgery.php', 'text' => 'Scheduled Surgeries'],
                    ['href' => 'surgical_procedure.php', 'text' => 'Surgical Procedures'],
                ]
            ]
        ]

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
    [
        'href' => 'cssd.php',
        'icon' => './assets/img/msv-sidenav-icon.svg',
        'text' => 'CSSD',
        'children' => [
            [
                'text' => 'CSSD',
                'children' => [
                    ['href' => 'cssd_item.php', 'text' => 'CSSD Item'],
                    ['href' => 'cssd_request.php', 'text' => 'CSSD Request'],
                ]
            ]
        ]
    ],
    [
        'href' => 'food_menu.php',
        'icon' => './assets/img/msv-sidenav-icon.svg',
        'text' => 'Meal',
        'children' => [
            [
                'text' => 'Meal',
                'children' => [
                    ['href' => 'food_menu.php', 'text' => 'Meal Menu'],
                    ['href' => 'food_requests.php', 'text' => 'Meal Request'],
                ]
            ]
        ]
    ],
    [
        'href' => 'visits.php',
        'icon' => './assets/img/msv-sidenav-icon.svg',
        'text' => 'Visitors Registry',

    ],
];

// Get the current page name to highlight the active link (optional but good practice)
$currentPage = basename($_SERVER['PHP_SELF']);


function renderNavItems($items, $currentPage, $level = 0)
{
    echo '<ul class="space-y-2' . ($level > 0 ? ' ml-4' : '') . '">';
    foreach ($items as $item) {
        $hasChildren = isset($item['children']);
        $isActive = (isset($item['href']) && $currentPage === basename($item['href'])) ?
            'text-coral bg-coral bg-opacity-10 rounded-lg' :
            'text-gray-600 hover:bg-gray-100 rounded-lg';

        echo '<li class="relative group">';
        if ($hasChildren) {
            // Parent item (no href)
            echo '<div class="flex items-center space-x-3 px-3 py-2 cursor-pointer ' . $isActive . '">';
            if (isset($item['icon'])) {
                echo '<img src="' . htmlspecialchars($item['icon']) . '" alt="nav-icon" class="w-5 h-5" />';
            }
            echo '<span class="font-medium">' . htmlspecialchars($item['text']) . '</span>';
            // Chevron
            echo '<svg class="w-4 h-4 ml-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>';
            echo '</div>';
            // Submenu
            echo '<div class="hidden group-hover:block bg-white shadow-lg py-4 rounded-md absolute left-10 top-0 z-10 min-w-[210px] w-full">';
            renderNavItems($item['children'], $currentPage, $level + 1);
            echo '</div>';
        } else {
            // Leaf item
            echo '<a href="' . htmlspecialchars($item['href']) . '" class="w-fit flex items-center space-x-3 px-3 py-2 ' . $isActive . '">';
            if (isset($item['icon'])) {
                echo '<img src="' . htmlspecialchars($item['icon']) . '" alt="nav-icon" class="w-5 h-5" />';
            }
            echo '<span class="font-medium w-fit">' . htmlspecialchars($item['text']) . '</span>';
            echo '</a>';
        }
        echo '</li>';
    }
    echo '</ul>';
}
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
                <!-- <ul class="space-y-2"> <?php foreach ($navItems as $item): ?>
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
                </ul> -->
                <?php renderNavItems($navItems, $currentPage); ?>
            </nav>
        </div>
    </aside>
</body>