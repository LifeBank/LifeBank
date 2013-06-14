<?php
// require Admin abstract

class Hospital extends Admin {
  
  public function signup ($name, $phone, $email, $location) {
  }
  
  // param: $param - array of (signup) params to update and value in key=>value relationship
  // return: bool
  public function update_details ($param) {
  }
  
  // return: bool
  public function is_logged () {}
  
  // Verifies donor
  // return: bool
  public function verify_donor ($user_id) {}
  
  // Upload logo
  // param: $source ($_FILE~)
  // return: bool
  public function upload_logo($source) {
  }
  
  
}