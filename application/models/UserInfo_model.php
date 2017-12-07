<?php
defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

class UserInfo_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->library( 'Geolocation' );
		$this->load->config( 'geolocation', true );
		$this->load->helper('url');
		$this->load->library('user_agent');
	}

	public function geolocation() {
		$config = $this->config->config['geolocation'];
		$ip     = $this->input->ip_address();
		$this->geolocation->initialize( $config );
		$this->geolocation->set_ip_address( $ip ); // IP to locate
		$this->geolocation->set_format( 'json' );
		// OR you can change the format within `config/geolocation.php` config file
		$result = json_decode( $this->geolocation->get_city(), true );

		$location_address = $result['cityName'] . ', ' .
		                    $result['regionName'] . ', ' .
		                    $result['countryName'];

		$data['ip'] = $result['ipAddress'];
		$data['location'] = $location_address;

		return $data;
	}

	public function browser() {
		$data['browser'] = $this->agent->browser();
		$data['browserVersion'] = $this->agent->version();
		$data['platform'] = $this->agent->platform();
//		$data['full_user_agent_string'] = $_SERVER['HTTP_USER_AGENT'];

		return $data;
	}
}
