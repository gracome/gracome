<?php
session_start();

require("src/connexion.php");


if (!empty($_POST['pseudo']) &&   !empty($_POST['nom']) &&   !empty($_POST['prenom']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['passwordConfirm'])) {
    $pseudo= $_POST['pseudo'];
    $nom= $_POST['nom'];
    $prenom= $_POST['prenom'];
    $email= $_POST['email'];
    $password= $_POST['password'];
    $passwordConfirm= $_POST['passwordConfirm'];


    if($password != $passwordConfirm){
        header('Location: inscription.php?error=1&pass=1');
            exit();

}
   

$req = $conn->prepare("SELECT count(*) as numberEmail FROM users WHERE email = ?");
		$req->execute(array($email));
 
		while($email_verification = $req->fetch()){
			if($email_verification['numberEmail'] != 0) {
				header('location: inscription.php?error=1&email=1');
				exit();
 			}
		}
        $secret = sha1($email).time();
		$secret = sha1($secret).time().time();

        $password = "aq1".sha1($password."1254")."25";


        
        $req = $conn->prepare("INSERT INTO users(pseudo,nom,prenom,email,password,creation_date,secrete) VALUES(?,?,?,?,?,NOW(),?)") or die ($db->errorInfo()); 
	 $req->execute(array($pseudo,$nom, $prenom, $email, $password, $secret));
			
 
				header('location: inscription.php?success=1');
					exit();
 
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="design/default.css">
    <title>Inscription</title>
</head>
<body>
    <header>
    <?php if(!isset($_SESSION['connect'])){ ?>
    <h1>Inscription</h1>  

    <?php } else { ?>
        <h1>Page menbres</h1>

        <?php } ?>
    </header>
    <div class="container">
        <?php if(!isset($_SESSION['connect'])){ ?>

      
        
<p id="info">Bienvenue sur mon site, pour avoir plus de détail inscrivez-vous. Si non <br> <a href="connection.php">Connectez-vous.</a></p>
    <?php

if(isset($_GET['error'])){
		 
    if(isset($_GET['pass'])){
        echo '<p id="error">Les mots de passe ne correspondent pas.</p>';
    }
    else if(isset($_GET['email'])){
        echo '<p id="error">Cette adresse email est déjà utilisée.</p>';

    } 
   
}
else if(isset($_GET['success'])){
    echo '<p id="success">Inscription réussie.</p>';
}

   
    ?>


<div id="form">
<form action="inscription.php" method="post" >
  <table>
      <tr>
          <td>
              Pseudo
          </td>
          <td>
              <input type="text" name="pseudo" placeholder="Ex: John" required>
          </td>
      </tr>

      <tr>
          <td>
              Nom
          </td>
          <td>
              <input type="text" name="nom" placeholder="Ex: Doe" required>
          </td>
      </tr>
      <tr>
          <td>
              Prénom
          </td>
          <td>
              <input type="text" name="prenom" placeholder="Ex: Johnathan" required>
          </td>
      </tr>
      <tr>
          <td>
              Email
          </td>
          <td>
              <input type="email" name="email" placeholder="Ex:example@gmail.com" required>
          </td>
      </tr>

      <tr>
          <td>
              Mot de passe
          </td>
          <td>
              <input type="password" name="password" placeholder="*******" required>
          </td>
      </tr>
      <tr>
          <td>
              Confirmer le mot de passe
          </td>
          <td>
              <input type="password" name="passwordConfirm" placeholder="*******"required>
          </td>
      </tr>
  </table>
<div id="button">
<button type="submit">Inscription</button>

</div>

</form>
</div>
<?php } else { ?>

    
		<p id="info" class='mt-4'>
			Bonjour <?= $_SESSION['pseudo'] ?><br>

		
  <h2 class='text-center'>  <p>Liste des menbres</p></h2>
    <?php
     if(isset($_POST['pseudo'])  && isset($_POST['email']) && isset($_POST['password']))  {
   
        $pseudo= $_POST['pseudo'];
        $email= $_POST['email'];
        $password= $_POST['password'];
    
        $requete= $conn -> prepare('INSERT INTO users(pseudo, email,password) VALUES (?,?,?)');
    
         $requete ->execute(array($pseudo, $email, $password));
      }
    
    
      $requete= $conn -> query('SELECT * FROM users');
    
      echo  " <table class='table table-striped' id='tableau' >
      <tr id='tableheader'>
      <th>
      Pseudo
      </th>
      <th>
      Nom
      </th>
      <th>
      Prénom
      </th>
      <th>
      Email
    </th>
   
    
    </tr> ";
    
    
    
    
    while($donnees = $requete -> fetch()){
       
      
        echo '<tr>
    
        <td> '. $donnees['pseudo'].' </td>
        <td> '. $donnees['nom'].' </td>
        <td> '. $donnees['prenom'].' </td>
        <td> '. $donnees['email'].' </td>
       
    
        </tr>';
        
       
    }
    $requete -> CloseCursor();
        echo '</table>';
        
        
    
        ?>
    
    
        <div class='mt-4'>
        <a href="disconection.php" >Déconnexion</a>

        </div>
		</p>

		<?php } ?>
</div>
</body>
</html>