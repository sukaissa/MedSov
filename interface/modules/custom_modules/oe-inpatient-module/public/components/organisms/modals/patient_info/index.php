<div id="patientDetailsModal"
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 hidden z-50">
    <!-- Modal Content -->
    <div class="bg-white rounded-xl shadow-lg w-full max-w-[500px] mx-auto p-6 relative">
        <div class="border-b border-b-[6px] border-b-[#282224] ">
            <!-- Close Button -->
            <button class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-2xl font-bold"
                onclick="closePatientDetailsModal()">
                &times;
            </button>

            <!-- Modal Header -->
            <div class="flex justify-between items-end pb-4 mb-4">
                <div>
                    <h2 class="text-2xl font-bold text-black" id="modalPatientName">Lily Cho</h2>
                    <p class="text-black text-sm font-medium">PID: <span class="font-[300]"
                            id="modalPatientPID">123456789</span>
                    </p>
                </div>

                <p class="text-black text-sm font-[300]">
                    May 5, 2025 • 4:35AM
                </p>
            </div>

            <!-- Patient Details -->
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div class="bg-[#FAFAFA] border-[#E7E7E7] border p-3 rounded-md flex items-center space-x-2">
                    <img src="./assets/img/msv-medical-icon.svg" alt="Department Icon" class="w-4 h-4">
                    <span id="modalPatientDepartment">Woman’s Medical</span>
                </div>
                <div class="bg-[#FAFAFA] border-[#E7E7E7] border p-3 rounded-md flex items-center space-x-2">
                    <img src="./assets/img/msv-bed-icon.svg" alt="Room Icon" class="w-4 h-5">
                    <span id="modalPatientRoom">123-D</span>
                </div>
            </div>
        </div>


        <div class="mt-6">
            <button
                class="w-full bg-[#FAFAFA] h-[64px] border-[#E7E7E7] border rounded-md flex items-center justify-center">
                <div class="flex gap-3 items-center">
                    <img src="./assets/img/msv-print-icon.svg" alt="Print Wristband Icon">
                    <span class="text-[14px] font-[300] text-[#282224]">Print Wristband</span>
                </div>
            </button>
            <!-- Action Buttons Grid -->
            <div class="grid grid-cols-3 gap-4 mb-6 mt-6">

                <button
                    class="flex flex-col items-center justify-center bg-[#FAFAFA] h-[122px] w-[134px] border-[#E7E7E7] rounded-md border hover:bg-gray-200 transition-colors">
                    <img src="./assets/img/msv-treatment-icon.svg" alt="Treatments Icon" class="mb-2">
                    <span class="text-sm font-medium">Treatments</span>
                </button>
                <button
                    class="flex flex-col items-center justify-center bg-[#FAFAFA] h-[122px] w-[134px] border-[#E7E7E7] rounded-md border hover:bg-gray-200 transition-colors">
                    <img src="./assets/img/msv-surgery-icon.svg" alt="Surgeries Icon" class="mb-2">
                    <span class="text-sm font-medium">Surgeries</span>
                </button>
                <button
                    class="flex flex-col items-center justify-center bg-[#FAFAFA] h-[122px] w-[134px] border-[#E7E7E7] rounded-md border hover:bg-gray-200 transition-colors">
                    <img src="./assets/img/msv-meals-icon.svg" alt="Meals Icon" class="mb-2">
                    <span class="text-sm font-medium">Meals</span>
                </button>
                <button
                    class="flex flex-col items-center justify-center bg-[#FAFAFA] h-[122px] w-[134px] border-[#E7E7E7] rounded-md border hover:bg-gray-200 transition-colors">
                    <img src="./assets/img/msv-vitals-icon.svg" alt="v Icon" class="mb-2">
                    <span class="text-sm font-medium">Vitals</span>
                </button>
                <button
                    class="flex flex-col items-center justify-center bg-[#FAFAFA] h-[122px] w-[134px] border-[#E7E7E7] rounded-md border hover:bg-gray-200 transition-colors">
                    <img src="./assets/img/msv-note-icon.svg" alt="Notes Icon" class="mb-2">
                    <span class="text-sm font-medium">Notes</span>
                </button>
                <button
                    class="flex flex-col items-center justify-center bg-[#FAFAFA] h-[122px] w-[134px] border-[#E7E7E7] rounded-md border hover:bg-gray-200 transition-colors">
                    <img src="./assets/img/msv-treatment-icon.svg" alt="Transfer Icon" class="mb-2">
                    <span class="text-sm font-medium">Transfer</span>
                </button>

            </div>
        </div>


        <!-- Discharge Button -->
        <div class="w-full">
            <button
                class="flex items-center justify-center w-full p-4 bg-[#FAFAFA] h-[63px] w-full border-[#E7E7E7] rounded-md border hover:bg-gray-200 transition-colors">
                <img src="./assets/img/msv-discharge-icon.svg"" alt=" Discharge Icon" class="mr-2">
                <span class="text-base font-medium">Discharge</span>
            </button>
        </div>
    </div>
</div>