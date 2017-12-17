<?php
/*
Plugin Name:  Amortization Calculator
Plugin URI:   http://thompsoninnovations.com
Description:  Basic Amortization Calculator
Version:      20171217
Author:       Davin Thompson
Author URI:   http://thompsoninnovations.com
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
*/
require_once("amort.php");


Class AmortizationCalc {
	function show_shortcode($atts){
		$data = ['message' => ''];
		if (isset($_POST['shortcode_submit_amort'])){
			if (empty($_POST['shortcode_payment_amount']) && empty($_POST['shortcode_rate'])) {
				$data['message'] = __("Please fill in 'Annual Intrest Rate' OR 'Payment Amount'", 'ti');
				$data['shortcode_principle'] = $this->_val('float', $_POST['shortcode_principle']);
				$data['shortcode_balloon'] = $this->_val('float', $_POST['shortcode_balloon']);
				$data['shortcode_num_payments_year'] = $this->_val('int', $_POST['shortcode_num_payments_year']);
				$data['shortcode_num_reg_payments'] = $this->_val('int', $_POST['shortcode_num_reg_payments']);
			} else {
			$a = new Amort(
					$this->_val('float', $_POST['shortcode_principle']),
					$this->_val('float', $_POST['shortcode_rate']),
					$this->_val('float', $_POST['shortcode_balloon']),
					$this->_val('int', $_POST['shortcode_num_payments_year']),
					$this->_val('int', $_POST['shortcode_num_reg_payments']),
					$this->_val('float', $_POST['shortcode_payment_amount']));
			
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
		if (file_exists( trailingslashit(get_stylesheet_directory()).$name.'.php')){
			require_once(trailingslashit(get_stylesheet_directory()).$name.'.php');
		} else if (file_exists(trailingslashit(plugin_dir_path(__FILE__)).'templates/'.$name.'.php')){
			require_once(trailingslashit(plugin_dir_path(__FILE__)).'templates/'.$name.'.php');
		} else {
			throw new Exception("AmortizationCalc: Template $name not found");
		}
		$res = ob_get_contents();
		ob_end_clean();
		//ensure there are no inconsistancies in our template
		return  balanceTags(ent2ncr($res));
	}
	
	private function _val($type, $val){
		//add an extra layer of validation before passing into calculator class
		$val = sanitize_text_field($val);
		switch ($type){
			case "float":
				return floatval(str_replace([',','$'], ['',''], $val));
			case "int":
			default:
				return absint(intval($val,10));
		}
	}
	
	private function _addStylesheet($name){
		//enqueue a stylesheet only if there is one 
		if (file_exists( trailingslashit(get_stylesheet_directory()).$name.'.css')){
			$css = trailingslashit(get_stylesheet_directory()).$name.'.css';
		} else if (file_exists(trailingslashit(plugin_dir_path(__FILE__)).'templates/'.$name.'.css')){
			$css = trailingslashit(plugin_dir_url(__FILE__)).'templates/'.$name.'.css';
		}
		if (isset($css)){
			add_action( 'wp_enqueue_scripts', function() use($name, $css){
				wp_enqueue_style($name, $css);
			} );
		}
	}
	
	function __construct(){
		add_shortcode("amortization_calc", [$this, 'show_shortcode']);
		$this->_addStylesheet("inline_calc");

	}
}

new AmortizationCalc();