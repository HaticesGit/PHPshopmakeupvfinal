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
abstract class User implements Interfaces\iUser{
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
    /*public function save(){
        $conn = Db::getConnection();
        $conn = new PDO('mysql:dbname=makeupshop;host=localhost', "root", "root");
        $statement = $conn->prepare('INSERT INTO users (firstname, lastname) VALUES (:firstname , :lastname)');
        $statement->bindValue("firstname", $this->firstname);
        $statement->bindValue("lastname", $this->lastname);
        $statement->execute();
    }

    public static function getAll(){ //new
        $conn = Db::getConnection();
        $conn = new PDO('mysql:dbname=makeupshop;host=localhost', "root", "root"); 
        $statement = $conn->query('SELECT * FROM users');
        return $statement->fetchAll(PDO::FETCH_ASSOC);

    }*/
    public static function changePassword($email, $password) {
        $conn = Db::getConnection();
        $query = $conn->prepare("UPDATE users SET password = :password WHERE email = :email");
        $query->bindValue(":email", $email);
        $options = ["cost" => 15,];
        $password = password_hash($password, PASSWORD_DEFAULT, $options);
        $query->bindValue(":password", $password);
        $query->execute();
    }
  }