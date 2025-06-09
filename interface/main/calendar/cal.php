<?php

require_once(__DIR__ . '/../../globals.php');

use OpenEMR\Core\Header;

//get patients with appointments for today
$sql = "SELECT p.fname, p.mname, p.lname, p.DOB, p.pid, p.street, p.postal_code,
 p.city, p.state, p.country_code, p.phone_home, p.phone_cell, p.sex, i.";

$currentDate = date('Y-m-d');

$formattedDate = oeFormatShortDate($currentDate);

$appointmentSql = "SELECT
    cal.pc_pid,
    cal.pc_eventDate,
    cal.pc_hometext,
    cal.pc_startTime,
    p.fname,
    p.mname,
    p.lname,
    p.DOB,
    p.pid,
    p.street,
    p.postal_code,
    p.city,
    p.state,
    p.country_code,
    p.phone_home,
    p.phone_cell,
    p.sex,
    p.email,
    p.email_direct
FROM openemr_postcalendar_events cal
INNER JOIN patient_data p ON p.pid = cal.pc_pid
WHERE cal.pc_eventDate = ?";

$appointmentResult = sqlStatement($appointmentSql, $currentDate);
?>

<html lang="en">
<head>
    <title><?php echo xlt("Appointments for Today"); ?></title>
    <?php Header::setupHeader(); ?>

    <style>

        @media print {
            .container {
                page-break-after: always;
            }

            .container:last-child {
                page-break-after: auto;;
            }
        }
    </style>
    <script>
        window.print();
    </script>
</head>
</html>

<?php

