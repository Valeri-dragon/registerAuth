<?php

class RegisterUser {
  //class properties.
  private $login;
  private $raw_password;
  private $password_confirmation;
  private $encrypted_password;
  private $email;
  private $first_name;
  public $error;
  public $success;
  private $storage = "./Core/data.json";
  private $stored_users; //array
  private $new_user; //array

public function __construct($login, $password, $password_confirmation, $email, $first_name){
      $this->login = filter_var(trim($login), FILTER_SANITIZE_STRING);
      $this->raw_password = filter_var(trim($password), FILTER_SANITIZE_STRING);
      $this->password_confirmation= filter_var(trim($password_confirmation), FILTER_SANITIZE_STRING);
      $this->encrypted_password = password_hash($password_confirmation, PASSWORD_DEFAULT);
       $this->email = filter_var(trim($email), FILTER_SANITIZE_STRING);
        $this->first_name = filter_var(trim($first_name), FILTER_SANITIZE_STRING);
      $this->stored_users = json_decode(file_get_contents($this->storage), true);
      $this->new_user = [
         "login" => $this->login,
         "password" => $this->encrypted_password,
         "email"=> $this->email,
         "first_name"=> $this->first_name,
      ];
      if($this->checkFieldValues()){
   $this->insertUser();
}
   }

private function checkFieldValues(){

      if (isset($_POST['login'])) {
            $login = trim($_POST['login']);
            $this->data['login'] = $login;
            if (mb_strlen($login) == 0) {
                $this->error .= 'Логин не может быть пустым<br>';
            }
            if(mb_strlen($login)<6){
               $this->error .= 'Логин не может иметь длину менее 6-ти символов<br>';
            }
        } else {
           //$this->data['login'] = '';
            $this->error .= 'Необходимо заполнить логин<br>';
        }
        if (isset($_POST['password'])) {
            $password = trim($_POST['password']);
            $this->data['password'] = $password;
            if (mb_strlen($password) == 0) {
                $this->error .= 'Пароль не может быть пустым<br>';
            }
            if(mb_strlen($password) < 6 || !preg_match("/[a-z0-9_]/i", $password) ){
 $this->error .= 'Пароль не может  иметь длину менее 6-ти символов и должен состоять из латинских букв и цифр<br>';
            }
            
        } else {
           // $this->data['password'] = '';
            $this->error .= 'Необходимо заполнить пароль<br>';
        }
          if (isset($_POST['password_confirmation'])) {
            $password_confirmation = trim($_POST['password_confirmation']);
            $this->data['password_confirmation'] = $password_confirmation;
            if (mb_strlen($password_confirmation) == 0) {
                $this->error .= 'Поле подтверждения пароля не может быть пустым<br>';
            }
        } else {
           // $this->data['password_confirmation'] = '';
            $this->error .= 'Необходимо заполнить подтверждение пароля<br>';
        }
if( !empty($this->password_confirmation) && $password!== $password_confirmation){
   $this->error .= 'Подтверждение пароля не совпадает с придуманным паролем<br>';

}/*else {
            $this->data['password_confirmation']= '';
            $this->error .= 'Введите верное подтверждение пароля<br>';
        }*/

        if (isset($_POST['email'])) {
            $email = trim($_POST['email']);
            $this->data['email'] = $email;
            if (mb_strlen($email) == 0) {
                $this->error .= 'Ваш e-mail не может быть пустым<br>';
            }
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
 $this->error .= 'Ваш e-mail должен иметь вид: info@example.ru<br>';
            }
        } else {
          // $this->data['email'] = '';
            $this->error .= 'Необходимо заполнить ваш e-mail<br>';
        }
        if (isset($_POST['first_name'])) {
            $first_name = trim($_POST['first_name']);
            $this->data['first_name'] = $first_name;
            if (mb_strlen($first_name) == 0) {
                $this->error .= 'Поле ваше имя не может быть пустым<br>';
            }
            if(mb_strlen($first_name)<2){
 $this->error .= 'Поле ваше имя не может быть меньше 2-х символов<br>';
            }
        } else {
           // $this->data['first_name'] = '';
            $this->error .= 'Необходимо ввести ваше имя<br>';
        }
        if( $error) 
        {
          echo $this->error;
          // exit();
         
         }
        return $this->error == '';//true если не было ошибки
   }
   //функция для перебора уже имеющихся пользователей
 private function usernameExists(){
      foreach ($this->stored_users as $user) {
        if($this->login == $user['login']){
            $this->error = "Данный login, уже используется в приложение. Придумайте другой login.";
            return true;
         }
         if($this->email == $user['email']){
            $this->error = "Данный e-mail, уже зарегистрирован в приложение. Используйте другой e-mail.";
            return true;
         }
      }
   }
   //функция для записи нового пользователя
    private function insertUser(){
      if($this->usernameExists() == FALSE){
         array_push($this->stored_users, $this->new_user);
         if(file_put_contents($this->storage, json_encode($this->stored_users))){
$_POST = array();
            return $this->success = "Ваша регистрация прошла успешно";
        
         }else{
            return $this->error = "Что-то пошло не так, пожалуйста, попробуйте еще раз";
         }
      }
   }

}