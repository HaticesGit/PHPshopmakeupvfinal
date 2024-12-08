<?php 
    namespace Hatice\makeupshop;
    class Db {
        private static $conn = null;
        const SETTINGS = [
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
                throw new \Exception("Database connection error: " . $e->getMessage());
            }
        }
        return self::$conn;
    }
    }