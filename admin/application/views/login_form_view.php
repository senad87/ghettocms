<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>4M Login</title>
<link href="<?php echo base_url(); ?>application/css/style.css" rel="stylesheet" type="text/css" /> 
</head>
<body>
<div class="login-box">
	<h2>4M Administration login</h2>
	<?php echo validation_errors('<div class="error">', '</div>'); ?>
	<?php if(isset($wrong_username_or_pass)) {?>
		<div class="error"><?php echo $wrong_username_or_pass; ?></div>
	<?php } ?>
	<form method="post" action="<?php echo base_url();?>access/login">
		<label for="parent_category"><strong>User name:</strong></label><br />
		<input class="lform" type="text" name="username"/><br /><br />
		<label for="category_name"><strong>Password:</strong></label><br />
		<input class="lform" type="password" name="password"/><br /><br />
		<input class="button-1"  type="submit" value="Login">
	</form>
</div>    
</body>
</html>