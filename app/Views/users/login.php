<div id="login_user">
	<form method="post">
		<h3>Connexion</h3>
		<p>Indiquez vos pseudo et mot de passe</p>
		</br>
		<?= $form->input('username', 'Pseudo : '); ?>
		<?= $form->input('password', 'Mot de passe : ', ['type' => 'password']); ?>
		<button>Connexion</button>
		<?php if($errors): ?>
			<div class="errors">
				Identifiants incorrects
			</div>
		<?php endif; ?>
	</form>
</div>