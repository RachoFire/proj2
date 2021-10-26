<?php 

header('Content-Type: application/json');
include_once "model.php"; 
session_start(); #This is where the session object has been started. It has been started at the very top of the code so it can be used anywher.
$data = new database; #This is where the data base object is set up. It has been started at the very top of the code so it can be used anywher.
$data->connect_db();
/*
if (isset($_SESSION['limit'])) { #This rate limit code stops users from making more then 1000 requests in one day.
    $_SESSION['limit'] += 1; #this will go up everytime a request has been made and will show a count of the ammount of requests have been made in one day.
    if (isset($_SESSION['day'])) { #this checks if the session pre-exists
        if ($_SESSION['day'] == date('d/m/y')) { #this checks if the day the fisrt request was made is the saem day as today.
            if ($_SESSION['limit'] > 1000) { #this stops the code from going on if they have made 1000 requests.
                http_response_code(429);
                die();
            }
        }
        else {
            unset($_SESSION['limit']);
            $_SESSION['day'] = date('d/m/y'); #this resets the rate limit if it is a new day and changes the day to the current one.
        }
    }

    else {
        $_SESSION['day'] = date('d/m/y');
    }
}

else {
    $_SESSION['limit'] = 1;
}


if (isset($_SESSION['time'])) { #this checks if the session pre-exists
    if ($_SESSION['time'] == date('h:i:sa')) { #this checks if the last requst happed durig the saem second as the first.
        http_response_code(429);
        $_SESSION['time'] = date('h:i:sa');
        die();
    }

    else {
        $_SESSION['time'] = date('h:i:sa');
    }
}

else {
    $_SESSION['time'] = date('h:i:sa');
}*/

