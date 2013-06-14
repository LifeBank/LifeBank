<?php

class Core {

    public $msgs = array();
    public $showMsg;
    public $action = null;
    public $do = null;
    public $year = null;
    public $month = null;
    public $day = null;

    /**
     * Core::__construct()
     * 
     * @return
     */
    public function __construct() {
        $this->getAction();
        $this->getDo();

        ($this->dtz) ? date_default_timezone_set($this->dtz) : date_default_timezone_set('GMT');

        $this->year = (get('year')) ? get('year') : strftime('%Y');
        $this->month = (get('month')) ? get('month') : strftime('%m');
        $this->day = (get('day')) ? get('day') : strftime('%d');

        return mktime(0, 0, 0, $this->month, $this->day, $this->year);
    }

    /**
     * Core::getShortDate()
     * 
     * @return
     */
    public function getShortDate() {
        $arr = array(
            '%m-%d-%Y' => '12-21-2009 (MM-DD-YYYY)',
            '%e-%m-%Y' => '21-12-2009 (D-MM-YYYY)',
            '%m-%e-%y' => '12-21-09 (MM-D-YY)',
            '%e-%m-%y' => '21-12-09 (D-MM-YY)',
            '%b %d %Y' => 'Dec 21 2009'
        );

        $shortdate = '';
        foreach ($arr as $key => $val) {
            if ($key == $this->short_date) {
                $shortdate .= "<option selected=\"selected\" value=\"" . $key . "\">" . $val . "</option>\n";
            } else
                $shortdate .= "<option value=\"" . $key . "\">" . $val . "</option>\n";
        }
        unset($val);
        return $shortdate;
    }

    /**
     * Core::getLongDate()
     * 
     * @return
     */
    public function getLongDate() {
        $arr = array(
            '%B %d, %Y' => 'December 21, 2009',
            '%d %B %Y %H:%M' => '21 December 2009 19:00',
            '%B %d, %Y %I:%M %p' => 'December 21, 2009 4:00 am',
            '%A %d %B, %Y' => 'Monday 21 December, 2009',
            '%A %d %B, %Y %H:%M' => 'Monday 21 December 2009 07:00',
            '%a %d, %B' => 'Mon. 12, December'
        );

        $longdate = '';
        foreach ($arr as $key => $val) {
            if ($key == $this->long_date) {
                $longdate .= "<option selected=\"selected\" value=\"" . $key . "\">" . $val . "</option>\n";
            } else
                $longdate .= "<option value=\"" . $key . "\">" . $val . "</option>\n";
        }
        unset($val);
        return $longdate;
    }

    /**
     * Core::monthList()
     * 
     * @return
     */
    public function monthList() {
        $selected = is_null(get('month')) ? strftime('%m') : get('month');

        $arr = array(
            '01' => _JAN,
            '02' => _FEB,
            '03' => _MAR,
            '04' => _APR,
            '05' => _MAY,
            '06' => _JUN,
            '07' => _JUL,
            '08' => _AUG,
            '09' => _SEP,
            '10' => _OCT,
            '11' => _NOV,
            '12' => _DEC
        );

        $monthlist = '';
        foreach ($arr as $key => $val) {
            $monthlist .= "<option value=\"$key\"";
            $monthlist .= ($key == $selected) ? ' selected="selected"' : '';
            $monthlist .= ">$val</option>\n";
        }
        unset($val);
        return $monthlist;
    }

    /**
     * Core::weekList()
     * 
     * @return
     */
    public function weekList() {
        $arr = array(
            '1' => _SUNDAY,
            '2' => _MONDAY,
            '3' => _TUESDAY,
            '4' => _WEDNESDAY,
            '5' => _THURSDAY,
            '6' => _FRIDAY,
            '7' => _SATURDAY
        );

        $weeklist = '';
        foreach ($arr as $key => $val) {
            if ($key == $this->weekstart) {
                $weeklist .= "<option selected=\"selected\" value=\"" . $key . "\">" . $val . "</option>\n";
            } else
                $weeklist .= "<option value=\"" . $key . "\">" . $val . "</option>\n";
        }
        unset($val);
        return $weeklist;
    }

