<div id="reset_password">
	<form method="post">
		<h3>Réinitialisation de mot de passe</h3>
		<p>Indiquez votre nouveau mot de passe</p>
		</br>
		<?= $form->input('password', 'Mot de passe : ', ['type' => 'password']); ?>
		<?= $form->input('password_confirm', 'Confirmez votre mot de passe : ', ['type' => 'password']); ?>
		<button type="submit">Réinitialiser mon mot de passe</button>
		<br>
		<?php if($errors): ?>
			<div class="errors">
				Merci de vrifier votre mot de passe
			</div>
		<?php endif; ?>
	</form>
</div>