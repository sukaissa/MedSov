<?php

/*
 *
 * @package     OpenEMR Telehealth Module
 * @link        https://lifemesh.ai/telehealth/
 *
 * @author      Sherwin Gaddis <sherwingaddis@gmail.com>
 * @copyright   Copyright (c) 2021 Lifemesh Corp <telehealth@lifemesh.ai>
 * @license     GNU General Public License 3
 *
 */

if (empty($_SESSION['pid'])) {
    echo json_encode(['error' => 'No Patient Found']);
    exit;
}

$patientService = new \OpenEMR\Services\PatientService();
$patient = $patientService->findByPid($_SESSION['pid']);

if (empty($patient)) {
    echo json_encode(['error' => 'No Patient Found']);
    exit;
}

unset($patient['uuid']);
echo json_encode($patient);
exit;
