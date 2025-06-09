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


namespace OpenEMR\Modules\LifeMesh;

require_once dirname(__FILE__, 5) . "/globals.php";

use DateTime;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use OpenEMR\Common\Crypto\CryptoGen;
use MyMailer;

use OpenEMR\Common\Logging\EventAuditLogger;
use OpenEMR\Common\Uuid\UniqueInstallationUuid;
use OpenEMR\Services\FacilityService;

//require_once __DIR__ . '/send_email.php';


/**
 * Class AppDispatch
 * @package OpenEMR\Modules\LifeMesh
 */
class AppDispatch
{
    public $accountCheck;
    public $accountSummary;
    private $db;
    public $createSession;
    private $store;
    private $statusMessage;
    private $status;

    //facility
    private $facility;


    /**
     * AppDispatch constructor.
     */
    public function __construct()
    {
        $this->db = new Container();
        $this->store = $this->db->getDatabase();
        //$this->facility =new FacilityService();
    }

    /**
     * @param $username
     * @param $password
     * @param $url
     * @return string
     */
    public function apiRequest($username, $password, $url)
    {
        $data = base64_encode($username . ':' . $password);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->setUrl($url)); //dynamically set the url for the api request
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
        curl_setopt($curl, CURLOPT_ENCODING, '');
        curl_setopt($curl, CURLOPT_AUTOREFERER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 120);
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Authorization: Basic ' . $data]);

        $response = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
        $this->status = $status;
        curl_close($curl);

