<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Course extends CI_Controller
{
        private $error = array();
        
    	function __construct()
	{
		parent::__construct();

		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('tank_auth');
                $this->load->model('livecode');
                $this->load->library('session');
                
                if (!$this->tank_auth->is_logged_in()) {									// logged in
			redirect('');
                }
	}
        
        function manage() {
            
            $this->load->view('manageCourse', $data);
        }
        
        function create() {
            $this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean|max_length[80]|alpha_dash');
            $this->form_validation->set_rules('website', 'Website', 'trim|required|xss_clean|max_length[255]|prep_url');
            $this->form_validation->set_rules('startDate', 'Start Date', 'trim|required|xss_clean|valid_date');
            $this->form_validation->set_rules('endDate', 'End Date', 'trim|required|xss_clean|valid_date[m/d/y,/]');
            $this->form_validation->set_rules('recaptcha_response_field', 'Confirmation Code', 'trim|xss_clean|required|callback__check_recaptcha');
            $data['errors'] = array();
            $data['show_captcha'] = TRUE;
            $data['recaptcha_html'] = $this->_create_recaptcha();
            if ($this->form_validation->run()) {								// validation ok
                $info['name'] = $this->form_validation->set_value('name');
                $info['website'] = $this->form_validation->set_value('website');
                $info['startDate'] = $this->toDate($this->form_validation->set_value('startDate'))->format("Y-m-d H:i:s");
                $info['endDate'] = $this->toDate($this->form_validation->set_value('endDate'))->format("Y-m-d H:i:s");
                $info['teacher'] = $this->session->userdata('user_id');
                if (!is_null($data = $this->livecode->create($info))) {									// success
                    redirect('');
                } else {
                        $this->_show_message($this->lang->line("database issue, form failed"));
                }
                $data['show_captcha'] = FALSE;
                //$data['recaptcha_html'] = $this->_create_recaptcha();
            }
            $this->load->view('newCourse', $data);
        }
        
        function toDate($toDate) {
            return new DateTime($toDate);
        }
        
        /**
	 * Create reCAPTCHA JS and non-JS HTML to verify user as a human
	 *
	 * @return	string
	 */
	function _create_recaptcha()
	{
		$this->load->helper('recaptcha');
                $this->lang->load('tank_auth');

		// Add custom theme so we can get only image
		$options = "<script>var RecaptchaOptions = {theme: 'custom', custom_theme_widget: 'recaptcha_widget'};</script>\n";

		// Get reCAPTCHA JS and non-JS HTML
		$html = recaptcha_get_html($this->config->item('recaptcha_public_key', 'tank_auth'));

		return $options.$html;
	}

	/**
	 * Callback function. Check if reCAPTCHA test is passed.
	 *
	 * @return	bool
	 */
	function _check_recaptcha()
	{
		$this->load->helper('recaptcha');

		$resp = recaptcha_check_answer($this->config->item('recaptcha_private_key', 'tank_auth'),
				$_SERVER['REMOTE_ADDR'],
				$_POST['recaptcha_challenge_field'],
				$_POST['recaptcha_response_field']);

		if (!$resp->is_valid) {
			$this->form_validation->set_message('_check_recaptcha', $this->lang->line('auth_incorrect_captcha'));
			return FALSE;
		}
		return TRUE;
	}

}