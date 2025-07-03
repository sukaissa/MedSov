<?php

?>

<div id="mealRequestForm" class="hidden pb-4">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <input type="hidden" name="new" value="1">
        <div class="mt-6 flex justify-between items-center">
            <p class="text-[#282224] text-2xl font-semibold">New Meal Requests</p>
        </div>
        <div class="flex flex-col gap-4 my-6  max-h-[400px] overflow-auto">
            <div>
                <label class="font-medium" for="patient_new"><?php echo xlt("Patient") ?> <span class="text-[#ED2024]">*</span></label>
                <select name="patient" id="patient_new" class="w-full h-[56px] px-5 rounded-md text-sm border border-[#8C898A] text-[#282224]" required>
                    <option value=""><?php echo xlt("Select patient") ?> </option>
                    <?php foreach ($patients as $patient) { ?>
                        <option value="<?php echo $patient['patient_id']; ?>"><?php echo $patient['fname'] . " " . $patient['mname'] . " " . $patient['lname']; ?> | <?php echo $patient['ward_name']; ?> | <?php echo "Bed - " . $patient['bed_number']; ?></option>
                    <?php
                    }  ?>
                </select>
            </div>
            <div>
                <label class="font-medium" for=""><?php echo xlt("Meal") ?><span class="text-[#ED2024]">*</span></label>
                <select name="food" id="meal" class="w-full h-[56px] px-5 rounded-md text-sm border border-[#8C898A] text-[#282224]" required>
                    <option value=""><?php echo xlt("Select meal") ?></option>
                    <?php foreach ($foodItems as $food) { ?>
                        <option value="<?php echo $food['id']; ?>"><?php echo $food['category']; ?> | <?php echo $food['price']; ?> | <?php echo $food['name']; ?></option>
                    <?php
                    }  ?>
                </select>
            </div>
            <div>
                <label class="font-medium" for="staff"><?php echo xlt("Staff") ?><span class="text-[#ED2024]">*</span></label>
                <select name="staff" id="staff" class="w-full h-[56px] px-5 rounded-md text-sm border border-[#8C898A] text-[#282224]" required>
                    <option value=""><?php echo xlt("Select staff") ?></option>
                    <?php foreach ($users as $user) { ?>
                        <option value="<?php echo $user['id']; ?>"><?php echo $user['fname'] . " " . $user['lname']; ?></option>
                    <?php
                    }  ?>
                </select>
            </div>

            <div>
                <label class="font-medium" for="requested_date"><?php echo xlt("Request Date") ?><span class="text-[#ED2024]">*</span></label>
                <input type="date" name="requested_date" id="requested_date" value="<?php echo date('Y-m-d'); ?>"
                    class="w-full h-[56px] px-5 rounded-md text-sm border border-[#8C898A] text-[#282224]">
            </div>
        </div>
        <button type="submit" class="bg-[#ED2024] w-full h-[50px] text-white px-4 py-2 rounded-md font-bold"><?php echo xlt("Save") ?></button>
    </form>
</div>