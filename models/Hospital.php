<?php

// require Admin abstract
require_once 'Admin.php';

class Hospital extends Admin {

    public function signup($name, $phone, $email, $location) {
        $name = $_POST['hospital_name'];
        $phone = $_POST['hospital_phone'];
        $email = $_POST['hospital_email'];
        $location = $_POST['hospital_location'];

        $register_hospital = "INSERT into ''";
    }

    // param: $param - array of (signup) params to update and value in key=>value relationship
    // return: bool
    public function update_details($param) {
        
    }

    // return: bool
    public function is_logged() {
        
    }

    // Verifies donor
    // return: bool
    public function verify_donor($user_id) {
        
    }

    public function get_donor($filters = array()) {
        // get the location of this hospital
    }

    // Upload logo
    // param: $source ($_FILE~)
    // return: bool
    public function upload_logo($source) {
        
    }

    public function get_locations() {
        $locations = array();
        $sql = "SELECT * FROM locations ORDER by name DESC";
        $locations = Database::fetchRows($sql);
        $location_names = array();
        foreach ($locations as $output) {
            $location_name = array();
            $location_name = $output['name'];
            $location_names[] = $location_name;
        }
        return json_encode($location_names);
    }

}