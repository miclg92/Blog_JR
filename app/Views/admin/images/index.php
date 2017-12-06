<div id="admin_images">
	
	<p class="return"><a href="?p=posts.administration" >Retour</a></p>
	<h2 class="category_title">Liste des images de fond des épisodes</h2>
	</br>
	
	<?php
	$folder = '../public/img/min';
	$dir = opendir($folder);
	while($file = readdir($dir)){
		$extensions_valides = array( 'jpg' , 'jpeg' , 'gif' , 'png' );
		$extension_upload = strtolower(substr(strrchr($file, '.')  ,1)  );
		if(in_array($extension_upload, $extensions_valides)){
		?>
		<div class="min">
			<a href="/img/<?= $file; ?>">
				<img src="/img/min/<?= $file; ?>">
				<h3><?= $file; ?></h3>
			</a>
		</div>
		<?php
		}
	}
	
	?>
	
</div>

