<div id="login_user">
	<form method="post">
		<h3>Connexion</h3>
		<p>Indiquez vos pseudo et mot de passe</p>
		</br>
		<?= $form->input('username', 'Pseudo : '); ?>
		<?= $form->input('password', 'Mot de passe : ', ['type' => 'password']); ?>
		<?= $form->checkbox('remember', 'Se souvenir de moi', '1'); ?>
		<button type="submit">Connexion</button>
		<br>
		<a href="index.php?p=users.forget">Mot de passe oublié</a>
		<?php if($errors): ?>
			<div class="errors">
				Identifiant ou mot de passe incorrect
			</div>
		<?php endif; ?>
	</form>
</div>
