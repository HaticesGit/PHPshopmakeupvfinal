<?php 
    namespace Hatice\makeupshop;
    include_once("Db.php");

    class Admin extends User{
        private $admin;

        /**
         * Get the value of admin
         */ 
        public function getAdmin()
        {
                return $this->admin;
        }

        /**
         * Set the value of admin
         *
         * @return  self
         */ 
        public function setAdmin($admin)
        {
                $this->admin = $admin;

                return $this;
        }
    }