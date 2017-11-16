<div id="bloc_content">
	
	<div class="comments">
		<h3>Liste de tous les commentaires postés</h3>
		<?php foreach($comments as $comment): ?>
			<p class="comment_author"></br>Commentaire de <?= $comment->author; ?><span><em>, le <?= $comment->date_comment; ?></span></em></p>
			<p class="comment_text"><em><?= $comment->comment; ?></em><a href="">Modérer ce commentaire</a></p>
		<?php endforeach; ?>
		
	</div>
</div>