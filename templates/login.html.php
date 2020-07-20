<div class="login-container">
	<h2>Login To Your Account</h2>
<form class="login-form" method="post" action="">
	<input type="text" placeholder="Email" id="email" name="email">
	<input type="password" id="password" name="password" placeholder="Password">
	<?php if (isset($error)):?>
	<div class="errors"><?=$error;?></div>
	<?php endif; ?>
	<input type="submit" name="login" value="Log in">
</form>
	<p>Don't have an account? <a href="index.php?instructor/register">Register Account</a></p>
</div>