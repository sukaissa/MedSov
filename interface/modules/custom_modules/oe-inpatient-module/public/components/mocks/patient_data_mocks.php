<?php

function getPatientMocks()
{
    return  [
        'patientName' => 'Lily Cho',
        'patientPID' => 'MSV987654',
        'dateTime' => 'June 24, 2025 • 10:30AM',
        'patientDepartment' => 'Woman’s Medical',
        'patientRoom' => 'A-205',
        'modalContent' => '  <div>
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
                        <img src="./assets/img/msv-treatment-icon.svg" alt="Treatments Icon"
                            class="mb-2 w-8 h-8 object-fit">
                        <span class="text-sm font-medium">Treatments</span>
                    </button>
                    <button
                        class="flex flex-col items-center justify-center bg-[#FAFAFA] h-[122px] w-[134px] border-[#E7E7E7] rounded-md border hover:bg-gray-200 transition-colors">
                        <img src="./assets/img/msv-surgery-icon.svg" alt="Surgeries Icon"
                            class="mb-2 w-8 h-8 object-fit">
                        <span class="text-sm font-medium">Surgeries</span>
                    </button>
                    <button
                        class="flex flex-col items-center justify-center bg-[#FAFAFA] h-[122px] w-[134px] border-[#E7E7E7] rounded-md border hover:bg-gray-200 transition-colors">
                        <img src="./assets/img/msv-meals-icon.svg" alt="Meals Icon" class="mb-2 w-8 h-8 object-fit">
                        <span class="text-sm font-medium">Meals</span>
                    </button>
                    <button
                        class="flex flex-col items-center justify-center bg-[#FAFAFA] h-[122px] w-[134px] border-[#E7E7E7] rounded-md border hover:bg-gray-200 transition-colors">
                        <img src="./assets/img/msv-vitals-icon.svg" alt="v Icon" class="mb-2 w-8 h-8 object-fit">
                        <span class="text-sm font-medium">Vitals</span>
                    </button>
                    <button
                        class="flex flex-col items-center justify-center bg-[#FAFAFA] h-[122px] w-[134px] border-[#E7E7E7] rounded-md border hover:bg-gray-200 transition-colors">
                        <img src="./assets/img/msv-notes-icon.svg" alt="Notes Icon" class="mb-2 w-8 h-8 object-fit">
                        <span class="text-sm font-medium">Notes</span>
                    </button>
                    <button
                        class="flex flex-col items-center justify-center bg-[#FAFAFA] h-[122px] w-[134px] border-[#E7E7E7] rounded-md border hover:bg-gray-200 transition-colors">
                        <img src="./assets/img/msv-treatment-icon.svg" alt="Transfer Icon"
                            class="mb-2 w-8 h-8 object-fit border">
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
        </div>'
    ];
}