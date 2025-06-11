
CREATE TABLE IF NOT EXISTS `inp_ward` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `short_name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (id)
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `inp_beds` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `number` varchar(100) NOT NULL,
  `bed_type` varchar(100) NOT NULL,
  `ward_id` bigint(20) NOT NULL,
  `price_per_day` varchar(100) NOT NULL,
  `availability` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (id)
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `inp_bed_records` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `bed_id` bigint(20) NOT NULL, 
  `admission_id` varchar(255) NOT NULL,
  `ward_id` bigint(20) NOT NULL,
  `start_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `end_date` timestamp,
  PRIMARY KEY (id)
) ENGINE = InnoDB;


CREATE TABLE IF NOT EXISTS `inp_patient_ward_transfer` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `admission_id` varchar(255) NOT NULL,
  `patient_id` varchar(255) NOT NULL,
  `transfer_date` date,
  `ward_id` int(11) NOT NULL,
  `old_ward` int(11) NOT NULL,
  `bed_id` int(11) NOT NULL,
  `old_bed` int(11) NOT NULL,
  `days` int(11),
  `ward_staff_id` varchar(100),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (id)
) ENGINE = InnoDB;


CREATE TABLE IF NOT EXISTS `inp_patient_admission` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `patient_id` varchar(255) NOT NULL,
  `encounter_id` varchar(255) NOT NULL,
  `opd_case_doctor_id` varchar(100) DEFAULT NULL,
  `assigned_nurse_id` varchar(100) DEFAULT NULL,
  `assigned_provider` varchar(100) DEFAULT NULL,
  `admission_type` varchar(100) DEFAULT NULL,
  `ward_staff_id` varchar(100) DEFAULT NULL,
  `ward_id` bigint(20),
  `bed_id` bigint(20),
  `status` varchar(100) DEFAULT NULL,
  `admission_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `discharge_date` timestamp,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (id)
) ENGINE = InnoDB;


CREATE TABLE IF NOT EXISTS `inp_inpatient_vitals` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `admission_id` varchar(255) NOT NULL,
  `patient_id` varchar(255) NOT NULL,
  `blood_pressure` varchar(100) NOT NULL,
  `pulse` varchar(100) NOT NULL,
  `temperature` varchar(100) NOT NULL,
  `respiratory_rate` varchar(100) NOT NULL,
  `spo_2` varchar(100) NOT NULL,
  `height` varchar(100) NOT NULL,
  `weight` varchar(100) NOT NULL,
  `fluid_input` varchar(100) NOT NULL,
  `fluid_output` varchar(100) NOT NULL,
  `staff_id` bigint(20) NOT NULL,
  `time_taken` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (id)
) ENGINE = InnoDB;


CREATE TABLE IF NOT EXISTS `inp_inpatient_nurses_note` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `admission_id` varchar(255) NOT NULL,
  `patient_id` varchar(255) NOT NULL,
  `time_taken` timestamp NOT NULL DEFAULT current_timestamp(),
  `note` text NOT NULL,
  `staff_id` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (id)
) ENGINE = InnoDB;


CREATE TABLE IF NOT EXISTS `inp_bills` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `patient_id` varchar(255) NOT NULL,
  `bed_id` varchar(100) NOT NULL,
  `ward_id` varchar(100) NOT NULL,
  `days_spent` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (id)
) ENGINE = InnoDB;


CREATE TABLE IF NOT EXISTS `inp_food_request` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `food_id` int(50) NOT NULL,
  `patient_id` varchar(255) NOT NULL,
  `staff_id` varchar(100) NOT NULL,
  `admission_id` varchar(255) NOT NULL,
  `status` varchar(100),
  `requested_date` varchar(100) NOT NULL,
  `delivery_date` varchar(100),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (id)
) ENGINE = InnoDB;


CREATE TABLE IF NOT EXISTS `inp_food_item` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `price` varchar(100) NOT NULL,
  `category` varchar(100) NOT NULL,
  `availability` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (id)
) ENGINE = InnoDB;


CREATE TABLE IF NOT EXISTS `inp_treatment_plan` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `admission_id` varchar(255) NOT NULL,
  `patient_id` varchar(255) NOT NULL,
  `type` varchar(100) NOT NULL,
  `title` varchar(100),
  `uuid` binary(16),
  `instructions` varchar(255),
  `action_start_time` varchar(40),
  `action_end_time` varchar(40),
  `time_interval` varchar(40) NOT NULL,
  `staff_id` varchar(10) NOT NULL,
  `status` varchar(10) DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (id)
) ENGINE = InnoDB;


CREATE TABLE IF NOT EXISTS `inp_treatment_plan_tracker` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `admission_id` varchar(255) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `action_time` varchar(100),
  `staff_id` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (id)
) ENGINE = InnoDB;


CREATE TABLE IF NOT EXISTS `inp_visits` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `patient_id` varchar(255) NOT NULL,
  `visitor_name` varchar(100) NOT NULL,
  `relationship_with_patient` varchar(100),
  `time_in` varchar(100),
  `time_out` varchar(100),
  `comment` varchar(100),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (id)
) ENGINE = InnoDB;


CREATE TABLE IF NOT EXISTS `inp_requested_services` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `patient_id` varchar(255) NOT NULL,
  `admission_id` varchar(255) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `quantity` varchar(100) NOT NULL,
  `price` varchar(100) NOT NULL,
  `staff_id` varchar(100) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (id)
) ENGINE = InnoDB;


CREATE TABLE IF NOT EXISTS `inp_theater` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `theater_name` varchar(255) NOT NULL,
  `status` varchar(255),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (id)
) ENGINE = InnoDB;


CREATE TABLE IF NOT EXISTS `inp_surgery` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `patient_id` varchar(255) NOT NULL,
  `procedure_id` bigint(20),
  `theater_id` bigint(20),
  `admission_id` varchar(255) NOT NULL,
  `start_date` varchar(225),
  `end_date` varchar(225),
  `status` varchar(225),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` varchar(255) NOT NULL,
  `updated_at` timestamp NOT NULL,
  `updated_by` varchar(255) NOT NULL,
  PRIMARY KEY (id)
) ENGINE = InnoDB;


