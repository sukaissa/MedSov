<div id="patientModalVitalsContent" class="hidden mt-5">
    <div class="flex items-center justify-between">
        <button class="flex gap-4 items-center" onclick="showModalContent('main')">
            <img src="./assets/img/msv-back-icon.svg" alt="back" />
            <p class="font-medium">Back</p>
        </button>

        <div class="flex items-center gap-3">
            <p class="text-sm font-medium text-[#282224]">Last Update: <span class="font-[400]">May 1, 2025 • 15:48</span></p>
            <button onclick="showModalContent('vitalsSettings')" class="w-[36px] h-[36px] rounded-md border bg-[] flex items-center justify-center">
                <img src="./assets/img/msv-settings-icon.svg" alt="settings" class="w-4 h-4">
            </button>
        </div>
    </div>

    <div class="grid grid-cols-3 gap-4 my-10">
        <div class="col-span-1 h-[122px] flex flex-col items-center justify-center rounded-md border border-[#E7E7E7] text-[#282224]">
            <p class="font-medium text-2xl ">36.8</p>
            <p class="font-[300] text-sm">Temperature</p>
        </div>
        <div class="col-span-1 h-[122px] flex flex-col items-center justify-center rounded-md border border-[#E7E7E7] text-[#282224]">
            <p class="font-medium text-2xl ">78</p>
            <p class="font-[300] text-sm">Heart Rate</p>
        </div>
        <div class="col-span-1 h-[122px] flex flex-col items-center justify-center rounded-md border border-[#E7E7E7] text-[#282224]">
            <p class="font-medium text-2xl ">16</p>
            <p class="font-[300] text-sm">Respiratory Rate</p>
        </div>
        <div class="col-span-1 h-[122px] flex flex-col items-center justify-center rounded-md border border-[#E7E7E7] text-[#282224]">
            <p class="font-medium text-2xl ">120/76</p>
            <p class="font-[300] text-sm">Blood Pressure</p>
        </div>
        <div class="col-span-1 h-[122px] flex flex-col items-center justify-center rounded-md border border-[#E7E7E7] text-[#282224]">
            <p class="font-medium text-2xl ">98%</p>
            <p class="font-[300] text-sm">SpO₂</p>
        </div>
        <div class="col-span-1 h-[122px] flex flex-col items-center justify-center rounded-md border border-[#E7E7E7] text-[#282224]">
            <p class="font-medium text-2xl ">2</p>
            <p class="font-[300] text-sm">Pain Score</p>
        </div>
    </div>
    <button
     onclick="showModalContent('recordVitals')"
        class="bg-[#ED2024] w-full h-[50px] text-white px-4 py-2 rounded-md">
        Record Vitals</button>
</div>