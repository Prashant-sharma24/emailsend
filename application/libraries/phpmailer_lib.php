<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
class PHPMailer_Lib {
 public function __construct()
 {
	log_message('debug', 'phpmailer class is loadded.');
 }

	public function load(){
		require_once APPPATH . 'third_party/PHPMailer/src/PHPMailer.php';
        require_once APPPATH . 'third_party/PHPMailer/src/SMTP.php';
        require_once APPPATH . 'third_party/PHPMailer/src/Exception.php';

		$mail = new PHPMailer;
		return $mail;
	}
}
