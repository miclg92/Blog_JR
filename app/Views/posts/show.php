<!-- Contenu d'un épisode spécifique -->
<div id="bloc_content">
	
	<div class="post">
		<p class="return_episodes"><a href="?p=posts.allEpisodes" >Retour aux épisodes</a></p>
		<h2 class="post_title">Episode <?= $article->episode;?> : <?= $article->titre;?></h2>
		<p class="post_category"><em><?= $article->categorie; ?> - Publié le <?= $article->date_public_fr; ?></em></p>
		<p class="post_category"><em>(Dernière modification le <?= $article->date_modif_fr; ?>)</em></p>
		<p class="post_full"><?= $article->contenu; ?></p>
		<div class="other_episodes">
			<?php
			$currentEpisodeId = $this->Post->currentEpisodeId([$article->id]);
			$firstEpisodeId = $this->Post->firstEpisodeId();
			$lastEpisodeId = $this->Post->lastEpisodeId();
			if($currentEpisodeId != $firstEpisodeId){
			?>
				<p class="prev"><a href="?p=posts.previousEpisode">...Précédemment</a></p>
			<?php
			}
			if($currentEpisodeId != $lastEpisodeId){
			?>
				<p class="next"><a href="?p=posts.nextEpisode">Prochain épisode...</a></p>
			<?php
			}
			?>
		</div>
	</div>
	
	<?php
	if(isset($_SESSION['auth'])){
	?>
		<div id="add-comment">
			<form method="post">
				<h3>Commenter cet épisode</h3></br></br>
				<input type= "hidden" name="id" value="<?= $article->id ?>">
				<div class="form-group">
					<label for="Author">Auteur :</label>
					<input name="author" type="password" placeholder="<?= $_SESSION{'user'}->username ?>">
				</div>
				<?= $form->input('comment', 'Commentaire : ');?>
				<button class="btn_post">Poster</button>
			</form>
		</div>
	<?php
	} else {
	?>
		<div id="add-comment">
			<form method="post">
				<h3>Commenter cet épisode</h3></br></br>
				<p class="no_show">Envie de laisser un commentaire ? <a href="index.php?p=users.login"> Connectez-vous </a> ou <a href="index.php?p=users.register"> Créez un compte </a> ;-)</p>
			</form>
		</div>
	<?php
	}
	?>
	
	<?php
	if(!empty($comments)){
	?>
		<div class="comments">
			<h3>Commentaires liés à cet épisode</h3>
			<?php foreach($comments as $comment): ?>
				<input type= "hidden" name="id" value="<?= $comment->id ?>">
				<p class="comment_author">Commentaire de <?= $comment->author; ?><span><em>, le <?= $comment->date_comment; ?></span></em></p>
				<?php
				if(isset($_SESSION['user'])) {
					if ($_SESSION['user']->flag == 1) {
						?>
						<p class="comment_text"><em><?= $comment->comment; ?></em><a href="index.php?p=admin.comments.edit">Signaler ce commentaire</a></p>
						<?php
					} elseif ($_SESSION['user']->flag == 2) {
						?>
						<p class="comment_text"><em><?= $comment->comment; ?></p>
						<?php
					}
				}	else {
				?>
					<p class="comment_text"><em><?= $comment->comment; ?></em><a href="index.php?p=admin.comments.edit">Signaler ce commentaire</a></p>
					<?php
				}
				?>
			<?php endforeach; ?>
		</div>
	<?php
	} else{
		?>
			<div class="comments">
				<h3>Commentaires liés à cet épisode</h3>
				<p class="no_show">Aucun commentaire pour l'instant, soyez le premier ;-)</p>
			</div>
		<?php
	}
	?>
	<button class="btn_all_episodes"><a href="index.php?p=posts.allEpisodes">Tous les épisodes</a></button>
	

