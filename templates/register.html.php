<div class="login-container">
	<h2>Create Your Account</h2>
<form class="login-form" action="" method="post">
    <input name="instructor[firstname]" id="firstname" type="text" value="<?=$instructor['firstname'] ?? ''?>" placeholder="First Name">
    <input name="instructor[lastname]" id="lastname" type="text" value="<?=$instructor['lastname'] ?? ''?>" placeholder="Last Name">
    <input name="instructor[email]" id="email" type="text" value="<?=$instructor['email'] ?? ''?>" placeholder="Email">
	<input name="instructor[password]" id="password" type="password" value="<?=$instructor['password'] ?? ''?>" placeholder="Password">
	<?php if (!empty($errors)): ?>
	<div class="errors">
		<p>Your account could not be created, please check the following:</p>
		<ul>
		<?php foreach ($errors as $error): ?>
			<li><?= $error ?></li>
		<?php endforeach; 	?>
		</ul>
	</div>
<?php endif; ?>
	<input type="submit" name="submit" value="Register">
</form>
<p>Already have an account? <a href="index.php?login">Log in</a></p>
</div>
