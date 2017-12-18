<?php
namespace App\Controller\Admin;
use Core\HTML\BootstrapForm;

class PostsController extends AppController
{
	public function __construct()
	{
		parent::__construct();
		$this->loadModel('Post');
		$this->loadModel('Image');
		$this->loadModel('User');
	}
	
	public function index()
	{
		$posts = $this->Post->all();
		$this->render('admin.posts.index', compact('posts'));
	}
	
	public function add()
	{
		if(!empty($_POST)){
			$errors = array();
			
			if(empty($_POST['episode'])) {
				$errors['episode'] = "Numéro d'épisode manquant.";
			} else {
				$episode = $this->Post->checkEpisodeNumber($_POST['episode']);
				if ($episode) {
					$errors['episode'] = "Ce numéro d'épisode est déjà utilisé.";
				}
			}
			
			if(empty($_POST['title'])) {
				$errors['title'] = "Titre manquant.";
			}
			
			if(empty($_POST['content'])) {
				$errors['content'] = "Contenu manquant.";
			}
			
			if(empty($_FILES)){
				$errors['image'] = "Image manquante.";
			} else {
				$extensions_valides = array( 'jpg' , 'jpeg' , 'gif' , 'png' );
				$extension_upload = strtolower(substr(strrchr($_FILES['image']['name'], '.')  ,1)  );
				
				if($_FILES['image']['error'] > 0 ) {
					$errors['image'] = "Erreur lors du transfert de l'image.";
				}
				
				if($_FILES['image']['size'] > $_POST['MAX_FILE_SIZE']){
					$errors['image'] = "L'image est trop volumineuse.";
				}
				
				if(!in_array($extension_upload, $extensions_valides)){
					$errors['image'] = "Le format de l'image n'est pas supporté.";
				}
				
				else{
					$img = $_FILES['image'];
					move_uploaded_file($img['tmp_name'], '../public/img/'.$img['name']);
					self::creerMinImg('../public/img/'.$img['name'], '../public/img/min', $img['name'], 358, 270);
					$this->loadModel('Image');
					$image = $this->Image->create([
						'img_name' => $img['name'],
						'img_url' => 'img/'.$img['name'],
						'img_size' => $img['size'],
					]);
				}
			}
			
			if (empty($errors)) {
				$image_array = $this->Image->getImageId();
				$image_obj = $image_array;
				$image_id = $image_obj->id;
				
				$result = $this->Post->create([
					'episode' => $_POST['episode'],
					'title' => $_POST['title'],
					'content' => $_POST['content'],
					'category_id' => $_POST['category_id'],
					'image_id' => $image_id
				]);
				if($result) {
					// Envoi d'un email à l'utilisateur
					$mails_array = $this->User->allUsersMails();
					foreach ($mails_array as $object => $mail) {
						mail(
							$mail->email,
							'Nouvel épisode disponible',
							"Bonjour. \n\nUn nouvel épisode vient d'être mis en ligne. Rendez-vous dès maintenant sur le site en cliquant sur le lien ci-dessous : \n\nhttps://www.legoarant.com/projet4/public/\n\nA bientôt.\n\nJean Forteroche",
							'From: "Jean Forteroche"<jforteroche@gmail.com>'. "\r\n" .
							'Reply-To: jforteroche@gmail.com' . "\r\n"
						);
					}
					$_SESSION['flash']['success'] = "Cet épisode a bien été ajouté.";
					return $this->index();
				}
			} else {
				$this->loadModel('Category');
				$categories = $this->Category->extract('id', 'title');
				$this->loadModel('Image');
				$form = new BootstrapForm($_POST);
				$this->render('admin.posts.add', compact('categories', 'images', 'form', 'errors'));
			}
		} else{
			$this->loadModel('Category');
			$categories = $this->Category->extract('id', 'title');
			$this->loadModel('Image');
			$form = new BootstrapForm($_POST);
			$this->render('admin.posts.add', compact('categories', 'images', 'form', 'errors'));
		}
	}
	
	public function edit()
	{
		$episode = $this->Post->find($_GET['id']);
		if($episode === false)
		{
			$this->notFound();
		}
		
		if(!empty($_POST)){
			$errors = array();
			
			if (empty($_POST['title'])) {
				$errors['titre'] = "Titre manquant.";
			}
			
			if (empty($_POST['content'])) {
				$errors['contenu'] = "Contenu manquant.";
			}
			
			if (empty($errors)) {
				$result = $this->Post->update($_GET['id'], [
					'episode' => $_POST['episode'],
					'title' => $_POST['title'],
					'content' => $_POST['content'],
					'category_id' => $_POST['category_id'],
					'date_update' => date('Y-m-d H:i:s')
				]);
				
				if($result)
				{
					$_SESSION['flash']['success'] = "Cet épisode a bien été modifié";
					return $this->index();
				}
			} else {
				$post = $this->Post->find($_GET['id']);
				$this->loadModel('Category');
				$categories = $this->Category->extract('id', 'title');
				$form = new BootstrapForm($post);
				$this->render('admin.posts.edit', compact('categories',  'form', 'errors', 'post'));
			}
		} else {
			$post = $this->Post->find($_GET['id']);
			$this->loadModel('Category');
			$categories = $this->Category->extract('id', 'title');
			$form = new BootstrapForm($post);
			$this->render('admin.posts.edit', compact('categories',  'form', 'errors', 'post'));
		}
	}
	
	
	public function delete()
	{
		if(!empty($_POST))
		{
			$result = $this->Post->delete($_POST['id']);
			$_SESSION['flash']['success'] = "Cet épisode a bien été supprimé";
			return $this->index();
		}
	}

	static function creerMinImg($img,$chemin,$nom,$mlargeur=100,$mhauteur=100){
		// On supprime l'extension du nom
		$nom = substr($nom,0,-4);
		// On récupère les dimensions de l'image
		$dimension=getimagesize($img);
		// On cré une image à partir du fichier récup
		if(substr(strtolower($img),-4)==".jpg"){$image = imagecreatefromjpeg($img); }
		else if(substr(strtolower($img),-4)==".png"){$image = imagecreatefrompng($img); }
		else if(substr(strtolower($img),-4)==".gif"){$image = imagecreatefromgif($img); }
		// L'image ne peut etre redimensionne
		else{return false; }
		
		// Création des miniatures
		// On cré une image vide de la largeur et hauteur voulue
		$miniature =imagecreatetruecolor ($mlargeur,$mhauteur);
		// On va gérer la position et le redimensionnement de la grande image
		if($dimension[0]>($mlargeur/$mhauteur)*$dimension[1] ){ $dimY=$mhauteur; $dimX=$mhauteur*$dimension[0]/$dimension[1]; $decalX=-($dimX-$mlargeur)/2; $decalY=0;}
		if($dimension[0]<($mlargeur/$mhauteur)*$dimension[1]){ $dimX=$mlargeur; $dimY=$mlargeur*$dimension[1]/$dimension[0]; $decalY=-($dimY-$mhauteur)/2; $decalX=0;}
		if($dimension[0]==($mlargeur/$mhauteur)*$dimension[1]){ $dimX=$mlargeur; $dimY=$mhauteur; $decalX=0; $decalY=0;}
		// on modifie l'image crée en y plaçant la grande image redimensionné et décalée
		imagecopyresampled($miniature,$image,$decalX,$decalY,0,0,$dimX,$dimY,$dimension[0],$dimension[1]);
		// On sauvegarde le tout
		imagejpeg($miniature,$chemin."/".$nom.".jpg",90);
		return true;
	}
	
}
