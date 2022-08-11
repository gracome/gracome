
    <?php

//     if(isset($_POST['nom'])  && isset($_POST['prenom']))  {
   
//         echo 'Bonjour '.$_POST['nom'].' '.$_POST['prenom'].' ';
//     }

//     if(isset($_FILES['image'])&& $_FILES['image']['error']==0){

//         if($_FILES['image']['size']<= 3000000){

//             $informationImage= pathinfo($_FILES['image']['name']);

//             $extensionImage= $informationImage['extension'];
//             $extensionsArray= array('png', 'jpg', 'jpeg', 'gif');


//             if(in_array($extensionImage, $extensionsArray )){
//                 move_uploaded_file($_FILES['image']['tmp_name'], 'upload/' .time(). rand() .rand(). '.' .$extensionImage);
//                 echo 'Envoie réussit !';
//             }
//         }

//     }
  
//  echo "
//  <form method='post' action='index.php' enctype='multipart/form-data'>
//     <table>
//     <tr>
//         <td>
//         Nom
//         </td>
//         <td>
//         <input type='text' name='nom'>
//         </td>
//       </tr>
       
//       <tr>
//       <td>
//       Prénom
//       </td>
//       <td>
//       <input type='text' name='prenom'>
//       </td>
//     </tr>
     
//     <tr>
//     <td>
//     Profile
//     </td>
//     <td>
//     <input type='file' name='image'>
//     </td>
//   </tr>
    
//     </table>
//     <button type='submit'> Envoyer</button>

 
//  </form>
    
//  "
 
 
 try {
 $conn = new PDO("mysql:host=localhost;dbname=users;charset=UTF8", 'root', '');

 

    // echo "Connexion réussie";
 }
 catch(PDOException $e){
    echo "Erreur : " . $e->getMessage();
  }



  

  


  if(isset($_POST['nom'])  && isset($_POST['prenom']) && isset($_POST['serie']))  {
   
    $prenom= $_POST['prenom'];
    $nom= $_POST['nom'];
    $serie= $_POST['serie'];

    $requete= $conn -> prepare('INSERT INTO USER(nom, prenom,série) VALUES (?,?,?)');

     $requete ->execute(array($prenom, $nom, $serie));
  }


  $requete= $conn -> query('SELECT * FROM USER');

  echo  " <table border>
  <tr>
  <th>
  Nom
  </th>
  <th>
  Prenom
</th>
<th>
Serie_préférée
</th>

</tr> ";




while($donnees = $requete -> fetch()){
   
  
    echo '<tr>

    <td> '. $donnees['prenom'].' </td>
    <td> '. $donnees['nom'].' </td>
    <td> '. $donnees['série'].' </td>

    </tr>';
    
   
}
$requete -> CloseCursor();
    echo '</table>';
    
    

    ?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Ajouter un utilisateur </h1>

    <form method="post" action="index.php">
    <table>
     <tr>
         <td>
         Prénom
         </td>
         <td>
         <input type='text' name='nom'>
         </td>
       </tr>
       
       <tr>
       <td>
       Nom
       </td>
       <td>
       <input type='text' name='prenom'>
       </td>
     </tr>
     
     <tr>
     <td>
     Série
     </td>
     <td>
     <input type='text' name='serie'>
     </td>
   </tr>
    
     </table>
     <button type='submit'> Ajouter</button>


    </form>
</body>
</html>