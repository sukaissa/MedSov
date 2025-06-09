<?php
require_once("../globals.php");
require_once("$srcdir/pid.inc");
require_once("$srcdir/forms.inc");

use OpenEMR\Common\Session\SessionUtil;
use OpenEMR\Common\Csrf\CsrfUtils;
use OpenEMR\Core\Header;

$eventDate = $_GET['eventDate'];
$pid = $_GET['pid'];
$eventId = $_GET['pc_eid'];

//set pid in session

$from_date = $eventDate . " 00:00:00";
$to_date = $eventDate . " 23:59:59";
$params = [$from_date, $to_date, $pid];

$encounterId = 0;
$encounterQuery = sqlQuery("SELECT date, encounter FROM form_encounter WHERE date BETWEEN ? AND ? AND pid = ?", $params);

// print_r($encounterQuery);

$patQuery = sqlQuery("SELECT pid, DOB FROM patient_data WHERE pid = ?", [$pid]);
$patDOB = $patQuery['DOB'];

//get meeting details
$bindArray = array($eventId,$eventDate);
$event = sqlQuery("SELECT * FROM lifemesh_chime_sessions WHERE pc_eid = ? AND event_date = ?", $bindArray);

$pc_catname = "%Telehealth%";
$pc_catid = sqlQuery("SELECT pc_catid FROM openemr_postcalendar_categories WHERE pc_catname LIKE ?", array($pc_catname));
    
$meetingId = $event['provider_uri'];

if (!empty($encounterQuery)) {
    $encounterId = $encounterQuery['encounter'];
} else {
    echo "new encounter used ";
    $encounter = generate_id();
    $encounterId = $encounter;
    $date = date('Y-m-d H:i:s');
    $facility = sqlQuery("SELECT name FROM facility WHERE id = ?", [$_SESSION['pc_facility']]);
    addForm(
        $encounter,
        "New Patient Encounter",
        sqlInsert(
            "INSERT INTO form_encounter SET
                date = ?,
                onset_date = ?,
                facility = ?,
                pc_catid = ?,
                facility_id = ?,
                billing_facility = ?,
                pid = ?,
                encounter = ?,
                provider_id = ?,
                encounter_type_code = ?,
                encounter_type_description = ?",
            [
                $date,
                null,
                $facility['name'],
                $pc_catid['pc_catid'],
                $_SESSION['pc_facility'],
                $_SESSION['pc_facility'],
                $pid,
                $encounter,
                $_SESSION['authUserID'],
                $encounter_type_code,
                $encounter_type_description
            ]
        ),
        "newpatient",
        $pid,
        1,
        $date
    );
}

?>

<html>
<script>
    window.onload = function() {
        const initiateButton = document.querySelector(".initiate-jitsi");
        const meetingId = "<?php echo ($meetingId); ?>";
        
        const anchor = document.createElement("a");
        anchor.href = "jitsi.php?id=" + (meetingId);
        initiateButton.appendChild(anchor);
        
        const pid = <?php echo $pid; ?>;
        const encounterId = <?php echo $encounterId; ?>;
        const datestr = "<?php echo $patDOB; ?>";
        
        // anchor.click();
        
    }
    
    function openJitsi(meetingId, pid, encounterId) {
        top.restoreSession();
        // document.fnew.submit();
        top.RTop.location = "/interface/patient_file/summary/demographics.php?set_pid=" + encodeURIComponent(pid) + "&set_encounterid=" + encodeURIComponent(encounterId);
        
        top.restoreSession();
        const url = "./jitsi.php?id=" + meetingId;
        dlgopen(url, "", '450', '450', true, '', null);
    }
</script>
    <head>
        <?php Header::setupHeader(['datetime-picker', 'report-helper']); ?>
    </head>
<body>
    <div class="initiate-jitsi"></div>
    <div class="container">
        <?php if ($encounterId) {?>
        <div><?php echo xlt("A visit/encounter already exists, would you like to join?"); ?></div>
        <button class="btn btn-primary" onclick="openJitsi(<?php echo attr_js($meetingId); ?>, <?php echo attr_js($pid); ?>, <?php echo attr_js($encounterId); ?>)"><?php echo text("Join Telehealth Session"); ?></button>
        <?php } else { ?>
        <div><?php echo xlt("A new visit has been created for this appointment, click the button below to begin the session"); ?></div>
        <button class="btn btn-primary" onclick="openJitsi(<?php echo attr_js($meetingId); ?>)"><?php echo text("Launch New Telehealth Session"); ?></button>
        <?php } ?>
    </div>

</body>
</html>