<div id="account">
	
	<h2 class="category_title">Compte de <?= $_SESSION['user'];?></h2>
	</br>

	<table class="table">
		<thead>
		<tr>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		</thead>
		
		<tbody>
			<tr>
				<td class="param">Mon Pseudo : </td>
				<td class="param_value"><?= $_SESSION['user']; ?></td>
			</tr>
			<tr>
				<td class="param">Mon Email : </td>
				<td class="param_value"><?= $_SESSION['email']; ?></td>
			</tr>
			<tr>
				<td class="param">Mon Mot de passe : </td>
				<td class="param_value"><?= $_SESSION['password']; ?></td>
			</tr>
		</tbody>
	</table>
	<br>
	<br>
	
	<div class="account_btn">
		<a class="btn-edit" href="?p=users.accountEdit&id=<?= $_SESSION['auth']; ?>">Editer votre compte</a>
		<form action="?p=users.account.delete" method="post" style="display: inline;">
			<input type="hidden" name="id" value="<?= $_SESSION['auth']; ?>">
			<button type="submit" class="btn-delete">Supprimer votre compte</button>
		</form>
	</div>
	
</div>