<main class="flex-1">
    <div class="bg-gradient-to-b h-[241px] from-[#FFA97F] to-[#ED2024] p-6">
        <p class="text-[32px] font-[500] text-white ml-12">Patient Finder</p>
    </div>

    <div class="flex w-full items-center flex-col justify-center">

        <div class="-mt-[150px] w-[1070px] min-h-[493px] bg-white p-[30px]">

            <div class="flex gap-5 align-items-center border-b pb-5 mb-5 ">
                <div class="h-[50px] w-full rounded-lg border border-[#8C898A] flex items-center gap-3 px-2">
                    <select class="flex-1 h-full focus:ring-0 focus:outline-none" placeholder="Select Ward">
                        <option value="" class="text-[#8C898A] font-[300]">Select Ward</option>
                    </select>
                    <div class="border h-[30px]"></div>
                    <input type="text" class="px-5 focus:ring-0 focus:outline-none flex-1 h-full"
                        placeholder="Enter patient’s name" />
                </div>

                <button class="flex items-center justify-center w-[50px] h-[50px] bg-[#ED2024] rounded-lg">
                    <img src="./assets/img/msv-search-icon.svg" alt="">
                </button>
            </div>


            <?php include_once __DIR__ . '/tables/finder-table.php'; ?>


        </div>
        <div class="w-[1100px] mx-10 flex px-4 items-center h-[60px] bg-white rounded-md justify-between">
            <div>Lily Cho • 123456789</div>


            <div class="flex gap-4 items-center">
                <button class="flex gap-2 items-center">
                    <img src="./assets/img/msv-treatment-icon.svg" alt="treatment">
                    <p class="text-[14px] text-[#282224]">Treatments</p>
                </button>
                <div class="border border-[#E7E7E7] h-[30px]"> </div>
                <button class="flex gap-2 items-center">
                    <img src="./assets/img/msv-surgery-icon.svg" alt="treatment">
                    <p class="text-[14px] text-[#282224]">Surgeries</p>
                </button>
                <div class="border border-[#E7E7E7] h-[30px]"> </div>
                <button class="flex gap-2 items-center">
                    <img src="./assets/img/msv-meals-icon.svg" alt="treatment">
                    <p class="text-[14px] text-[#282224]">Meals</p>
                </button>
                <div class="border border-[#E7E7E7] h-[30px]"> </div>
                <button class="flex gap-2 items-center">
                    <img src="./assets/img/msv-vitals-icon.svg" alt="treatment">
                    <p class="text-[14px] text-[#282224]">Vitals</p>
                </button>
                <div class="border border-[#E7E7E7] h-[30px]"> </div>
                <button class="flex gap-2 items-center">
                    <img src="./assets/img/msv-note-icon.svg" alt="treatment">
                    <p class="text-[14px] text-[#282224]">Notes</p>
                </button>
                <div class="border border-[#E7E7E7] h-[30px]"> </div>
                <button class="flex gap-2">
                    <button class="flex gap-2">
                        <img src="./assets/img/msv-menu-icon.svg" alt="treatment">
                    </button>
                </button>
            </div>

        </div>
</main>