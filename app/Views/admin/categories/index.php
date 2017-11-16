<h2 class="category_title">Ajouter, Modifier ou Supprimer une catégorie</h2>
</br>

<div id="admin_categories">
	
	<p class="return"><a href="?p=posts.indexadmin" >Retour</a></p>
	<p><a href="?p=admin.categories.add" class="btn-add">Ajouter une catégorie</a></p>
	
	<table class="table">
		<thead>
		<tr>
<!--		<td>ID</td>-->
			<td>Titre</td>
			<td>Actions</td>
		</tr>
		</thead>
		
		<tbody>
		<?php foreach ($categories as $category): ?>
			<tr>
<!--			<td>--><?//= $category->id; ?><!--</td>-->
				<td><?= $category->titre; ?></td>
				<td>
					<a class="btn-edit" href="?p=admin.categories.edit&id=<?= $category->id; ?>">Modifier</a>
					
					<form action="?p=admin.categories.delete" method="post" style="display: inline;">
						<input type="hidden" name="id" value="<?= $category->id ?>">
						<button type="submit" class="btn-delete">Supprimer</button>
					</form>
				
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
	
</div>

