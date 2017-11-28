<div id="forget_password">
	<form method="post">
		<h3>Mot de passe oublié</h3>
		<p>Indiquez votre adresse mail</p>
		</br>
		<?= $form->input('email', 'Email : ', ['type' => 'email']); ?>
		<button type="submit">Connexion</button>
		<br>
		
		<?php if($errors): ?>
			<div class="errors">
				Aucun compte ne correspond à cet email.
			</div>
		<?php endif; ?>
	</form>
</div>