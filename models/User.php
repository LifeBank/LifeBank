<?php
require_once 'lib/is_email.php';

// @kehers
// Errors are stored in a session variable
// And can be returned via functions:get_error

class User {
  
  public function get_user($username) {
    $username = Database::escape($username);
    $r = Database::fetchRow("select username, u.name, email, avatar, phone, l.name as location, blood_group, verified, status, donated_times, referrals from users u, locations l where username='$username' and u.location=l.location_id");
    return $r;
  }
  
  // return: id
  public function signup($username, $name, $email, $password, $phone, $blood_type, $location_id) {
    $username = Database::escape($username);
    $name = Database::escape($name);
    $email = Database::escape($email);
    
    // Confirm username
    $r = Database::fetchRow("select * from users where username='$username'");
    if ($r) {
      $_SESSION['error'] = 'Username already in use, please try another username';
      return false;
    }
    
		if (!preg_match('|^[a-z0-9\-_.]{4,}$|i', $username)) {
			$_SESSION['error'] = 'Username should contain word characters only. Minimum of 4 characters';
			return false;
		}
    
    if (!preg_match("|^[a-z'\-\s]{2,}$|i", $name)) {
      // error: invalid name
      $_SESSION['error'] = 'Please enter a valid name';
      return false;
    }
    
    // Enforce password length?
    if (empty($password)) {
      $_SESSION['error'] = 'No password provided';
      return false;
    }
    
    /*if (is_email($email)) {
      $_SESSION['error'] = 'Invalid email';
      return false;
    }//*/
    
    if (!preg_match('|[a-z0-9.\-_\+]{1,}@[a-z0-9.\-_\+]{4,}|i', $email)) {
      $_SESSION['error'] = 'Invalid email';
      return false;
    }
    
    if (!preg_match('|^\+?[0-9]{5,}$|', $phone)) {
      $_SESSION['error'] = 'Invalid phone number';
      return false;
    }
    
    /*if (!in_array($blood_type, 
          array('A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'))) {
      $_SESSION['error'] = 'Invalid blood group';
      return false;
    }//*/
    
    if (!$location_id) {
      $_SESSION['error'] = 'Invalid location';
      return false;
    }
    
    
    if (!preg_match('|[a-z0-9.\-_\+]{1,}@[a-z0-9.\-_\+]{4,}|i', $email)) {
      $_SESSION['error'] = 'Invalid email';
      return false;
    }
    
		require 'lib/PasswordHash.php';
		$hasher = new PasswordHash(8, FALSE);
		$hash = $hasher->HashPassword($password);
    
    $id = Database::insert('users', array(
        'username' => $username,
        'name' => $name,
        'email' => $email,
        'password' => $hash,
        'phone' => $phone,
        'location' => $location_id,
        'blood_group' => $blood_type,
        'last_login' => date('YYYY-MM-DD HH:mm'),
        'date' => date('YYYY-MM-DD HH:mm')
      ));
    
    // Login
    $_SESSION['user'] = array(
      'user_id' => $id,
      'name' => $name,
      'email' => $email,
      'last_login' => date('YYYY-MM-dd HH:mm')
    );
    
    unset($_SESSION['tmp']);
    
    return true;
  }
  
  // return: bool
  public function login($email, $password) {
		if (!$email) {
      $_SESSION['error'] = 'No email provided';
			return false;
		}
		
		if (!$password) {
      $_SESSION['error'] = 'No password provided';
			return false;
		}
    
		$r = Database::fetchRow("select user_id, username, password, name, email, verified, status, last_login from users where email='".Database::escape($email)."'");
		if ($r) {			
			require 'lib/PasswordHash.php';
			$hasher = new PasswordHash(8, FALSE);
			
			if (!$hasher->CheckPassword($password, $r['password'])) {
        $_SESSION['error'] = 'Invalid password';
				return false;
			}
      
      // Declare user sessions
      $_SESSION['user'] = array(
        'user_id' => $r['user_id'],
        'username' => $r['username'],
        'name' => $r['name'],
        'email' => $r['email'],
        'verified' => $r['verified'],
        'status' => $r['status'],
        'last_login' => $r['ll']
      );
			
			Database::query("update users set last_login=now() where email='".Database::escape($r['email'])."'");
			return true;
		}
		else {
      $_SESSION['error'] = 'Specified email does not exist';
			return false;
		}
  }
  
