<div id="patientModalTreatmentContent" class="hidden mt-5">
    <button class="flex gap-4 items-center" onclick="showModalContent('main')">
        <img src="./assets/img/msv-back-icon.svg" alt="back" />
        <p class="font-medium">Back</p>
    </button>
    <div class="flex w-full items-center justify-center">
        <div class="flex flex-col items-center justify-center h-[300px]">
            <img src="./assets/img/msv-treatment-icon.svg" alt="print" class="w-20 h-20">
            <p class="text-2xl font-semibold">Treatments</p>
            <p class="font-[300]">No treatments yet. Add one to get started.</p>
        </div>
    </div>
    <button onclick="showModalContent('addTreatment')"
        class="bg-[#ED2024] w-full h-[50px] text-white px-4 py-2 rounded-md">
        Add a Treatment</button>
</div>