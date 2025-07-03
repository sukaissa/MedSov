<?php

use OpenEMR\Modules\InpatientModule\AuthQuery;
use OpenEMR\Modules\InpatientModule\FoodQuery;
use OpenEMR\Modules\InpatientModule\InpatientQuery;

require_once __DIR__ . "/../../../../../../../../../../globals.php";
require_once __DIR__ . "/../../../../../sql/AuthQuery.php";
require_once __DIR__ . "/../../../../../sql/FoodQuery.php";
require_once __DIR__ . "/../../../../../sql/InpatientQuery.php";

$authQuery = new AuthQuery();
$foodQuery = new FoodQuery();
$inpatientQuery = new InpatientQuery();

$patients = $inpatientQuery->getInpatients();
$foodRequests = $foodQuery->getFoodRequests();
$foodItems = $foodQuery->getMenuItems();
$users = $authQuery->getUsers();
$pid = isset($_GET['pid']) ? $_GET['pid'] : null;

?>

<div id="patientModalAddMealsContent" class="hidden mt-5 pb-6">
    <button class="flex gap-4 items-center" onclick="showModalContent('meals')">
        <img src="./assets/img/msv-back-icon.svg" alt="back" />
        <p class="font-semibold">New Request</p>
    </button>

    <form action="<?php echo $_SERVER['PHP_SELF'] . '?pid=' . urlencode($pid) . '&meals=1'; ?>" method="POST" id="mealRequestForm">
        <input type="hidden" name="pid" value="<?php echo htmlspecialchars($pid); ?>">
        <input type="hidden" name="new_food_request" value="1">
        <div class="flex flex-col gap-4  max-h-[400px] overflow-auto my-4">
            <div>
                <label class="font-medium" for="">Meal<span class="text-[#ED2024]">*</span></label>
                <select id="food" name="food" class="w-full h-[56px] px-5 rounded-md text-sm border border-[#8C898A] text-[#282224]">
                    <option value=""><?php echo xlt("Select food") ?> </option>
                    <?php foreach ($foodItems as $food) { ?>
                        <option value="<?php echo $food['id']; ?>"><?php echo $food['category']; ?> | <?php echo $food['price']; ?> | <?php echo $food['name']; ?></option>
                    <?php
                    }  ?>
                </select>
            </div>
            <div>
                <label class="font-medium" for="">Staff<span class="text-[#ED2024]">*</span></label>
                <select name="staff" id="staff" class="w-full h-[56px] px-5 rounded-md text-sm border border-[#8C898A] text-[#282224]">
                    <option value=""> <?php echo xlt("Select Staff") ?> </option>
                    <?php foreach ($users as $user) { ?>
                        <option value="<?php echo $user['id']; ?>"><?php echo $user['fname'] . " " . $user['lname']; ?></option>
                    <?php
                    }  ?>
                </select>
            </div>
            <div>
                <label class="font-medium" for="">Request Date<span class="text-[#ED2024]">*</span></label>
                <input type="date" name="requested_date"
                    class="w-full h-[56px] px-5 rounded-md text-sm border border-[#8C898A] text-[#282224]" id="requested_date">
            </div>

        </div>
        <button type="submit" class="bg-[#ED2024] w-full h-[50px] text-white px-4 py-2 rounded-md font-bold">Save</button>
    </form>
</div>