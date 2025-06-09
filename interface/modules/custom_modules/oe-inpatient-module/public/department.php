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
use OpenEMR\Modules\InpatientModule\DepartmentQuery;

require_once "../../../../globals.php";
require_once "./components/sql/AuthQuery.php";
require_once "./components/sql/DepartmentQuery.php";

$authQuery = new AuthQuery();
$department = new DepartmentQuery();

$providers = $authQuery->getProviders();
$getdepartment = $department->getDepartment();

$display_mesasge = 'none';
$message = '';
if (isset($_GET['status'])) {
    $message = $_GET['message'];
    $display_mesasge = 'block';
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['search'])) {
    //$surgery = $surgeryQuery->searchVisitor($_POST['search']);
    // header('Refresh:0');

} elseif (isset($_POST['new_department']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $data = [
        'department_name' => $_POST['department_name'],
        'created_by' => $user['fname'],
    ];
    $department->insertDepartment($data);
    header('location:department.php?status=success&message=Department Added Successfully');
} elseif (isset($_POST['department_id']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $data = [
        'department_name' => $_POST['department_name'],
        'updated_by' => $user['fname'],
    ];

    $department->updateDepartment($data);
    header('location:department.php?status=success&message=Department Updated Successfully');
} elseif (isset($_POST['deleteId']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $department->destroyDepartment($_POST['deleteId']);
    header('location:department.php?status=success&message=Department Deleted Successfully');
    // header('Refresh:0');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once(__DIR__ . "/include_files.php"); ?>
    
    <title>Department</title>
</head>

<body class="container-fluid d-flex flex-column" style="padding-left: 30px; padding-right: 30px;">

    <section class="main-containerx" style="flex-direction: column;">
        <div class="left-con">

            <div class="search_container">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" style="display: flex;">
                    <input type="text" class="form-control" name="search" id="search" placeholder="search...">
                    <button type="submit" class="btn btn-primary" style="margin-left: 20px;">Search</button>
                </form>
            </div>

            <?php if ($display_mesasge == 'block') { ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert" id="alert">
                    <strong>Success!</strong> <?php echo $message; ?>
                    <!-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> -->
                </div>
            <?php } ?>


            <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                <h4 class="section-head">Department</h4>
                <button type="button" class="btn new_surgeryBtn" style="background-color: #40E0D0;" data-toggle="modal" data-target="#addModal">
                    New Department
                </button>
            </div>


            <table>
                <tr>
                    <th>Department Name</th>
                    <th>Actions</th>
                </tr>

                <?php foreach ($getdepartment as $data) {
                ?>
                    <tr>
                        <td><?php echo $data['department_name']; ?></td>

                        <td style="display: flex;">
                            <button type="button" class=" updateBtn btn btn-primary" style="" data-toggle="modal" data-target="#cssdModal" data-department_id="<?php echo $data['department_id']; ?>" data-department_name="<?php echo $data['department_name']; ?>" data-updated_by="<?php echo $data['updated_by']; ?>">
                                Update
                            </button>

                            <button type="button " class=" deleteBtn btn btn-danger" style="" data-toggle="modal" data-target="#deleteBedModal" data-department_id="<?php echo $data['department_id']; ?>">
                                Delete
                            </button>

                        </td>

                    </tr>
                <?php
                } ?>
            </table>

        </div>

    </section>

    <!-- cssd service-->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="wardModal">Department</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method='POST' action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <input type="hidden" name="new_department" id="new_department" value="">

                        <div class="form-group">
                            <label for="formGroupExampleInput2">Department Name</label>
                            <input type="text" class="form-control" name="department_name" id="department_name">
                        </div>


                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- edit cssd -->
    <div class="modal fade" id="cssdModal" tabindex="-1" aria-labelledby="cssdModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cssdModal">Update CSSD Service</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method='POST' action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <input type="hidden" id="department_id" name="department_id" value="">

                        <div class="form-group">
                            <label for="formGroupExampleInput2">Department Name</label>
                            <input type="text" class="form-control" id="department_name_name" name="department_name">
                        </div>

                        <input type="" id="updated_by_" name="updated_by" value="<?php echo $user['fname'] ?>">




                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
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
                    <h5 class="modal-title" id="deleteBedModal">Confirm Delete</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete Department?</p>

                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <input type="hidden" name="deleteId" id="deleteId" value="">

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>



    <script defer>
        window.onload = function() {
            $(".updateBtn").click(function() {
                var department_id = $(this).data('department_id');
                var department_name = $(this).data('department_name');
                var updated_by = $(this).data('updated_by');


                $('#department_id').val(department_id);
                $('#department_name_name').val(department_name);
                $('#updated_by_by').val(updated_by);


            });

            $(".deleteBtn").click(function() {
                var department_id = $(this).data('department_id');
                $('#deleteId').val(department_id);
            });

            // hide alert
            setTimeout(function() {
                $('#alert').hide();
            }, 3000);
        };
    </script>





    <?php include_once "./components/footer.php"; ?>