<style>
#shortcode_amort_calc label {
	display: block;
}
</style>
<form method="post" name="shortcode_amort_calc" id="shortcode_amort_calc" >
	<table>
	<tr><td colspan="3"><?php echo (isset($data['message'])?$data['message']:""); ?></td></tr>
		<tr>
			<td><label for="shortcode_principle">Principal</label><input type="text" name="shortcode_principle" id="shortcode_principle" value="<?php echo (isset($data['shortcode_principle'])?$data['shortcode_principle']:""); ?>" pattern="^\$?(([1-9](\d*|\d{0,2}(,\d{3})*))|0)(\.\d{1,2})?$"></td>
			<td><label for="shortcode_rate">Annual Interest Rate</label><input type="text" name="shortcode_rate" value="<?php echo (isset($data['shortcode_rate'])?$data['shortcode_rate']:""); ?>" step="0.001" min="0.001" max="99.999" type="number"></td>
			<td><label for="shortcode_balloon">Balloon Payment</label><input type="text" name="shortcode_balloon" value="<?php echo (isset($data['shortcode_balloon'])?$data['shortcode_balloon']:""); ?>" pattern="^\$?(([1-9](\d*|\d{0,2}(,\d{3})*))|0)(\.\d{1,2})?$"></td>
		</tr>
		<tr>
			<td><label for="shortcode_num_payments_year">Payments Per Year</label><input type="number" name="shortcode_num_payments_year" value="<?php echo (isset($data['shortcode_num_payments_year'])?$data['shortcode_num_payments_year']:""); ?>"></td>
			<td><label for="shortcode_num_reg_payments">Number of Regular Payments</label><input type="number" name="shortcode_num_reg_payments" value="<?php echo (isset($data['shortcode_num_reg_payments'])?$data['shortcode_num_reg_payments']:""); ?>"></td>
			<td><label for="shortcode_payment_amount">Payment Amount</label><input type="text" name="shortcode_payment_amount" value="<?php echo (isset($data['shortcode_payment_amount'])?$data['shortcode_payment_amount']:""); ?>" pattern="^\$?(([1-9](\d*|\d{0,2}(,\d{3})*))|0)(\.\d{1,2})?$"></td>
		</tr>
		<tr>
			<td></td>
			<td><input type="hidden" name="action" value="process_form"></td>
			<td><input type="submit" name="shortcode_submit_amort"></td>
	</table>
</form>
<?php if (isset($data['a'])) {?>
<table>
	<tr>
		<td>Principal barrowed:</td>
		<td><?php echo $data['a']->format("principle"); ?></td>
		<td>Annual Payments:</td>
		<td><?php echo $data['a']->format("peryear"); ?></td>
	</tr>
	<tr>
		<td>Regular Payment amount:</td>
		<td><?php echo $data['a']->format("payment"); ?></td>
		<td>Total Payments:</td>
		<td><?php echo $data['a']->format("text_years"); ?></td>
	</tr>
	<tr>
		<td>Final Balloon Payment:</td>
		<td><?php echo $data['a']->format("balloon"); ?></td>
		<td>Annual interest rate:</td>
		<td><?php echo $data['a']->format("annual_rate"); ?></td>
	</tr>
	<tr>
		<td>Interest-only payment:</td>
		<td><?php echo $data['a']->format("interest_only"); ?></td>
		<td>Periodic interest rate:</td>
		<td><?php echo $data['a']->format("periodic_rate"); ?></td>
	</tr>
	<tr>
		<td>*Total Repaid:</td>
		<td><?php echo $data['a']->format("total_repaid"); ?></td>
		<td>Total interest paid as a percentage of Principal:</td>
		<td><?php echo $data['a']->format("interest_percentage"); ?></td>
	</tr>
	<tr>
		<td>*Total Interest Paid:</td>
		<td><?php echo $data['a']->format("total_interest"); ?></td>
		<td></td>
		<td></td>
	</tr>
</table>
<?php } ?>