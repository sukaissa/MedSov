<?php

/*
 *
 * @package     OpenEMR Inpatient Module
 * @link        https://omegasystemsgroup.com
 *
 * @author       <kkappiah@medsov.com>
 * @copyright   Copyright (c) 2023 Omega Systems Group <telehealth@lifemesh.ai>
 * @license     GNU General Public License 3
 *
 */

require_once "../../../globals.php";

use OpenEMR\Common\Acl\AclMain;
use OpenEMR\Core\Header;

if (!AclMain::aclCheckCore('admin', 'manage_modules')) {
    echo xlt('Not Authorized');
    exit;
}

?>
<!DOCTYPE html>
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<head style="text-align: center;">
    <?php Header::setupHeader(); ?>
    <meta charset="utf-8" />
    <title>Telehealth Service</title>
    <style>
        .btnlogin {
            background: #C24511;
            border-radius: 10px;
            font-family: 'Roboto', Arial;
            color: #ffffff;
            font-size: 18px;
            text-decoration: none;

            border: none;
            padding: 10px;
            margin: 15px 2px;
        }

        .btnlogin:hover {
            background: #A93D0F;
            text-decoration: none;
        }

        .btnsubscribe {
            background: #C24511;
            border-radius: 10px;
            font-family: 'Roboto', Arial;
            color: #ffffff;
            font-size: 18px;
            text-decoration: none;

            border: none;
            padding: 10px;
            margin: 4px 2px;
        }

        .btnsubscribe:hover {
            background: #A93D0F;
            text-decoration: none;
        }

        #login {
            width: 300px;
        }

        #subscribe {
            width: 300px;
        }

        .container {
            text-align: center;
            padding-top: 20px;
        }

        .page-content {
            padding-left: 50px;
            padding-right: 50px;
            padding-bottom: 50px;
            /* padding-top: 100px; */
            background: white;
            border-radius: 15px;
            width: 300px;
            text-align: center;
            display: inline-table;

            box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
        }

        .label_soft {
            font-family: 'Roboto', Arial;
            color: darkgrey;
            font-size: 14px;
        }

        input[type=email] {
            width:100%;
            border:2px solid #aaa;
            border-radius:10px;
            margin:8px 0;
            outline:none;
            padding:8px;
            box-sizing:border-box;
            transition:.3s;
        }


    </style>
</head>
<body style="background-color: lightgray">

<div class="container">
    <div class="page-content">
        <div class="text-center">
            Inpatient Module Installed!
        </div>
    </div>
</div>
</body>
<script>

</script>
</html>

