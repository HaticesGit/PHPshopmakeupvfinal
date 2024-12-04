<?php 
    namespace Hatice\makeupshop\interfaces;
    interface iUser{
        public function login();
        public function canLogin();
        //public function changePassword($oldPassword, $newPassword);
    }