CREATE TABLE IF NOT EXISTS `inp_surgical_team` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `surgery_id` bigint(20) NOT NULL,
  `admission_id` varchar(255) NOT NULL,
  `employee_id` bigint(20),
  `role` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` varchar(255),
  `updated_at` timestamp,
  `updated_by` varchar(255),
  PRIMARY KEY (id)
) ENGINE = InnoDB;


CREATE TABLE IF NOT EXISTS `inp_external_surgical_team` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `surgery_id` bigint(20) NOT NULL,
  `admission_id` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` varchar(255),
  `updated_at` timestamp,
  `updated_by` varchar(255),
  PRIMARY KEY (id)
) ENGINE = InnoDB;


CREATE TABLE IF NOT EXISTS `inp_procedure` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `procedure_name` varchar(255) NOT NULL,
  `insurance_status` varchar(255) NOT NULL,
  `price` varchar(255),
  `g_drg_code` varchar(255),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp DEFAULT current_timestamp(),
  PRIMARY KEY (id)
) ENGINE = InnoDB;


CREATE TABLE IF NOT EXISTS `inp_cssd_service` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `service_name` varchar(255) NOT NULL,
  `supervisor` varchar(255) NOT NULL,
  `availability_status` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` varchar(255) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_by` varchar(255) NOT NULL,
  PRIMARY KEY (id)
) ENGINE = InnoDB;


