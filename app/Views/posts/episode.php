<!-- Extrait d'un épisode-->

<div id="bloc_content">
	
	<div class="category">
		<ul>
			<?php foreach($categories as $categorie): ?>
				<li><a href="<?= $categorie->url; ?>"><?= $categorie->titre; ?></a></li>
			<?php endforeach; ?>
		</ul>
	</div>
	
	<div class="posts">
		
		<?php foreach($posts as $post): ?>
			<div class="post">
				<h2 class="post_title"><a href="<?= $post->url ?>">Episode <?= $post->episode;?> : <?= $post->titre;?></a></h2>
				<p class="post_category"><em><?= $post->categorie; ?> - Publié le <?= $post->date_public_fr; ?></em></p>
				<p class="post_extrait"><?= $post->extrait; ?></p>
			</div>
		<?php endforeach; ?>
		
		<button class="btn_all_episodes"><a href="index.php?p=posts.allEpisodes"><i class="fa fa-book" aria-hidden="true"></i>Tous les épisodes</a></button>
	
	</div>
</div>