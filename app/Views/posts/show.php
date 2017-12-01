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
<!--		<p class="comment"><a href="" >Commenter</a> | <a href="" >Liste des commentaires</a></p>-->
	</div>
	
	<div id="add-comment">
		<form method="post">
			<h3>Commenter </h3></br></br>
			<input type= "hidden" name="id" value="<?= $article->id ?>">
			<?= $form->input('author', 'Auteur : '); ?>
			<?= $form->input('comment', 'Commentaire : ');?>
			<button class="btn_post">Poster</button>
		</form>
	</div>
	
	<div class="comments">
		<h3>Liste des commentaires</h3>
<!--		--><?php //foreach($comments as $comment): ?>
		<input type= "hidden" name="id" value="<?= $article->id ?>">
		<p class="comment_author"><br><?= $article->author; ?><span><em><?= $article->date_comment_fr; ?></span></em></p>
		<p class="comment_text"><em><?= $article->comment; ?></em><a href="">Signaler ce commentaire</a></p>
<!--		--><?php //endforeach; ?>
	</div>
	
<!--	<div class="comments">-->
<!--		<h3>Commentaires</h3>-->
<!--		--><?php //foreach($comments as $comment): ?>
<!--		<input type= "hidden" name="id" value="--><?//= $comment->id ?><!--">-->
<!--		<p class="comment_author"></br>Commentaire de --><?//= $comment->author; ?><!--<span><em>, le --><?//= $comment->date_comment; ?><!--</span></em></p>-->
<!--		<p class="comment_text"><em>--><?//= $comment->comment; ?><!--</em><a href="">Modérer ce commentaire</a></p>-->
<!--		--><?php //endforeach; ?>
<!--	</div>-->
	
	
	
	<button class="btn_all_episodes"><a href="index.php?p=posts.allEpisodes">Tous les épisodes</a></button>
	

