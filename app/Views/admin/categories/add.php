<div id="add-category">
	<form method="post">
		
		<p class="return"><a href="?p=admin.categories.index" >Retour</a></p>
		<h2 class="category_title">Ajouter une catégorie</h2></br></br>
		
		<?= $form->input('titre', 'Titre de la catégorie : '); ?>
		<button class="btn-save">Enregistrer</button>
	</form>
</div>
