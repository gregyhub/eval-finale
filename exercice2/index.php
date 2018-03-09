<?php
//correction du nom du fichier à inclure
require_once 'connect.php';

$order = '';
//un tri sur une colonne est demandé > constitution des éléments de la requete avec le champ sur le quel s'effecture le trie et le sens (ascendant ou descendant)
if(isset($_GET['order']) && isset($_GET['column'])){ //correction -> ")" manquante pour fermer le if
	if($_GET['column'] == 'lastname'){ //correction de l'index column
		$order = ' ORDER BY lastname';
	}
	elseif($_GET['column'] == 'firstname'){ //correction de l'index column //correction sur le test ==
		$order = ' ORDER BY firstname';
	}
	elseif($_GET['column'] == 'birthdate'){ //correction de l'index column
		$order = ' ORDER BY birthdate';
	}
	if($_GET['order'] == 'asc'){ //correction de l'index order
		$order.= ' ASC';
	}
	elseif($_GET['order'] == 'desc'){ //correction de l'index order
		$order.= ' DESC';
	}
}

//dans le cas ou le formulaire pour ajouter un utilisateur est envoyé
if(!empty($_POST)){
	$errors=array();
	foreach($_POST as $key => $value){
		//pour supprimer les balises html et les espace avant et apres la chaine
		$post[$key] = strip_tags(trim($value)); //correcion-> une ")" en trop
	}
	if(strlen($post['firstname']) < 3){ //correction de la ")" mal placée
		$errors[] = 'Le prénom doit comporter au moins 3 caractères';
	}
	if(strlen($post['lastname']) < 3){ //correction de la ")" mal placée
	$errors[] = 'Le nom doit comporter au moins 3 caractères';
	}
	if(!filter_var($post['email'], FILTER_VALIDATE_EMAIL)){ //correction sur le nom de la fonction filter_var
		$errors[] = 'L\'adresse email est invalide';
	}
	if(empty($post['birthdate'])){
		$errors[] = 'La date de naissance doit être complétée';
	}
	if(empty($post['city'])){
		$errors[] = 'La ville ne peut être vide';
	}
	//si il n'y a pas d'erreur, je prépare la requete d'insertion en bdd
	if(count($errors) == 0){ //correction de la condition > => == // correction sur le nom de la variable errors
		// error = 0 = insertion user
		$insertUser = $db->prepare('INSERT INTO users (gender, firstname, lastname, email, birthdate, city) VALUES(:gender, :firstname, :lastname, :email, :birthdate, :city)');
		$insertUser->bindValue(':gender', $post['gender']);
		$insertUser->bindValue(':firstname', $post['firstname']); //correction -> ajout du ";" de fin de ligne //correction sur l'indice firstname
		$insertUser->bindValue(':lastname', $post['lastname']);
		$insertUser->bindValue(':email', $post['email']);
		$insertUser->bindValue(':birthdate', date('Y-m-d', strtotime($post['birthdate'])));
		$insertUser->bindValue(':city', $post['city']);
		if($insertUser->execute()){
			$createUser = true;
		} else {
			$errors[] = 'Erreur SQL';
		}
	}//correction -> ajout de la "}" fermant le if(count error)
} //correction -> ajout de la "}" fermant le if(POST)

$queryUsers = $db->prepare('SELECT * FROM users'.$order);
if($queryUsers->execute()){
	$users = $queryUsers->fetchAll(); //correction sur l'appel de la méthode ->
}
?><!DOCTYPE html>
<html>
<head>
<title>Exercice 1</title>
<meta charset="utf-8">
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

	<div class="container">
		<h1>Liste des utilisateurs</h1>
		<p>Trier par :
			<a href="index.php?column=firstname&order=asc">Prénom (croissant)</a> |
			<a href="index.php?column=firstname&order=desc">Prénom (décroissant)</a> |
			<a href="index.php?column=lastname&order=asc">Nom (croissant)</a> |
			<a href="index.php?column=lastname&order=desc">Nom (décroissant)</a> |
			<a href="index.php?column=birthdate&order=desc">Âge (croissant)</a> |
			<a href="index.php?column=birthdate&order=asc">Âge (décroissant)</a>
		</p>
		<div class="row">
	<?php
	if(isset($createUser) && $createUser == true){
		echo '<div class="col-md-6 col-md-offset-3">';
		echo '<div class="alert alert-success">Le nouvel utilisateur a été ajouté avec succès.</div>';
		echo '</div><br>'; //correction -> ajout du ";" de fin de ligne
	}
	if(isset($errors) && !empty($errors)){  //ajour de la condition isset(errors) pour vérifier son existance et du !empty()
		echo '<div class="col-md-6 col-md-offset-3">';
		echo '<div class="alert alert-danger">'.implode('<br>', $errors).'</div>';
		echo '</div><br>';
	}
	?>

			<div class="col-md-7">
				<table class="table">
					<thead>
						<tr>
							<th>Civilité</th>
							<th>Prénom</th>
							<th>Nom</th>
							<th>Email</th>
							<th>Age</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($users as $user):?>
						<tr>
							<td><?php echo $user['gender']; ?></td>
							<td><?php echo $user['firstname']; ?></td>
							<td><?php echo $user['lastname']; ?></td>
							<td><?php echo $user['email']; ?></td>
							<td><?php echo DateTime::createFromFormat('Y-m-d', $user['birthdate'])->diff(new DateTime('now'))->y; ?> ans</td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>

			<div class="col-md-5">
				<form method="post" class="form-horizontal well well-sm">
				<fieldset>
					<legend>Ajouter un utilisateur</legend>
					<div class="form-group">
						<label class="col-md-4 control-label" for="gender">Civilité</label>
						<div class="col-md-8">
							<select id="gender" name="gender" class="form-control input-md" required>
								<option value="Mlle" <?= (isset($post['gender']) && $post['gender'] == 'Mlle') ? 'selected' : '' ?>>Mademoiselle</option>
								<option value="Mme" <?= (isset($post['gender']) && $post['gender'] == 'Mme') ? 'selected' : '' ?>>Madame</option>
								<option value="M" <?= (isset($post['gender']) && $post['gender'] == 'M') ? 'selected' : '' ?>>Monsieur</option>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="firstname">Prénom</label>
						<div class="col-md-8">
							<input id="firstname" name="firstname" type="text" class="form-control input-md" required value="<?= $post['firstname'] ?? '' ?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-4 control-label" for="lastname">Nom</label>
						<div class="col-md-8">
							<input id="lastname" name="lastname" type="text" class="form-control input-md" required value="<?= $post['lastname'] ?? '' ?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-4 control-label" for="email">Email</label>
						<div class="col-md-8">
							<input id="email" name="email" type="email" class="form-control input-md" required value="<?= $post['email'] ?? '' ?>">
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="city">Ville</label>
						<div class="col-md-8">
							<input id="city" name="city" type="text" class="form-control input-md" required value="<?= $post['city'] ?? '' ?>">
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="birthdate">Date de naissance</label>
						<div class="col-md-8">
							<input id="birthdate" name="birthdate" type="text" placeholder="JJ-MM-AAAA" class="form-control input-md" required value="<?= $post['birthdate'] ?? '' ?>">
							<span class="help-block">au format JJ-MM-AAAA</span>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-4 col-md-offset-4">
							<button type="submit" class="btn btn-primary">Envoyer</button>
						</div>
					</div>
				</fieldset>
				</form>
			</div>
		</div> <!-- fin du ROW -->
	</div> <!-- fin du CONTAINER -->
</body>
</html>