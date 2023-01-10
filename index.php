<?php require("./Model/Register.php") ?>

<?php
   if(isset($_POST['submit'])){
      $user = new RegisterUser($_POST['login'], $_POST['password'], $_POST['password_confirmation'], $_POST['email'], $_POST['first_name']);
   }
?>
<!DOCTYPE html>
<html lang="ru">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="../assets/css/style.css">
   <script src="../assets/js/main.js"></script>
   <title>Регситрация в приложении</title>
</head>
<body>
 <form action="" method="post" enctype="multipart/form-data" autocomplete="off" name="registerForm">
      <h2>Зарегистрирвоаться в приложении</h2>
      <h4>Все поля обязательны для <span>заполнения</span></h4>
 
      <label>Логин</label>
      <input type="text" name="login" placeholder="Придумайте логин" value="<?=$_POST['login'] ?? null?>">
 
      <label>Пароль</label>
      <input type="password" name="password" placeholder="Придумайте пароль" value="<?=$_POST['password'] ?? null?>">
      <label>Подтвердите пароль: </label>
      <input type="password" name="password_confirmation" placeholder="Повторите пароль" value="<?=$_POST['password_confirmation'] ?? null?>">
      <label>Электронная почта:</label>
      <input type="email" name="email" placeholder="Ваш e-mail" value="<?=$_POST['email'] ?? null?>">
      <label>Имя:</label>
       <input type="text" name="first_name" placeholder="Ваше имя" value="<?=$_POST['first_name'] ?? null?>">
                                         

 
      <button type="submit" name="submit" class="register">Зарегистрироваться</button>
 
      <p class="error" id="registerError"><?php echo @$user->error ?></p>
      <p class="success" id="registerSucces"><?php echo @$user->success ?></p>
   </form>






  	</body>
</html>
