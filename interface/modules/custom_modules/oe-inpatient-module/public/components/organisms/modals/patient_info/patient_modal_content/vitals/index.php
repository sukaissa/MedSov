<?php

use OpenEMR\Modules\InpatientModule\AuthQuery;
use OpenEMR\Modules\InpatientModule\VitalQuery;
use OpenEMR\Modules\InpatientModule\InpatientQuery;

require_once __DIR__ . "/../../../../../../../../../../globals.php";
require_once __DIR__ . "/../../../../../sql/AuthQuery.php";
require_once __DIR__ . "/../../../../../sql/VitalQuery.php";
require_once __DIR__ . "/../../../../../sql/InpatientQuery.php";

$authQuery = new AuthQuery();
$vitalQuery = new VitalQuery();
$inpatientQuery = new InpatientQuery();

$pid = isset($_GET['pid']) ? $_GET['pid'] : null;
$inpatientData = $pid ? $inpatientQuery->getInpatientByPid($pid) : null;

if (isset($_POST['new_vital_record']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $inpatientData = $pid ? $inpatientQuery->getInpatientByPid($pid) : null;

    // Validation with type checking
    $errors = [];
    
    // Required numeric fields
    if (empty($_POST['temperature']) || !is_numeric($_POST['temperature'])) {
        $errors[] = "Temperature must be a valid number";
    }
    if (empty($_POST['heart_rate']) || !is_numeric($_POST['heart_rate'])) {
        $errors[] = "Heart rate must be a valid number";
    }
    if (empty($_POST['respiratory_rate']) || !is_numeric($_POST['respiratory_rate'])) {
        $errors[] = "Respiratory rate must be a valid number";
    }
    if (empty($_POST['blood_pressure']) || trim($_POST['blood_pressure']) === '') {
        $errors[] = "Blood pressure is required";
    }
    if (empty($_POST['spo2']) || !is_numeric($_POST['spo2'])) {
        $errors[] = "SpO2 must be a valid number";
    }
    if (empty($_POST['pain_score']) || !is_numeric($_POST['pain_score'])) {
        $errors[] = "Pain score must be a valid number";
    }
    
    if (!empty($errors)) {
        $error_message = implode("\\n", $errors);
        echo "<script>alert('$error_message');</script>";
    } else {
        // Proceed with data insertion
        $data = [
            'patient' => $pid,
            'ward_id' => $inpatientData['ward_id'] ?? 0,
            'bed_id' => $inpatientData['bed_id'] ?? 0,
            'admission_id' => $inpatientData['id'] ?? 0,
            'temperature' => floatval($_POST['temperature']),
            'heart_rate' => intval($_POST['heart_rate']),
            'respiratory_rate' => intval($_POST['respiratory_rate']),
            'blood_pressure' => trim($_POST['blood_pressure']),
            'spo2' => floatval($_POST['spo2']),
            'pain_score' => intval($_POST['pain_score']),
            'height' => !empty($_POST['height']) ? floatval($_POST['height']) : null,
            'weight' => !empty($_POST['weight']) ? floatval($_POST['weight']) : null,
            'fluid_input' => !empty($_POST['fluid_input']) ? floatval($_POST['fluid_input']) : null,
            'fluid_output' => !empty($_POST['fluid_output']) ? floatval($_POST['fluid_output']) : null,
            'time_taken' => date('Y-m-d H:i:s'),
        ];
        $vitalQuery->insertVital($data);
    }
}

// Get the latest vital signs for the admission
$latestVital = null;
if ($inpatientData && isset($inpatientData['id'])) {
    $latestVital = $vitalQuery->getLatestAdmissionVital($inpatientData['id']);
}

?>
<div id="patientModalVitalsContent" class="hidden mt-5">
    <div class="flex items-center justify-between">
        <button class="flex gap-4 items-center" onclick="showModalContent('main')">
            <img src="./assets/img/msv-back-icon.svg" alt="back" />
            <p class="font-medium">Back</p>
        </button>

        <div class="flex items-center gap-3">
            <p class="text-sm font-medium text-[#282224]">Last Update: 
                <span class="font-[400]">
                    <?php 
                    if ($latestVital && isset($latestVital['time_taken'])) {
                        echo date('M j, Y • H:i', strtotime($latestVital['time_taken']));
                    } else {
                        echo 'No records found';
                    }
                    ?>
                </span>
            </p>
            <button onclick="showModalContent('vitalsSettings')" class="w-[36px] h-[36px] rounded-md border bg-[] flex items-center justify-center">
                <img src="./assets/img/msv-settings-icon.svg" alt="settings" class="w-4 h-4">
            </button>
        </div>
    </div>

    <div class="grid grid-cols-3 gap-4 my-10">
        <div class="col-span-1 h-[122px] flex flex-col items-center justify-center rounded-md border border-[#E7E7E7] text-[#282224]">
            <p class="font-medium text-2xl"><?php echo $latestVital['temperature'] ?? '--'; ?></p>
            <p class="font-[300] text-sm">Temperature</p>
        </div>
        <div class="col-span-1 h-[122px] flex flex-col items-center justify-center rounded-md border border-[#E7E7E7] text-[#282224]">
            <p class="font-medium text-2xl"><?php echo $latestVital['heart_rate'] ?? '--'; ?></p>
            <p class="font-[300] text-sm">Heart Rate</p>
        </div>
        <div class="col-span-1 h-[122px] flex flex-col items-center justify-center rounded-md border border-[#E7E7E7] text-[#282224]">
            <p class="font-medium text-2xl"><?php echo $latestVital['respiratory_rate'] ?? '--'; ?></p>
            <p class="font-[300] text-sm">Respiratory Rate</p>
        </div>
        <div class="col-span-1 h-[122px] flex flex-col items-center justify-center rounded-md border border-[#E7E7E7] text-[#282224]">
            <p class="font-medium text-2xl"><?php echo $latestVital['blood_pressure'] ?? '--'; ?></p>
            <p class="font-[300] text-sm">Blood Pressure</p>
        </div>
        <div class="col-span-1 h-[122px] flex flex-col items-center justify-center rounded-md border border-[#E7E7E7] text-[#282224]">
            <p class="font-medium text-2xl"><?php echo isset($latestVital['spo2']) ? $latestVital['spo2'] . '%' : '--'; ?></p>
            <p class="font-[300] text-sm">SpO₂</p>
        </div>
        <div class="col-span-1 h-[122px] flex flex-col items-center justify-center rounded-md border border-[#E7E7E7] text-[#282224]">
            <p class="font-medium text-2xl"><?php echo $latestVital['pain_score'] ?? '--'; ?></p>
            <p class="font-[300] text-sm">Pain Score</p>
        </div>
    </div>
    <button
     onclick="showModalContent('recordVitals')"
        class="bg-[#ED2024] w-full h-[50px] text-white px-4 py-2 rounded-md">
        Record Vitals</button>
</div>