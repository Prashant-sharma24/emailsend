<?php
defined('BASEPATH') OR exit('No direct script access allowed');




class Business_registration extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('client_model');
		$this->load->library('form_validation'); // Load the Form Validation library
		require_once APPPATH . 'third_party/PHPMailer/src/PHPMailer.php';
        require_once APPPATH . 'third_party/PHPMailer/src/SMTP.php';
        require_once APPPATH . 'third_party/PHPMailer/src/Exception.php';
		$this->load->helper('email');


    }
	

public function fetch_corporate_address() {
    $corporate_name_id = $this->input->post('corporate_name_id'); // Get the selected corporate ID from POST data

    // Call the method in Corporate_Model to fetch corporate address based on the ID
    $corporate_address = $this->client_model->get_corporate_address($corporate_name_id);

    // Send the corporate address as JSON response
    $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($corporate_address));
}

	
    public function index() {
        // Get corporate customer names
    
        $this->load->view('registration_form');
    }


public function fetch_corporate_names() {
	// Call the method in Corporate_Model to fetch corporate names
	$corporate_names = $this->client_model->get_all_corporate_names();
	// Send the corporate names as JSON response
	$this->output
		->set_content_type('application/json')
		->set_output(json_encode($corporate_names));
}


	public function save_registration() {
		// Form validation
		$this->form_validation->set_rules('contact_person_name', 'Contact Person Name', 'required');
		$this->form_validation->set_rules('business_email', 'Business Email', 'required|valid_email');
		$this->form_validation->set_rules('contact_number', 'Contact Number', 'required');
		$this->form_validation->set_rules('business_name', 'Business Name', 'required');
		$this->form_validation->set_rules('address', 'Address', 'required');
		$this->form_validation->set_rules('country', 'Country', 'required');
		$this->form_validation->set_rules('state', 'State', 'required');
		$this->form_validation->set_rules('zip_code', 'Zip Code', 'required');
		$this->form_validation->set_rules('gst_no', 'GST No', 'required');
	
		if ($this->form_validation->run() == FALSE) {
			// Validation failed, reload the form with validation errors
			$this->load->view('registration_form');
		} else {
			// Form data is valid, proceed to save to database
			$data = array(
				'contact_person_name' => $this->input->post('contact_person_name'),
				'business_email' => $this->input->post('business_email'),
				'contact_number' => $this->input->post('contact_number'),
				'business_name' => $this->input->post('business_name'),
				'address' => $this->input->post('address'),
				'country' => $this->input->post('country'),
				'state' => $this->input->post('state'),
				'zip_code' => $this->input->post('zip_code'),
				'gst_no' => $this->input->post('gst_no')
			);
	// var_dump($data);die;
			// Check if it's a corporate customer
			if ($this->input->post('customer_type') == 'corporate') {
				$data['corporate_address'] = $this->input->post('corporate_address');

				$data['corporate_code'] = $this->input->post('corporate_name');
				$data['payment_option'] = $this->input->post('payment_option');
			}
	
			// Save data to database
			$this->load->model('client_model');
			$client_id = $this->client_model->save_client($data);
	
			// Send email to customer
			$email = $this->input->post('business_email');
			$customer_name = $this->input->post('contact_person_name');
			$link = "https://example.com"; // Replace with the actual link
			
			$subject = "Welcome to the Registration Process";
			$message = "Dear $customer_name,<br><br>We welcome you to the registration process which will help to create your account in the App. In order to make the sign-up process experience better, please click the following link and enter your location information.<br><br><a href='$link'>Click here to enter your location information</a><br><br>Thanks & regards,<br>App Support Team";
			
			$curl = curl_init();
			
			curl_setopt_array($curl, array(
				CURLOPT_URL => "https://api.zeptomail.in/v1.1/email",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_POSTFIELDS => '{
					"bounce_address":"info@bounce.streetcause.org",
					"from": { "address": "noreply@streetcause.org"},
					"to": [{"email_address": {"address": "'.$email.'","name": "'.$customer_name.'"}}],
					"subject":"'.$subject.'",
					"htmlbody":"'.$message.'"
				}',
				CURLOPT_HTTPHEADER => array(
					"accept: application/json",
					"authorization: Zoho-enczapikey PHtE6r1cEeHu2m559xgCsaKxR8H3NYsm9e42fghB44lKAv8ESU1XroopkzG+/00vBqYQR/SYyYg8sr+b5e7UIWq8MT4aDmqyqK3sx/VYSPOZsbq6x00asl4ddU3dUobrd9Jq1iDWuNfYNA==",
					"cache-control: no-cache",
					"content-type: application/json",
				),
			));
			
			$response = curl_exec($curl);
			$err = curl_error($curl);
			
			curl_close($curl);
			
			if ($err) {
				// Error occurred while sending email
				$this->session->set_flashdata('error_msg', 'Failed to send email. Please try again later.');
			} else {
				// Email sent successfully
				$this->session->set_flashdata('success_msg', 'Registration saved successfully. Email sent.');
			}
			
			// Redirect to index page
			redirect('business_registration/index');
		}
	}
	

}
?>
