<div id="admin_comments">
	
	<p class="return"><a href="?p=posts.administration" >Retour</a></p>
	<h2 class="category_title">Gérer les commentaires laissés par les utilisateurs</h2>
	</br>
	
	<table class="table">
		<thead>
		<tr>
			<td>Date du commentaire</td>
			<td>Auteur</td>
			<td>Commentaire</td>
			<td>id de l'épisode</td>
		</tr>
		</thead>
		
		<tbody>
		<?php foreach ($comments as $comment): ?>
			<tr>
				<td><?= $comment->date_comment; ?></td>
				<td><?= $comment->author; ?></td>
				<td><?= $comment->comment; ?></td>
				<td><?= $comment->article_id; ?></td>
				<td>
					<a class="btn-edit" href="?p=admin.comments.edit&id=<?= $comment->id; ?>">Modérer</a>
					<form action="?p=admin.comments.delete" method="post" style="display: inline;">
						<input type="hidden" name="id" value="<?= $comment->id ?>">
						<button type="submit" class="btn-delete">Supprimer</button>
					</form>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>

</div>
