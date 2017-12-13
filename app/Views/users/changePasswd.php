<?php
if(isset($_SESSION['auth'])){
	?>
	<div id="edit-user">
		
		<form method="post" action="">
			<p class="return"><a href="?p=users.account" >Retour</a></p>
			<h3>Modifier mon mot de passe</h3>
			<p class="text">Remplissez les deux champs puis enregistrez</p>
			<br><br>
			<div class="form-group">
				<label for="password">Nouveau mot de passe : </label>
				<input name="password" type="password">
			</div>
			<div class="form-group">
				<label for="password">Confirmez nouveau mot de passe : </label>
				<input name="password_confirm" type="password">
			</div>
			<br>
			<button type="submit">Enregistrer</button>
			
			<?php if(!empty($errors)): ?>
				<div class="errors">
					<ul>
						<?php foreach ($errors as $error): ?>
							<li><?= $error; ?></li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endif; ?>
		</form>
	</div>
	<?php
} else {
	$_SESSION['flash']['danger'] = "Vous ne pouvez pas afficher cette page. Veuillez vous connecter ou créer un compte utilisateur";
}
?>