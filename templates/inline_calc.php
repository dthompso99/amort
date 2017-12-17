<form method="post" name="shortcode_amort_calc" id="shortcode_amort_calc" >
	<table>
	<tr><td colspan="3"><?php echo (isset($data['message'])?$data['message']:""); ?></td></tr>
		<tr>
			<td><label for="shortcode_principle"><?php echo __("Principal", 'ti'); ?></label><input type="text" name="shortcode_principle" id="shortcode_principle" value="<?php echo (isset($data['shortcode_principle'])?$data['shortcode_principle']:""); ?>" pattern="^\$?(([1-9](\d*|\d{0,2}(,\d{3})*))|0)(\.\d{1,2})?$"></td>
			<td><label for="shortcode_rate"><?php echo __("Annual Interest Rate", 'ti'); ?></label><input type="text" name="shortcode_rate" value="<?php echo (isset($data['shortcode_rate'])?$data['shortcode_rate']:""); ?>" step="0.001" min="0.001" max="99.999" type="number"></td>
			<td><label for="shortcode_balloon"><?php echo __("Balloon Payment", 'ti'); ?></label><input type="text" name="shortcode_balloon" value="<?php echo (isset($data['shortcode_balloon'])?$data['shortcode_balloon']:""); ?>" pattern="^\$?(([1-9](\d*|\d{0,2}(,\d{3})*))|0)(\.\d{1,2})?$"></td>
		</tr>
		<tr>
			<td><label for="shortcode_num_payments_year"><?php echo __("Payments Per Year", 'ti'); ?></label><input type="number" name="shortcode_num_payments_year" value="<?php echo (isset($data['shortcode_num_payments_year'])?$data['shortcode_num_payments_year']:""); ?>"></td>
			<td><label for="shortcode_num_reg_payments"><?php echo __("Number of Regular Payments", 'ti'); ?></label><input type="number" name="shortcode_num_reg_payments" value="<?php echo (isset($data['shortcode_num_reg_payments'])?$data['shortcode_num_reg_payments']:""); ?>"></td>
			<td><label for="shortcode_payment_amount"><?php echo __("Payment Amount", 'ti'); ?></label><input type="text" name="shortcode_payment_amount" value="<?php echo (isset($data['shortcode_payment_amount'])?$data['shortcode_payment_amount']:""); ?>" pattern="^\$?(([1-9](\d*|\d{0,2}(,\d{3})*))|0)(\.\d{1,2})?$"></td>
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
		<td><?php echo __("Principal barrowed", 'ti'); ?>:</td>
		<td><?php echo $data['a']->format("principle"); ?></td>
		<td><?php echo __("Annual Payments", 'ti'); ?>:</td>
		<td><?php echo $data['a']->format("peryear"); ?></td>
	</tr>
	<tr>
		<td><?php echo __("Regular Payment amount", 'ti'); ?>:</td>
		<td><?php echo $data['a']->format("payment"); ?></td>
		<td><?php echo __("Total Payments", 'ti'); ?>:</td>
		<td><?php echo $data['a']->format("text_years"); ?></td>
	</tr>
	<tr>
		<td><?php echo __("Final Balloon Payment", 'ti'); ?>:</td>
		<td><?php echo $data['a']->format("balloon"); ?></td>
		<td><?php echo __("Annual interest rate", 'ti'); ?>:</td>
		<td><?php echo $data['a']->format("rate"); ?></td>
	</tr>
	<tr>
		<td><?php echo __("Interest-only payment", 'ti'); ?>:</td>
		<td><?php echo $data['a']->format("interest_only"); ?></td>
		<td><?php echo __("Periodic interest rate", 'ti'); ?>:</td>
		<td><?php echo $data['a']->format("periodic_rate"); ?></td>
	</tr>
	<tr>
		<td>*<?php echo __("Total Repaid", 'ti'); ?>:</td>
		<td><?php echo $data['a']->format("total_repaid"); ?></td>
		<td><?php echo __("Total interest paid as a percentage of Principal", 'ti'); ?>:</td>
		<td><?php echo $data['a']->format("interest_percentage"); ?></td>
	</tr>
	<tr>
		<td>*<?php echo __("Total Interest Paid", 'ti'); ?>:</td>
		<td><?php echo $data['a']->format("total_interest"); ?></td>
		<td></td>
		<td></td>
	</tr>
</table>
<?php } ?>