<div id="patientModalReprintWristbandContent" class="hidden mt-5">
    <button class="flex gap-4 items-center" onclick="showModalContent('main')">
        <img src="./assets/img/msv-back-icon.svg" alt="back" />
        <p class="font-semibold">Reprint Wristband</p>
    </button>
    <div class="flex w-full items-center justify-center py-8 max-h-[300px] overflow-auto">
        <div class="flex flex-col gap-4">
            <div
                class="w-full h-[56px] text-sm rounded-md bg-[#FFF9F9] border border-[#ED2024] text-[#282224] font-[300] px-8 flex items-center">
                A
                wristband has already been
                issued. Please fill in the below to re-print a wristband.</div>

            <div>
                <label for="">Reason</label>
                <input type="text" name=""
                    class="w-full h-[56px] rounded-md text-sm border border-[#ED2024] text-[#282224]" id="">
            </div>
            <div>
                <label for="">Comments</label>
                <textarea name="" id=""
                    class="w-full h-[156px] text-sm border rounded-md border-[#ED2024] text-[#282224]"></textarea>
            </div>
        </div>
    </div>
    <button class="bg-[#ED2024] w-full h-[50px] text-white px-4 py-2 rounded-md ">Reprint Wristband</button>
</div>