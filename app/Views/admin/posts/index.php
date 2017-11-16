<h2 class="category_title">Ajouter, Modifier ou Supprimer un épisode</h2>
</br>

<div id="admin_episodes">
	
	<p class="return"><a href="?p=posts.indexadmin" >Retour</a></p>
	<p><a href="?p=admin.posts.add" class="btn-add">Ajouter un épisode</a></p>
	
	<table class="table">
		<thead>
		<tr>
			<td>ID</td>
			<td>Episode</td>
			<td>Titre</td>
			<td>Actions</td>
		</tr>
		</thead>
		
		<tbody>
		<?php foreach ($posts as $post): ?>
			<tr>
				<td><?= $post->id; ?></td>
				<td><?= $post->episode; ?></td>
				<td><?= $post->titre; ?></td>
				<td id="buttons-actions">
					<a class="btn-edit" href="?p=admin.posts.edit&id=<?= $post->id; ?>">Modifier</a>
					
					<form action="?p=admin.posts.delete" method="post" style="display: inline;">
						<input type="hidden" name="id" value="<?= $post->id ?>">
						<button type="submit" class="btn-delete">Supprimer</button>
					</form>
				
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
	
</div>
