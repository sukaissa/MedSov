<?php
ob_start();
use OpenEMR\Modules\InpatientModule\InpatientQuery;

require_once __DIR__ . "/../../../../../../globals.php";
require_once __DIR__ . "/../sql/InpatientQuery.php";
require_once __DIR__ . "/../organisms/modals/patient_info/patient_modal_content/index.php";

// If POST, redirect to GET
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pid'])) {
    header('Location: ' . $_SERVER['PHP_SELF'] . '?pid=' . urlencode($_POST['pid']));
    exit;
}

$pid = isset($_GET['pid']) ? $_GET['pid'] : null;
$showModal = $pid ? true : false;

$inpatientQuery = new InpatientQuery();
$inpatientData = $pid ? $inpatientQuery->getInpatientByPid($pid) : null;

$patientDetails = $pid ? getPatientModalContent($inpatientData, $pid) : null;

?>

<div>
    <form id="patientDetailsForm" method="POST" action="">
        <input type="hidden" name="pid" id="patientDetailsPid" value="">
        <?php
        include_once __DIR__ . "/../organisms/msv-inpatient-finder-content.php";
        require_once __DIR__ . "/../organisms/modals/patient_info/index.php";
        renderPatientDetailsModal($patientDetails);
        ?>
    </form>
</div>

<?php if ($showModal): ?>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const modal = document.getElementById("patientDetailsModal");
            if (modal) modal.classList.remove("hidden");
        });
    </script>
<?php endif; ?>

<?php

$pageContent = ob_get_clean();
$content = $pageContent; // Pass the captured content to the layout

include __DIR__ . '/../layouts/msv-inpatient-layout.php';
?>