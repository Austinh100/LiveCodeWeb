<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation {

 function __construct(){
  parent::__construct();
 }

    /**
    * @desc Validates a date format
    * @params format,delimiter
    * e.g. d/m/y,/ or y-m-d,-
    */
    function valid_date($str)
    {
        $str = new DateTime($str);
        if($str = $str->format('n@j@Y')) { 
          $arr = explode("@",$str);     // splitting the array
          $yy = intval($arr[2]);            // first element of the array is year
          $mm = intval($arr[0]);            // second element is month
          $dd = intval($arr[1]);            // third element is days
          return checkdate($mm, $dd, $yy); 
       } else {
          $CI =&get_instance();
          $CI->form_validation->set_message('valid_date', "The date format is invalid. Use mm/dd/yyyy");
          return FALSE;
       }
    }
}
?>