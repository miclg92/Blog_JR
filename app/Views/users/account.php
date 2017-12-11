<?php
if(isset($_SESSION['auth'])){
?>
	<div id="account">
		
		<h3>Compte de <?= $_SESSION['user']->username;?></h3>
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
				<td class="param_value"><?= $_SESSION['user']->username; ?></td>
			</tr>
			<tr>
				<td class="param">Mon Email : </td>
				<td class="param_value"><?= $_SESSION['user']->email; ?></td>
			</tr>
			</tbody>
		</table>
		<br>
		<br>
		
		<div class="account_btn">
			<a class="btn-edit" href="?p=users.edit&id=<?= $_SESSION['auth']; ?>">Editer Profil</a>
			<a class="btn-edit" href="?p=users.changePasswd&id=<?= $_SESSION['auth']; ?>">Changer Mot de passe</a>
			<form action="?p=users.delete" method="post" style="display: inline;">
				<input type="hidden" name="id" value="<?= $_SESSION['auth']; ?>">
				<button type="submit" class="btn-delete">Supprimer Compte</button>
			</form>
		</div>
	</div>
<?php
} else {
	$_SESSION['flash']['danger'] = "Vous ne pouvez pas afficher cette page. Veuillez vous connecter ou créer un compte utilisateur";
}
?>