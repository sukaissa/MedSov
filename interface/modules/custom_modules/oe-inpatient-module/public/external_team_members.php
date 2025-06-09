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

use OpenEMR\Modules\InpatientModule\SurgeryQuery;
use OpenEMR\Modules\InpatientModule\InpatientQuery;
use OpenEMR\Modules\InpatientModule\AuthQuery;
use OpenEMR\Modules\InpatientModule\ExternalTeamMembersQuery;

require_once "../../../../globals.php";
require_once "./components/sql/SurgeryQuery.php";
require_once "./components/sql/AuthQuery.php";
require_once "./components/sql/ExternalTeamMembersQuery.php";

$surgeryQuery = new SurgeryQuery();
$authQuery = new AuthQuery();
$externalTeamMemebersQuery = new ExternalTeamMembersQuery();

$surgery = $surgeryQuery->getSurgery();
$providers = $authQuery->getProviders();
$external = $externalTeamMemebersQuery->getExternalTeamMembers();

$display_mesasge = 'none';
$message = '';
if (isset($_GET['status'])) {
    $message = $_GET['message'];
    $display_mesasge = 'block';
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['search'])) {
    //$surgery = $surgeryQuery->searchVisitor($_POST['search']);
    // header('Refresh:0');

} elseif (isset($_POST['new_teamMember']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $data = [
        'title' => $_POST['title'],
        'first_name' => $_POST['first_name'],
        'middle_name' => $_POST['middle_name'],
        'last_name' => $_POST['last_name'],
        'date_of_birth' => $_POST['date_of_birth'],
        'gender' => $_POST['gender'],
        'occupation' => $_POST['occupation'],
        'affliated_institution' => $_POST['affliated_institution'],
        'email' => $_POST['email'],
        'created_by' => $_POST['created_by'],
    ];
    $externalTeamMemebersQuery->insertExternalTeamMembers($data);
    header('location:external_team_members.php?status=success&message=Member Addedd Successfully');
} elseif (isset($_POST['member_id']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $data = [
        'title' => $_POST['title'],
        'first_name' => $_POST['first_name'],
        'middle_name' => $_POST['middle_name'],
        'last_name' => $_POST['last_name'],
        'date_of_birth' => $_POST['date_of_birth'],
        'gender' => $_POST['gender'],
        'occupation' => $_POST['occupation'],
        'affliated_institution' => $_POST['affliated_institution'],
        'email' => $_POST['email'],
        'updated_by' => $user['fname'],
    ];
    $externalTeamMemebersQuery->updateExternalTeamMembers($data);
    header('location:external_team_members.php?status=success&message=Member Updated Successfully');
} elseif (isset($_POST['deleteId']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $externalTeamMemebersQuery->destroyExternalTeam($_POST['deleteId']);
    header('location:external_team_members.php?status=success&message=External Team Members Deleted Successfully');
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once(__DIR__ . "/include_files.php"); ?>
    <title><?php echo xlt('Success') ?>External Team Members</title>

</head>

<body class="container-fluid d-flex flex-column" style="padding-left: 30px; padding-right: 30px;">

    <section class="main-containerx" style="flex-direction: column;">
        <div class="left-con">

            <div class="search_container">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" style="display: flex;">
                    <input type="text" class="form-control" name="search" id="search" placeholder="search...">
                    <button type="submit" class="btn btn-primary" style="margin-left: 20px;"><?php echo xlt('Success') ?>Search</button>
                </form>
            </div>

            <?php if ($display_mesasge == 'block') { ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert" id="alert">
                    <strong><?php echo xlt('Success') ?>Success!</strong> <?php echo $message; ?>
                    <!-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> -->
                </div>
            <?php } ?>


            <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                <h4 class="section-head"><?php echo xlt('Success') ?> <?php echo xlt('Success') ?> External Team Members</h4>
                <!-- <button type="button" class="btn btn-primary"  data-toggle="modal" data-target="#addModal">
                    New Team Member
                </button> -->
            </div>


            <table>
                <tr>
                    <th> <?php echo xlt('Success') ?> Title</th>
                    <th> <?php echo xlt('Success') ?> Full Name</th>
                    <th> <?php echo xlt('Success') ?> DOB</th>
                    <th> <?php echo xlt('Success') ?> Gender</th>
                    <th> <?php echo xlt('Success') ?> occupation</th>
                    <th> <?php echo xlt('Success') ?> Affliated Institution</th>
                    <th> <?php echo xlt('Success') ?> Email</th>
                    <th></th>
                </tr>

                <?php foreach ($external as $value) {
                ?>
                    <tr>
                        <td><?php echo $value['title']; ?></td>
                        <td><?php echo $value['first_name']; ?> <?php echo $value['middle_name']; ?> <?php echo $value['last_name']; ?></td>
                        <td><?php echo $value['date_of_birth']; ?></td>
                        <td><?php echo $value['gender']; ?></td>
                        <td><?php echo $value['occupation']; ?></td>
                        <td><?php echo $value['affliated_institution']; ?></td>
                        <td><?php echo $value['email']; ?></td>
                        <td style="display: flex;">
                            <!-- <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post"> -->
                            <!-- <input type="hidden" name="id" value="<?php echo $value['memeber_id']; ?>"> -->
                            <button type="button" class="btn btn-primary externalTeam_updateBtn" style="" data-toggle="modal" data-target="#externalModal" data-member_id="<?php echo $value['member_id']; ?>" data-title="<?php echo $value['title']; ?>" data-first_name="<?php echo $value['first_name']; ?>" data-middle_name="<?php echo $value['middle_name']; ?>" data-last_name="<?php echo $value['last_name']; ?>" data-date_of_birth="<?php echo $value['date_of_birth']; ?>" data-gender="<?php echo $value['gender']; ?>" data-occupation="<?php echo $value['occupation']; ?>" data-affliated_institution="<?php echo $value['affliated_institution']; ?>" data-email="<?php echo $value['email']; ?>" data-updated_by="<?php echo $value['updated_by']; ?>">
                                <?php echo xlt('Success') ?> Update
                            </button>
                            <!-- </form> -->

                            <button type="button " class="btn btn-danger external_deleteBtn" style="" data-toggle="modal" data-target="#deleteExternalModal" data-member_id="<?php echo $value['member_id']; ?>">
                                <?php echo xlt('Success') ?> Delete
                            </button>

                        </td>

                        </td>

                    </tr>
                <?php
                } ?>
            </table>

        </div>

    </section>



    <!-- add team member-->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="wardModal"><?php echo xlt('Success') ?>Add Team Member</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method='POST' action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <input type="hidden" name="new_teamMember" id="new_teamMember" value="">
                        <input type="hidden" name="created_by" value="<?php echo $user['fname'] ?>">

                        <div class="form-group">
                            <label for="formGroupExampleInput2"><?php echo xlt('Success') ?>Title</label>
                            <select class="form-control" style="width: 100%;" name="title" id="title">
                                <option><?php echo xlt('Success') ?> Select Title</option>
                                <option value="Mr"><?php echo xlt('Success') ?> Mr</option>
                                <option value="Mrs"><?php echo xlt('Success') ?> Mrs</option>
                                <option value="Doc"><?php echo xlt('Success') ?> Doc</option>
                                <option value="Prof"><?php echo xlt('Success') ?> Prof</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="formGroupExampleInput2"><?php echo xlt('Success') ?>First Name</label>
                            <input type="text" class="form-control" name="first_name" id="first_name">
                        </div>

                        <div class="form-group">
                            <label for="formGroupExampleInput2"><?php echo xlt('Success') ?>Middle Name</label>
                            <input type="text" class="form-control" name="middle_name" id="middle_name">
                        </div>

                        <div class="form-group">
                            <label for="formGroupExampleInput2"><?php echo xlt('Success') ?>Last Name</label>
                            <input type="text" class="form-control" name="last_name" id="last_name">
                        </div>

                        <div class="form-group">
                            <label for="formGroupExampleInput2"><?php echo xlt('Success') ?>Email</label>
                            <input type="text" class="form-control" name="email" id="email">
                        </div>

                        <div class="form-group">
                            <label for="formGroupExampleInput2"><?php echo xlt('Success') ?>Date Of Birth</label>
                            <input type="date" class="form-control" name="date_of_birth" id="date_of_birth">
                        </div>

                        <div class="form-group">
                            <label for="formGroupExampleInput2"><?php echo xlt('Success') ?>Gender</label>
                            <select class="form-control" style="width: 100%;" name="gender" id="gender">
                                <option><?php echo xlt('Success') ?>Select Sex</option>
                                <option value="Male"><?php echo xlt('Success') ?>Male</option>
                                <option value="Female"><?php echo xlt('Success') ?>Female</option>
                                <option value="Transgender"><?php echo xlt('Success') ?>Transgender</option>
                                <option value="Dont Want to Say"><?php echo xlt('Success') ?>Dont Want to Say</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="formGroupExampleInput2"><?php echo xlt('Success') ?>Occupation</label>
                            <input type="text" class="form-control" name="occupation" id="occupation">
                        </div>

                        <div class="form-group">
                            <label for="formGroupExampleInput2"><?php echo xlt('Success') ?>Affliated Institution</label>
                            <input type="text" class="form-control" name="affliated_institution" id="affliated_institution">
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo xlt('Success') ?>Close</button>
                            <button type="submit" class="btn btn-primary"><?php echo xlt('Success') ?>Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- edit external -->
    <div class="modal fade" id="externalModal" tabindex="-1" aria-labelledby="externalModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="externalModal"><?php echo xlt('Success') ?>Edit Scheduled Surgeries</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method='POST' action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <input type="hidden" name="member_id" id="member_id" value="">

                        <div class="form-group">
                            <label for="formGroupExampleInput2"><?php echo xlt('Success') ?>Title</label>
                            <select class="form-control" style="width: 100%;" name="title" id="title">
                                <option value="Mr"><?php echo xlt('Success') ?>Mr</option>
                                <option value="Mrs"><?php echo xlt('Success') ?>Mrs</option>
                                <option value="Doc"><?php echo xlt('Success') ?>Doc</option>
                                <option value="Prof"><?php echo xlt('Success') ?>Prof</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="formGroupExampleInput2"> <?php echo xlt('Success') ?> First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name">
                        </div>

                        <div class="form-group">
                            <label for="formGroupExampleInput2"> <?php echo xlt('Success') ?> Middle Name</label>
                            <input type="text" class="form-control" id="middle_name" name="middle_name">
                        </div>

                        <div class="form-group">
                            <label for="formGroupExampleInput2"> <?php echo xlt('Success') ?> Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name">
                        </div>

                        <div class="form-group">
                            <label for="formGroupExampleInput2"> <?php echo xlt('Success') ?> Email</label>
                            <input type="text" class="form-control" id="email" name="email">
                        </div>

                        <div class="form-group">
                            <label for="formGroupExampleInput2"> <?php echo xlt('Success') ?> Date Of Birth</label>
                            <input type="date" class="form-control" id="date_of_birth" name="date_of_birth">
                        </div>

                        <div class="form-group">
                            <label for="formGroupExampleInput2"> <?php echo xlt('Success') ?> Gender</label>
                            <select class="form-control" style="width: 100%;" name="gender" id="gender">
                                <option value="Male"> <?php echo xlt('Success') ?> Male</option>
                                <option value="Female"> <?php echo xlt('Success') ?> Female</option>
                                <option value="Transgender"> <?php echo xlt('Success') ?> Transgender</option>
                                <option value="Dont Want to Say"> <?php echo xlt('Success') ?> Dont Want to Say</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="formGroupExampleInput2"> <?php echo xlt('Success') ?> Occupation</label>
                            <input type="text" class="form-control" id="occupation" name="occupation">
                        </div>

                        <div class="form-group">
                            <label for="formGroupExampleInput2"> <?php echo xlt('Success') ?> Affliated Institution</label>
                            <input type="text" class="form-control" id="affliated_institution" name="affliated_institution">
                        </div>



                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"> <?php echo xlt('Success') ?> Close</button>
                            <button type="submit" class="btn btn-primary"><?php echo xlt('Success') ?>Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <!-- delete external team members -->
    <div class="modal fade" id="deleteExternalModal" tabindex="-1" aria-labelledby="deleteExternalModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteExternalModal"><?php echo xlt('Success') ?>Confirm Delete</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><?php echo xlt('Success') ?>Are you sure you want to delete External Team Member?</p>

                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <input type="hidden" name="deleteId" id="deleteId" value="">

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo xlt('Success') ?>Close</button>
                            <button type="submit" class="btn btn-danger"><?php echo xlt('Success') ?>Delete</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>



    <script defer>
        window.onload = function() {
            $(".externalTeam_updateBtn").click(function() {
                var member_id = $(this).data('member_id');
                var title = $(this).data('title');
                var first_name = $(this).data('first_name');
                var middle_name = $(this).data('middle_name');
                var last_name = $(this).data('last_name');
                var date_of_birth = $(this).data('date_of_birth');
                var gender = $(this).data('gender');
                var occupation = $(this).data('occupation');
                var affliated_institution = $(this).data('affliated_institution');
                var email = $(this).data('email');

                $('#member_id').val(member_id);
                $('#title').val(title);
                $('#first_name').val(first_name);
                $('#middle_name').val(middle_name);
                $('#last_name').val(last_name);
                $('#date_of_birth').val(date_of_birth);
                $('#gender').val(gender);
                $('#occupation').val(occupation);
                $('#affliated_institution').val(affliated_institution);
                $('#email').val(email);

            });

            $(".external_deleteBtn").click(function() {
                var member_id = $(this).data('member_id');
                $('#deleteId').val(member_id);
            });


            // hide alert
            setTimeout(function() {
                $('#alert').hide();
            }, 3000);
        };
    </script>

    <?php include_once "./components/footer.php"; ?>