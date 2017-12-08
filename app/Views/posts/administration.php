<?php
if(isset($_SESSION['auth']) && isset($_SESSION['user']) && $_SESSION['user']->flag == 2){
?>
<div id="admin_choices">
	<p><a href="?p=admin.posts.index">Gestion des épisodes</a></p>
	<p><a href="?p=admin.categories.index">Gestion des catégories</a></p>
	<p><a href="?p=admin.comments.index">Gestion des commentaires</a></p>
</div>
<?php
} else {
	$_SESSION['flash']['danger'] = "Vous ne pouvez pas afficher cette page. Veuillez vous connecter en tant qu'administrateur du site";
}
?>