<div id="patientModalAddTreatmentContent" class="hidden mt-5">
    <button class="flex gap-4 items-center" onclick="showModalContent('treatment')">
        <img src="./assets/img/msv-back-icon.svg" alt="back" />
        <p class="font-semibold">Add Treatment</p>
    </button>
    <div class="flex w-full items-center justify-center py-8">
        <div class="flex flex-col gap-4  max-h-[300px] overflow-auto">

            <div>
                <label class="font-medium" for="">Plan<span class="text-[#ED2024]">*</span></label>
                <input type="text" name=""
                    class="w-full h-[56px] px-5 rounded-md text-sm border border-[#8C898A] text-[#282224]" id="">
            </div>
            <div>
                <label class="font-medium" for="">Title<span class="text-[#ED2024]">*</span></label>
                <input type="text" name=""
                    class="w-full h-[56px] px-5 rounded-md text-sm border border-[#8C898A] text-[#282224]" id="">
            </div>
            <div>
                <label class="font-medium" for="">Interval<span class="text-[#ED2024]">*</span></label>
                <input type="text" name=""
                    class="w-full h-[56px] px-5 rounded-md text-sm border border-[#8C898A] text-[#282224]" id="">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div class="">
                    <label class="font-medium" for="">Start Time <span class="text-[#ED2024]">*</span></label>
                    <input type="time" name=""
                        class="w-full h-[56px] px-5 rounded-md text-sm border border-[#8C898A] text-[#282224]" id="">
                </div>
                <div>
                    <label class="font-medium" for="">End Time<span class="text-[#ED2024]">*</span></label>
                    <input type="time" name=""
                        class="w-full h-[56px] px-5 rounded-md text-sm border border-[#8C898A] text-[#282224]" id="">
                </div>
            </div>
        </div>
    </div>
    <button class="bg-[#ED2024] w-full h-[50px] text-white px-4 py-2 rounded-md font-bold">Add a Treatment</button>
</div>