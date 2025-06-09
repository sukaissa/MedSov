##Inpatient Module Installation

1. Download and extract the module into the location /openemr/Installation/modules/custom_modules/
2. Headover to openemr
3. Modules -> Unregistered
4. Click on the register button next to Inpatient Module.
5. Heaver over to Registered.
6. Click Install
7. After installation, Click enable.
8. Log out and login again to see the changes

# edited files directory

- forms.php
  -- `interface/patient_file/encounter/forms.php`
  ``A button was introduced on the OpenEMR encounter page to admit patients during an encounter. The button references or calls another JS method called queuePatient () which calls a php file called admit_patient.php.
  The php file (admit_patient.php) adds the patient to admission_queue table and set the status to “In Queue”.

Fields include
Patient_id
Encounter_id
Ward_id
Bed_id
Opd_case_doctor_id
Assigned_nurse_id
Assigned_provider
Status
``

- admit_patient.php 'custom script to admit the patient'
  -- `interface/patient_file/encounter/admit_patient.php`
