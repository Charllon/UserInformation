<?php
defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

class UserInfo_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->library( 'Geolocation' );
		$this->load->config( 'geolocation', true );
		$this->load->helper( 'url' );
		$this->load->library( 'user_agent' );
	}

	public function get_ip() {

		return $this->input->ip_address();
	}

	public function get_geolocation() {
		$config = $this->config->config['geolocation'];
		$ip     = $this->get_ip();
		$this->geolocation->initialize( $config );
		$this->geolocation->set_ip_address( $ip ); // IP to locate
		$this->geolocation->set_format( 'json' );
		// OR you can change the format within `config/geolocation.php` config file
		$result = json_decode( $this->geolocation->get_city(), true );

		$data = $result['cityName'] . ', ' .
		        $result['regionName'] . ', ' .
		        $result['countryName'];

		return $data;
	}

	public function get_browser() {
		$data['browser']        = $this->agent->browser();
		$data['browserVersion'] = $this->agent->version();
		$data['platform']       = $this->agent->platform();
//		$data['full_user_agent_string'] = $_SERVER['HTTP_USER_AGENT'];

		return $data;
	}
}
