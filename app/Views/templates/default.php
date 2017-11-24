<!doctype html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Billet simple pour l'Alaska : Roman en ligne de Jean Forteroche">
	<meta name="author" content="Jean Forteroche">
	
	<!-- style général -->
	<link rel="stylesheet" type="text/css" href="/css/main.css" media="screen"/>
	<!-- style spécifique onglet "Tous les épisodes" -->
	<link rel="stylesheet" type="text/css" href="/css/episodes.css" media="screen"/>
	<!-- style spécifique commentaires -->
	<link rel="stylesheet" type="text/css" href="/css/comments.css" media="screen"/>
	<!-- style spécifique onglet "Connexion/Inscription" -->
	<link rel="stylesheet" type="text/css" href="/css/login.css" media="screen"/>
	<!-- style spécifique onglet "Administration du blog" -->
	<link rel="stylesheet" type="text/css" href="/css/admin.css" media="screen"/>
	<!-- style spécifique à TinyMCE -->
	<link rel="stylesheet" type="text/css" href="/css/tinymce.css" media="screen"/>
	
	<!-- Accès aux différentes polices Google Fonts -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=BenchNine">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
	<link href="https://fonts.googleapis.com/css?family=Meddon" rel="stylesheet">
	
	<!-- Accès CDN jQuery -->
	<script src="https://code.jquery.com/jquery-1.12.3.js" integrity="sha256-1XMpEtA4eKXNNpXcJ1pmMPs8JV+nwLdEqwiJeCQEkyc=" crossorigin="anonymous"></script>
	<!-- Accès aus différents fichiers JS -->
	<script src="js/tinymce/tinymce.min.js"></script>
	
	<title><?= App::getInstance()->title; ?></title>
	
	<!--Bootstrap core CSS
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
	-->
	
</head>

<body>
	<div id="bloc_page">
	
		<header>
			<div id="home">
				<div id="title">
					<h1 class="go_home" ><a href="index.php">" Billet Simple Pour L'Alaska "</a></h1>
					<div id="link_episodes">
						<p id="first_episode"><a href="index.php?p=posts.firstEpisode">Commencer l'Aventure</a></p>
						<p id="last_episode"><a href="index.php?p=posts.lastEpisode">Dernier épisode publié</a></p>
					</div>
				</div>
				
				<div id="presentation">
					<h2>Suivez les épisodes de mon nouveau roman en ligne,</h2>
					<h2>Et plongez dans le sublime froid glacial de l'Alaska.</h2>
					<h4>Jean Forteroche</h4>
				</div>
			</div>
		</header>
		
		<nav id="menu">
			<ul>
				<li><a href="index.php">Accueil</a></li>
				<li><a href="index.php?p=posts.allEpisodes">Tous les épisodes</a></li>
				<?php
				if(isset($_SESSION['auth'])){
					if($_SESSION['flag'] == 1){
					?>
						<li >Bonjour <?= $_SESSION['user'];?> - <a href="index.php?p=users.account">Mon compte</a></li>
						<li><a href="index.php?p=users.logout">Deconnexion</a></li>
					<?php
					} elseif($_SESSION['flag'] == 2) {
					?>
						<li >Bonjour <?= $_SESSION['user'];?> - <a href="index.php?p=users.account">Mon compte</a></li>
						<li><a href="index.php?p=users.logout">Deconnexion</a></li>
						<li><a href="index.php?p=posts.administration">Administration du site</a></li>
					<?php
					}
				} else {
				?>
					<li><a href="index.php?p=users.login">Connexion</a></li>
					<li><a href="index.php?p=users.register">Inscription</a></li>
				<?php
				}
				?>
			</ul>
		</nav>

		<section id="container">
			<div id="content">
				<?= $content; ?>
			</div>
		</section>
		
		<footer>
			<div id="me">
				<div id="me_picture">
					<img src="/img/jforteroche.jpg" alt="Photo de Jean Forteroche"/>
					<p id="sign">Amicalement, Jean Forteroche</p>
				</div>
				<div id="about_me">
					<h2>Qui suis je ?</h2>
					<p>Né en 1972, j'ai fait des études de Lettres Modernes et d’Etudes Théâtrales à Paris. C’est à l’âge de vingt cinq ans, en 1997, que je publie ma première pièce, Onysos le furieux, à Théâtre Ouvert. Ce premier texte sera monté en 2000 au Théâtre national de Strasbourg dans une mise en scène de Yannis Kokkos. Suivront alors des années consacrées à l’écriture théâtrale, avec notamment Pluie de cendres jouée au Studio de la Comédie Française, Combat de Possédés, traduite et joué en Allemagne, puis mise en lecture en anglais au Royal National Theatre de Londres, Médée Kali joué au Théâtre du Rond Point et Les Sacrifiées.</p>
					<p>Parallèlement à ce travail, Je me lance dans l’écriture romanesque. En 2001, âgé de vingt neuf ans, je publie mon premier roman, Cris. L’année suivante, en 2002, j'obtiens le Prix Goncourt des Lycéens et le prix des Libraires avec La mort du roi Tsongor. En 2004, je suis lauréat du Prix Goncourt pour Le soleil des Scorta, roman traduit dans 34 pays.</p>
					<p>Romancier et dramaturge, je suis aussi auteur de nouvelles, d’un beau livre avec le photographe Oan Kim, d’un album pour enfants, de scénario. Je m'essaie à toutes ces formes pour le plaisir d’explorer sans cesse le vaste territoire de l’imaginaire et de l’écriture.</p>
					<p>Aujourd'hui, je décide de publier mon nouveau roman d'une façon originale... directement en ligne...</p>
					<p>Dès maintenant, SOYEZ ACTEURS AVEC MOI, en découvrant chaque nouvel épisode publié.</p>
				</div>
			</div>
			<div id="copyright">
				<p>
					C 2017 Jean Forteroche | Tous droits réservés
				</p>
			</div>
		</footer>
		
	</div>
	
	
<!--	<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>-->
	
	<script>
		tinymce.init({
			selector: '#content form div textarea',
			content_css: "/css/main.css,/css/admin.css",
			menubar: false,
			plugins: [
				'advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker',
				'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
				'save table contextmenu directionality emoticons template paste textcolor'
			]
		});
	</script>
	

</body>
</html>