<!-- Contenu de tous les épisodes disponibles -->

<div id="bloc_content_all">
	
	<div class="posts_all">
		<?php foreach($posts as $post): ?>
			<div class="post_all">
				<a href="<?= $post->url ?>">
					<h2>Episode <?= $post->episode;?></h2>
					<h3><?= $post->titre;?></h3>
				</a>
			</div>
		<?php  endforeach; ?>
	</div>

</div>