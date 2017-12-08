<?php
if(isset($_SESSION['auth']) && isset($_SESSION['user']) && $_SESSION['user']->flag == 2){
?>
<div id="admin_comments">
	
	<p class="return"><a href="?p=posts.administration" >Retour</a></p>
	<h2 class="category_title">Gérer les commentaires laissés par les utilisateurs</h2>
	</br>
	
	
	<table class="table">
		<caption class="NO">Commentaires signalés - Action requise : modérer/supprimer</caption>
		<thead>
		<tr>
			<td>ID</td>
			<td>Date du commentaire</td>
			<td>Auteur</td>
			<td>Commentaire</td>
			<td>ID de l'épisode</td>
		</tr>
		</thead>
		
		<tbody>
		<?php foreach ($comments as $comment):
			if($comment->is_signaled == 1)
			{
			?>
				<tr>
					<td><?= $comment->id; ?></td>
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
			<?php
			}
			?>
		<?php endforeach; ?>
		</tbody>
	</table>
	
	<br>
	
	<table class="table">
		<caption class="OK">Commentaires non signalés - Action requise : contrôler</caption>
		<thead>
		<tr>
			<td>ID</td>
			<td>Date du commentaire</td>
			<td>Auteur</td>
			<td>Commentaire</td>
			<td>ID de l'épisode</td>
		</tr>
		</thead>
		
		<tbody>
		<?php foreach ($comments as $comment):
			if($comment->is_signaled == 0)
			{
				?>
				<tr>
					<td><?= $comment->id; ?></td>
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
				<?php
			}
			?>
		<?php endforeach; ?>
		</tbody>
	</table>
</div>
	<?php
} else {
	$_SESSION['flash']['danger'] = "Vous ne pouvez pas afficher cette page. Veuillez vous connecter en tant qu'administrateur du site";
}
?>