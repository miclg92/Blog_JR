<?php
if(isset($_SESSION['auth'])){
?>
<div id="reset-passwd">
	<form method="post" action="">
		<h3>Réinitialiser mon mot de passe</h3>
		<p class="text">Remplissez les deux champs puis validez</p>
		<br><br>
		<div class="form-group">
			<label for="password">Nouveau mot de passe :</label>
			<input name="password" type="password">
		</div>
		<div class="form-group">
			<label for="password">Confirmez nouveau mot de passe :</label>
			<input name="password_confirm" type="password">
		</div>
		<br>
		<button type="submit">Réinitialiser</button>
		
		<?php if($errors): ?>
			<div class="errors">
				Merci de vérifier votre mot de passe
			</div>
		<?php endif; ?>
	</form>
</div>
	<?php
} else {
	$_SESSION['flash']['danger'] = "Vous ne pouvez pas afficher cette page. Veuillez vous connecter ou créer un compte utilisateur";
}
?>