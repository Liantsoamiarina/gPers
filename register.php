<?php require'function.php';?>
<?php

 $errors=array();

$pdo=new PDO("mysql:dbname=register;host=localhost","root","");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);



if (isset($_POST['submit'])) {

    if (isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email']) && isset($_POST['password'])) {
  $first_name=$_POST["first_name"];
  $last_name=$_POST["last_name"];
  $email=$_POST["email"];
  $password=$_POST["password"];
  $confirm=$_POST["password_repeat"];
} }



if(empty($first_name)){
  $errors['first_name']="Votre prénom est invalide";
}else{
    $req=$pdo->prepare('SELECT id FROM users WHERE last_name= ?');
  $req->execute([$_POST["last_name"]]);
  $users=$req->fetch();
  if($users){ 
   $errors["first_name"]="ce nom existe déjà";
  } }

    if(empty($last_name)){
      $errors['last_name']="Votre prénom est invalide";
    }else{
      $req=$pdo->prepare('SELECT id FROM users WHERE last_name= ?');
    $req->execute([$_POST["last_name"]]);
    $users=$req->fetch();
    if($users){
      $errors["last_name"]="ce prénom existe déjà";
    }
    }


  
           
    if(empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ) {
      $errors['email'] = "Votre email n'est pas valide";
      } else {
      $req = $pdo->prepare('SELECT id FROM users WHERE email = ?');
      $req->execute([$_POST['email']]);
      $user = $req->fetch(); 
      if($user) {
      $errors['email'] = 'Cet email est déja utilise pour un autre compte';
        }
      }
        
        if(empty($_POST['password']) || $_POST['password'] != $_POST['password_repeat']){
          $errors['password'] = "Vous devez rentrer un mot de passe valide";
            
          }
        
        
        if(empty($errors)){ 
        $req = $pdo->prepare("INSERT INTO users SET first_name = ?,last_name = ?, password = ?, email = ?");
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $req->execute([$_POST['first_name'],$_POST['last_name'], $_POST['email'],$password, ]);
        die('Notre compte a bien été créé');
        }
        
        debug($errors);
        ?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Register</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/css/animate.min.css">
</head>

<!-- Gestion d'erreur -->
<?php if ( empty($errors)):  ?>
  <div class="alert alert-danger">

  <p>Vous n'avez pas rempli le formulaire correctement</p>
  <?php foreach($errors as $error): ?>

 <?php endforeach?>
 </div>
<?php endif ?>

<body class="bg-gradient-primary" style="background: linear-gradient(68deg, #5ea8ed, white);">
    <div class="container">
    <div class="card shadow-lg o-hidden border-0 my-5" style="filter: blur(0px);border-radius: 57.6px;">
    <div class="card-body p-0">
   <div class="row">
        <div class="col-lg-5 d-none d-lg-flex"><img src="assets/img/meeting.svg"></div>
         <div class="col-lg-7">
         <div class="p-5">
         </div><div class="text-center"> 
              <h4 class="text-dark mb-4">Create an Account!</h4>
                  </div>
               <form class="user" action="register.php" method="post">
                 <div class="row mb-3">
               <div class="col-sm-6 mb-3 mb-sm-0"><input class="form-control form-control-user" type="text" data-bss-hover-animate="pulse" id="exampleFirstName" placeholder="First Name" name="first_name" style="color: rgb(99,116,241);"></div>
                     <div class="col-sm-6" >
                  <input class="form-control form-control-user" type="text" data-bss-hover-animate="pulse" id="exampleLastName" placeholder="Last Name" name="last_name"></div>
                         </div>
                          <div class="mb-3"><input class="form-control form-control-user" type="email" data-bss-hover-animate="pulse" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Email Address" name="email"></div>
                           <div class="row mb-3">
                      <div class="col-sm-6 mb-3 mb-sm-0"><input class="form-control form-control-user" type="password" data-bss-hover-animate="pulse" id="examplePasswordInput" placeholder="Password" name="password"></div>
                      <div class="col-sm-6"><input class="form-control form-control-user" type="password"data-bss-hover-animate="pulse" id="exampleRepeatPasswordInput" placeholder="Repeat Password" name="password_repeat"></div>
                          </div><button class="btn btn-primary d-block btn-user w-100" data-bss-hover-animate="flash" type="submit" name="submit">Register Account</button>
                            <hr><a class="btn btn-primary d-block btn-google btn-user w-100 mb-2" role="button"><i class="fab fa-google"></i>&nbsp; Register with Google</a><a class="btn btn-primary d-block btn-facebook btn-user w-100" role="button"><i class="fab fa-facebook-f"></i>&nbsp; Register with Facebook</a>
                              <hr>
                </form>
             <div class="text-center"><a class="small" href="forgot-password.html">Forgot Password?</a></div>
            <div class="text-center"><a class="small" href="login.php">Already have an account? Login!</a></div>
           </div>
          </div>
         </div>
         </div>
        </div>
        </div>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/theme.js"></script>
</body>

</html>