while ($row = sqlFetchArray($appointmentResult)) { ?>
    <div class="container mt-5">
        <div class="border p-4 rounded-lg">
            <div>
                <div class="text-muted text-uppercase"><?php echo xlt("Patient Name"); ?></div>
                <div class="title font-weight-bolder text-capitalize"><?php echo text($row['fname']) . " " . text($row['mname']) . " " . text($row['lname']); ?></div>
            </div>
            <?php if ($row['pc_hometext']) { ?>
            <hr/>
            <div class="appointment_comment">
                <div>
                    <i class="fa-solid fa-message"></i>
                    <span><?php echo xlt($row['pc_hometext']); ?></span>
                </div>
            </div>
            <?php } ?>
        </div>

        <section class="icon-field d-flex justify-content-between mt-4">
            <div class="d-flex align-items-center">
                <div class="bg-light p-2 mr-2 rounded-lg">
                    <i class="text-muted fa-solid fa-venus-mars fa-2x"></i>
                </div>
                <div>
                    <div class="text-muted text-uppercase"><?php echo xlt("Gender"); ?></div>
                    <div class="font-weight-bold"><?php echo text($row['sex']); ?></div>
                </div>
            </div>
            <div class="d-flex align-items-center">
                <div class="bg-light p-2 mr-2 rounded-lg">
                    <i class="text-muted fa-regular fa-calendar-check fa-2x"></i>
                </div>
                <div>
                    <div class="text-muted text-uppercase"><?php echo xlt("Appointment Date & Time"); ?></div>
                    <div class="font-weight-bold"><?php echo text(oeFormatDateTime($row['pc_eventDate'])). " " . oeFormatTime($row['pc_startTime']); ?></div>
                </div>
            </div>
            <div class="d-flex align-items-center">
                <div class="bg-light p-2 mr-2 rounded-lg">
                    <i class="text-muted fa-regular fa-hourglass-half fa-2x"></i>
                </div>
                <div>
                    <div class="text-muted text-uppercase"><?php echo xlt("Age"); ?></div>
                    <div class="font-weight-bold"><?php echo text(oeFormatAge($row['DOB'])); ?></div>
                </div>
            </div>
        </section>

        <div>
            <div class="title font-weight-bold mt-4">
                <?php echo xlt("General Info"); ?>
            </div>
            <div class="row mt-4">
                <div class="col">
                    <div class="text-muted text-uppercase"><?php echo xlt("FULLNAME"); ?></div>
                    <div class="font-weight-bold text-capitalize"><?php echo text($row['fname']) . " " . text($row['mname']) . " " . text($row['lname']); ?></div>
                </div>
                <div class="col">
                    <div class="text-muted text-uppercase"><?php echo xlt("PHONE NUMBER"); ?></div>
                    <div class="font-weight-bold text-lowercase"><?php echo text($row['phone_cell']); ?></div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col">
                    <div class="text-muted text-uppercase"><?php echo xlt("DOB"); ?></div>
                    <div class="font-weight-bold text-lowercase"><?php echo text(oeFormatShortDate($row['DOB'])); ?></div>
                </div>
                <div class="col">
                    <div class="text-muted text-uppercase"><?php echo xlt("EMAIL"); ?></div>
                    <div class="font-weight-bold text-lowercase"><?php echo text($row['email']); ?></div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col">
                    <div class="text-muted text-uppercase"><?php echo xlt("ADDRESS"); ?></div>
                    <div class="font-weight-bold text-lowercase"><?php echo text($row['street']); ?></div>
                </div>
            </div>
        </div>

        <hr/>

        <section class="mt-4">
            <div class="font-weight-bold title"><?php echo xlt("Insurance"); ?></div>

            <?php
            $insQuery = sqlStatement("SELECT
                id.*,
                ic.*
            FROM insurance_data id
            INNER JOIN insurance_companies ic ON ic.id = id.provider
            WHERE id.pid = ? AND (id.provider != '' OR id.provider IS NULL)", [$row['pid']]
            );

            $style = "border rounded-lg p-2 d-inline-block bg-light";

            while ($insRow = sqlFetchArray($insQuery)) {
                if ($insRow['type'] == 'primary') {
                    echo "<div class='$style'>" . xlt("Primary Insurance") . "</div>";
                }
                if ($insRow['type'] == 'secondary') {
                    echo "<div class='$style'>" . xlt("Secondary Insurance") . "</div>";
                }
                if ($insRow['type'] == 'tertiary') {
                    echo "<div class='$style'>" . xlt("Tertiary Insurance") . "</div>";
                }
                ?>

                <div class="row my-2">
                    <div class="col">
                        <div class="text-muted"><?php echo xlt("Name of Insurance"); ?></div>
                        <div class="font-weight-bold"><?php echo text($insRow['name']); ?></div>
                    </div>
                    <div class="col">
                        <div class="text-muted"><?php echo xlt("Plan Name"); ?></div>
                        <div class="font-weight-bold"><?php echo text($insRow['plan_name']); ?></div>
                    </div>
                    <div class="col">
                        <div class="text-muted"><?php echo xlt("Subscriber Name"); ?></div>
                        <div class="font-weight-bold"><?php echo text($insRow['subscriber_fname'])." ".text($insRow['subscriber_mname'])." ".text($insRow['subscriber_lname']); ?></div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col">
                        <div class="text-muted"><?php echo xlt("Subscriber Relationship"); ?></div>
                        <div class="font-weight-bold"><?php echo text($insRow['subscriber_relationship']); ?></div>
                    </div>
                    <div class="col">
                        <div class="text-muted"><?php echo xlt("Subscriber Address"); ?></div>
                        <div class="font-weight-bold"><?php echo text($insRow['subscriber_street']); ?></div>
                    </div>
                    <div class="col">
                        <div class="text-muted"><?php echo xlt("Policy Number"); ?></div>
                        <div class="font-weight-bold"><?php echo text($insRow['policy_number']); ?></div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col">
                        <div class="text-muted"><?php echo xlt("Subscriber SSN"); ?></div>
                        <div class="font-weight-bold"><?php echo text($insRow['subscriber_ss']); ?></div>
                    </div>
                <?php if ($insRow['subscriber_employer']) { ?>
                    <div class="col">
                        <div class="text-muted"><?php echo xlt("Employer Name"); ?></div>
                        <div class="font-weight-bold"><?php echo text($insRow['subscriber_employer']); ?></div>
                    </div>
                    <div class="col">
                        <div class="text-muted"><?php echo xlt("Employer Address"); ?></div>
                        <div class="font-weight-bold"><?php echo text($insRow['subscriber_employer_street']); ?></div>
                    </div>
                <?php } ?>
                </div>

                <?php if ($insRow['subscriber_employer']) { ?>
                    <div class="row mt-2">
                        <div class="col">
                            <div class="text-muted"><?php echo xlt("Employer Country") ."/". xlt("State"); ?></div>
                            <div class="font-weight-bold"><?php echo text($insRow['subscriber_employer_country']). "/" .text($insRow['subscriber_employer_state']); ?></div>
                        </div>
                        <div class="col">
                            <div class="text-muted"><?php echo xlt("Employer City"); ?></div>
                            <div class="font-weight-bold"><?php echo text($insRow['subscriber_employer_city']); ?></div>
                        </div>
                        <div class="col">
                            <div class="text-muted"><?php echo xlt("Employer Zip code"); ?></div>
                            <div class="font-weight-bold"><?php echo text($insRow['subscriber_employer_postal_code']); ?></div>
                        </div>
                    </div>
                <?php }
            }
            ?>
        </section>


    </div>
<?php
}
