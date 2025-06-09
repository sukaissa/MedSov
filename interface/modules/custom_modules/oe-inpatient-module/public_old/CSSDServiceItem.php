<?php

/*
 *
 * @package     OpenEMR Inpatient Module
 * @link        https://lifemesh.ai/telehealth/
 *
 * @author      Mohammed Awal Saeed <awalsaeed736@gmail.com@gmail.com>
 * @copyright   Copyright (c) 2022 MedSov <telehealth@lifemesh.ai>
 * @license     GNU General Public License 3
 *
 */

use OpenEMR\Modules\InpatientModule\AuthQuery;
use OpenEMR\Modules\InpatientModule\CSSDServiceQuery;


require_once "../../../../globals.php";
require_once "./components/sql/AuthQuery.php";
require_once "./components/sql/CSSDServiceQuery.php";

$authQuery = new AuthQuery();
$cssd = new CSSDServiceQuery();


$providers = $authQuery->getProviders();
$getCssd = $cssd->getCSSDService();
$getCssdItem = $cssd->getCSSDServiceItem();

$display_mesasge = 'none';
$message = '';
if (isset($_GET['status'])) {
    $message = $_GET['message'];
    $display_mesasge = 'block';
}


if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['search'])) {
    //$surgery = $surgeryQuery->searchVisitor($_POST['search']);
    // header('Refresh:0');

} elseif (isset($_POST['new_service_item']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $data = [
        'item_name' => $_POST['item_name'],
        'created_by' => $user['fname'],
    ];
    $cssd->insertCSSDServiceItem($data);
    header('location:CSSDServiceItem.php?status=success&message=CSSD Service Item Added Successfully');
} elseif (isset($_POST['service_id']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $data = [
        'id' => $_POST['service_id'],
        'item_name' => $_POST['item_name'],
        'updated_by' => $user['fname'],
    ];
    $cssd->updateCSSDServiceItem($data);
    header('location:CSSDServiceItem.php?status=success&message=CSSD Service Item Updated Successfully');
} elseif (isset($_POST['deleteId']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $cssd->destroyCSSDServiceItem($_POST['deleteId']);
    header('location:CSSDServiceItem.php?status=success&message=CSSD Service Item Deleted Successfully');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./assets/css/main.css">
    <title><?php echo xlt('CSSD Service Item') ?></title>

    <script src="https://code.jquery.com/jquery-3.6.2.js" integrity="sha256-pkn2CUZmheSeyssYw3vMp1+xyub4m+e+QK4sQskvuo4=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- <script src="https://code.jquery.com/jquery-3.6.2.js" integrity="sha256-pkn2CUZmheSeyssYw3vMp1+xyub4m+e+QK4sQskvuo4=" crossorigin="anonymous"></script> -->

</head>

<body class="container-fluid d-flex flex-column" style="padding-left: 30px; padding-right: 30px;">

    <section class="main-containerx" style="flex-direction: column;">
        <div class="left-con">

            <div class="search_container">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" style="display: flex;">
                    <input type="text" class="form-control" name="search" id="search" placeholder="search...">
                    <button type="submit" class="btn btn-primary" style="margin-left: 20px;"><?php echo xlt('Search') ?></button>
                </form>
            </div>

            <?php if ($display_mesasge == 'block') { ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert" id="alert">
                    <strong><?php echo xlt('Success') ?>!</strong> <?php echo $message; ?>
                    <!-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> -->
                </div>
            <?php } ?>


            <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                <h4 class="section-head"><?php echo xlt('CSSD Service Item') ?></h4>
                <button type="button" class="btn new_surgeryBtn" style="background-color: #40E0D0;" data-toggle="modal" data-target="#addModal">
                    <?php echo xlt('New Service Item') ?>
                </button>
            </div>


            <table>
                <tr>
                    <th><?php echo xlt('Service Name') ?></th>
                    <th><?php echo xlt('Actions') ?></th>
                </tr>

                <?php foreach ($getCssdItem as $item) {
                ?>
                    <tr>
                        <td><?php echo $item['item_name']; ?></td>
                        <td style="display: flex;">
                            <button type="button" class="btn btn-primary updateBtn" style="" data-toggle="modal" data-target="#cssdModal" data-id="<?php echo $item['id']; ?>" data-item_name="<?php echo $item['item_name']; ?>" data-updated_by="<?php echo $item['updated_by']; ?> ">
                                <?php echo xlt('Update') ?>
                            </button>

                            <button type="button " class="btn btn-danger deleteBtn" style="" data-toggle="modal" data-target="#deleteBedModal" data-id="<?php echo $item['id']; ?>">
                                <?php echo xlt('Delete') ?>
                            </button>

                        </td>

                    </tr>
                <?php
                } ?>
            </table>

        </div>

    </section>

    <!-- cssd item service-->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModal"><?php echo xlt('CSSD Service Item') ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method='POST' action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <input type="hidden" name="new_service_item" id="new_service_item" value="">

                        <div class="form-group">
                            <label for="formGroupExampleInput2"><?php echo xlt('Item Name') ?></label>
                            <input type="text" class="form-control" name="item_name">
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo xlt('Close') ?></button>
                            <button type="submit" class="btn btn-primary"><?php echo xlt('Save') ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- edit cssd item -->
    <div class="modal fade" id="cssdModal" tabindex="-1" aria-labelledby="cssdModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cssdModal"><?php echo xlt('Update CSSD Item Service') ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method='POST' action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <input type="hidden" id="id" name="service_id" value="">
                        <input type="hidden" id="updated_by" name="updated_by" value="">

                        <div class="form-group">
                            <label for="formGroupExampleInput2"><?php echo xlt('Item Name') ?></label>
                            <input type="text" class="form-control" name="item_name" id="item_name">
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo xlt('Close') ?></button>
                            <button type="submit" class="btn btn-primary"><?php echo xlt('Save') ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- delete -->
    <div class="modal fade" id="deleteBedModal" tabindex="-1" aria-labelledby="deleteBedModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteBedModal"><?php echo xlt('Confirm Delete') ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><?php echo xlt('Are you sure you want to delete bed?') ?></p>

                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <input type="hidden" name="deleteId" id="deleteId" value="">

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo xlt('Close') ?></button>
                            <button type="submit" class="btn btn-danger"><?php echo xlt('Delete') ?></button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>



    <script defer>
        window.onload = function() {
            $(".updateBtn").click(function() {
                var id = $(this).data('id');
                var item_name = $(this).data('item_name');
                var updated_by = $(this).data('updated_by');


                $('#id').val(id);
                $('#item_name').val(item_name);
                $('#updated_by').val(updated_by);

            });

            $(".deleteBtn").click(function() {
                var item_id = $(this).data('id');
                $('#deleteId').val(item_id);
            });

            // hide alert
            setTimeout(function() {
                $('#alert').hide();
            }, 3000);
        };
    </script>





    <?php include_once "./components/footer.php"; ?>