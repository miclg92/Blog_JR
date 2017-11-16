<!-- Contenu d'un épisode spécifique -->
<div id="bloc_content">
	
	<div class="post">
		<h2 class="post_title">Episode <?= $article->episode;?> : <?= $article->titre;?></h2>
		<p class="post_category"><em><?= $article->categorie; ?> - Publié le <?= $article->date_public_fr; ?></em></p>
		<p class="post_category"><em>(Dernière modification le <?= $article->date_modif_fr; ?>)</em></p>
		<p class="post_full"><?= $article->contenu; ?></p>
		<p class="comment"><a href="?p=comments.add" >Commenter</a> | <a href="?p=comments.index" >Liste des commentaires</a></p>
		<p class="return_episodes"><a href="?p=posts.indexall" >Retour aux épisodes</a></p>
	</div>
	
	<div class="comments">
		<h3>Commentaires</h3>
		<p class="comment_author"><br><?= $article->author; ?><span><em><?= $article->date_comment_fr; ?></span></em></p>
		<p class="comment_text"><em><?= $article->comment; ?></em><a href="">Signaler ce commentaire</a></p>
	</div>
	
	<button class="btn_all_episodes"><a href="index.php?p=posts.indexall">Tous les épisodes</a></button>
	
</div>

