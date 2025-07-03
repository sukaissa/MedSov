<?php
ob_start();

require_once __DIR__ . "/../../../../../../globals.php";
require_once __DIR__ . "/../organisms/modals/patient_info/patient_modal_content/index.php";

$pid = isset($_GET['pid']) ? $_GET['pid'] : null;
$meals = isset($_GET['meals']) ? $_GET['meals'] : null;

$showModal = $pid ? true : false;
$showMealsModalContent = $meals ? true : false;

$inpatientData = $pid ? $inpatientQuery->getInpatientByPid($pid) : null;
$patientDetails = $pid ? getPatientModalContent($inpatientData, $pid) : null;


?>

<div>

    <?php
    include_once __DIR__ . "/../organisms/msv-inpatient-finder-content.php";
    require_once __DIR__ . "/../organisms/modals/patient_info/index.php";
    renderPatientDetailsModal($patientDetails);
    ?>

</div>

<?php if ($showModal): ?>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const modal = document.getElementById("patientDetailsModal");
            if (modal) modal.classList.remove("hidden");

            <?php if ($showMealsModalContent): ?>
                showModalContent('meals');
            <?php endif; ?>
        });
    </script>
<?php endif; ?>

<?php

$pageContent = ob_get_clean();
$content = $pageContent; // Pass the captured content to the layout

include __DIR__ . '/../layouts/msv-inpatient-layout.php';
?>