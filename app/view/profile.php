<form action="index.php?c=dashboard&a=profile" method="POST">
		
		<input type="text" name="username" id="username" value="<?= $data['user_username'] ?>" placeholder="Username" disabled>
		
		<input type="password" name="oldpassword" id="oldpassword" placeholder="Old password" required>
		<input type="password" name="newpassword" id="newpassword" placeholder="New password" required>
		
		<button type="submit" id="action" name="action" value="update">Save</button>

</form>
