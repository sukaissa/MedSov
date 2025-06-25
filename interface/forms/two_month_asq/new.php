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

?>
<html>

<head>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container py-4">
        <h1 class="mb-3">Ages &amp; Stages Questionnaires® (ASQ®): 2-Month Questionnaire</h1>
        <p class="fst-italic">To be filled out by parent or caregiver</p>
        <h2 class="mt-4">General Instructions</h2>
        <p>Please read each question carefully and select the option that best describes your child’s ability. Answer based on what your child is doing now. If your child has a medical condition, please explain at the end of the questionnaire.</p>

        <form action="#" method="post" id="asqForm">
            <?php include __DIR__ . '/components/baby_info.php'; ?>
            <?php include __DIR__ . '/components/person_filling.php'; ?>
            <?php include __DIR__ . '/components/program_info.php'; ?>
            <?php include __DIR__ . '/components/communication.php'; ?>
            <?php include __DIR__ . '/components/gross_motor.php'; ?>
            <?php include __DIR__ . '/components/fine_motor.php'; ?>
            <?php include __DIR__ . '/components/problem_solving.php'; ?>
            <?php include __DIR__ . '/components/personal_social.php'; ?>
            <?php include __DIR__ . '/components/overall_section.php'; ?>
            <div class="text-end">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#previewModal" id="previewButton">Preview &amp; Submit</button>
            </div>
        </form>
    </div>
    <!-- Preview Modal -->
    <?php include __DIR__ . '/components/preview_modal.php'; ?>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('previewButton').addEventListener('click', function() {
            const form = document.getElementById('asqForm');
            const data = new FormData(form);
            let html = '';
            data.forEach((value, key) => {
                html += `<p><strong>${key.replace(/\-/g, ' ')}:</strong> ${value}</p>`;
            });
            document.getElementById('previewBody').innerHTML = html;
        });
    </script>
</body>

</html>

<?php
formFooter();
?>