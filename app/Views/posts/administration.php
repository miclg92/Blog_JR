<?php
//// Si le user n'a pas été envoyé ou n'est pas bon
//if (!isset($_POST['username']) OR $_POST['username'] != "JForteroche")
//{
//	// Si le mot de passe n'a pas été envoyé ou n'est pas bon
//	if (!isset($_POST['password']) OR $_POST['password'] != "demo"){
//		// Afficher le formulaire de saisie des identifiants
//		?><!--<form class="admin_login" method="post">-->
<!--		<h3>Connexion Administrateur</h3>-->
<!--		<p>Cette page est réservée aux administrateurs du site.</p>-->
<!--		<p>Veuillez entrer vos identifiants d'administrateur :</p>-->
<!--		</br>-->
<!--		--><?//= $form->input('username', 'identifiant : '); ?>
<!--		--><?//= $form->input('password', 'Mot de passe : ', ['type' => 'password']); ?>
<!--		<button>Connexion</button>-->
<!--		-->
<!--		--><?php //if($errors): ?>
<!--			<div class="errors">-->
<!--				Identifiants administrateur incorrects-->
<!--			</div>-->
<!--		--><?php //endif; ?>
<!--		</form>-->
<!--		--><?php
//	}
//}
//// Si les username et mot de passe ont été envoyés et sont bons
//else {
//	// Afficher la page d'administration du blog
//	?>
	<div id="admin_choices">
		<p><a href="?p=admin.posts.index">Gestion des épisodes</a></p>
		<p><a href="?p=admin.categories.index">Gestion des catégories</a></p>
	</div>
<!--	--><?php
//}
//?>