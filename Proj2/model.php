<?php


ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);


class database{

    private $pdo;
    private $password;
    private $restaurantID;
    private $drinkID;

    public function connect_db() {

        $dsn =  'mysql:dbname=CoffeeKing_DB;host=localhost;port=8889';
        $username = 'Coffee';
        $password = 'lzcJsPl1blChx869';

        try {
            $this->pdo = new PDO($dsn, $username, $password);
        }

        catch (PDOExecption $e) {
            echo $e->Message();
        }
    }

#====================================Users

    public function register($username, $firstName, $lastName, $password) {

        $this->password = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO `365_users` (username, firstName, lastName, password) VALUE (:UN, :FN, :LN, :PW)";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(":UN", $username);
        $stmt->bindParam(":FN", $firstName);
        $stmt->bindParam(":LN", $lastName);
        $stmt->bindParam(":PW", $this->password);
        $stmt->execute();
    }

    public function userCheck($username) {

        $query = "SELECT username FROM `365_users` WHERE username = :UN AND status IS NULL";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(":UN", $username);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateUsers($username, $firstName, $lastName, $password, $oldUsername) {

        $this->password = password_hash($password, PASSWORD_DEFAULT);

        $query = "UPDATE `365_users` SET username = :UN, firstName = :FN, lastName = :LN, password = :PW WHERE username = :OUN";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(":UN", $username);
        $stmt->bindParam(":FN", $firstName);
        $stmt->bindParam(":LN", $lastName);
        $stmt->bindParam(":PW", $this->password);
        $stmt->bindParam(":OUN", $oldUsername);
        $stmt->execute();
    }

    public function selectOneUser($username, $password, $direction) {

        $query = "SELECT * FROM `365_users` WHERE username = :UN AND `status` IS NULL";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(":UN", $username);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->password = $row['password'];
        

        if ($direction == "login") {
            if (password_verify($password, $this->password)) {
                $dataInfo = array('resp_code' => 201, "account" => $row['accounType']);
                return $dataInfo;
            }
            else {
                $dataInfo = array('resp_code' => 401, "account" => $row['accountType']);
                return $dataInfo;
            }
        }

        else {
            return $row;
        }
        
    }

    public function deleteUser($username) {

        $query = "UPDATE `365_users` SET status = 'deleted' WHERE username = :UN";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(":UN", $username);
        $stmt->execute();
    }

#====================================Drinks

    public function saveDrinks($drinkName, $image) {

        $query = "INSERT INTO `149_drinks` (drinkName, drinkImage, restaurantID) VALUES (:DN, :DI, :RID)";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(":DN", $drinkName);
        $stmt->bindParam(":DI", $image);
        $stmt->bindParam(":RID", $this->restaurantID);
        $stmt->execute();
    }

    public function updateDrinks($drinkID, $drinkName, $drinkImage) {

        $query = "UPDATE `149_drinks` SET drinkName = :DN, drinkImage = :DI WHERE drinkID = :ID AND status IS NULL";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':DN', $drinkName);
        $stmt->bindParam(':DI', $drinkImage);
        $stmt->bindParam(':ID', $drinkID);
        $stmt->execute();
    }

    public function selectDrinks() {
        
        $query = "SELECT * FROM `149_drinks` WHERE restaurantID = :RID AND status IS NULL";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':RID', $this->restaurantID);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $row;
    }

    public function selectOneDrink($drinkID) {

        $query = "SELECT * FROM `149_drinks` WHERE drinkID = :DID AND status IS NULL";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':DID', $drinkID);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    public function deleteDrinks($drinkID) {

        $query1 = "SELECT restaurantID FROM `149_drinks` WHERE drinkID = :DID";
        $stmt1 = $this->pdo->prepare($query1);
        $stmt1->bindParam(":DID", $drinkID);
        $stmt1->execute();
        $row = $stmt1->fetch(PDO::FETCH_ASSOC);

        if ($row['restaurantID'] == $this->restaurantID) {

            $query = "UPDATE `149_drinks` SET status = 'deleted' WHERE drinkID = :ID";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(":ID", $drinkID);
            $stmt->execute();

        }
    }

#====================================Resurants

    public function getRestaurantID($username) {

        $query = "SELECT restaurantID FROM `356_restaurants` WHERE username = :UN AND status IS NULL";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(":UN", $username);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->restaurantID = $row['restaurantID'];

    }

    public function createRestraurant($restaurantName, $streetName, $streetNumber, $suburb, $postcode, $username) {

        $query = "INSERT INTO `356_restaurants` (restaurantName, streetName, streetNumber, suburb, postcode, username) VALUES (:RN, :SN, :SNO, :S, :PC, :UN)";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(":RN", $restaurantName);
        $stmt->bindParam(":SN", $streetName);
        $stmt->bindParam(":SNO", $streetNumber);
        $stmt->bindParam(":S", $suburb);
        $stmt->bindParam(":PC", $postcode);
        $stmt->bindParam(":UN", $username);
        $stmt->execute();

        $query1 = "UPDATE `365_users` SET accountType = 'R' WHERE username = :UN";
        $stmt1 = $this->pdo->prepare($query1);
        $stmt1->bindParam(":UN", $username);
        $stmt1->execute();
    }

    public function updateResuraunt($restaurantName, $streetName, $streetNumber, $suburb, $postcode) {

        $query =  "UPDATE `356_restaurants` SET restaurantName = :RN, streetName = :SN, streetNumber = :SNO, suburb = :S, postcode = :PC WHERE restaurantID = :ID AND status IS NULL";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(":RN", $restaurantName);
        $stmt->bindParam(":SN", $streetName);
        $stmt->bindParam(":SNO", $streetNumber);
        $stmt->bindParam(":S", $suburb);
        $stmt->bindParam(":PC", $postcode);
        $stmt->bindParam(":ID", $this->restaurantID);
        $stmt->execute();
    }

    public function selectRestaurant() {

        $query = "SELECT * FROM `356_restaurants` WHERE status IS NULL";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $row;
    }
    
    public function getRestraurant() {

        $query = "SELECT * FROM `356_restaurants` WHERE restaurantID = :ID AND status IS NULL";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(":ID", $this->restaurantID);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    public function deleteResurant() {

        $query = "UPDATE `356_restaurants` SET status = 'deleted' WHERE restaurantID = :ID AND status IS NULL";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(":ID", $this->restaurantID);
        $stmt->execute();
    }


#====================================Joins

    public function selectDrinksJoin($restaurantID) {

        $query = "SELECT `356_restaurants`.restaurantName, `149_drinks`.drinkName, `149_drinks`.drinkImage FROM `356_restaurants`
        INNER JOIN `149_drinks`
        ON `356_restaurants`.restaurantID = `149_drinks`.restaurantID
        WHERE `356_restaurants`.restaurantID = :RID AND `149_drinks`.status IS NULL";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(":RID", $restaurantID);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $row;
    }
}

?>