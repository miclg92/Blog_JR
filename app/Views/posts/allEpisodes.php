<!-- Contenu de tous les épisodes disponibles -->

<div id="bloc_content_all">
	<div class="posts_all">
		<?php foreach($posts as $post): ?>
			<figure>
				<a href="<?= $post->url ?>">
					<img src="<?= $post->image ?>" alt="<?= $post->image_name ?>">
					<figcaption>
						Episode <?= $post->episode;?>
						<br>
						<?= $post->title;?>
					</figcaption>
				</a>
			</figure>
		<?php  endforeach; ?>
	</div>
</div>