  // param: id (from oauth login), social_media: 'f' (facebook) or 't' (twitter)
  // return: bool
  public function social_login($id, $social_media, $key, $token) {
    if ($social_media != 'f' || $social_media != 't') {
      // error: invalid type
      return false;
    }
      
    $id = (int) $id;
    
    $q = "select user_id from user_social_acc where social_id='$id' and type='$social_media'";
    $r = mysq_query($q);
    list($user_id) = mysql_fetch_array($r);
    
    if (!$user_id) {
      // Not registered, register
      
    }
    
		$r = mysql_query("select user_id, username, name, email, verified, status, last_login from users where user_id='$user_id'");
		if (mysql_num_rows($r)) {
			list($user_id, $username, $name, $email, $verified, $status, $ll) = mysql_fetch_array($r);
      
      // User sessions
      $_SESSION['user'] = array(
        'user_id' => $user_id,
        'username' => $username,
        'name' => $name,
        'email' => $email,
        'verified' => $verified,
        'status' => $status,
        'last_login' => $ll
      );
			
			mysql_query("update users set last_login=now() where email='".escape($email)."'");
			return true;
    }
    
    // error: something went wrong
    return false;
  }
  
  // param: id (unique id on social site), name (name or username on SS), type: t or f, 
  //   key (oauth key), token (oauth token)
  public function add_social_account($id, $name, $type, $key, $token, $avatar) {
    $id = (int) $id;
    $name = escape($name);
    $avatar = escape($avatar);
    
    if (!is_logged()) {
      // error: User not found
      return false;
    }
    
    if ($type != 'f' && !$type != 't') {
      // error: invalid type
      return false;
    }
    
    $q = "insert into user_social_acc (user_id, social_id, type, okey, otoken, name, avatar) values ('{$_SESSION['user']['user_id']}', '$id', '$type', '$key', '$token', '$name', '$avatar')";
    $r = mysql_query($q);
    
    return mysql_num_rows($r);
  }
  
  // param: id, type (just in case has same id across social acc)
  public function remove_social_account($id, $type) {
    $id = (int) $id;
    if ($type != 'f' && !$type != 't') {
      // error: invalid type
      return false;
    }
    
    $q = "delete from user_social_acc where user_id='{user.id}' and social_id='$id' and type='$type'";
    mysql_query($q);
    return mysql_affected_rows();
  }
  
  // param: $param - array of user object to update and value in key=>value relationship
  //   these are: name, email, phone, blood_type and location
  // return: bool
  public function update_profile($param) {
    if (!count($param))
      return false;

    $location_id = get_location_id($location);
    if (!$location_id) {
      // error: invalid location
      return false;
    }
      
    $q = "update users set";
    $q .= $param['name'] ? " name='".escape($param['name'])."'" : '';
    $q .= $param['email'] ? " email='".escape($param['email'])."'" : '';
    $q .= $param['phone'] ? " phone='".escape($param['phone'])."'" : '';
    $q .= $param['blood_type'] ? " blood_type='".escape($param['blood_type'])."'" : '';
    $q .= $param['location'] ? " location='".escape($param['location_id'])."'" : '';
    $q .= " where user_id='{$_SESSION['user']['user_id']}'";
    
    $r = mysql_query($q);
    return mysql_affected_rows($r);
  }
  
  // return bool
  public function update_password($old, $new) {
    include '../lib/PasswordHash.php';
    $hash = new PasswordHash(8, TRUE);
    $password= $hash->HashPassword($new);
    $q = "select password from users where id='{$_SESSION['user']['user_id']}'";
    $r = mysql_query($q);
    list($dbpassword) = mysql_fetch_array($r);
    if($hash->CheckPassword($old, $dbpassword)) {
      $q = "update users set password='$password' where id='{user.id}'";
      $r = mysql_query($q);
      if ($r) {
        return true;
      } else {
        // error = "An internal error has occured. Try again later.";
        return false;
      }
    }
    else{
      // error = 'Old password does not match!';
    }
    
    return false;
  }
  
  // param: $source: 't' (twitter), 'g' (gravatar) or 'f' (facebook)
  // return: bool
  public function set_avatar($source) {
    switch ($source) {
      case 'g':
        $avatar = get_gravatar($_SESSION['email']);
        break;
      case 't':
        $q = "select avatar from user_social_acc where user_id='{$_SESSION['user']['user_id']}' and type='t'";
        $r = mysql_query($q);
        list($avatar) = mysql_fetch_array($r); 
        break;
      case 'f':
        $q = "select avatar from user_social_acc where user_id='{$_SESSION['user']['user_id']}' and type='f'";
        $r = mysql_query($q);
        list($avatar) = mysql_fetch_array($r); 
        break;
      default:
        return false;
        break;
    }
    
    mysql_query("update users set avatar='$avatar' where user_id='{$_SESSION['user']['user_id']}'");
    return mysql_affected_rows();
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
    $status = (int) $status;
    mysql_query("update users set status='$status' where user_id='{$_SESSION['user']['user_id']}'");
    return mysql_affected_rows();
  }
  
  // Delete account
  public function delete_account() {
    mysql_query("delete from users where user_id='{$_SESSION['user']['user_id']}'");
    return mysql_affected_rows();
  }

}
?>