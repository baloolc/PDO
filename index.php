
<?php

require_once 'connec.php';

$pdo = new \PDO(DSN, USER, PASS);
$query = "SELECT * FROM friend";
$statement = $pdo->query($query);
$friends = $statement->fetchAll(PDO::FETCH_ASSOC);

$errors = [];

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $request = array_map('trim', $_POST);


    if (empty($request["firstname"])) {
        $errors[] = "Le prénom est requis";
      }

      if (empty($request["lastname"])) {
        $errors[] = "Le nom est requis";
      }

      $firstnameMaxLength = 45;
      if (strlen($request['firstname']) > $firstnameMaxLength) {
          $errors[] = 'Le prénom doit faire moins de ' . $firstnameMaxLength . ' caractères';
      }

      $lastnameMaxLength = 45;
      if (strlen($request['lastname']) > $lastnameMaxLength) {
          $errors[] = 'Le nom doit faire moins de ' . $lastnameMaxLength . ' caractères';
      }

      if (empty($errors)) {

        $query = "INSERT INTO friend (firstname, lastname) VALUES (:firstname, :lastname)";
        $statement = $pdo->prepare($query);
        $statement->bindValue('firstname', $request['firstname']);
        $statement->bindValue('lastname', $request['lastname']);
        $statement->execute();
        header('Location: /index.php');
      }

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDO</title>
</head>
<body>
    <ul>
        <?php  foreach($friends as $friend):?>
        <li><?= $friend['firstname'] . ' ' . $friend['lastname'];?></li>
        <?php endforeach; ?>
    </ul>
    <h1>Personnage</h1>
    <form action="" method="POST">
        <label for="firstname">Prénom</label>
         <input type="text" id="firstname" name="firstname" required placeholder="Le prénom" >
        <label for="lastname">Nom</label>
         <input type="text" id="lastname" name="lastname" required placeholder="Le nom" >
        <button>Ajouter</button>
    </form>
    
</body>
</html>