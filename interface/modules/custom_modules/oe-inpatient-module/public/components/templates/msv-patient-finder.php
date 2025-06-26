<?php
ob_start();
require_once __DIR__ . "/../organisms/modals/patient_info/patient_modal_content/index.php";

// Get specific patient data from the mocks array
$patientDetails = getPatientModalContent();

?>

<div>
    <?php
    include_once __DIR__ . "/../organisms/msv-inpatient-finder-content.php";
    require_once __DIR__ . "/../organisms/modals/patient_info/index.php";
    renderPatientDetailsModal($patientDetails);
    ?>
</div>

<?php

$pageContent = ob_get_clean();
$content = $pageContent; // Pass the captured content to the layout

include __DIR__ . '/../layouts/msv-inpatient-layout.php';
?>