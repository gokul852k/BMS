<?php

require_once '../../config.php';
require_once '../Models/ConductorModel.php';
require_once '../Services/FileUpload.php';
require_once '../../../Common/Services/Mail2.php';

class ConductorService
{

    private $modelBMS;

    private $modelA;
    private $mail;

    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        global $bmsDB;
        global $authenticationDB;
        $this->modelBMS = new ConductorModel($bmsDB);
        $this->modelA = new ConductorModel($authenticationDB);
        $this->mail = new Mail2();
    }

    public function createConductor($conductorImage, $name, $mobile, $mail, $password, $address, $state, $district, $pincode, $language, $aadharCard, $aadharNo, $panCard, $panNo)
    {

        //Check mail ID is already exit
        $response1 = $this->modelA->getMailID($mail);

        if ($response1) {
            return [
                'status' => 'mail error',
                'message' => 'The email address you provided is already associated with a registered conductor in our system. Please try registering with a different email address.'
            ];
        }

        $uploadService = new FileUpload();

        //Upload Conductor Image

        $conductorImage_dir = "../../Assets/User/Conductor image/";

        $conductorImage_filename = $uploadService->uploadFile($conductorImage, $conductorImage_dir);

        $conductorImage_path = $conductorImage_filename['status'] === 'success' ? 'Conductor image/' . $conductorImage_filename['fileName'] : '';

        //Upload Aadhar Card

        $aadharCard_dir = "../../Assets/User/Conductor aadharcard/";

        $aadharCard_filename = $uploadService->uploadFile($aadharCard, $aadharCard_dir);

        $aadharCard_path = $aadharCard_filename['status'] === 'success' ? 'Conductor aadharcard/' . $aadharCard_filename['fileName'] : '';

        //Upload PAN Card

        $panCard_dir = "../../Assets/User/Conductor pancard/";

        $panCard_filename = $uploadService->uploadFile($panCard, $panCard_dir);

        $panCard_path = $panCard_filename['status'] === 'success' ? 'Conductor pancard/' . $panCard_filename['fileName'] : '';

        //Password Hasing

        $hashPassword = password_hash($password, PASSWORD_DEFAULT);

        //Insert username & password in users table in authentication DB

        $response2 = $this->modelA->setConductorInUsers($mail, $hashPassword, $_SESSION['companyId']);

        if (!$response2) {
            return [
                'status' => 'error',
                'message' => 'Something went wrong while creating the conductor',
                'error' => 'Error while insert data in users table.'
            ];
        }

        $userId = $response2['userId'];

        $responseRole = $this->modelA->setConductorInUserRole($userId, 4, 2);

        if (!$responseRole) {
            //Delete the user from users table
            $this->modelBMS->deleteUser($userId);
            return [
                'status' => 'error',
                'message' => 'Something went wrong while creating the conductor',
                'error' => 'Error while insert data in users table.'
            ];
        }

        //Insert Conductor details in conductors table in bms DB

        $response3 = $this->modelBMS->setConductor($userId, $_SESSION['companyId'], $name, $mobile, $mail, $address, $state, $district, $pincode, $language, $conductorImage_path, $aadharNo, $aadharCard_path, $panNo, $panCard_path);

        if (!$response3) {
            //Delete the user from users table
            $this->modelBMS->deleteUser($userId);

            return [
                'status' => 'error',
                'message' => 'Something went wrong while creating the conductor',
                'error' => 'Error while insert data in conductor table.'
            ];
        }

        //Sent Mail to conductor

        $mailContent = $this->mailContent('en', $name, $mail, $password, $_SESSION['companyName'], 'http://localhost/TMS/BMS/Admin/View/conductor.php');

        $subject = $mailContent['subject'];
        $body = $mailContent['body'];
        $response4 = $this->mail->sendMail($mail, $subject, $body);

        if ($response4['status'] == 'error') {
            return [
                "status" => "success",
                "message" => "The conductor has created a username and password, but the email has not been sent."
            ];
        }

        return [
            "status" => "success",
            "message" => "The conductor has created a username and password, which has been sent to your email address."
        ];

    }

    public function updateConductor($conductorId, $conductorImage, $name, $mobile, $language, $password, $address, $state, $district, $pincode, $aadharCard, $aadharNo, $panCard, $panNo)
    {
        $conductorInfo = [
            "fullname" => $name,
            "mobile" => $mobile,
            "language" => $language,
            "address" => $address,
            "state" => $state,
            "district" => $district,
            "pincode" => $pincode,
            "aadhar_no" => $aadharNo,
            "pan_no" => $panNo
        ];

        $currentData = $this->modelBMS->getConductor($conductorId);

        if (!$currentData) {
            return [
                'status' => 'error',
                'message' => 'Something went wrong while updating the conductor',
                'error' => 'Error while select conductor data from conductor table.'
            ];
        }

        //Check for changes
        $changes = [];
        $fields = ['fullname', 'mobile', 'language', 'address', 'state', 'district', 'pincode', 'aadhar_no', 'pan_no'];

        //check & upload file changes
        $fileChanges = false;

        $uploadService = new FileUpload();

        //Upload conductor image
        if (isset($conductorImage) && $conductorImage['error'] === UPLOAD_ERR_OK) {
            $conductorImage_dir = "../../Assets/User/Conductor image/";

            $conductorImage_filename = $uploadService->uploadFile($conductorImage, $conductorImage_dir);

            $conductorImage_path = $conductorImage_filename['status'] === 'success' ? 'Conductor image/' . $conductorImage_filename['fileName'] : '';

            $fields[] = 'conductor_image_path';
            $conductorInfo['conductor_image_path'] = $conductorImage_path;
            $fileChanges = true;
            //Delete old file
            $oldconductorImage = "../../Assets/User/" . $currentData['conductor_image_path'];
            if (file_exists($oldconductorImage) && is_file($oldconductorImage)) {
                unlink($oldconductorImage);
            }
        }


        //Upload Aadhar Card
        if (isset($aadharCard) && $aadharCard['error'] === UPLOAD_ERR_OK) {
            $aadharCard_dir = "../../Assets/User/Conductor aadharcard/";

            $aadharCard_filename = $uploadService->uploadFile($aadharCard, $aadharCard_dir);

            $aadharCard_path = $aadharCard_filename['status'] === 'success' ? 'Conductor aadharcard/' . $aadharCard_filename['fileName'] : '';

            $fields[] = 'aadhar_path';
            $conductorInfo['aadhar_path'] = $aadharCard_path;
            $fileChanges = true;
            //Delete old file
            $oldAadharCard = "../../Assets/User/" . $currentData['aadhar_path'];
            if (file_exists($oldAadharCard) && is_file($oldAadharCard)) {
                unlink($oldAadharCard);
            }
        }

        //Upload PAN Card
        if (isset($panCard) && $panCard['error'] === UPLOAD_ERR_OK) {
            $panCard_dir = "../../Assets/User/Conductor pancard/";

            $panCard_filename = $uploadService->uploadFile($panCard, $panCard_dir);

            $panCard_path = $panCard_filename['status'] === 'success' ? 'Conductor pancard/' . $panCard_filename['fileName'] : '';

            $fields[] = 'pan_path';
            $conductorInfo['pan_path'] = $panCard_path;
            $fileChanges = true;
            //Delete old file
            $oldPanCard = "../../Assets/User/" . $currentData['pan_path'];
            if (file_exists($oldPanCard) && is_file($oldPanCard)) {
                unlink($oldPanCard);
            }
        }

        //Change password
        $passwordChange = false;
        if (isset($password) && !empty($password)) {
            //Password Hasing

            $hashPassword = password_hash($password, PASSWORD_DEFAULT);

            $pass_response = $this->modelA->updatePassword($currentData['user_id'], $hashPassword);

            if(!$pass_response) {
                return [
                    'status' => 'error',
                    'message' => 'Something went wrong while updating the password',
                    'error' => 'Error while update password in user table.'
                ];
            }

            $passwordChange = true;
        }

        foreach ($fields as $field) {
            if ($conductorInfo[$field] != $currentData[$field]) {
                $changes[$field] = $conductorInfo[$field];
            }
        }
        // Construct and execute dynamic SQL query if there are changes
        if (!empty($changes) || $fileChanges) {
            $update_fields = [];
            $update_values = [];

            foreach ($changes as $field => $new_value) {
                $update_fields[] = "$field = :$field";
                $update_values[":$field"] = $new_value;
            }

            $update_values['id'] = $conductorId;

            $final_response = $this->modelBMS->updateConductor($update_fields, $update_values);

            if ($final_response) {
                return [
                    'status' => 'success',
                    'message' => 'Conductor details updated successfully'
                ];
            } else {
                return [
                    'status' => 'error',
                    'message' => 'Something went wrong while updating the conductor',
                    'error' => 'Error while update conductor data in conductor table.'
                ];
            }

        } else {
            if ($passwordChange) {
                return [
                    'status' => 'success',
                    'message' => 'Conductor details updated successfully'
                ];
            } else {
                return [
                    'status' => 'error',
                    'message' => 'There are no changes in conductor details.',
                    'error' => 'All values as in conductor table'
                ];
            }
            
        }
    }

    public function deleteConductor($conductorId) {
        $currentData = $this->modelBMS->getConductor($conductorId);

        if (!$currentData) {
            return [
                'status' => 'error',
                'message' => 'Something went wrong while deleting the conductor',
                'error' => 'Error while select conductor data in conductor table.'
            ];
        }
        //Delete old file
        $oldImage = "../../Assets/User/" . $currentData['conductor_image_path'];
        if (file_exists($oldImage) && is_file($oldImage)) {
            unlink($oldImage);
        }

        //Delete old file
        $oldDrivingLicence = "../../Assets/User/" . $currentData['licence_path'];
        if (file_exists($oldDrivingLicence) && is_file($oldDrivingLicence)) {
            unlink($oldDrivingLicence);
        }

        //Delete old file
        $oldAadharCard = "../../Assets/User/" . $currentData['aadhar_path'];
        if (file_exists($oldAadharCard) && is_file($oldAadharCard)) {
            unlink($oldAadharCard);
        }

        //Delete old file
        $oldPanCard = "../../Assets/User/" . $currentData['pan_path'];
        if (file_exists($oldPanCard) && is_file($oldPanCard)) {
            unlink($oldPanCard);
        }
        

        //Delete drive from users table in Authentication DB
        $response1 = $this->modelA->deleteUser($currentData['user_id']);

        if (!$response1) {
            return [
                'status' => 'error',
                'message' => 'Something went wrong while deleting the conductor',
                'error' => 'Error while delete conductor data in users table in Authentication DB.'
            ];
        }

        $response2 = $this->modelBMS->deleteConductor($conductorId);

        if ($response2) {
            return [
                'status' => 'success',
                'message' => 'conductor deleted successfully.'
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'Something went wrong while deleting the conductor',
                'error' => 'Error while delete conductor data in conductor table in bms DB.'
            ];
        }
    }
    public function checkMail($mail)
    {
        //Check mail ID is already exit
        $response1 = $this->modelBMS->getMailID($mail);

        if ($response1) {
            return [
                'status' => 'mail error',
                'message' => 'The email address you provided is already associated with a registered driver in our system. Please try registering with a different email address.'
            ];
        } else {
            return [
                'status' => 'success',
                'message' => 'Mail ID verified'
            ];
        }
    }

    public function getConductor($conductorId)
    {
        $response = $this->modelBMS->getConductor($conductorId);

        if (!$response) {
            return [
                'status' => 'error',
                'message' => 'No data found'
            ];
        }

        return [
            'status' => 'success',
            'data' => $response
        ];
    }

    public function getDriversCardDetails() {
        $response = $this->modelBMS->getDriversCardDetails($_SESSION['companyId']);
        if (!$response) {
            return [
                'status' => 'no data',
                'message' => 'No data found'
            ];
        }

        return [
            'status' => 'success',
            'data' => $response
        ];
    }

    public function getConductors()
    {
        $response = $this->modelBMS->getConductors($_SESSION['companyId']);
        if (!$response) {
            return [
                'status' => 'no data',
                'message' => 'No data found'
            ];
        }

        return [
            'status' => 'success',
            'data' => $response
        ];
    }

    public function mailContent($language, $name, $username, $password, $companyName, $url)
    {
        $english_subject = 'Welcome to AstronuX - Your Login Credentials';

        $english_body = '
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <html xmlns="http://www.w3.org/1999/xhtml">

            <head>
                <meta name="viewport" content="width=device-width, initial-scale=1.0" />
                <meta name="x-apple-disable-message-reformatting" />
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                <meta name="color-scheme" content="light dark" />
                <meta name="supported-color-schemes" content="light dark" />
                <title></title>
                <style>
                    @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap");
                </style>
            </head>

            <body style="width: 100% !important; height: 100%; margin: 0; -webkit-text-size-adjust: none; background-color: #f9f3ea; color: #51545E; font-family: Poppins, sans-serif;">
                <table class="email-wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation" style="width: 100%; margin: 0; padding: 0; background-color: #f9f3ea;">
                    <tr>
                        <td align="center">
                            <table class="email-content" width="100%" cellpadding="0" cellspacing="0" role="presentation" style="width: 100%; margin: 0; padding: 0;">
                                <tr>
                                    <td class="email-masthead" style="padding: 20px 0; text-align: center;">
                                        <a href="https://example.com" class="f-fallback email-masthead_name" style="font-size: 16px; font-weight: bold; color: #A8AAAF; text-decoration: none; text-shadow: 0 1px 0 white;">
                                            <div class="logo-card" style="font-family: Poppins, sans-serif;">
                                                <!-- <img src="../Assets/Developer/Svg/logo-3.svg" alt="logo" class="logo-left" style="width: 60px;"> -->
                                                <span class="logo-right" style="color: black; font-size: 50px; font-weight: bold; position: relative; top: 3px;"><span style="color: #ff9900;">A</span>stronu<span style="color: #ff9900;">X</span></span>
                                            </div>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="email-body" width="570" cellpadding="0" cellspacing="0" style="width: 100%; margin: 0; padding: 0;">
                                        <table class="email-body_inner" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation" style="width: 700px; margin: 0 auto; padding: 0; background-color: #FFFFFF;">
                                            <tr>
                                                <td class="content-cell">
                                                    <div class="fp-svg" style="text-align: center;">
                                                        <img src="../Assets/Developer/Svg/forgot-password.svg" alt="" style="width: 100%;">
                                                    </div>
                                                    <div class="f-fallback p-div" style="padding: 60px 20px;">
                                                        <h1 style="color: #ff9900 !important; text-align: center; margin-top: 0; font-size: 23px; font-weight: 600;">Hello ' . $name . ', Welcome to AstronuX</h1>
                                                        <p style="margin: .4em 0 1.1875em; font-size: 16px; line-height: 1.625; color: #c38426; text-align: center;">Your account has been created by <span style="font-weight: 600;">' . $companyName . '</span><br>
                                                            Below are your system login credentials,<br>
                                                            <span style="font-weight: 600;">Please change your password immediately after logging in.</span></p>
                                                            <table class="body-sub" role="presentation" style="margin-top: 25px; padding-top: 25px; border-top: 1px solid #EAEAEC; width: 100%;">
                                                                <tr>
                                                                    <td>
                                                                        <p class="f-fallback sub" style="margin: .4em 0 .4em; font-size: 14px; line-height: 1.625; color: #c38426; text-align: center;">Username</p>
                                                                        <p class="f-fallback sub" style="margin: .4em 0 1.1875em; font-size: 14px; font-weight: bold; line-height: 1.625; color: #c38426; text-align: center;">' . $username . '</p>
                                                                        <p class="f-fallback sub" style="margin: .4em 0 .4em; font-size: 14px; line-height: 1.625; color: #c38426; text-align: center;">Password</p>
                                                                        <p class="f-fallback sub" style="margin: .4em 0 1.1875em; font-size: 14px; font-weight: bold; line-height: 1.625; color: #c38426; text-align: center;">' . $password . '</p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        <table class="body-action" align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation" style="width: 100%; margin: 0 auto; padding: 0; text-align: center;">
                                                            <tr>
                                                                <td align="center">
                                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" role="presentation">
                                                                        <tr>
                                                                            <td align="center">
                                                                                <a href="' . $url . '" class="f-fallback button button--green" target="_blank" style="background-color: #ff9900; border-top: 10px solid #ff9900; border-right: 18px solid #ff9900; border-bottom: 10px solid #ff9900; border-left: 18px solid #ff9900; display: inline-block; color: #FFF; text-decoration: none; border-radius: 3px; box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16); box-sizing: border-box;">Login</a>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <table class="email-footer" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation" style="width: 570px; margin: 0 auto; padding: 0; text-align: center;">
                                            <tr>
                                                <td class="content-cell" align="center" style="padding: 30px;">
                                                    <p class="f-fallback sub align-center" style="margin: .4em 0 1.1875em; font-size: 13px; line-height: 1.625; color: #A8AAAF;">[AstronuX]<br>6, 22nd St, Ashok Nagar<br>Chennai</p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </body>

            </html>
            ';


        $tamil_subject = 'AstronuX க்கு வரவேற்கின்றேன் - உங்கள் உள்நுழைவு சான்றுகள்';

        $tamil_body = '
            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <html xmlns="http://www.w3.org/1999/xhtml">

            <head>
                <meta name="viewport" content="width=device-width, initial-scale=1.0" />
                <meta name="x-apple-disable-message-reformatting" />
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                <meta name="color-scheme" content="light dark" />
                <meta name="supported-color-schemes" content="light dark" />
                <title></title>
                <style>
                    @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap");
                </style>
            </head>

            <body style="width: 100% !important; height: 100%; margin: 0; -webkit-text-size-adjust: none; background-color: #f9f3ea; color: #51545E; font-family: Poppins, sans-serif;">
                <span class="preheader" style="display: none !important; visibility: hidden; mso-hide: all; font-size: 1px; line-height: 1px; max-height: 0; max-width: 0; opacity: 0; overflow: hidden;">Use this link to reset your password. The link is only valid for 24 hours.</span>
                <table class="email-wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation" style="width: 100%; margin: 0; padding: 0; background-color: #f9f3ea;">
                    <tr>
                        <td align="center">
                            <table class="email-content" width="100%" cellpadding="0" cellspacing="0" role="presentation" style="width: 100%; margin: 0; padding: 0;">
                                <tr>
                                    <td class="email-masthead" style="padding: 25px 0; text-align: center;">
                                        <a href="https://example.com" class="f-fallback email-masthead_name" style="font-size: 16px; font-weight: bold; color: #A8AAAF; text-decoration: none; text-shadow: 0 1px 0 white;">
                                            <div class="logo-card" style="display: flex; align-items: flex-start; justify-content: center; font-family: Poppins, sans-serif;">
                                                <!-- <img src="../Assets/Developer/Svg/logo-3.svg" alt="logo" class="logo-left" style="width: 60px;"> -->
                                                <span class="logo-right" style="color: black; font-size: 50px; font-weight: bold; position: relative; top: 3px;"><span style="color: #ff9900;">A</span>stronu<span style="color: #ff9900;">X</span></span>
                                            </div>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="email-body" width="570" cellpadding="0" cellspacing="0" style="width: 100%; margin: 0; padding: 0;">
                                        <table class="email-body_inner" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation" style="width: 700px; margin: 0 auto; padding: 0; background-color: #FFFFFF;">
                                            <tr>
                                                <td class="content-cell">
                                                    <div class="fp-svg" style="text-align: center;">
                                                        <img src="../Assets/Developer/Svg/forgot-password.svg" alt="" style="width: 100%;">
                                                    </div>
                                                    <div class="f-fallback p-div" style="padding: 60px;">
                                                        <h1 style="color: #ff9900 !important; text-align: center; margin-top: 0; font-size: 23px; font-weight: 600;">AstronuX-க்கு வரவேற்கிறோம்!</h1>
                                                        <p style="margin: .4em 0 1.1875em; font-size: 16px; line-height: 1.625; color: #c38426; text-align: center;">உங்கள் கணக்கை <span style="font-weight: 600;">' . $companyName . '/span> உருவாக்கியுள்ளார்.<br>
                                                            உங்கள் கணக்கிற்கான நுழைவு விவரங்கள் கீழே கொடுக்கப்பட்டுள்ளன.<br>
                                                            <span style="font-weight: 600;">தயவுசெய்து நுழைந்தவுடன் உங்கள் கடவுச்சொல்லை உடனடியாக மாற்றுங்கள்.</span></p>
                                                            <table class="body-sub" role="presentation" style="margin-top: 25px; padding-top: 25px; border-top: 1px solid #EAEAEC; width: 100%;">
                                                                <tr>
                                                                    <td>
                                                                        <p class="f-fallback sub" style="margin: .4em 0 .4em; font-size: 14px; line-height: 1.625; color: #c38426; text-align: center;">பயனர் பெயர்</p>
                                                                        <p class="f-fallback sub" style="margin: .4em 0 1.1875em; font-size: 14px; font-weight: bold; line-height: 1.625; color: #c38426; text-align: center;">' . $username . '</p>
                                                                        <p class="f-fallback sub" style="margin: .4em 0 .4em; font-size: 14px; line-height: 1.625; color: #c38426; text-align: center;">கடவுச்சொல்</p>
                                                                        <p class="f-fallback sub" style="margin: .4em 0 1.1875em; font-size: 14px; font-weight: bold; line-height: 1.625; color: #c38426; text-align: center;">' . $password . '</p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        <table class="body-action" align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation" style="width: 100%; margin: 0 auto; padding: 0; text-align: center;">
                                                            <tr>
                                                                <td align="center">
                                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" role="presentation">
                                                                        <tr>
                                                                            <td align="center">
                                                                                <a href="{{action_url}}" class="f-fallback button button--green" target="_blank" style="background-color: #ff9900; border-top: 10px solid #ff9900; border-right: 18px solid #ff9900; border-bottom: 10px solid #ff9900; border-left: 18px solid #ff9900; display: inline-block; color: #FFF; text-decoration: none; border-radius: 3px; box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16); box-sizing: border-box;">நுழைவு</a>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <table class="email-footer" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation" style="width: 570px; margin: 0 auto; padding: 0; text-align: center;">
                                            <tr>
                                                <td class="content-cell" align="center" style="padding: 30px;">
                                                    <p class="f-fallback sub align-center" style="margin: .4em 0 1.1875em; font-size: 13px; line-height: 1.625; color: #A8AAAF;">[AstronuX]<br>6, 22nd St, Ashok Nagar<br>Chennai</p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </body>

            </html>
            ';

        if ($language == 'en') {
            return [
                'subject' => $english_subject,
                'body' => $english_body
            ];
        } elseif ($language == 'ta') {
            return [
                'subject' => $tamil_subject,
                'body' => $tamil_subject
            ];
        }
    }

    public function getConductorField(){
        $response = $this->modelBMS->getConductorField($_SESSION['companyId']);

        if (!$response) {
            return [
                'status' => 'error',
                'message' => 'No data found'
            ];
        }

        return [
            'status' => 'success',
            'data' => $response
        ];
    }
}