<?php
if(isset($_SESSION['auth']) && isset($_SESSION['user']) && $_SESSION['user']->flag == 2){
?>
<div id="add-category">
	<form method="post">
		
		<p class="return"><a href="?p=admin.categories.index" >Retour</a></p>
		<h2 class="category_title">Ajouter une catégorie</h2></br></br>
		
		<?= $form->input('title', 'Titre de la catégorie : '); ?>
		<button class="btn-save">Enregistrer</button>
	</form>
</div>
<?php
} else {
	$_SESSION['flash']['danger'] = "Vous ne pouvez pas afficher cette page. Veuillez vous connecter en tant qu'administrateur du site";
}
?>