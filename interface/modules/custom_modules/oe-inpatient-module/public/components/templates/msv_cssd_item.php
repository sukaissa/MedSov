<?php
ob_start();
?>

<div>
    <?php
    include_once __DIR__ . "/../organisms/msv_cssd_item_content.php";
    ?>
</div>

<?php

$pageContent = ob_get_clean();
$content = $pageContent; // Pass the captured content to the layout

include __DIR__ . '/../layouts/msv-inpatient-layout.php';
?>