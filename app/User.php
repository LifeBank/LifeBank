<?php
// Errors are stored in a session variable
// And can be returned via functions:get_error

class User {
  
  // User logged in or not?
  //  Checked by other methods that requires user to be logged in
  // return bool
  public function is_logged() {
  }
  
  // return: id
  public function signup($name, $email, $password, $phone, $blood_type, $location) {
  }
  
  // return: bool
  public function login($email, $password) {
  }
  
  // param: id (from oauth login), social_media: 'f' (facebook) or 't' (twitter)
  // return: bool
  public function social_login($id, $social_media) {
  }
  
  // param: id (unique id on social site), name (name or username on SS), type: t or f, 
  //   key (oauth key), token (oauth token)
  public function add_social_account($id, $name, $type, $key, $token) {
  }
  
  // param: id, type (just in case has same id across social acc)
  public function remove_social_account($id, $type) {
  }
  
  // param: $param - array of user object to update and value in key=>value relationship
  //   these are: name, email, phone, blood_type and location
  // return: bool
  public function update_profile($param) {
  }
  
  // return bool
  public function update_password($old, $new) {
  }
  
  // param: $source: 't' (twitter), 'g' (gravatar) or 'f' (facebook)
  // return: bool
  public function set_avatar($source) {
  }
  
  // Upload avatar
  // param: $source ($_FILE~)
  // return: bool
  public function upload_avatar($source) {
  }
  
  // Set status
  // param: status: 1/0 (active or inactive)
  // return: bool
  public function set_status($status) {
  }
  
  // Delete account
  public function delete_account() {
  }
   
}
?>