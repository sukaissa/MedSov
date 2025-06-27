<?php

use OpenEMR\Modules\InpatientModule\WardQuery;

require_once __DIR__ . "/../../../../../../globals.php";
require_once __DIR__ . "/../sql/WardQuery.php";

$wardQuery = new WardQuery();

$searchTerm = '';
if (isset($_GET['search_by_ward_name']) && $_SERVER['REQUEST_METHOD'] == "GET") {
    $searchTerm = isset($_GET['search_term']) && trim($_GET['search_term']) !== '' ? $_GET['search_term'] : '';
    $wards = $wardQuery->searchWardsByName($searchTerm);
} else {
    $wards = $wardQuery->getWards();
}

?>
<main class="flex-1">
    <div class="bg-gradient-to-b h-[241px] from-[#FFA97F] to-[#ED2024] p-6">
        <p class="text-[32px] font-[500] text-white ml-12">Wards</p>
    </div>

    <div class="flex w-full items-center flex-col justify-center">

        <div class="-mt-[150px] w-[1070px] min-h-[493px] bg-white p-[30px]">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET" class="w-full">
                <input type="hidden" name="search_by_ward_name">
                <div class="flex gap-5 align-items-center border-b pb-5 mb-5">
                    <div class="h-[50px] w-full rounded-lg border border-[#8C898A] flex items-center gap-3 px-2">
                        <div class="border h-[30px]"></div>
                        <input
                            type="text"
                            class="px-5 focus:ring-0 focus:outline-none flex-1 h-full"
                            name="search_term"
                            placeholder="Enter name of ward"
                            value="<?php echo xlt($searchTerm); ?>"
                        />
                    </div>

                    <button type="submit" class="flex items-center justify-center w-[50px] h-[50px] bg-[#ED2024] rounded-lg">
                        <img src="./assets/img/msv-search-icon.svg" alt="">
                    </button>

                    <?php if ($searchTerm !== ''): ?>
                        <a href="<?php echo $_SERVER['PHP_SELF']; ?>"
                           class="flex items-center justify-center w-[50px] h-[50px] bg-[#FFA97F] rounded-lg transition hover:bg-[#ED2024] group"
                           title="Clear search">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </a>
                    <?php endif; ?>
                </div>
            </form>

            <?php include_once __DIR__ . '/tables/ward-table.php'; ?>

        </div>

</main>