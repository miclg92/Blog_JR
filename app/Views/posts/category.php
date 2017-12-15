<!-- Contenu de tous les épisodes d'une catégorie spécifique -->

<div id="bloc_content">
	
	<h2 class="category_title">Episodes ayant pour thème les "<?= $categorie->title; ?>"</h2>
	
	<div class="category">
		<ul>
			<?php foreach($categories as $categorie): ?>
				<li><a href="<?= $categorie->url; ?>"><?= $categorie->title; ?></a></li>
			<?php endforeach; ?>
		</ul>
	</div>
	
	<div class="posts">
	<?php foreach($posts as $post): ?>
		<div class="post">
			<img src="<?= $post->image ?>" alt="<?= $post->image_name ?>">
			<h2 class="post_title"><a href="<?= $post->url ?>">Episode <?= $post->episode;?> : <?= $post->title;?></a></h2>
			<p class="post_category"><em>Publié le <?= $post->date_episode_fr; ?></em></p>
			<p class="post_extrait"><?= $post->extrait; ?></p>
		</div>
	<?php  endforeach; ?>
		<button class="btn_all_episodes"><a href="index.php">Retour Accueil</a></button>
	</div>
</div>