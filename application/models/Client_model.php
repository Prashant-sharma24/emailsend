<?php
class Client_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database(); // Load the database in the constructor
    }

    public function save_client($data) {
        $this->db->insert('client', $data);
        return $this->db->insert_id();
    }

    public function get_corporate_names() {
        $query = $this->db->get('corporate_master');
        return $query->result();
    }

	public function getAddress($corporate_id) {
		$this->db->select('address');
		$this->db->where('id', $corporate_id);
		$query = $this->db->get('corporate_master');
	
		// Check if the query was successful
		if ($query->num_rows() > 0) {
			$result = $query->row();
			return $result->address;
		} else {
			return false; // Return false if no data found
		}
	}
	public function get_dropdown_data() {
        $query = $this->db->get('corporate_master'); // Replace 'your_table_name' with your actual table name
        return $query->result();
    }
	public function get_all_corporate_names() {
        $query = $this->db->select('id, business_name')
                          ->from('corporate_master')
                          ->get();
        
        // Check if query was successful
        if ($query->num_rows() > 0) {
            return $query->result(); // Return an array of objects containing corporate names
        } else {
            return array(); // Return an empty array if no corporate names found
        }
    }

	// Model: Corporate_Model.php

public function pget_corporate_address($corporate_name_id) {
    $query = $this->db->select('address')
        ->from('corporate_master')
        ->where('id', $corporate_name_id)
        ->get();
    
    // Check if query was successful
    if ($query->num_rows() > 0) {
        $row = $query->row();
        return $row->address; // Return the corporate address
    } else {
        return ''; // Return an empty string if no address found
    }
}

public function get_corporate_address($corporate_name_id) {
    // Select all fields from the 'corporate_master' table where the 'id' matches $corporate_name_id
    $query = $this->db->where('id', $corporate_name_id)
                      ->get('corporate_master');

    // Check if query was successful
    if ($query->num_rows() > 0) {
        // If the query returned at least one row, extract the data from the first row as an associative array
        return $query->row_array();
    } else {
        // If no rows were returned, return an empty array
        return array();
    }
}

public function get_business_name_by_id($corporate_name) {
	// Fetch the business name from the database based on the provided ID
	$query = $this->db->get_where('corporate_master', array('id' => $corporate_name));

	// Check if the query returned a result
	if ($query->num_rows() > 0) {
		// Return the business name
		return $query->row()->business_name;
	} else {
		// If no result found, return false or handle the error as needed
		return false;
	}
}
	
}
?>
