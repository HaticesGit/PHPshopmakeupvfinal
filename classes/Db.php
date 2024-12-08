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
        private static $conn = null;
        const SETTINGS = [
            // "user" => "root", 
            // "password" => "tOJmgRJtOljxohfnPqxNHWEjOUxvArYw", 
            // "host" => "junction.proxy.rlwy.net:31590/railway", 
            // "db" => "railway",
             "ssl_ca" => __DIR__ . "/CA.pem"
           

        ];
       

        public static function getConnection(){
        if (self::$conn === null) {
            $options = [
                \PDO::MYSQL_ATTR_SSL_CA => self::SETTINGS['ssl_ca'],
                \PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false // For testing purposes only
            ];
            try {
                 $host = getenv('DB_HOST');
                $db = getenv('DB_NAME');
                $user = getenv('DB_USER');
                $password = getenv('DB_PASS');
                $port = getenv('DB_PORT');


                self::$conn = new \PDO(
                    "mysql:host=$host;port=$port;dbname=$db",
                    $user,
                    $password,
                    $options
                );
            } catch (\PDOException $e) {
                // Handle the exception (e.g., log the error, rethrow, etc.)
                throw new \Exception("Database connection error: " . $e->getMessage());
            }
        }
        return self::$conn;
    }
    }