    /**
     * Core::yearList()
     *
     * @param mixed $start_year
     * @param mixed $end_year
     * @return
     */
    function yearList($start_year, $end_year) {
        $selected = is_null(get('year')) ? date('Y') : get('year');
        $r = range($start_year, $end_year);

        $select = '';
        foreach ($r as $year) {
            $select .= "<option value=\"$year\"";
            $select .= ($year == $selected) ? ' selected="selected"' : '';
            $select .= ">$year</option>\n";
        }
        return $select;
    }

    /**
     * Core::getTimezones()
     * 
     * @return
     */
    public function getTimezones() {
        $data = '';
        $tzone = DateTimeZone::listIdentifiers();
        $data .='<select name="dtz" style="width:200px" class="custombox">';
        foreach ($tzone as $zone) {
            $selected = ($zone == $this->dtz) ? ' selected="selected"' : '';
            $data .= '<option value="' . $zone . '"' . $selected . '>' . $zone . '</option>';
        }
        $data .='</select>';
        return $data;
    }

    /**
     * Core::in_url()
     * 
     * @param mixed $data
     * @return
     */
    public function in_url($data) {

        return str_replace("../uploads/", "uploads/", $data);
    }

    /**
     * Core::out_url()
     * 
     * @param mixed $data
     * @return
     */
    public function out_url($data) {
        return str_replace("uploads/", "../uploads/", $data);
    }

    /**
     * getRowById()
     * 
     * @param mixed $table
     * @param mixed $id
     * @param bool $and
     * @param bool $is_admin
     * @return
     */
    public function getRowById($table, $id, $and = false, $is_admin = true) {
        global $db;
        $id = sanitize($id, 8, true);
        if ($and) {
            $sql = "SELECT * FROM " . (string) $table . " WHERE id = '" . $db->escape((int) $id) . "' AND " . $db->escape($and) . "";
        } else
            $sql = "SELECT * FROM " . (string) $table . " WHERE id = '" . $db->escape((int) $id) . "'";

        $row = $db->first($sql);

        if ($row) {
            return $row;
        } else {
            if ($is_admin)
                $this->error("You have selected an Invalid Id - #" . $id, "Core::getRowById()");
        }
    }

    /**
     * Core::setActiveInactive()
     * 
     * @param mixed $table
     * @param mixed $redirect
     * @return
     */
    public function setActiveInactive($table, $redirect) {
        global $db;

        if (isset($_GET['publish'])) {
            $id = intval($_GET['id']);

            $data['active'] = intval($_GET['publish']);

            $db->update($table, $data, "id='" . $id . "'");
            if ($db->affected() == 1)
                redirect_to($redirect);
        }
    }

