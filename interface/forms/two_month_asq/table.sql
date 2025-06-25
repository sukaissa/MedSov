-- Table for storing ASQ-3: 2-Month Questionnaire responses
CREATE TABLE IF NOT EXISTS `form_asq_2_month` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    -- Baby’s Information
    baby_first_name VARCHAR(100),
    baby_middle_initial CHAR(1),
    baby_last_name VARCHAR(100),
    baby_dob DATE,
    baby_premature_weeks INT,
    baby_gender VARCHAR(10),
    -- Person Filling Out Questionnaire
    pf_first_name VARCHAR(100),
    pf_middle_initial CHAR(1),
    pf_last_name VARCHAR(100),
    pf_street_address VARCHAR(255),
    pf_country VARCHAR(100),
    pf_city VARCHAR(100),
    pf_state_province VARCHAR(100),
    pf_zip_postal VARCHAR(20),
    pf_home_phone VARCHAR(30),
    pf_other_phone VARCHAR(30),
    pf_email VARCHAR(100),
    pf_relationship VARCHAR(50),
    pf_relationship_other VARCHAR(100),
    pf_assisting_name_1 VARCHAR(100),
    pf_assisting_name_2 VARCHAR(100),
    -- Program Information
    program_baby_id VARCHAR(30),
    program_id VARCHAR(30),
    program_name VARCHAR(100),
    program_age_admin_months INT,
    program_age_admin_days INT,
    program_adj_age_months INT,
    program_adj_age_days INT,
    -- Communication
    comm_1 VARCHAR(20), comm_2 VARCHAR(20), comm_3 VARCHAR(20), comm_4 VARCHAR(20), comm_5 VARCHAR(20), comm_6 VARCHAR(20), comm_total VARCHAR(10),
    -- Gross Motor
    gross_1 VARCHAR(20), gross_2 VARCHAR(20), gross_3 VARCHAR(20), gross_4 VARCHAR(20), gross_5 VARCHAR(20), gross_6 VARCHAR(20), gross_total VARCHAR(10),
    -- Fine Motor
    fine_1 VARCHAR(20), fine_2 VARCHAR(20), fine_3 VARCHAR(20), fine_4 VARCHAR(20), fine_5 VARCHAR(20), fine_6 VARCHAR(20), fine_total VARCHAR(10),
    -- Problem Solving
    ps_1 VARCHAR(20), ps_2 VARCHAR(20), ps_3 VARCHAR(20), ps_4 VARCHAR(20), ps_5 VARCHAR(20), ps_6 VARCHAR(20), ps_total VARCHAR(10),
    -- Personal-Social
    psoc_1 VARCHAR(20), psoc_2 VARCHAR(20), psoc_3 VARCHAR(20), psoc_4 VARCHAR(20), psoc_5 VARCHAR(20), psoc_6 VARCHAR(20), psoc_total VARCHAR(10),
    -- Overall
    overall_1 VARCHAR(20), overall_1_comment TEXT,
    overall_2 VARCHAR(20), overall_2_comment TEXT,
    overall_3 VARCHAR(20), overall_3_comment TEXT,
    overall_4 VARCHAR(20), overall_4_comment TEXT,
    overall_5 VARCHAR(20), overall_5_comment TEXT,
    overall_6 VARCHAR(20), overall_6_comment TEXT,
    -- Parent/Caregiver Info
    caregiver_child_name VARCHAR(100),
    caregiver_child_dob DATE,
    caregiver_completed_by VARCHAR(100),
    caregiver_relationship VARCHAR(100),
    caregiver_date_completed DATE
) ENGINE=InnoDB;
