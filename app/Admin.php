<?php
// Admin abstract
// Extended by hospital and admin
abstract class Admin {
 
  // Get hospital status
  // Is the hospital approved by super admin yet?
  // No get_donor, mail_donor, add_hospital_admin if not
  // param: hospital_id. Optional. Use one in current session if null
  // return bool
  public function get_hospital_status ($hospital_id = null);
  
  // Get donors
  // param: array of filters (optional)
  // filters are user_id, user_email, blood_group, hospital_id & location
  // return: list of matching users
  public function get_donor($filters = array());
  
  // Mail donors
  // param: array of filters as get_donor().
  // passes filters to get users from get_donor and mail
  // return: bool?
  public function mail_donor($filters = array());
  
  // Get hospital admin
  // param: hospital_id. If null, use one of current session
  // return: list of hospital admins
  public function get_hospital_admin($hospital_id = null);
  
  // Add the hospital admin
  // param: user_id
  // return: bool
  public function add_hospital_admin($user_id);
  
  // Remove hospital admin
  // param: user_id
  // return: bool
  public function remove_hospital_admin($user_id);
}
?>