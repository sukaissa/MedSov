<?php


require_once __DIR__ . "/../../../../../../globals.php";



?>

<main class="flex-1">


    <div class="bg-gradient-to-b h-[241px] from-[#FFA97F] to-[#ED2024] p-6">
        <div class="flex justify-between items-center">
            <p class="text-[32px] font-[500] text-white ml-16">Meal Menu</p>

            <button class="flex mr-16 rounded-md items-center w-[36px] h-[36px] bg-white justify-center" onclick="showFormsModal('mealMenuForm')">
                +
            </button>
        </div>
    </div>

    <div class="flex w-full items-center flex-col justify-center">

        <div class="-mt-[150px] w-[1070px] min-h-[493px] bg-white p-[30px]">

            <div class="flex gap-5 align-items-center border-b pb-5 mb-5 ">
                <div class="h-[50px] w-full rounded-lg border border-[#8C898A] flex items-center gap-3 px-2">

                    <input type="text" class="px-5 focus:ring-0 focus:outline-none flex-1 h-full"
                        placeholder="Enter meal name" />
                </div>

                <button class="flex items-center justify-center w-[50px] h-[50px] bg-[#ED2024] rounded-lg">
                    <img src="./assets/img/msv-search-icon.svg" alt="">
                </button>   
            </div>


            <?php include_once __DIR__ . '/tables/meal_menu_table.php'; ?>


        </div>

</main>