<?php 
class Amort {
	private $_prin, $_rate, $_balloon=0, $_peryear, $_numpay, $_payment, $_years, $_annual_rate, $_total_repaid, $_calculated, $_err;
	function __construct($prin, $rate, $balloon, $peryear, $numpay, $payamt){
		$this->_prin = $this->n($prin);
		$this->_rate = $this->n($rate);
		$this->_balloon = $this->n($balloon);
		$this->_peryear = $this->n($peryear);
		$this->_numpay = $this->n($numpay);
		$this->_payment=  $this->n($payamt) ;
		if ($this->_peryear > 0) $this->_years = $this->n(($this->_numpay + (empty($balloon)?0:1)) / $this->_peryear);
		if ($this->_rate > 0 || $this->_payment > 0) {
			if (empty($this->_rate)){
				$this->_calculated = "rate";
				$this->_calcRate();
			} else if (empty($_payment)){
				$this->_calculated = "payment";
				$this->_calcPayment();
			}
			$this->_total_repaid=  round((($this->_payment* $this->_numpay) + $this->_balloon ), 2, PHP_ROUND_HALF_UP);
		} else {
			$this->_err = __("Invalid Input", 'ti');
		}
	}
	
	function validates(){
		if ($this->_err) return $this->_err;
		if (!($this->_prin > 0)) return __("Principle must be greater than zero", 'ti');
		if (!($this->_rate > 0) && !($this->_rate < 100)) return __("Invalid Annual Interest Rate", 'ti');
		if (!($this->_peryear > 0)) return __("Payments Per Year must be greater than zero", 'ti');
		if (!($this->_numpay > 0)) return __("Number of Regular Payments must be greater than zero", 'ti');
		if (!($this->_payment > 0)) return __("Payment must be greater than zero", 'ti');
		return true;
	}
	
	
	function _calcRate(){
		$min_rate = 0; $max_rate = 100;
		while ($min_rate < $max_rate - 0.0001){
			$mid_rate = ($min_rate + $max_rate) / 2;
			$J = $mid_rate /1200;
			$guessed_pmt = ($this->_prin -($this->_balloon/(1+$J)**$this->_numpay) )* $J/ (1 - (1+$J)** -$this->_numpay);
			if ($guessed_pmt > $this->_payment){
				$max_rate = $mid_rate;
			} else {
				$min_rate = $mid_rate;
			}
		}
		$this->_rate = $mid_rate;
	}
	
	function _calcPayment(){
		if ($this->_peryear > 0 && $this->_numpay > 0) $this->_payment= ($this->_prin - ($this->_balloon/((1+(($this->_rate/100)/$this->_peryear))**$this->_numpay)) )* (($this->_rate/100)/$this->_peryear)/ (1 - (1+(($this->_rate/100)/$this->_peryear))**-$this->_numpay);
		if ($this->_peryear > 0 && $this->_numpay > 0) $this->_payment = $this->truncate(round($this->_payment, 2, PHP_ROUND_HALF_UP),2);
	}
	
	function truncate($val, $f="0")	{
		if(($p = strpos($val, '.')) !== false) {
			$val = floatval(substr($val, 0, $p + 1 + $f));
		}
		return $val;
	}
	
	function n($in){
		return floatval(str_replace([',','$'], ['',''], $in));
	}
	
	function get($field){
		switch($field){
			case "principle":
				return $this->_prin;
			case "rate":
				return $this->_rate;
			case "balloon":
				return (empty($this->_balloon)?0:$this->_balloon);
			case "peryear":
				return $this->_peryear;
			case "numpay":
				return $this->_numpay;
			case "payment":
				return $this->_payment;
			case "annual_rate":
				return $this->_annual_rate;
			case "interest_only":
				return $this->_prin * (($this->_rate/100)/$this->_peryear);
			case "periodic_rate":
				return $this->_rate/$this->_peryear;
			case "total_repaid":
				return $this->_total_repaid;
			case "total_interest":
				return $this->_total_repaid - $this->_prin;
			case "interest_percentage":
				return  ($this->get("total_interest") / $this->_prin)*100;
		}
	}
	
	function format($field, $len=2){
		switch($field){
			case "principle":
			case "balloon":
			case "payment":
			case "interest_only":
			case "total_repaid":
			case "total_interest":
				return "$".number_format($this->get($field),$len);
				
			case "rate":
			case "periodic_rate":
			case "annual_rate":
			case "interest_percentage":
				return number_format($this->get($field), $len)."%";
				
			case "peryear":
				return $this->get($field);
			case "text_years":
				return $this->_numpay+(($this->_balloon>0)?1:0). " (".number_format($this->_years, $len)." years)";
			default:
				return $this->get($field);
		}
	}
}