<?php
class LoginUser{
   // class properties --------------------------------------
   private $login;
   private $password;
   public $error;
   public $success;
   private $storage = "../Core/data.json";
   private $stored_users;
 
   // class methods -----------------------------------------
   public function __construct($login, $password){
      $this->login = $login;
      $this->password = $password;
      $this->stored_users = json_decode(file_get_contents($this->storage), true);
      $this->login();
   }
 
   private function login(){
      foreach ($this->stored_users as $user) {
         if($user['login'] == $this->login){
            if(password_verify($this->password, $user['password'])){
               // You can set a session and redirect the user to his account.
               return  $this->success = "You are loged in";
            }
         }
         if($user['login']!==$this->login){
           $this->error .="Этих учетных данных нет в нашей базе<br>";
         }

         if($user['login']==$this->login&&$user['password']!=$this->password){
           $this->error .="Не верный пароль<br>";
         }
         
      }
      
     // return $this->error = "Wrong username or password";
   }
} // end of class