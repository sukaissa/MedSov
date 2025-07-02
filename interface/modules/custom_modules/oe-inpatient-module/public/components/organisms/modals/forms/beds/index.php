<div id="bedsForm" class="hidden pb-4">
    <form method="POST">
        <input type="hidden" name="new" id="new" value="1">
        <input type="hidden" name="availability" id="availability" value="Available">

        <div class="mt-6 flex justify-between items-center">
            <p class="text-[#282224] text-2xl font-semibold">Bed Form</p>
        </div>
        <div class="flex flex-col gap-4 my-6  max-h-[400px] overflow-auto">
            <div>
                <label class="font-medium" for="number"><?php echo xlt('Bed number') ?><span class="text-[#ED2024]">*</span></label>
                <input type="text" name="number"
                    class="w-full h-[56px] px-5 rounded-md text-sm border border-[#8C898A] text-[#282224]" id="">
            </div>
            <div>
                <label class="font-medium" for="bed_type"><?php echo xlt('Bed Type') ?><span class="text-[#ED2024]">*</span></label>

                <select class="w-full h-[56px] px-5 rounded-md text-sm border border-[#8C898A] text-[#282224]" id="bed_type" name="bed_type">
                    <option value="<?php echo xlt('Private') ?>"> <?php echo xlt('Private') ?></option>
                    <option value="<?php echo xlt('VIP') ?>"> <?php echo xlt('VIP') ?></option>
                    <option value="<?php echo xlt('Regular') ?>"> <?php echo xlt('Regular') ?></option>
                </select>
            </div>
            <div>
                <label class="font-medium" for="price_per_day"><?php echo xlt('Price per Day') ?><span class="text-[#ED2024]">*</span></label>
                <input type="number" name="price_per_day" id="price_per_day"
                    class="w-full h-[56px] px-5 rounded-md text-sm border border-[#8C898A] text-[#282224]" id="">
            </div>
            <div>
                <label class="font-medium" for="ward"><?php echo xlt('Ward') ?><span class="text-[#ED2024]">*</span></label>
                <select class="w-full h-[56px] px-5 rounded-md text-sm border border-[#8C898A] text-[#282224]" id="ward" name="ward_id">
                    <?php foreach ($wards as $ward) { ?>
                        <option value="<?php echo $ward['id']; ?>"><?php echo $ward['short_name']; ?> - <?php echo $ward['name']; ?></option>
                    <?php
                    }  ?>
                </select>
            </div>
        </div>
        <button type="submit" class="bg-[#ED2024] w-full h-[50px] text-white px-4 py-2 rounded-md font-bold"><?php echo xlt('Save') ?></button>
    </form>
</div>