CREATE TABLE IF NOT EXISTS `inp_cssd_service_item` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `item_name` varchar(100),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` varchar(255),
  `updated_at` timestamp,
  `updated_by` varchar(255),
  PRIMARY KEY (id)
) ENGINE = InnoDB;


CREATE TABLE IF NOT EXISTS `inp_cssd_service_request` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `service_id` bigint(20) NOT NULL,
  `item_id` bigint(20) NOT NULL,
  `surgery_id` bigint(20),
  `department_id` bigint(20),
  `quantity` bigint(20) NOT NULL,
  `request_date` timestamp,
  `request_by` varchar(255),
  `status` varchar(255),
  `request_processed_date` varchar(255),
  `request_processed_by` varchar(255),
  `quantity_returned` bigint(20),
  `receipt_date` varchar(255),
  `received_by` varchar(255),
  `created_at` timestamp DEFAULT current_timestamp(),
  `created_by` varchar(255),
  `updated_at` timestamp DEFAULT current_timestamp(),
  `updated_by` varchar(255),
  PRIMARY KEY (id)
) ENGINE = InnoDB;


CREATE TABLE IF NOT EXISTS `inp_department` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `short_name` varchar(255),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (id)
) ENGINE = InnoDB;


CREATE TABLE IF NOT EXISTS `inp_item` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (id)
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `form_predischarge` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `pid` bigint(20) NOT NULL, -- Links to the patient_data table
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, -- Form creation timestamp
  `created_by` varchar(255) NOT NULL, -- User who created the form
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `form_predischarge_items` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `form_id` bigint(20) NOT NULL, -- Links to the form_predischarge table
  `list_option_id` varchar(100) NOT NULL, -- Links to the list_options table (pre_discharge_items)
  `list_option_value` boolean NOT NULL DEFAULT 0, -- Whether the checklist item is completed
  `notes` text, -- Additional notes for the checklist item
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, -- Item creation timestamp
  `created_by` varchar(255) NOT NULL, -- User who created the item
  PRIMARY KEY (`id`),
  FOREIGN KEY (`form_id`) REFERENCES `form_predischarge`(`id`) ON DELETE CASCADE,
) ENGINE=InnoDB;

INSERT INTO `inp_ward` (`name`, `short_name`) VALUES  ( 'Pediatrics Ward', 'PW');
INSERT INTO `inp_ward` (`name`, `short_name`) VALUES ( 'Maternity Ward', 'MW');
INSERT INTO `inp_ward` (`name`, `short_name`) VALUES ( 'Male Medical', 'MM');
INSERT INTO `inp_ward` (`name`, `short_name`) VALUES ( 'Male Surgical', 'MS');
INSERT INTO `inp_ward` (`name`, `short_name`) VALUES ( 'Male Emergency', 'ME');
INSERT INTO `inp_ward` (`name`, `short_name`) VALUES ( 'Female Medical', 'FM');
INSERT INTO `inp_ward` (`name`, `short_name`) VALUES ( 'Female Surgical', 'FS');
INSERT INTO `inp_ward` (`name`, `short_name`) VALUES ( 'Female Emergency', 'FE');
INSERT INTO `inp_ward` (`name`, `short_name`) VALUES ( 'Emergency Room', 'ER');
INSERT INTO `inp_ward` (`name`, `short_name`) VALUES ( 'Intensive Care', 'IC');

#IfNotRow openemr_postcalendar_categories pc_constant_id surgical_appointment
INSERT INTO `openemr_postcalendar_categories` ( `pc_constant_id`, `pc_catname`, `pc_catcolor`, `pc_catdesc`, `pc_recurrspec`, `pc_active`, `aco_spec`, `pc_seq`, `pc_duration`, `pc_cattype`) 
VALUES ('surgical_appointment', 'Surgical Appointment', '#a2d9e2', 'Surgical Appointment', 'a:5:{s:17:"event_repeat_freq";s:1:"0";s:22:"event_repeat_freq_type";s:1:"0";s:19:"event_repeat_on_num";s:1:"1";s:19:"event_repeat_on_day";s:1:"0";s:20:"event_repeat_on_freq";s:1:"0";}', 1, 'encounters|notes', 20, 1800, 0);
#EndIf

#IfNotRow2D list_options list_id lists option_id pre_discharge_items
    INSERT INTO `list_options` (`list_id`, `option_id`, `title`) 
    VALUES ('lists', 'pre_discharge_items', 'Pre-Discharge Items');
#EndIf

#IfNotRow2Dx2 list_options list_id pre_discharge_items option_id discharge_summary title Discharge Summary
    INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`) 
    VALUES 
    ('pre_discharge_items', 'discharge_summary', 'Discharge Summary', 10, 0),
    ('pre_discharge_items', 'medication_review', 'Medication Review', 20, 0),
    ('pre_discharge_items', 'follow_up_plan', 'Follow-Up Plan', 30, 0),
    ('pre_discharge_items', 'patient_education', 'Patient Education', 40, 0);
#EndIf


-- ALTER TABLE inp_patient_admission
-- ADD COLUMN admission_type varchar(100) DEFAULT NULL;
