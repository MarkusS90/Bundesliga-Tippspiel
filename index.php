<?php
require __DIR__ . '/vendor/autoload.php';
require './src/header.php';
require './src/jumbotron.php';
?>

<div class="row">
  <div class="col-sm-6">
  <h3>Login</h3>
  <form action="./login.php" method="POST">
  <div class="form-group">
    <label for="email">Email Adresse:</label>
    <input type="email" class="form-control" placeholder="Email eingeben" id="email" name="email">
  </div>
  <div class="form-group">
    <label for="pwd">Passwort:</label>
    <input type="password" class="form-control" placeholder="Passwort eingeben" id="pwd" name="password">
  </div>
  <button type="submit" class="btn btn-primary">Login</button>
</form> 
  </div>

  <div class="col-sm-6"><h3>Registrieren</h3>
  <form action="./register.php" method="POST">
  <div class="form-group">
    <label for="email">Email Adresse:</label>
    <input type="email" class="form-control" placeholder="Email eingeben" id="email" name="email">
  </div>
  <div class="form-group">
    <label for="username">Username:</label>
    <input type="text" class="form-control" placeholder="Username eingeben" id="username" name="username">
  </div>
  <div class="form-group">
    <label for="pwd">Passwort:</label>
    <input type="password" class="form-control" placeholder="Passwort eingeben" id="pwd" name="password">
  </div>
  <div class="form-group">
    <label for="pwd">Passwort wiederholen:</label>
    <input type="password" class="form-control" placeholder="Passwort wiederholen" id="pwd" name="password2">
  </div>
  <button type="submit" class="btn btn-primary">Registrieren</button>
</form> 
  </div>

</div> 

<?php
require './src/footer.php';
?> 