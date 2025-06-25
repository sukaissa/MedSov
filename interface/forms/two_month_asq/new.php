<?php

/**
 * ASQ-3: 2-Month Questionnaire form.
 *
 * @package   MedSov EMR
 * @link      https://www.medsov.com
 * @author    Mark Amoah <mcprah@gmail.com>
 * @copyright Copyright (c) 2025 Medsov <info@medsov.com> Omega Systems
 */

require_once(__DIR__ . "/../../globals.php");
require_once("$srcdir/api.inc.php");

formHeader("2-Month ASQ Questionnaire");

use OpenEMR\Common\Csrf\CsrfUtils;

$form_name = "two_month_asq";

?>
<html>

<head>
    <!-- Bootstrap 5 CSS (local) -->
    <link href="<?php echo $web_root; ?>/public/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container py-4">
        <h1 class="mb-3">Ages &amp; Stages Questionnaires® (ASQ®): 2-Month Questionnaire</h1>
        <p class="fst-italic">To be filled out by parent or caregiver</p>
        <h2 class="mt-4">General Instructions</h2>
        <p>Please read each question carefully and select the option that best describes your child’s ability. Answer based on what your child is doing now. If your child has a medical condition, please explain at the end of the questionnaire.</p>


        <form action="<?php echo $rootdir . "/forms/" . $form_name . "/save.php?id="; ?>" method="post" id="asqForm">
            <input type="hidden" name="csrf_token_form" value="<?php echo attr(CsrfUtils::collectCsrfToken()); ?>" />
            <?php include __DIR__ . '/components/baby_info.php'; ?>
            <?php include __DIR__ . '/components/person_filling.php'; ?>
            <?php include __DIR__ . '/components/program_info.php'; ?>
            <?php include __DIR__ . '/components/communication.php'; ?>
            <?php include __DIR__ . '/components/gross_motor.php'; ?>
            <?php include __DIR__ . '/components/fine_motor.php'; ?>
            <?php include __DIR__ . '/components/problem_solving.php'; ?>
            <?php include __DIR__ . '/components/personal_social.php'; ?>
            <?php include __DIR__ . '/components/overall_section.php'; ?>
            <div class="text-right">
                <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#previewModal" id="previewButton">Preview &amp; Submit</button> -->
                <input type="button" class="btn btn-success ms-2 save" value="Save">
                <input type="button" class="btn btn-warning ms-2 dontsave" value="Cancel" onclick="parent.closeTab(window.name, false)" />
            </div>
        </form>
    </div>
    <!-- Preview Modal -->
    <?php include __DIR__ . '/components/preview_modal.php'; ?>

    <!-- Bootstrap 5 JS (local) -->
    <script src="<?php echo $web_root; ?>/public/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        // document.getElementById('previewButton').addEventListener('click', function() {
        //     const form = document.getElementById('asqForm');
        //     const data = new FormData(form);
        //     let html = '';
        //     data.forEach((value, key) => {
        //         html += `<p><strong>${key.replace(/\-/g, ' ')}:</strong> ${value}</p>`;
        //     });
        //     document.getElementById('previewBody').innerHTML = html;
        // });

        document.addEventListener('DOMContentLoaded', function() {
            // Save button
            document.querySelectorAll('.save').forEach(function(btn) {                
                btn.addEventListener('click', function() {
                    if (typeof top.restoreSession === 'function') top.restoreSession();
                    document.getElementById('asqForm').submit();
                });
            });
            // Cancel button
            document.querySelectorAll('.dontsave').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    if (window.parent && typeof window.parent.closeTab === 'function') {
                        window.parent.closeTab(window.name, false);
                    }
                });
            });
        });
    </script>
</body>

</html>

<?php
formFooter();
?>