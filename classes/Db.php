<?php 
    namespace Hatice\makeupshop;
    // class Db{
    //     private static $conn = null;  //statiek maken

    //     public static function getConnection(){
    //         //Db::getConnection();
    //         if(self::$conn == null){//geen this want geen instantie
    //             self::$conn =  new \PDO('mysql:dbname=makeupshop;host=localhost', "root", "root");
    //             return self::$conn;
    //     }
    //     else{
    //         return self::$conn;
    //     } //als je connectie vraagt, staat er al 1 open? als er geen staat dan...
    // }

    class Db {
        private static $conn;
        const SETTINGS = [
            "user" => "root", 
            "password" => "tOJmgRJtOljxohfnPqxNHWEjOUxvArYw", 
            "host" => "mysql.railway.internal", 
            "db" => "railway",
            "ssl_ca" => __DIR__ . "/CA.pem"
        ];


        public static function getConnection(){
            if (self::$conn === null) {
                $options[PDO::MYSQL_ATTR_SSL_CA] = self::SETTINGS['ssl_ca'];
                self::$conn = new PDO("mysql:host=".self::SETTINGS["host"].";dbname=".self::SETTINGS["db"]."",self::SETTINGS["user"],self::SETTINGS["password"], $options);
                //[PDO::MYSQL_ATTR_SSL_CA => __DIR__."/CA.pem"]
                return self::$conn;
            }
            else {return self::$conn;}
        }
    }