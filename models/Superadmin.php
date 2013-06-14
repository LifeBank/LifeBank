<?php
// require Admin abstract

class Superadmin extends Admin {
  
  // Set hospital status
  // param: id, status (1/0)
  // return bool
  public function set_hospital_status ($hospital_id, $status) {
  }
  
  // 
  // param: array of filters. Optional.
  //  filters: id, location, email, name, phone
  // return: list of matching hospital
  public function get_hospitals ($filters = array) {
  }
  
  // return: bool
  public function remove_hospital($id) {
  }
  
}