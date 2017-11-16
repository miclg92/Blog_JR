<div id="register">
	<form method="post">
		<h3>Inscription</h3>
		<p>Complétez tous les champs pour créer un compte</p>
		</br>
		<?= $form->input('username', 'Pseudo : '); ?>
		<?= $form->input('email', 'Email : ', ['type' => 'email']); ?>
		<?= $form->input('password', 'Mot de passe : ', ['type' => 'password']); ?>
		<?= $form->input('password_confirm', 'Confirmez votre mot de passe : ', ['type' => 'password']); ?>
		<button type="submit">M'inscrire</button>
	
		<?php if($errors): ?>
			<div class="errors">
				Veuillez compléter tous les champs
			</div>
		<?php endif; ?>
	</form>
</div>