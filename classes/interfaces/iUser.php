<?php 
    namespace Hatice\makeupshop\interfaces;
    interface iUser{
        public function login();
        public static function canLogin($email, $password);
        //public function changePassword($oldPassword, $newPassword);
    }