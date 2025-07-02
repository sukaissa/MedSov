<?php

function renderPatientDetailsModal($patientData)
{
    // Default values to prevent errors if a key is not provided
    $patientName = htmlspecialchars($patientData['patientName'] ?? 'N/A');
    $patientPID = htmlspecialchars($patientData['patientPID'] ?? 'N/A');
    $dateTime = htmlspecialchars($patientData['dateTime'] ?? 'N/A');
    $patientDepartment = htmlspecialchars($patientData['patientDepartment'] ?? 'N/A');
    $patientRoom = htmlspecialchars($patientData['patientRoom'] ?? 'N/A');
    // Note: $modalContent is likely redundant if you're using $modalContents
    // $modalContent = $patientData['modalContent'] ?? '';

    // Get all modal content sections, default to an empty array if not set
    $modalContents = $patientData['modalContents'] ?? ['main' => '<p>No content provided.</p>'];

    echo <<<HTML
    <div id="patientDetailsModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 hidden z-50">
        <div class="bg-white rounded-xl shadow-lg w-full max-w-[500px] mx-auto p-6 relative">
            <div class="border-b border-b-[6px] border-b-[#282224] ">
                <button class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-2xl font-bold"
                    onclick="closePatientDetailsModal()">
                    &times;
                </button>

                <div class="flex justify-between items-end pb-4 mb-4">
                    <div>
                        <h2 class="text-2xl font-bold text-black" id="modalPatientName">{$patientName}</h2>
                        <p class="text-black text-sm font-medium">PID: <span class="font-[300]"
                                id="modalPatientPID">{$patientPID}</span>
                        </p>
                    </div>

                    <p class="text-black text-sm font-[300]">
                        {$dateTime}
                    </p>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div class="bg-[#FAFAFA] border-[#E7E7E7] border p-3 rounded-md flex items-center space-x-2">
                        <img src="./assets/img/msv-medical-icon.svg" alt="Department Icon" class="w-4 h-4">
                        <span id="modalPatientDepartment">{$patientDepartment}</span>
                    </div>
                    <div class="bg-[#FAFAFA] border-[#E7E7E7] border p-3 rounded-md flex items-center space-x-2">
                        <img src="./assets/img/msv-bed-icon.svg" alt="Room Icon" class="w-4 h-5">
                        <span id="modalPatientRoom">{$patientRoom}</span>
                    </div>
                </div>
            </div>

            <div id="patientModalDynamicContentArea">
HTML;
    // CLOSE HEREDOC HERE, THEN EXECUTE PHP CODE
    foreach ($modalContents as $key => $contentHtml) {
        echo $contentHtml; // This will output the HTML string for each content part
    }
    // REOPEN HEREDOC FOR THE CLOSING DIVS
    echo <<<HTML
            </div>

        </div>
    </div>
    HTML;
}
