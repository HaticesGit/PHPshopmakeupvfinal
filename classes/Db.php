<?php 
    namespace Hatice\makeupshop;
    class Db{
        private static $conn = null;  //statiek maken

        public static function getConnection(){
            //Db::getConnection();
            if(self::$conn == null){//geen this want geen instantie
                self::$conn =  new \PDO('mysql:dbname=makeupshop;host=localhost', "root", "root");
                return self::$conn;
        }
        else{
            return self::$conn;
        } //als je connectie vraagt, staat er al 1 open? als er geen staat dan...
    }
}