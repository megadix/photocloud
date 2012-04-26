<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?>

<h2>Login</h2>
<?php
echo form_open('login/validate_credentials', array('class' => 'form-vertical'));
?>
<label>Username</label>
<?php echo form_input('username'); ?>
<label>Password</label>
<?php echo form_password('password'); ?>
<br /><button type="submit" class="btn">Login</button>
<?php echo form_close(); ?>