<?php
/*
Plugin Name:  Amortization Calculator
Plugin URI:   http://thompsoninnovations.com.
Description:  Basic Amortization Calculator
Version:      20171215
Author:       Davin Thompson
Author URI:   https://developer.wordpress.org/amortization
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
*/
require_once("amort.php");


Class AmortizationCalc {
	function show_shortcode($atts){
		$data = ['message' => ''];
		if (isset($_POST['shortcode_submit_amort'])){
			if (empty($_POST['shortcode_payment_amount']) && empty($_POST['shortcode_rate'])) {
				$data['message'] = "Please fill in 'Annual Intrest Rate' OR 'Payment Amount'";
				$data['shortcode_principle'] =$_POST['shortcode_principle'];
				$data['shortcode_balloon'] = $_POST['shortcode_balloon'];
				$data['shortcode_num_payments_year'] = $_POST['shortcode_num_payments_year'];
				$data['shortcode_num_reg_payments'] = $_POST['shortcode_num_reg_payments'];
			} else {
			$a = new Amort(
					$_POST['shortcode_principle'],
					$_POST['shortcode_rate'],
					$_POST['shortcode_balloon'],
					$_POST['shortcode_num_payments_year'],
					$_POST['shortcode_num_reg_payments'],
					$_POST['shortcode_payment_amount']);
			
				$data['shortcode_principle'] =$a->get('principle');
				$data['shortcode_rate'] = (empty($_POST['shortcode_rate'])?"":$a->get('rate'));
				$data['shortcode_balloon'] = $a->get('balloon');
				$data['shortcode_num_payments_year'] = $a->get("peryear");
				$data['shortcode_num_reg_payments'] = $a->get("numpay");
				$data['shortcode_payment_amount'] = (empty($_POST['shortcode_payment_amount'])?"":$a->get("payment"));
				$data['a']=$a;
			}
		} else {
			//defaults
			$data['shortcode_principle'] = 100000;
			$data['shortcode_balloon'] = 0;
			$data['shortcode_num_payments_year'] = 12;
			$data['shortcode_num_reg_payments'] = 360;
			
		}

		return $this->_processTemplate("inline_calc", $data);
	}
	
	private function _processTemplate($name, $data=array()){
		ob_start();
		if (file_exists( get_stylesheet_directory().$name.'.php')){
			require_once(plugin_dir_path(__FILE__).'templates/'.$name.'.php');
		} else if (file_exists(plugin_dir_path(__FILE__).'templates/'.$name.'.php')){
			require_once(plugin_dir_path(__FILE__).'templates/'.$name.'.php');
		} else {
			echo "Template $name not found";
		}
		$res = ob_get_contents();
		ob_end_clean();
		return $res;
	}
	
	private function process_form(){
		
	}
	
	function __construct(){
		add_shortcode("amortization_calc", [$this, 'show_shortcode']);
	}
}

new AmortizationCalc();