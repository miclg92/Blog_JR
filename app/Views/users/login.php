<div id="login_choices">
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

<!--	<form method="post">-->
<!--		<h3>Inscription</h3>-->
<!--		<p>Complétez tous les champs pour créer un compte</p>-->
<!--		</br>-->
<!--		--><?//= $form->input('name', 'Nom : '); ?>
<!--		--><?//= $form->input('firstname', 'Prénom : '); ?>
<!--		--><?//= $form->input('email', 'Email : ', ['type' => 'email']); ?>
<!--		--><?//= $form->input('username', 'Pseudo : '); ?>
<!--		--><?//= $form->input('password', 'Mot de passe : ', ['type' => 'password']); ?>
<!--		--><?//= $form->input('password', 'Confirmez le mot de passe : ', ['type' => 'password']); ?>
<!--		<button>Inscription</button>-->
<!--		--><?php //if($errors): ?>
<!--			<div class="errors">-->
<!--				Veuillez compléter tous les champs-->
<!--			</div>-->
<!--		--><?php //endif; ?>
<!--	</form>-->
</div>