        if ($url == 'accountCheck') {
            if ($status === 200) {
                return true;
            } else {
                if ($status === 261) {
                    $statusMessage = "Please note your subscription is not active. You will not be able to schedule a Telehealth session or initiate the session from inside OpenEMR.";
                } else if ($status === 401) {
                    $statusMessage = "Please try again. Your user name or password is incorrect. You can contact Lifemesh at telehealth@lifemesh.ai for further support.";
                } else {
                    $statusMessage = "An error has occurred. Please contact Lifemesh at telehealth@lifemesh.ai for further support with a description to reproduce this error.";
                }
                $this->statusMessage = $statusMessage;
                return false;
            }
        }
        if ($url == 'accountSummary') {
            return $response;
        }
    }

    /**
     * @return mixed
     */
    public function getStatusMessage()
    {
        return $this->statusMessage;
    }

    /**
     * @param $status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param $username
     * @param $password
     * @param $url
     * @param $callid
     * @param $eventid
     * @param $eventdatetimeutc
     * @param $eventdatetimelocal
     * @param $patientfirstname
     * @param $patientlastname
     * @param $patientemail
     * @param $patientcell
     */
    public function apiRequestSession(
        $username,
        $password,
        $url,
        $callid,
        $eventid,
        $eventdatetimeutc,
        $eventdatetimelocal,
        $patientfirstname,
        $patientlastname,
        $patientemail,
        $patientcell
    )
    {

        $meetingid = rand(10,10000000000);
        $patient_code = rand(1, 10000000000);
        $patient_uri = "https://meet.jit.si/". $meetingid; //change for different jitsi instance
        $provider_code = rand(1, 10000000000);;
        $provider_uri = $patient_uri;
        $time = explode("T", $eventdatetimelocal);
        $event_status = 'Scheduled';
        $updatedAt = date("Y-m-d H:m:i");

        $this->store->saveSessionData(
            $eventid,
            $meetingid,
            $patient_code,
            $patient_uri,
            $provider_code,
            $provider_uri,
            $eventdatetimelocal,
            $time[1],
            $event_status,
            $updatedAt
        );
        //call the email function
       $patientFullName = $patientfirstname . ' ' . $patientlastname;
       $date = new DateTime($eventdatetimelocal);
       $eventdatetimelocal = $date->format('Y-m-d H:i');
        $this->sendEmail($patientemail,
            $patientFullName,
            $patient_uri,
            $patient_code,
            $eventdatetimelocal
        );

    }

    public function sendEmail($pt_email, $pt_name, $pat_uri, $pat_code, $date){
        $message = "<strong>" . xlt("Hello $pt_name, you have been scheduled ") . "</strong><br />";
        $message .= xlt("for a telemedicine appointment on $date.") . "<br />";
        $message .= xlt("When the appointment date and time is due, click on the link below") . "<br /><br />";
        $message .= xlt("meeting link: $pat_uri") . "<br />";
        $message .= xlt("meeting unique code: $pat_code") . "<br /><br />";
        $message .= xlt("Thank you for allowing us to serve you.") . "<br />";

        $mail = new MyMailer();
        $email_subject = xl('Telemedicine Encounter');
        $email_sender = $GLOBALS['patient_reminder_sender_email'];
        $mail->AddReplyTo($email_sender, $email_sender);
        $mail->SetFrom($email_sender, $email_sender);
        $mail->AddAddress($pt_email, $pt_name);
        $mail->Subject = $email_subject;
        $mail->MsgHTML("<html><body><div class='wrapper'>" . $message . "</div></body></html>");
        $mail->IsHTML(true);
        $mail->AltBody = $message;

        /* try{
            $mail->Send();
        }
        catch(\Exception $e){
            echo "Message could not be sent";
            echo "<pre>";
            echo "Mailer error: " . $mail->ErrorInfo;
        } */

        if ($mail->Send()) {
            return true;
        } else {
            $email_status = $mail->ErrorInfo;
            error_log("EMAIL ERROR: " . errorLogEscape($email_status), 0);
            return false;
        }
    }

    /* function sendEmailC($pt_email, $pt_name, $pat_uri, $pat_code, $date, $time){
        $email = $GLOBALS['patient_reminder_sender_email'];
        $user = $GLOBALS['SMTP_USER'];
        $cryptoGen = new CryptoGen();
        $password = $cryptoGen->decryptStandard($GLOBALS['SMTP_PASS']);
        $port =   $GLOBALS['SMTP_PORT'];
        $secure = $GLOBALS['SMTP_SECURE'];
        $host = $GLOBALS['SMTP_HOST'];

        $message = "<strong>" . xlt("Hello $pt_name, you have been scheduled ") . "</strong><br />";
        $message .= xlt("for a telemedicine appointment on $date, $time.") . "<br />";
        $message .= xlt("When the appointment date and time is due, click on the link below") . ":<br /><br />";
        $message .= xlt("meeting link: $pat_uri") . ":<br />";
        $message .= xlt("meeting unique code: $pat_code") . ":<br /><br />";
        $message .= xlt("Thank you for allowing us to serve you.") . ":<br />";

        $mail = new PHPMailer(true);

        try{
            $mail->SMTPDebug = false;
            $mail->isSMTP();
            $mail->IsHTML(true);
            $mail->Host = $host;
            $mail->SMTPAuth = true;
            $mail->Username = $user;
            $mail->Password = $password;
            $mail->SMTPSecure = $secure;
            $mail->Port = $port;

            $mail->setFrom($GLOBALS['patient_reminder_sender_email'], 'Billing Coordinator');
            $mail->addAddress($pt_email, $pt_name);
            $mail->Subject = 'Telemedicine Encounter ';
            $mail->Body = $message;
            $mail->send();
            die('Message Sent Successfully');
        }
        catch (\Exception $e)
        {
            echo "Message could not be sent";
            echo "<pre>";
            echo "Mailer error: " . $mail->ErrorInfo;
        }

    } */



    /**
     * @param $username
     * @param $password
     * @param $callerid
     * @param $eventdatetime
     * @param $eventlocaltime
     * @param $eventid
     * @param $url
     */
    public function rescheduleSession($username, $password, $callerid, $eventdatetime,$eventlocaltime, $eventid, $url)
    {
        /* $data = base64_encode($username . ':' . $password);
        $header = [
            'Authorization: Basic ' . $data,
            'Content-Type: application/json'
        ];
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->setUrl($url),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER         => true,
            CURLOPT_AUTOREFERER    => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 120,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                    "caller_id":"' . $callerid . '",
                    "appointment_id":"' . $eventid . '",
                    "new_appointment_datetime":"' . $eventdatetime . '",
                    "new_appointment_datetime_local":"' . $eventlocaltime . '"
                }',
            CURLOPT_HTTPHEADER => $header
        ));

        $response = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);

        if ($status != 200) {
            echo $response;
        }

        curl_close($curl); */

    }

    /**
     * @param $encryptedaccountinfo
     * @param $eventid
     * @param $callerid
     * @param $url
     * @return bool|string
     */
    public function cancelSession($encryptedaccountinfo, $eventid, $callerid, $url)
    {
       /*  $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->setUrl($url),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "caller_id":"' . $callerid . '",
                "appointment_id":"' . $eventid . '"
            }',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Basic ' . $encryptedaccountinfo,
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl); */

        $this->store->cancelSessionDatabase($eventid);

        return "Successfully Cancelled";
    }

    /**
     * @param $encryptedaccountinfo
     * @param $url
     * @return bool|string
     */
    public function resetPassword($encryptedaccountinfo, $url)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->setUrl($url),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => array(
                'Authorization: ' . $encryptedaccountinfo
            ),
        ));

        $response = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
        curl_close($curl);
        if ($status == 200) {
            return 'complete';
        } else {
            return $response;
        }
    }

    /**
     * @param $encryptedaccountinfo
     * @param $url
     * @return bool|string
     */
    public function cancelSubscription($encryptedaccountinfo, $url)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->setUrl($url),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Basic ' . $encryptedaccountinfo,
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
        curl_close($curl);
        if ($status == 200) {
            return $response;
        } else {
            return $status;
        }
    }

    public function getStripeUrl($url, $email)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->setUrl($url),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "user_email": "' . $email . '"
            }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }

    /**
     * @param $username
     * @param $password
     * @param $eventid
     */
    public function apiCheckPatientStatus($username, $password, $eventid)
    {
        $data = base64_encode($username . ':' . $password);
        $header = [
            'Authorization: Basic ' . $data,
            'Content-Type: application/json'
        ];
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->setUrl("checkPatientStatus"),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_AUTOREFERER    => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 120,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "caller_id":"' . UniqueInstallationUuid::getUniqueInstallationUuid() . '",
                "appointment_id":"' . $eventid . '"
            }',
            CURLOPT_HTTPHEADER => $header
        ));
        // For debug, can send following parameter to force a "true" (note it returns strings and not booleans) :
        //  "force_true_response":"true"

        $response = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
        curl_close($curl);

        if ($status == 200) {
            return json_decode($response, true);
        } else {
            return false;
        }

    }

    /**
     * @param $value
     * @return string|null
     * set URL values based on the call to action
     */
    private function setUrl($value)
    {
        switch ($value) {
            case "accountCheck":
                return 'https://api.telehealth.lifemesh.ai/account_check';

            case "accountSummary":
                return 'https://api.telehealth.lifemesh.ai/account_summary';

            case "createSession":
                return 'http://localhost:8080/api/v1/sendEmail';

            case "rescheduleSession":
                return 'https://api.telehealth.lifemesh.ai/reschedule_session';

            case "cancelSession":
                return 'https://api.telehealth.lifemesh.ai/cancel_session';

            case "resetPassword":
                return "https://api.telehealth.lifemesh.ai/reset_password";

            case "cancelSubscription":
                return "https://api.telehealth.lifemesh.ai/cancel_subscription";

            case "createCheckoutSessionUrl":
                return "https://api.telehealth.lifemesh.ai/create_checkout_session_url";

            case "checkPatientStatus":
                return "https://api.telehealth.lifemesh.ai/check_session_patient_status";

            default:
                return NULL;
        }
    }
}
