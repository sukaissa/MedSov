<div id="mealRequestForm" class="hidden pb-4">
    <form action="" method="POST">
        <input type="hidden" name="new" value="1">
        <div class="mt-6 flex justify-between items-center">
            <p class="text-[#282224] text-2xl font-semibold">New Meal Request</p>
        </div>
        <div class="flex flex-col gap-4 my-6  max-h-[400px] overflow-auto">
            <div>
                <label class="font-medium" for="">Patient<span class="text-[#ED2024]">*</span></label>
                <select name="patient" id="patient" class="w-full h-[56px] px-5 rounded-md text-sm border border-[#8C898A] text-[#282224]">
                    <option value="">Select Patient</option>
                </select>
            </div>
            <div>
                <label class="font-medium" for="">Meal<span class="text-[#ED2024]">*</span></label>
                <select name="meal" id="meal" class="w-full h-[56px] px-5 rounded-md text-sm border border-[#8C898A] text-[#282224]">
                    <option value="">Select Meal</option>
                </select>
            </div>
            <div>
                <label class="font-medium" for="">Staff<span class="text-[#ED2024]">*</span></label>
                <select name="staff" id="staff" class="w-full h-[56px] px-5 rounded-md text-sm border border-[#8C898A] text-[#282224]">
                    <option value="">Select Staff</option>
                </select>
            </div>

            <div>
                <label class="font-medium" for="">Request Date<span class="text-[#ED2024]">*</span></label>
                <input type="date" name="date"
                    class="w-full h-[56px] px-5 rounded-md text-sm border border-[#8C898A] text-[#282224]">
            </div>
        </div>
        <button type="submit" class="bg-[#ED2024] w-full h-[50px] text-white px-4 py-2 rounded-md font-bold">Save</button>
    </form>
</div>