    /**
     * Core::msgAlert()
     * 
     * @param mixed $msg
     * @param bool $fader
     * @param bool $altholder
     * @return
     */
    public function msgAlert($msg, $fader = true, $altholder = false) {
        $this->showMsg = "<div class=\"msgAlert\">" . $msg . "</div>";
        if ($fader == true)
            $this->showMsg .= "<script type=\"text/javascript\"> 
		  // <![CDATA[
			setTimeout(function() {       
			  $(\".msgAlert\").customFadeOut(\"slow\",    
			  function() {       
				$(\".msgAlert\").remove();  
			  });
			},
			4000);
		  // ]]>
		  </script>";

        print ($altholder) ? '<div id="alt-msgholder">' . $this->showMsg . '</div>' : $this->showMsg;
    }

    /**
     * Core::msgOk()
     * 
     * @param mixed $msg
     * @param bool $fader
     * @param bool $altholder
     * @return
     */
    public function msgOk($msg, $fader = true, $altholder = false) {
        $this->showMsg = "<div class=\"msgOk\">" . $msg . "</div>";
        if ($fader == true)
            $this->showMsg .= "<script type=\"text/javascript\"> 
		  // <![CDATA[
			setTimeout(function() {       
			  $(\".msgOk\").customFadeOut(\"slow\",    
			  function() {       
				$(\".msgOk\").remove();  
			  });
			},
			4000);
		  // ]]>
		  </script>";

        print ($altholder) ? '<div id="alt-msgholder">' . $this->showMsg . '</div>' : $this->showMsg;
    }

    /**
     * Core::msgError()
     * 
     * @param mixed $msg
     * @param bool $fader
     * @param bool $altholder
     * @return
     */
    public function msgError($msg, $fader = true, $altholder = false) {
        $this->showMsg = "<div class=\"msgError\">" . $msg . "</div>";
        if ($fader == true)
            $this->showMsg .= "<script type=\"text/javascript\"> 
		  // <![CDATA[
			setTimeout(function() {       
			  $(\".msgError\").customFadeOut(\"slow\",    
			  function() {       
				$(\".msgError\").remove();  
			  });
			},
			4000);
		  // ]]>
		  </script>";

        print ($altholder) ? '<div id="alt-msgholder">' . $this->showMsg . '</div>' : $this->showMsg;
    }

    /**
     * msgInfo()
     * 
     * @param mixed $msg
     * @param bool $fader
     * @param bool $altholder
     * @return
     */
    public function msgInfo($msg, $fader = true, $altholder = false) {
        $this->showMsg = "<div class=\"msgInfo\">" . $msg . "</div>";
        if ($fader == true)
            $this->showMsg .= "<script type=\"text/javascript\"> 
		  // <![CDATA[
			setTimeout(function() {       
			  $(\".msgInfo\").customFadeOut(\"slow\",    
			  function() {       
				$(\".msgInfo\").remove();  
			  });
			},
			4000);
		  // ]]>
		  </script>";

        print ($altholder) ? '<div id="alt-msgholder">' . $this->showMsg . '</div>' : $this->showMsg;
    }

    /**
     * Core::msgStatus()
     * 
     * @return
     */
    public function msgStatus() {
        $this->showMsg = "<div class=\"msgError\">" . _SYSTEM_ERR . "<ul class=\"error\">";
        foreach ($this->msgs as $msg) {
            $this->showMsg .= "<li>" . $msg . "</li>\n";
        }
        $this->showMsg .= "</ul></div>";

        return $this->showMsg;
    }

    /**
     * doForm()
     * 
     * @param mixed $data
     * @param string $url
     * @param integer $reset
     * @param integer $clear
     * @param string $form_id
     * @param string $msgholder
     * @return
     */
    public function doForm($data, $url = "controller.php", $reset = 0, $clear = 0, $form_id = "admin_form", $msgholder = "msgholder") {
        $display = '
		  <script type="text/javascript">
		  // <![CDATA[
			  $(document).ready(function () {
				  var options = {
					  target: "#' . $msgholder . '",
					  beforeSubmit:  showLoader,
					  success: showResponse,
					  url: "' . $url . '",
					  resetForm : ' . $reset . ',
					  clearForm : ' . $clear . ',
					  data: {
						  ' . $data . ': 1
					  }
				  };
				  $("#' . $form_id . '").ajaxForm(options);
			  });
			  
			  function showLoader() {
				  $("#loader").fadeIn(200);
			  }
		  
			  function hideLoader() {
				  $("#loader").fadeOut(200);
			  };	
			  		  
			  function showResponse(msg) {
				  hideLoader();
				  $(this).html(msg);
				  $("html, body").animate({
					  scrollTop: 0
				  }, 600);
			  }
			  ';
        $display .='
		  // ]]>
		  </script>';

        print $display;
    }

    /**
     * Core::doDelete()
     * 
     * @param mixed $title
     * @param mixed $varpost
     * @param string $attr
     * @param string $id
     * @param string $url
     * @return
     */
    public static function doDelete($title, $varpost, $url = "ajax.php", $attr = 'item_', $id = 'a.delete') {
        $display = "
		  <script type=\"text/javascript\"> 
		  // <![CDATA[
		  $(document).ready(function () {
			  $('.container').on('click', '" . $id . "', function () {
				  var id = $(this).attr('id').replace('" . $attr . "', '')
				  var parent = $(this).parent().parent();
				  var title = $(this).attr('data-title');
				  var text = '<div><span class=\"ui-icon ui-icon-alert\" style=\"float:left; margin:0 7px 20px 0;\"></span>" . _DEL_CONFIRM . "</div>';
				  $.confirm({
					  title: '" . $title . "',
					  message: text,
					  buttons: {
						  '" . _DELETE . "': {
							  'class': 'yes',
							  'action': function () {
								  $.ajax({
									  type: 'post',
									  url: '" . $url . "',
									  data: '" . $varpost . "=' + id + '&title=' + encodeURIComponent(title),
									  beforeSend: function () {
										  parent.animate({
											  'backgroundColor': '#FFBFBF'
										  }, 400);
									  },
									  success: function (msg) {
										  parent.fadeOut(400, function () {
											  parent.remove();
										  });
										  $('html, body').animate({
											  scrollTop: 0
										  }, 600);
										  $(\"#msgholder\").html(msg);
									  }
								  });
							  }
						  },
						  '" . _CANCEL . "': {
							  'class': 'no',
							  'action': function () {}
						  }
					  }
				  });
			  });
		  });
		  // ]]>
		  </script>";

        print $display;
    }

    /**
     * Core::checkTable()
     * 
     * @param mixed $tablename
     * @return
     */
    function checkTable($tablename) {
        global $db;
        return $db->numrows($db->query("SHOW TABLES LIKE '" . $tablename . "'")) ? true : false;
    }

    /**
     * Core::ooops()
     * 
     * @return
     */
    public static function ooops() {
        $the_error = "<div class=\"msgError\" style=\"color:#444;width:400px;margin-left:auto;margin-right:auto;border:1px solid #C3C3C3;font-family:Arial, Helvetica, sans-serif;font-size:13px;padding:10px;background:#f2f2f2;border-radius:5px;text-shadow:1px 1px 0 #fff\">";
        $the_error .= "<h4 style=\"font-size:18px;margin:0;padding:0\">Oops!!!</h4>";
        $the_error .= "<p>Something went wrong. Looks like the page you're looking for was moved or never existed. Make sure you typed the correct URL or followed a valid link.</p>";
        $the_error .= "<p>&lsaquo; <a href=\"javascript:history.go(-1)\" style=\"color:#0084FF;\"><strong>Go Back to previous page</strong></a></p>";
        $the_error .= '</div>';
        print $the_error;
        die();
    }

    /**
     * Core::error()
     * 
     * @param mixed $msg
     * @param mixed $source
     * @return
     */
    public function error($msg, $source) {

        $the_error = "<div class=\"msgError\">";
        $the_error .= "<span>System ERROR!</span><br />";
        $the_error .= "DB Error: " . $msg . " <br /> More Information: <br />";
        $the_error .= "<ul>";
        $the_error .= "<li> Date : " . date("F j, Y, g:i a") . "</li>";
        $the_error .= "<li> Function: " . $source . "</li>";
        $the_error .= "<li> Script: " . $_SERVER['REQUEST_URI'] . "</li>";
        $the_error .= "<li>&lsaquo; <a href=\"javascript:history.go(-1)\"><strong>Go Back to previous page</strong></a></li>";
        $the_error .= '</ul>';
        $the_error .= '</div>';
        print $the_error;
        die();
    }

    /**
     * Core::getAction()
     * 
     * @return
     */
    private function getAction() {
        if (isset($_GET['action'])) {
            $action = ((string) $_GET['action']) ? (string) $_GET['action'] : false;
            $action = sanitize($action);

            if ($action == false) {
                $this->error("You have selected an Invalid Action Method", "Core::getAction()");
            } else
                return $this->action = $action;
        }
    }

    /**
     * Core::getDo()
     * 
     * @return
     */
    private function getDo() {
        if (isset($_GET['do'])) {
            $do = ((string) $_GET['do']) ? (string) $_GET['do'] : false;
            $do = sanitize($do);

            if ($do == false) {
                $this->error("You have selected an Invalid Do Method", "Core::getDo()");
            } else
                return $this->do = $do;
        }
    }

}

?>