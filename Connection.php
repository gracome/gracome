<?php
session_start();

if(isset($_SESSION['connect'])){
	header('location: inscription.php');
	exit();
}


require("src/connexion.php");


if(!empty($_POST['email']) && !empty($_POST['password'])){

	$email 		= $_POST['email'];
	$password 	= $_POST['password'];
    $error = 1;

	$password = "aq1".sha1($password."1254")."25";


	$req = $conn->prepare('SELECT * FROM users WHERE email = ?');
	$req->execute(array($email));

    while($user = $req->fetch()){

		if($password == $user['password']){
            $error = 0;
			$_SESSION['connect'] = 1;
			$_SESSION['pseudo']	 = $user['pseudo'];

            if(isset($_POST['connect'])) {
				setcookie('log', $user['secret'], time() + 365*24*3600, '/', null, false, true);
			}

             header('location: connection.php?sucess=1');

        }
    }
    if($error == 1){
		header('location: connection.php?error=1');
		exit();
	}


}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Design/Default.css">
    <title>Connection</title>
</head>
<body>
    <header>
    <h1>Connection</h1>  

    </header>
    <div class="container">
    <p id="info">Bienvenue sur mon site, pour avoir plus de détail connectez-vous. Si vous n'avez pas de compte , <br> <a href="inscription.php">Inscrivez-vous.</a></p>

    <?php
    if(isset($_GET['error'])){
				echo'<p id="error">Adresse email ou mot de passe incorrect.</p>';
			}
			else if(isset($_GET['sucess'])){
				echo'<p id="success">Connexion réussie.</p>';
			}
		?>

<div id="form">

<form action="connection.php" method="post" >
  <table>
   
    
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
    
  </table>

  <p>
        <label for="connect">
        <input type="checkbox" name="connect" checked> Connexion automatique
        </label>
    </p>
    <div id="button">
    <button type="submit">Connection</button>

    </div>
 
</form>
</div>
    </div>
  
</body>
</html>