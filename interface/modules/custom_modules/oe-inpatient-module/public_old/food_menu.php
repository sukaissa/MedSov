<?php

/*
 *
 * @package     OpenEMR Inpatient Module
 * @link        https://lifemesh.ai/telehealth/
 *
 * @author      Stanley kwamina Otabil <stanleyotabil10@gmail.com@gmail.com>
 * @copyright   Copyright (c) 2022 MedSov <telehealth@lifemesh.ai>
 * @license     GNU General Public License 3
 *
 */

use OpenEMR\Modules\InpatientModule\FoodQuery;

require_once "../../../../globals.php";
require_once "./components/sql/FoodQuery.php";

$foodQuery = new FoodQuery();
$menuItems = $foodQuery->getMenuItems();

if (isset($_POST['new']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $data = [
        'name' => $_POST['name'],
        'category' => $_POST['category'],
        'price' => $_POST['price'],
    ];
    $foodQuery->insertFoodItem($data);
    header('Refresh:0');
} elseif (isset($_POST['id']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $data = [
        'id' => $_POST['id'],
        'name' => $_POST['name'],
        'category' => $_POST['category'],
        'price' => $_POST['price'],
        'availability' => $_POST['availability'],
    ];
    $foodQuery->updateFoodItem($data);
    header('Refresh:0');
} elseif (isset($_POST['deleteId']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $foodQuery->destroyFoodItem($_POST['deleteId']);
    header('Refresh:0');
} elseif (isset($_POST['search']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $search = $_POST['search'];
    $admissionsQueue = $admissionQueuQuery->searchAdmissionQueue($search);
    header('Refresh:0');
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
    <title><?php echo xlt("Inpatient - Meal Menu") ?></title>

    <script src="https://code.jquery.com/jquery-3.6.2.js" integrity="sha256-pkn2CUZmheSeyssYw3vMp1+xyub4m+e+QK4sQskvuo4=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>

<body class="container-fluid d-flex flex-column" style="padding-left: 30px; padding-right: 30px;">
    <div style="margin-top: 25px;">
        <a href="./inpatient.php"><?php echo xlt("Back") ?></a>
        <p></p>
    </div>

    <div style="display: flex; justify-content: space-between; margin-bottom: 12px; margin-top: 50px;">
        <h4 class="section-head"><?php echo xlt(" Meal Menu") ?></h4>
        <button type="button" class="btn" style="background-color: #40E0D0;" data-toggle="modal" data-target="#newFoodItem">
            <?php echo xlt("New Meal") ?>
        </button>
    </div>

    <table>
        <thead>
            <tr>
                <th scope="col"> <?php echo xlt("No") ?> </th>
                <th scope="col"> <?php echo xlt("Item Name") ?> </th>
                <th scope="col"> <?php echo xlt("Meal Types") ?> </th>
                <th scope="col"> <?php echo xlt("Price") ?> </th>
                <th scope="col"> <?php echo xlt("Availability") ?> </th>
                <th scope="col"> <?php echo xlt("Action") ?> </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($menuItems as $key => $value) { ?>
                <tr>
                    <td><?php echo $key + 1; ?></td>
                    <td><?php echo $value['name']; ?></td>
                    <td><?php echo $value['category']; ?></td>
                    <td><?php echo $value['price']; ?></td>
                    <td><?php echo $value['availability']; ?></td>
                    <td>
                        <a href="#" class="btn btn-primary updateBtn" data-toggle="modal" data-target="#updateItem" data-id="<?php echo $value['id']; ?>" data-name="<?php echo $value['name']; ?>" data-availability="<?php echo $value['availability']; ?>" data-price="<?php echo $value['price']; ?>" data-category="<?php echo $value['category']; ?>"> <?php echo xlt("Edit") ?> </a>
                        <a href="#" class="btn btn-danger deleteBtn" data-toggle="modal" data-target="#itemDelete" data-id="<?php echo $value['id']; ?>"> <?php echo xlt("Delete") ?> </a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <?php include_once "./components/modals/food/menu_new.php"; ?>
    <?php include_once "./components/modals/food/menu_update.php"; ?>
    <?php include_once "./components/modals/food/menu_delete.php"; ?>

    <script defer>
        window.onload = function() {
            $(".updateBtn").click(function() {
                var id = $(this).data('id');
                var name = $(this).data('name');
                var category = $(this).data('category');
                var price = $(this).data('price');
                var availability = $(this).data('availability');

                $('input[name=id]').val(id);
                $('input[name=name]').val(name);
                $('input[name=price]').val(price);
                $('select[name=category]').val(category);
                $('select[name=availability]').val(availability);
            });

            $(".deleteBtn").click(function() {
                var id = $(this).data('id');
                $('#deleteId').val(id);
            });
        };
    </script>
    <?php include_once "./components/footer.php"; ?>