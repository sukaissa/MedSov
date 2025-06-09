<?php

/**
 * Lifemesh Sessions UI
 *
 * @Package OpenEMR
 * @link http://www.open-emr.org
 * @author OpenEMR Support LLC
 * @author Stnaley Otabil <stanleywkwaminaotabil@gmail.com>
 * @copyright Copyright (c) 2010 OpenEMR Support LLC
 * @copyright Copyright (c) 2022 Medsov
 * @copyright Copyright (c) 2022 Stanley Otabil
 * @license https://github.com/openemr/openemr/blob/master/LICENSE GNU General Public License 3
 */

 $ignoreAuth_onsite_portal = true;

require_once("../../interface/globals.php");

use OpenEMR\Core\Header;

// $session_results = sqlQuery("SELECT * FROM lifemesh_chime_sessions where event_status=?", array('Scheduled'));
// $query = "SELECT * FROM lifemesh_chime_sessions WHERE event_status = ?";
$query = "SELECT * FROM openemr_postcalendar_events INNER JOIN lifemesh_chime_sessions ON openemr_postcalendar_events.pc_eid=lifemesh_chime_sessions.pc_eid WHERE pc_pid=? ORDER BY event_date DESC LIMIT 1";
$results = sqlStatement($query, $_SESSION['pid']);
$sessionsData = true ? $results : array();

?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="MedEx Bank" />
    <meta name="author" content="OpenEMR: MedExBank" />

    <?php

    echo "<title>" .  xlt('Telehealth Sessions') . "</title>";
    ?>
    <?php Header::setupHeader('datetime-picker'); ?> 

    <style>
        .desktop-browser {
            background: #1b263800 !important;
            width: 80% !important;
            /* display: flex; */
            margin-left: auto !important;
            margin-right: auto !important;
        }
    </style>
</head>

<body class='body_top'>
    <h1><?php echo text("Telehealth Sessions"); ?></h1>

    <div>
        
        <?php
        foreach ($sessionsData as $obj) {
        ?>
            <section style="background-color: #e1e1e1; padding: 12px; margin: 20px; display: flex; justify-content: space-evenly; align-items: center;">
                <div>
                    <p>ID: <?php echo $obj['id']; ?></p>
                    <p>PC EID: <?php echo $obj['pc_eid']; ?></p>
                    <p>Meeting ID <?php echo $obj['meeting_id']; ?></p>
                    <p>Patient Code: <?php echo $obj['patient_code']; ?></p>
                </div>

                <div>
                    <p>Patient URI: <?php echo $obj['patient_uri']; ?></p>
                    <p>Event Date: <?php echo $obj['event_date']; ?></p>
                    <p>Event Time: <?php echo $obj['event_time']; ?></p>
                </div>

                <?php $meeting_id = $obj['provider_uri']; ?>
                <a href="jitsi.php?id=<?php echo $meeting_id; ?>" style="padding: 8px 12px; background-color: blue; border-radius: 7px; color: white; text-decoration: none;">Start Telehealth</a>
            </section>
        <?php
        }
        ?>
    </div>


</body>

</html>