/*
if ($_SERVER['HTTP_REFERER'] == 'http://localhost:8888//Proj2/') {
    foreach ($_POST as $key => $value) {
        if ($_POST[$key] == 'id' or $_POST[$key] == 'sreetNumber' or $_POST[$key] == 'postcode') { #this code will check if the $_POST is either of the listed values.
            $_POST[$key] = filter_var($value, FILTER_SANITIZE_NUMBER_INT); #this validates those values to be INT 
        }

        else {
            $_POST[$key] = filter_var($value, FILTER_SANITIZE_STRING); #this validates all other values to only be strings
        }   
    }


    if (isset($_GET['ID'])) { #this checks if the $_GET is ID 
        $_GET['ID'] = filter_var($_GET['ID'], FILTER_VALIDATE_INT); #this vadlidates the get as only an INT
    }
    else if (isset($_GET['restaurant'])) { #this checks if the $_GET is restaurant
        $_GET['restaurant'] = filter_var($_GET['restaurant'], FILTER_VALIDATE_INT); #this vadlidates the get as only an INT
    }
*/
    
    if (isset($_GET['function'])) {

        switch ($_GET['function']) {
        
    #==============================================users
            case "loggedIn":
                if (isset($_SESSION['loggedIn'])) { #this checks if the session pre-exists
                    $resp_code = 204;
                }

                else {
                    $resp_code = 404;
                }
                break;

            case "alreadyUser":
                $resp_code = alreadyUser();
                break;

            case "register":

                $userCheck = alreadyUser();

                if ($userCheck == 404) {

                    if (isset($_POST['username']) and isset($_POST['firstName']) and isset($_POST['lastName']) and isset($_POST['password'])) {

                        try {
                            $data->register($_POST['username'], $_POST['firstName'], $_POST['lastName'], $_POST['password']);
                            $resp_code = 201;
                        }

                        catch (exception $e) {
                            $resp_code = 500;
                        }
                        
                    }

                    else {
                        $resp_code = 400;
                    }
                }

                else {
                    $resp_code = 203;
                }
                break;

            case "login":

                if (isset($_POST['username']) and isset($_POST['password'])) {

                    try {
                        $dataInfo = $data->selectOneUser($_POST['username'], $_POST['password'], 'login');
                        if ($dataInfo['resp_code'] == 201) {
                            $_SESSION['loggedIn'] = $_POST['username'];
                            $_SESSION['accountType'] =  $dataInfo['account'];
                            $resp_code = $dataInfo['resp_code'];
                        }

                        else {
                            $resp_code = 401;
                        }
                    }

                    catch (exception $e) {
                        $resp_code = 500;
                    }
                }

                else {
                    $resp_code = 400;
                }
                
                break;

                case "logout":
                    unset($_SESSION['loggedIn']);
                    $resp_code = 200;
                    break;
                
            case "updateUsers":

                if (isset($_POST['username']) and isset($_POST['firstName']) and isset($_POST['lastName']) and isset($_POST['password'])) {

                    try {
                        $data->updateUsers($_POST['username'], $_POST['firstName'], $_POST['lastName'], $_POST['password'], $_SESSION['loggedIn']);
                        $resp_code = 201;
                        $_SESSION['loggedIn'] = $_POST['username'];
                    }

                    catch (exception $e) {
                        $resp_code = 500;
                    }
                    
                }

                else {
                    $resp_code = 400;
                }
                break;

            case "selectOneUser":

                if (isset($_SESSION['loggedIn'])) { #this checks if the session pre-exists

                    try {
                        $resp_body = $data->selectOneUser($_SESSION['loggedIn'], '', '');
                        $resp_code = 200;
                    }

                    catch(exception $e) {
                        $resp_code = 500;
                    }
                }

                else {
                    $resp_code = 400;
                }
                break;

            case "deleteUser":

                if (isset($_SESSION['loggedIn'])) { #this checks if the session pre-exists

                    try {
                        $data->deleteUser($_SESSION['loggedIn']);
                        $resp_code = 204;
                        unset($_SESSION['loggedIn']);
                    }

                    catch(exception $e) {
                        $resp_code = 500;
                    }
                }

                else {
                    $resp_code = 400;
                }

                break;


    #==============================================restaurants
        
            case "registerRestaurants":

                if (isset($_POST['restraurantName']) and isset($_POST['streetName']) and isset($_POST['streetNumber']) and isset($_POST['suburb']) and isset($_POST['postcode']) and isset($_SESSION['loggedIn'])) { #this checks if the session pre-exists

                    try {
                        $data->createRestraurant($_POST['restraurantName'], $_POST['streetName'], $_POST['streetNumber'], $_POST['suburb'], $_POST['postcode'], $_SESSION['loggedIn']);
                        $resp_code = 201;

                    }

                    catch (exception $e) {
                        $resp_code = 500;
                    }
                }

                else {
                    $resp_code = 400;
                }

                break;

            case "updateRestaurant":

                if (isset($_POST['restaurantName']) and isset($_POST['streetName']) and isset($_POST['streetNumber']) and isset($_POST['suburb']) and isset($_POST['postcode']) and isset($_SESSION['loggedIn'])) { #this checks if the session pre-exists

                    try {
                        $data->getRestaurantID($_SESSION['loggedIn']);
                        $data->updateResuraunt($_POST['restaurantName'], $_POST['streetName'], $_POST['streetNumber'], $_POST['suburb'], $_POST['postcode']);
                        $resp_code = 201;
                    }

                    catch (exeception $e) {
                        $resp_code = 500;
                    }

                }

                else  {
                    $resp_code = 400;
                }

                break;

            case "getRestaurants":

                try {
                    $resp_body = $data->selectRestaurant();
                    $resp_code = 202;
                }

                catch (exception $e) {
                    $resp_code = 500;
                }
                break;
            case "selectRestaurant": 
                
                if (isset($_SESSION['loggedIn'])) { #this checks if the session pre-exists

                    try {
                        $data->getRestaurantID($_SESSION['loggedIn']);
                        $resp_body = $data->getRestraurant();
                        $resp_code = 202;
                    }

                    catch (exception $e) {
                        $resp_code = 500;
                    }
                }

                else {
                    $resp_code = 400;
                }

                break;

            case "deleteRestaurant":

                if (isset($_SESSION['loggedIn'])) { #this checks if the session pre-exists

                    try {
                        $data->getRestaurantID($_SESSION['loggedIn']);
                        $data->deleteResurant();
                        $resp_code = 202;
                    }

                    catch (exception $e) {
                        $resp_code = 500;
                    }
                }

                else {
                    $resp_code = 400;
                }

                break;

    #==============================================Drinks

            case "image":

                if (isset($_FILES['drinkImage'])) {
                    $imageName = mt_rand().$_FILES['drinkImage']['name'];
                    $imagePath = "images/" . $imageName;
                    move_uploaded_file($_FILES['drinkImage']['tmp_name'], $imagePath);
                    $_SESSION['drinkImage'] = "http://localhost:8888/proj2/images/" . $imageName;
                    
                    $resp_code = 200;
                }

                else {
                    $resp_code = 400;
                }

                break;

            case "saveDrinks":

                if (isset($_POST['drinkName']) and isset($_SESSION['drinkImage']) AND isset($_SESSION['loggedIn'])) { #this checks if the session pre-exists

                    try {
                        $data->getRestaurantID($_SESSION['loggedIn']);
                        $data->saveDrinks($_POST['drinkName'], $_SESSION['drinkImage']);
                        unset($_SESSION['drinkImage']);
                        $resp_code = 201;
                    }

                    catch (exception $e) {
                        $resp_code = 500;
                    }
                }

                else {

                    $resp_code = 400;
                }

                break;

            case "selectDrinks":

                if (isset($_SESSION['loggedIn'])) { #this checks if the session pre-exists

                    try {

                        $row = $data->getRestaurantID($_SESSION['loggedIn']);
                        $resp_body = $data->selectDrinks();
                        $resp_code = 202;
                    }
        
                    catch(exception $e) {
        
                        $resp_code = 500;
                    }
                }

                else {

                    $resp_code = 401;
                }
                

                break;

            case "deleteDrinks":

                if (isset($_GET['ID']) and $_SESSION['loggedIn']) { #this checks if the session pre-exists
                    
                    try {

                        $data->getRestaurantID($_SESSION['loggedIn']);
                        $data->deleteDrinks($_GET['ID']);
                        $resp_code = 204; 
                    }

                    catch (exception $e) {

                        $resp_code = 500;
                    }
                }

                else {

                    $resp_code = 400;
                }

                break;

    #==============================================Joins

            case "selectDrinksJoin":

                if (isset($_GET['restaurant'])) {

                    try {
                        $resp_body = $data->selectDrinksJoin($_GET['restaurant']);
                        
                        $resp_code = 202;
                    }

                    catch (exception $e) {
                        $resp_code = 500;
                    } 
                }

                else {
                    $resp_code = 400;
                }
            break;
            
            default:
                $resp_code = 400;
        }
    }

    http_response_code($resp_code);

    if (isset($resp_body)) {

        echo json_encode($resp_body);
    }


    function alreadyUser() {


        try {

            $data = new database;
            $data->connect_db();
            $user = $data->userCheck($_POST['username']);

            if ($user['username'] == $_POST['username']) {

                $resp_code = 204;
                echo $user['username'] . " " . $_POST['username'];
            }

            else {
                $resp_code = 404;
            }

            return $resp_code;
        }

        catch (exception $e) {
            $resp_code = 500;
            return $resp_code;
        }
    }
#}

?>