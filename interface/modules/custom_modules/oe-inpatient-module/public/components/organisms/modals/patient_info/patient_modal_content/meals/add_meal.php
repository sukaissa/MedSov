<div id="patientModalAddMealsContent" class="hidden mt-5 pb-6">
    <button class="flex gap-4 items-center" onclick="showModalContent('meals')">
        <img src="./assets/img/msv-back-icon.svg" alt="back" />
        <p class="font-semibold">New Request</p>
    </button>
    <div class="flex flex-col gap-4  max-h-[400px] overflow-auto my-4">
        <div>
            <label class="font-medium" for="">Meal<span class="text-[#ED2024]">*</span></label>
            <select class="w-full h-[56px] px-5 rounded-md text-sm border border-[#8C898A] text-[#282224]" name="" id="">
                <option value="">Select Meal</option>
                <option value="">Breakfast</option>
                <option value="">Lunch</option>
                <option value="">Dinner</option>
                <option value="">Snack</option>
            </select>
        </div>
        <div>
            <label class="font-medium" for="">Staff<span class="text-[#ED2024]">*</span></label>
            <select class="w-full h-[56px] px-5 rounded-md text-sm border border-[#8C898A] text-[#282224]" name="" id="">
                <option value="">Select Staff</option>
            </select>
        </div>
        <div>
            <label class="font-medium" for="">Request Date<span class="text-[#ED2024]">*</span></label>
            <input type="date" name=""
                class="w-full h-[56px] px-5 rounded-md text-sm border border-[#8C898A] text-[#282224]" id="">
        </div>

    </div>
    <button class="bg-[#ED2024] w-full h-[50px] text-white px-4 py-2 rounded-md font-bold">Save</button>
</div>