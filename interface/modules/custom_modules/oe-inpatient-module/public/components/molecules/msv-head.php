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
    <header class="px-6 bg-white">
        <div class="bg-white border-b border-[#282325] border-b-[6px] py-4 flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <img src="./assets/img/msv-inpatient-icon.svg" alt="inpatient-icon" />
                <span class="text-xl font-semibold text-gray-900">Inpatient</span>
            </div>
            <div class="flex items-center space-x-4">
                <button class="p-2 hover:bg-gray-100 rounded">
                    <img src="./assets/img/msv-notification-icon.svg" alt="notification" class="w-5 h-5">
                </button>
                <button class="p-2 hover:bg-gray-100 rounded">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16">
                        </path>
                    </svg>
                </button>
            </div>
        </div>
    </header>

</body>