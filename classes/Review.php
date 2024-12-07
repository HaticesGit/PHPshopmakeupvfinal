<?php
namespace Hatice\makeupshop;
require_once(__DIR__ . "/Db.php");
use Hatice\makeupshop\Db;
    class Review {
        private $text;
        private $product_id;
        private $user_id;

        /**
         * Get the value of text
         */ 
        public function getText()
        {
            return $this->text;
        }

        /**
         * Set the value of type
         *
         * @return  self
         */ 
        public function setText($text)
        {
            $this->text = $text;

            return $this;
        }

        
        /**
         * Get the value of product_id
         */ 
        public function getProduct_id()
        {
            return $this->product_id;
        }

        /**
         * Set the value of product_id
         *
         * @return  self
         */ 
        public function setProduct_id($product_id)
        {
            $this->product_id = $product_id;

            return $this;
        }

        /**
         * Get the value of user_id
         */ 
        public function getUser_id()
        {
            return $this->user_id;
        }

        /**
         * Set the value of user_id
         *
         * @return  self
         */ 
        public function setUser_id($user_id)
        {
            $this->user_id = $user_id;

            return $this;
        }

        public function saveReview(){
            $conn = Db::getConnection();
            $statement = $conn->prepare("INSERT INTO reviews (text, product_id, user_id) VALUES (:text, :product_id, :user_id)");
            $text = $this->getText();
            $product_id = $this->getProduct_id();
            $user_id = $this->getUser_id();
            
            $statement->bindValue(":text", $text);
            $statement->bindValue(":product_id", $product_id);
            $statement->bindValue(":user_id", $user_id);

            $result = $statement->execute();
            return $result;
        }

        public static function getAll($product_id){
            $conn = Db::getConnection();
            $statement = $conn->prepare("SELECT * FROM reviews where product_id = :product_id");
            $statement->bindValue(":product_id", $product_id);
            $result = $statement->execute();
            return $statement->fetchAll(\PDO::FETCH_ASSOC);
        }

        public static function hasOrderedProduct($user_id, $product_id) {
            $conn = Db::getConnection();
            $statement = $conn->prepare("SELECT COUNT(*) FROM orders JOIN orders_products ON orders.id = orders_products.orders_id WHERE orders.user_id = :user_id AND orders_products.products_id = :product_id");
            $statement->bindValue(":user_id", $user_id);
            $statement->bindValue(":product_id", $product_id);
            $statement->execute();
            return $statement->fetchColumn() > 0;
        }

    }