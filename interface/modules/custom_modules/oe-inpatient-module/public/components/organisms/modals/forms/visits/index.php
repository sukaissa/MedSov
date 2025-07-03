<div id="visitorsRegistryForm" class="hidden pb-4">
    <form action="" method="POST">
        <input type="hidden" name="new" value="1">
        <div class="mt-6 flex justify-between items-center">
            <p class="text-[#282224] text-2xl font-semibold">New Visitors Registry</p>
        </div>
        <div class="flex flex-col gap-4 my-6  max-h-[400px] overflow-auto">
            <div>
                <label class="font-medium" for="">Visitor Name<span class="text-[#ED2024]">*</span></label>
                <input type="text" name="visitor_name"
                    class="w-full h-[56px] px-5 rounded-md text-sm border border-[#8C898A] text-[#282224]" id="visitor_name">
            </div>

            <div>
                <label class="font-medium" for="">Patient Name<span class="text-[#ED2024]">*</span></label>
                <select name="patient_name" id="patient_name" class="w-full h-[56px] px-5 rounded-md text-sm border border-[#8C898A] text-[#282224]">
                    <option value="">Select Patient</option>
                </select>
            </div>

            <div>
                <label class="font-medium" for="">Relationship<span class="text-[#ED2024]">*</span></label>
                <select name="relationship" id="relationship" class="w-full h-[56px] px-5 rounded-md text-sm border border-[#8C898A] text-[#282224]">
                    <option value="">Select Relationship</option>
                </select>
            </div>

            <div class="grid grid-cols-2 w-full gap-4">
                <div class="col-span-1">
                    <label class="font-medium" for="">Time In<span class="text-[#ED2024]">*</span></label>
                    <input type="time" name="time_in"
                        class="w-full h-[56px] px-5 rounded-md text-sm border border-[#8C898A] text-[#282224]">
                </div>
                <div class="col-span-1">
                    <label class="font-medium" for="">Time Out<span class="text-[#ED2024]">*</span></label>
                    <input type="time" name="time_out"
                        class="w-full h-[56px] px-5 rounded-md text-sm border border-[#8C898A] text-[#282224]">
                </div>

            </div>

            <div>
                <label class="font-medium" for="">Reason For Visit<span class="text-[#ED2024]">*</span></label>
                <textarea name="reason_for_visit" id="reason_for_visit" class="w-full h-[80px] px-5 rounded-md text-sm border border-[#8C898A] text-[#282224]"></textarea>
            </div>
        </div>
        <button type="submit" class="bg-[#ED2024] w-full h-[50px] text-white px-4 py-2 rounded-md font-bold">Save</button>
    </form>
</div>