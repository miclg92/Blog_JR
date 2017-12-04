<div id="edit-comment">
	<form method="post">
		<p class="return"><a href="?p=admin.comments.index" >Retour</a></p>
		<h2 class="category_title">Modérer un commentaire</h2></br></br>
		<div class="form-group">
			<label for="comment">Contenu à modérer :</label>
			<textarea name="comment" ><?= $commentContent ?></textarea>
		</div>
		<button class="btn-save">Enregistrer</button>
	</form>
</div>