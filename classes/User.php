<?php 
namespace Hatice\makeupshop;
use Hatice\makeupshop\interfaces\iUser;
include_once("Db.php");

include_once(__DIR__ . '/interfaces/iUser.php');
if (!interface_exists('Hatice\makeupshop\Interfaces\iUser')) {
    echo "Interface iUser not found!";
}


/*$user = new User();
//...
$user->save();
if(User::canLogin($email, $password))*/
 class User {
    protected $firstname; //als r staat var staat er eignelijk public 4 principes abstactie, encapsulation, overerving en polymorfism (test vraag)
    protected $lastname;

    protected $email;
    protected $password;
    protected $birthdate;

    
    /**
     * Get the value of firstname
     */ 
    public function getFirstname()
    //public static function save(){
    //SQL}

    {
        return $this->firstname;
    }

    /**
     * Set the value of firstname
     
     * @return  self
     */ 
    public function setFirstname($firstname)
    {
        if(empty($firstname)){
            throw new Exception("firstname cannot be empty");
        }
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get the value of lastname
     */ 
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set the value of lastname
     *
     * @return  self
     */ 
    public function setLastname($lastname)
    {
        if(empty($lastname)){
            throw new Exception("lastname cannot be empty");
        }
        $this->lastname = $lastname;

        return $this;
    }

/**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of birthdate
     */ 
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * Set the value of birthdate
     *
     * @return  self
     */ 
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;

        return $this;
    }
    public function save(){
        $conn = Db::getConnection();
        // $conn = new PDO('mysql:dbname=makeupshop;host=localhost', "root", "root");
        $statement = $conn->prepare('INSERT INTO users (email, password) VALUES (:email , :password)');
        $statement->bindValue("email", $this->email);
        $statement->bindValue("password", $this->password);
        $statement->execute();
    }

    public static function getAll(){ //new
        $conn = Db::getConnection();
        $conn = new PDO('mysql:dbname=makeupshop;host=localhost', "root", "root"); 
        $statement = $conn->query('SELECT * FROM users');
        return $statement->fetchAll(PDO::FETCH_ASSOC);

    }

    public static function canLogin($email, $password) {
        $conn = Db::getConnection();
        $statement = $conn->prepare('SELECT * FROM users WHERE email = :email');
        $statement->bindValue(':email', $email);
        $statement->execute();
        $user = $statement->fetch(\PDO::FETCH_ASSOC);
        if ($user) {
            $hash = $user['password'];
            if (password_verify($password, $hash)) {
                return $user;
            }
        }
        return false;
    }


    public static function changePassword($email, $password) {
        $conn = Db::getConnection();
        $query = $conn->prepare("UPDATE users SET password = :password WHERE email = :email");
        $query->bindValue(":email", $email);
        $options = ["cost" => 15,];
        $password = password_hash($password, PASSWORD_DEFAULT, $options);
        $query->bindValue(":password", $password);
        $query->execute();
    }

    public static function adminCheck($email) {
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT admin FROM users WHERE email = :email");
        $statement->bindValue(":email", $email);
        $statement->execute();
        $result = $statement->fetch(\PDO::FETCH_ASSOC);
        return $result;
    }
    public static function editProduct( $id, $title, $price, $img, $descr, $stock, $variation) {
        $conn = Db::getConnection();
        $query = $conn->prepare("UPDATE products SET title = :title, price = :price, img = :img, descr = :descr, stock = :stock, variation = :variation WHERE id = :id");
        $query->bindValue(":id", $id);
        $query->bindValue(":title", $title);
        $query->bindValue(":price", $price);
        $query->bindValue(":img", $img);
        $query->bindValue(":descr", $descr);
        $query->bindValue(":stock", $stock);
        $query->bindValue(":variation", $variation);
        $query->execute();
    }
  }