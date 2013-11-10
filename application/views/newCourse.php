<?php
$name = array(
	'name'	=> 'name',
	'id'	=> 'name',
	'value'	=> set_value('name'),
	'maxlength'	=> 255,
	'size'	=> 30,
);
$website = array(
	'name'	=> 'website',
	'id'	=> 'website',
	'value'	=> set_value('website'),
	'maxlength'	=> 255,
	'size'	=> 30,
);
$startDate = array(
	'name'	=> 'startDate',
	'id'	=> 'startDate',
	'value'	=> set_value('startDate'),
	'maxlength'	=> 10,
	'size'	=> 30,
);
$endDate = array(
	'name'	=> 'endDate',
	'id'	=> 'endDate',
	'value'	=> set_value('endDate'),
	'maxlength'	=> 10,
	'size'	=> 30,
);
$captcha = array(
	'name'	=> 'captcha',
	'id'	=> 'captcha',
	'maxlength'	=> 8,
);
?>
<?php echo form_open("course/create"); ?>
<table>
	<tr>
		<td><?php echo form_label('Name', $name['id']); ?></td>
		<td><?php echo form_input($name); ?></td>
		<td style="color: red;"><?php echo form_error($name['name']); ?><?php echo isset($errors[$name['name']])?$errors[$name['name']]:''; ?></td>
	</tr>
        <tr>
		<td><?php echo form_label('Website', $website['id']); ?></td>
		<td><?php echo form_input($website); ?></td>
		<td style="color: red;"><?php echo form_error($website['name']); ?><?php echo isset($errors[$website['name']])?$errors[$website['name']]:''; ?></td>
	</tr>
        <tr>
		<td><?php echo form_label('Start Date (dd/mm/yyyy)', $startDate['id']); ?></td>
		<td><?php echo form_input($startDate); ?></td>
		<td style="color: red;"><?php echo form_error($startDate['name']); ?><?php echo isset($errors[$startDate['name']])?$errors[$startDate['name']]:''; ?></td>
	</tr>
	<tr>
		<td><?php echo form_label('End Date (dd/mm/yyyy)', $endDate['id']); ?></td>
		<td><?php echo form_input($endDate); ?></td>
		<td style="color: red;"><?php echo form_error($endDate['name']); ?><?php echo isset($errors[$endDate['name']])?$errors[$endDate['name']]:''; ?></td>
	</tr>
        <?php if($show_captcha) { ?>
	<tr>
		<td colspan="2">
			<div id="recaptcha_image"></div>
		</td>
		<td>
			<a href="javascript:Recaptcha.reload()">Get another CAPTCHA</a>
			<div class="recaptcha_only_if_image"><a href="javascript:Recaptcha.switch_type('audio')">Get an audio CAPTCHA</a></div>
			<div class="recaptcha_only_if_audio"><a href="javascript:Recaptcha.switch_type('image')">Get an image CAPTCHA</a></div>
		</td>
	</tr>
	<tr>
		<td>
			<div class="recaptcha_only_if_image">Enter the words above</div>
			<div class="recaptcha_only_if_audio">Enter the numbers you hear</div>
		</td>
		<td><input type="text" id="recaptcha_response_field" name="recaptcha_response_field" /></td>
		<td style="color: red;"><?php echo form_error('recaptcha_response_field'); ?></td>
		<?php echo $recaptcha_html; ?>
	</tr>
        <?php } ?>
</table>
<?php echo form_submit('newCourse', 'Create!'); ?>
<?php echo form_close(); ?>