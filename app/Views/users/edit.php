<?php
if(isset($_SESSION['auth'])){
?>
	<div id="edit-user">
		
		<form method="post" action="">
			<p class="return"><a href="?p=users.account" >Retour</a></p>
			<h3>Editer mon profil</h3>
			<p class="text">Vous pouvez modifier vos pseudo et email de contact</p>
			<br><br>
			<?= $form->input('username', 'Changer mon pseudo : ');?>
			<?= $form->input('email', 'Changer mon email : ', ['type' => 'email']); ?>
			<button type="submit">Enregistrer les changements</button>
			
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