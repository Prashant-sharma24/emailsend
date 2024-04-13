<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class mail extends CI_Controller{
	public function __construct() {
        parent::__construct();
	}

	public function index(){
		$this->load->library('phpmailer_lib');
		$mail = $this->phpmailer_lib->load();
		$mail->ClearAddresses();
		$mail->ClearAttachments();
		$mail->isSMTP();
		$mail->Host  = 'smtp.gmail.com';
		$mail->SMTPAuth = true;
		$mail->username = 'ps.s100697@gmail.com';
		$mail->password = 'Prashant1@#.';
		$mail->SMTPSecure   = 'ssl';
		$mail->Port     = 465;

		$mail->setFrom('ps.s100697@gmail.com', 'Admin');
		$mail->addReplyTo('ps.s100697@gmail.com', 'Information');
		$mail->addAdress('ps.sharma2403@gmail.com');

		$mail->Subject = 'hello';

		$mail->isHTML(true);
		$message = ' hello';
		$mail->Body = $message;
		if(!$mail->send()){
			$status='mailer Error:'	.$mail->ErrorInf;
		} else{
			$status='<h2>email send  successfully</h2>';
		}
		echo $status;
	}
}
