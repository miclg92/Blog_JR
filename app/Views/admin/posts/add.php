<?php
if ($_SESSION['user']->flag == 2) {
?>
	<div id="add-post">
		<form method="post">
			<p class="return"><a href="?p=admin.posts.index" >Retour</a></p>
			<h2 class="category_title">Ajouter un épisode</h2></br></br>
			<?= $form->input('episode', 'Numéro de l\'épisode : '); ?>
			<?= $form->input('titre', 'Titre de l\'épisode : '); ?>
			<?= $form->input('contenu', 'Contenu : ', ['type' => 'textarea']); ?>
			<?= $form->select('category_id', 'Catégorie : ', $categories); ?>
			<?= $form->select('image_id', 'Image : ', $images); ?>
			<button class="btn-save">Enregistrer</button>
			
			<?php if (!empty($errors)): ?>
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
}
?>