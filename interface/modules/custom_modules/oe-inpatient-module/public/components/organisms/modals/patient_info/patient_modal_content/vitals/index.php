<?php

use OpenEMR\Modules\InpatientModule\VitalQuery;
use OpenEMR\Modules\InpatientModule\InpatientQuery;

require_once __DIR__ . "/../../../../../../../../../../globals.php";
require_once __DIR__ . "/../../../../../sql/VitalQuery.php";
require_once __DIR__ . "/../../../../../sql/InpatientQuery.php";

$vitalQuery = new VitalQuery();
$inpatientQuery = new InpatientQuery();

$pid = isset($_GET['pid']) ? $_GET['pid'] : null;
$inpatientData = $pid ? $inpatientQuery->getInpatientByPid($pid) : null;

if (isset($_POST['new_vital_record']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $inpatientData = $pid ? $inpatientQuery->getInpatientByPid($pid) : null;

    // Validation with type checking
    $errors = [];
    
    // Handle blood pressure combination
    $blood_pressure = '';
    if (!empty($_POST['systolic']) && !empty($_POST['diastolic'])) {
        if (is_array($_POST['systolic']) && is_array($_POST['diastolic'])) {
            $blood_pressure = $_POST['systolic'][0] . '/' . $_POST['diastolic'][0];
        } else {
            $blood_pressure = $_POST['systolic'] . '/' . $_POST['diastolic'];
        }
    } elseif (!empty($_POST['blood_pressure'])) {
        $blood_pressure = $_POST['blood_pressure'];
    }
    
    // Required numeric fields validation
    if (empty($blood_pressure)) {
        $errors[] = "Blood pressure is required";
    }
    if (empty($_POST['temperature']) || !is_numeric($_POST['temperature'][0] ?? $_POST['temperature'])) {
        $errors[] = "Temperature must be a valid number";
    }
    if (empty($_POST['pulse']) || !is_numeric($_POST['pulse'][0] ?? $_POST['pulse'])) {
        $errors[] = "Heart rate must be a valid number";
    }
    if (empty($_POST['respiratory_rate']) || !is_numeric($_POST['respiratory_rate'][0] ?? $_POST['respiratory_rate'])) {
        $errors[] = "Respiratory rate must be a valid number";
    }
    if (empty($_POST['spo_2']) || !is_numeric($_POST['spo_2'][0] ?? $_POST['spo_2'])) {
        $errors[] = "SpO2 must be a valid number";
    }
    
    if (!empty($errors)) {
        $error_message = implode("\\n", $errors);
        echo "<script>alert('$error_message');</script>";
    } else {
        // Get values (handle both array and single values)
        $temperature = is_array($_POST['temperature']) ? $_POST['temperature'][0] : $_POST['temperature'];
        $pulse = is_array($_POST['pulse']) ? $_POST['pulse'][0] : $_POST['pulse'];
        $respiratory_rate = is_array($_POST['respiratory_rate']) ? $_POST['respiratory_rate'][0] : $_POST['respiratory_rate'];
        $spo_2 = is_array($_POST['spo_2']) ? $_POST['spo_2'][0] : $_POST['spo_2'];
        $pain_score = is_array($_POST['pain_score']) ? $_POST['pain_score'][0] : $_POST['pain_score'];
        $height = !empty($_POST['height']) ? (is_array($_POST['height']) ? $_POST['height'][0] : $_POST['height']) : null;
        $weight = !empty($_POST['weight']) ? (is_array($_POST['weight']) ? $_POST['weight'][0] : $_POST['weight']) : null;
        $fluid_input = !empty($_POST['fluid_input']) ? (is_array($_POST['fluid_input']) ? $_POST['fluid_input'][0] : $_POST['fluid_input']) : null;
        $fluid_output = !empty($_POST['fluid_output']) ? (is_array($_POST['fluid_output']) ? $_POST['fluid_output'][0] : $_POST['fluid_output']) : null;
        
        // Proceed with data insertion
        $data = [
            'patient_id' => $pid,
            'admission_id' => $inpatientData['id'] ?? 0,
            'blood_pressure' => $blood_pressure,
            'temperature' => floatval($temperature),
            'pulse' => intval($pulse),
            'respiratory_rate' => intval($respiratory_rate),
            'spo_2' => floatval($spo_2),
            'pain_score' => intval($pain_score),
            'height' => $height ? floatval($height) : null,
            'weight' => $weight ? floatval($weight) : null,
            'fluid_input' => $fluid_input ? floatval($fluid_input) : null,
            'fluid_output' => $fluid_output ? floatval($fluid_output) : null,
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
        <button class="flex gap-4 items-center" onclick="showModalContent('main', true, ['vitals']);">
            <img src="./assets/img/msv-back-icon.svg" alt="back" />
            <p class="font-medium"><?php echo xlt('Back'); ?></p>
        </button>

        <div class="flex items-center gap-3">
            <p class="text-sm font-medium text-[#282224]"><?php echo xlt('Last Update:'); ?>
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
            <p class="font-[300] text-sm"><?php echo xlt('Temperature'); ?></p>
        </div>
        <div class="col-span-1 h-[122px] flex flex-col items-center justify-center rounded-md border border-[#E7E7E7] text-[#282224]">
            <p class="font-medium text-2xl"><?php echo $latestVital['pulse'] ?? '--'; ?></p>
            <p class="font-[300] text-sm"><?php echo xlt('Heart Rate'); ?></p>
        </div>
        <div class="col-span-1 h-[122px] flex flex-col items-center justify-center rounded-md border border-[#E7E7E7] text-[#282224]">
            <p class="font-medium text-2xl"><?php echo $latestVital['respiratory_rate'] ?? '--'; ?></p>
            <p class="font-[300] text-sm"><?php echo xlt('Respiratory Rate'); ?></p>
        </div>
        <div class="col-span-1 h-[122px] flex flex-col items-center justify-center rounded-md border border-[#E7E7E7] text-[#282224]">
            <p class="font-medium text-2xl"><?php echo $latestVital['blood_pressure'] ?? '--'; ?></p>
            <p class="font-[300] text-sm"><?php echo xlt('Blood Pressure'); ?></p>
        </div>
        <div class="col-span-1 h-[122px] flex flex-col items-center justify-center rounded-md border border-[#E7E7E7] text-[#282224]">
            <p class="font-medium text-2xl"><?php echo isset($latestVital['spo_2']) ? $latestVital['spo_2'] . '%' : '--'; ?></p>
            <p class="font-[300] text-sm"><?php echo xlt('SpO₂'); ?></p>
        </div>
        <div class="col-span-1 h-[122px] flex flex-col items-center justify-center rounded-md border border-[#E7E7E7] text-[#282224]">
            <p class="font-medium text-2xl"><?php echo $latestVital['pain_score'] ?? '--'; ?></p>
            <p class="font-[300] text-sm"><?php echo xlt('Pain Score'); ?></p>
        </div>
    </div>
    <button
        onclick="showModalContent('recordVitals')"
        class="bg-[#ED2024] w-full h-[50px] text-white px-4 py-2 rounded-md">
        <?php echo xlt('Record Vitals'); ?></button>
</div>