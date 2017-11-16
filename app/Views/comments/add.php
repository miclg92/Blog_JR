<div id="add-comment">
	<form method="post">
		<h2 class="comment_title">Ajouter un commentaire </h2></br></br>
		<?= $form->input('author', 'Auteur : '); ?>
		<?= $form->input('comment', 'Commentaire : ');?>
		<button class="btn-save">Poster</button>
	</form>
</div>