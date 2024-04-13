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
}
?>
