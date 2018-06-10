<?php
//require_once('includes/constants.inc.php');
include 'includes/connection.php';
//require_once('classes/CatDog.php');
/**
 * funciton for allowsing a url to call different function within this one file
 */
if(function_exists($_GET['f'])) {
   $_GET['f']();
}

/***************************CAT*******************************
 */
    /**
     * get one cat where the entry id is equal to the json strings objects EntryID
     */
    function getOneCat(){
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if (!$conn) {
            die('Could not connect: ' . mysqli_error());
        }
        $json = file_get_contents('php://input');
        $obj = json_decode($json,true);

        $name = $obj['Name']; 
        $ownerId =$obj['OwnerId'];

        $returned->isValid = 'valid';
        $sql = "SELECT * FROM `Cat` WHERE Name = ? AND OwnerId = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('si', $name, $ownerId);
        $stmt->execute();
        $stmt->bind_result($Name, $OwnerId, $EntryID);
        $stmt->store_result();
        $returned->CatList = array();
        while($stmt->fetch()){
            $temp = array('name'=>$Name, 'OwnerId'=>$OwnerId, 'EntryID'=>$EntryID);
            array_push($returned->CatList, $temp);
        }
        $stmt->close();

        echo json_encode($returned);
    }
    /**
     * get all of the cats in the Cat table
     */
    function getCat(){
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if (!$conn) {
            die('Could not connect: ' . mysqli_error());
        }
        $json = file_get_contents('php://input');
        $obj = json_decode($json,true);

        $returned->isValid = 'valid';
        $sql = "SELECT * FROM `Cat`";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->bind_result($Name, $OwnerId, $EntryID);
        $stmt->store_result();
        $returned->CatList = array();
        while($stmt->fetch()){
            $temp = array('name'=>$Name, 'OwnerId'=>$OwnerId, 'EntryID'=>$EntryID);
            array_push($returned->CatList, $temp);
        }
        $stmt->close();

        echo json_encode($returned);
    }
    /**
     * create a new cat entry
     */
    function createCat(){
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if (!$conn) {
            die('Could not connect: ' . mysqli_error());
        }
        $json = file_get_contents('php://input');
        $obj = json_decode($json,true);
            /* get next entry id ? dont know why you would want this*
             * $sql = "SELECT `EntryID` FROM `Cat` ORDER BY `EntryID` DESC LIMIT 1";
             * $stmt = $conn->prepare($sql);
             * $stmt->execute();
             * $stmt->bind_result($EntryID);
             * $stmt->store_result();
             * $stmt->fetch();
             * $stmt->close();
             * $newEntryID = $EntryID + 1;
             * $returned->newEntryID = $newEntryID;
             */

        
        $name = $obj['Name'];
        $ownerId = $obj['OwnerId'];

        $returned->isValid = 'valid';
        $returned->name = $name;
        $returned->ownerId = $ownerId;
        
        $sql2 = 'INSERT INTO `Cat`(`Name`, `OwnerId`) VALUES (?,?)';
        $stmt2 = $conn->prepare($sql2);
        $stmt2->bind_param('si', $name, $ownerId);
        $stmt2->execute();
        $stmt2->close();

        echo json_encode($returned);
    }
    /**
     * update cat entry
     */
    function updateCat(){
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if (!$conn) {
            die('Could not connect: ' . mysqli_error());
        }
        $json = file_get_contents('php://input');
        $obj = json_decode($json,true);

        $name = $obj['Name'];
        $ownerId = $obj['OwnerId'];
        $newName = $obj['NewName'];
        $newOwnerId = $obj['NewOwnerId'];

        $returned->isValid = 'valid';
        $sql = "SELECT * FROM `Cat` WHERE Name = ? AND OwnerId = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('si', $newName, $newOwnerId);
        $stmt->execute();
        $stmt->bind_result($Name, $OwnerId, $EntryID);
        $stmt->store_result();
        $returned->CatList = array();
        while($stmt->fetch()){
            $temp = array('name'=>$Name, 'OwnerId'=>$OwnerId, 'EntryID'=>$EntryID);
            array_push($returned->CatList, $temp);
        }
        $stmt->close();

        if(empty($returned->CatList)){
            $returned->isValid = "valid";
            $sql2 = "UPDATE `Cat` SET Name=?,OwnerId=? WHERE Name = ? AND OwnerId = ?";
            $stmt2 = $conn->prepare($sql2);
            $stmt2->bind_param('sisi',$newName, $newOwnerId, $name, $ownerId);
            $stmt2->execute();
            $stmt2->close();
        }
        else{
            $returned->isValid = "notValid";
        }
        echo json_encode($returned);
    }
    /**
     * delete cat from entry id
     * 
     * TODO
     */
    function deleteCat(){
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if (!$conn) {
            die('Could not connect: ' . mysqli_error());
        }
        $json = file_get_contents('php://input');
        $obj = json_decode($json,true);

        $name = $obj['Name'];
        $ownerId = $obj['OwnerId'];

        $returned->isValid = 'valid';
        $sql = "DELETE FROM `Cat` WHERE Name = ? AND OwnerId = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('si', $name, $ownerId);
        $stmt->execute();
        $stmt->close();

        echo json_encode($returned);
    }
/***************************DOG*******************************
 */
    /**
     * get one Dog where the entry id is equal to the json strings objects EntryID
     */
    function gatOneDog(){
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if (!$conn) {
            die('Could not connect: ' . mysqli_error());
        }
        $json = file_get_contents('php://input');
        $obj = json_decode($json,true);

        $name = $obj['Name'];
        $ownerId = $obj['OwnerId'];

        $returned->isValid = 'valid';
        $sql = "SELECT * FROM `Dog` WHERE Name = ? AND OwnerId = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('si', $name, $ownerId);
        $stmt->execute();
        $stmt->bind_result($Name, $OwnerId, $EntryID);
        $stmt->store_result();
        $returned->DogList = array();
        while($stmt->fetch()){
            $temp = array('name'=>$Name, 'OwnerId'=>$OwnerId, 'EntryID'=>$EntryID);
            array_push($returned->DogList, $temp);
        }
        $stmt->close();

        echo json_encode($returned);
    }
    /**
     * get all of the Dogs in the Dog table
     */
    function getDog(){
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if (!$conn) {
            die('Could not connect: ' . mysqli_error());
        }
        $json = file_get_contents('php://input');
        $obj = json_decode($json,true);

        $returned->isValid = 'valid';
        $sql = "SELECT * FROM `Dog`";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->bind_result($Name, $OwnerId, $EntryID);
        $stmt->store_result();
        $returned->DogList = array();
        while($stmt->fetch()){
            $temp = array('name'=>$Name, 'OwnerId'=>$OwnerId, 'EntryID'=>$EntryID);
            array_push($returned->DogList, $temp);
        }
        $stmt->close();

        echo json_encode($returned);
    }
    /**
     * create a new Dog entry
     */
    function createDog(){
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if (!$conn) {
            die('Could not connect: ' . mysqli_error());
        }
        $json = file_get_contents('php://input');
        $obj = json_decode($json,true);
        
        $name = $obj['Name'];
        $ownerId = $obj['OwnerId'];

        $returned->isValid = 'valid';
        $returned->name = $name;
        $returned->ownerId = $ownerId;
        
        $sql2 = 'INSERT INTO `Dog`(`Name`, `OwnerId`) VALUES (?,?)';
        $stmt2 = $conn->prepare($sql2);
        $stmt2->bind_param('si', $name, $ownerId);
        $stmt2->execute();
        $stmt2->close();

        echo json_encode($returned);
    }
    /**
     * update Dog entry
     */
    function updateDog(){
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if (!$conn) {
            die('Could not connect: ' . mysqli_error());
        }
        $json = file_get_contents('php://input');
        $obj = json_decode($json,true);

        $name = $obj['Name'];
        $ownerId = $obj['OwnerId'];
        $newName = $obj['NewName'];
        $newOwnerId = $obj['NewOwnerId'];

        $returned->isValid = 'valid';
        $sql = "SELECT * FROM `Dog` WHERE Name = ? AND OwnerId = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('si', $newName, $newOwnerId);
        $stmt->execute();
        $stmt->bind_result($Name, $OwnerId, $EntryID);
        $stmt->store_result();
        $returned->DogList = array();
        while($stmt->fetch()){
            $temp = array('name'=>$Name, 'OwnerId'=>$OwnerId, 'EntryID'=>$EntryID);
            array_push($returned->DogList, $temp);
        }
        $stmt->close();

        if(empty($returned->DogList)){
            $returned->isValid = "valid";
            $sql2 = "UPDATE `Dog` SET Name=?,OwnerId=? WHERE Name = ? AND OwnerId = ?";
            $stmt2 = $conn->prepare($sql2);
            $stmt2->bind_param('sisi',$newName, $newOwnerId, $name, $ownerId);
            $stmt2->execute();
            $stmt2->close();
        }
        else{
            $returned->isValid = "notValid";
        }
        echo json_encode($returned);
    }
    /**
     * delete Dog from entry id
     * 
     * TODO
     */
    function deleteDog(){
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if (!$conn) {
            die('Could not connect: ' . mysqli_error());
        }
        $json = file_get_contents('php://input');
        $obj = json_decode($json,true);

        $name = $obj['Name'];
        $ownerId = $obj['OwnerId'];

        $returned->isValid = 'valid';
        $sql = "DELETE FROM `Dog` WHERE Name = ? AND OwnerId = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('si', $name, $ownerId);
        $stmt->execute();
        $stmt->close();

        echo json_encode($returned);
    }
/***************************EMPLOYEE**************************
 */
    /**
     * get one Employee where the entry id is equal to the json strings objects EntryID
     */
    function gatOneEmployee(){
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if (!$conn) {
            die('Could not connect: ' . mysqli_error());
        }
        $json = file_get_contents('php://input');
        $obj = json_decode($json,true);

        $employeeId = 1;//$obj['EmployeeId'];

        $returned->isValid = 'valid';
        $sql = "SELECT * FROM `Employee` WHERE EmployeeID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i',$employeeId);
        $stmt->execute();
        $stmt->bind_result($FirstName, $LastName, $EmployeeID, $totalHours);
        $stmt->store_result();
        $returned->EmployeeList = array();
        while($stmt->fetch()){
            $temp = array('FirstName'=>$FirstName, 'LastName'=>$LastName, 'EmployeeId'=>$EmployeeID,'TotalHours'=>$totalHours);
            array_push($returned->EmployeeList, $temp);
        }
        $stmt->close();

        echo json_encode($returned);
    }
    /**
     * get all of the Employees in the Employee table
     */
    function getEmployee(){
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if (!$conn) {
            die('Could not connect: ' . mysqli_error());
        }
        $json = file_get_contents('php://input');
        $obj = json_decode($json,true);

        $returned->isValid = 'valid';
        $sql = "SELECT * FROM `Employee`";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->bind_result($FirstName, $LastName, $EmployeeID, $totalHours);
        $stmt->store_result();
        $returned->EmployeeList = array();
        while($stmt->fetch()){
            $temp = array('FirstName'=>$FirstName, 'LastName'=>$LastName, 'EmployeeId'=>$EmployeeID,'TotalHours'=>$totalHours);
            array_push($returned->EmployeeList, $temp);
        }
        $stmt->close();

        echo json_encode($returned);
    }
    /**
     * create a new Employee entry
     */
    function createEmployee(){
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if (!$conn) {
            die('Could not connect: ' . mysqli_error());
        }
        $json = file_get_contents('php://input');
        $obj = json_decode($json,true);
        
        $firstName = $obj['FirstName'];
        $lastName = $obj['LastName'];

        $returned->isValid = 'valid';
        $returned->name = $name;
        $returned->ownerId = $ownerId;
        
        $sql2 = 'INSERT INTO `Employee`(`FirstName`, `LastName`, `totalHours`) VALUES (?,?,0)';
        $stmt2 = $conn->prepare($sql2);
        $stmt2->bind_param('ss', $firstName, $lastName);
        $stmt2->execute();
        $stmt2->close();
        echo json_encode($returned);
    }
    /**
     * update Employee entry
     * 
     * we dont allow for changing the employees name
     * id get auto generated
     * total hours gets auto counted
     * 
     */
    
    /**
     * delete Employee from Employee id
     * 
     * TODO
     */
    function deleteEmployee(){
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if (!$conn) {
            die('Could not connect: ' . mysqli_error());
        }
        $json = file_get_contents('php://input');
        $obj = json_decode($json,true);

        $employeeId = 5;//$obj['EmployeeId'];

        $returned->isValid = 'valid';
        $sql = "DELETE FROM `Dog` WHERE EmployeeID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $employeeId);
        $stmt->execute();
        $stmt->close();

        echo json_encode($returned);
    }
/***************************PmActivity************************
 */
    /**
     * get one PmActivity where the entry id is equal to the json strings objects EntryID
     */
    function gatOnePmActivity(){
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if (!$conn) {
            die('Could not connect: ' . mysqli_error());
        }
        $json = file_get_contents('php://input');
        $obj = json_decode($json,true);

        $activityID = $obj['ActivityId'];

        $returned->valid = 'valid';
        $sql = "SELECT * FROM `PmActivity` WHERE ActivityId = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_params('i',$activityID);
        $stmt->execute();
        $stmt->bind_result($EntryIDCat, $EntryIDDog, $EmployeeID, $Type, $Hours, $Date, $ActivityId);
        $stmt->store_result();
        $returned->PmActivityList = array();
        while($stmt->fetch()){
            $temp = array('EntryIDCat'=>$EntryIDCat, 'EntryIDDog'=>$EntryIDDog, 'EmployeeID'=>$EmployeeID, 'Type'=>$Type, 'Hours'=>$Hours, 'Date'=>$Date, 'ActivityId'=>$ActivityId);
            array_push($returned->PmActivityList, $temp);
        }
        $stmt->close();

        echo json_encode($returned);
    }
    /**
     * get all of the PmActivitys in the PmActivity table
     */
    function getPmActivity(){
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if (!$conn) {
            die('Could not connect: ' . mysqli_error());
        }
        $json = file_get_contents('php://input');
        $obj = json_decode($json,true);

        $returned->isValid = 'valid';
        $sql = "SELECT * FROM `PmActivity`";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->bind_result($EntryIDCat, $EntryIDDog, $EmployeeID, $Type, $Hours, $Date, $ActivityId);
        $stmt->store_result();
        $returned->PmActivityList = array();
        while($stmt->fetch()){
            $temp = array('EntryIDCat'=>$EntryIDCat, 'EntryIDDog'=>$EntryIDDog, 'EmployeeID'=>$EmployeeID, 'Type'=>$Type, 'Hours'=>$Hours, 'Date'=>$Date, 'ActivityId'=>$ActivityId);
            array_push($returned->PmActivityList, $temp);
        }
        $stmt->close();

        echo json_encode($returned);
    }
    /**
     * create a new PmActivity entry
     * TODO SOLVE DATE PROBLEM
     */
    function createPmActivity(){
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if (!$conn) {
            die('Could not connect: ' . mysqli_error());
        }
        $json = file_get_contents('php://input');
        $obj = json_decode($json,true);

        $returned->isValid = 'valid';

        $sql = "INSERT INTO `PmActivity`(`EntryIDCat`, `EntryIDDog`, `EmployeeID`, `Type`, `Hours`, `Date`) VALUES (?,?,?,?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_params('iiisis', $entryIDCat, $entryIDDog, $employeeID, $type, $hours, $date);
        $stmt->execute();
        $stmt->close();

        echo json_encode($returned);
    }
    /**
     * update PmActivity entry
     */
    function updatePmActivity(){
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if (!$conn) {
            die('Could not connect: ' . mysqli_error());
        }
        $json = file_get_contents('php://input');
        $obj = json_decode($json,true);

        $entryIDCat = 2;
        $entryIDDog = 2;
        $employeeID = 2;
        $type = 't';
        $hours = 2;
        $date = 'somethign';

        // $returned->isValid = 'valid';
        // $sql = "SELECT * FROM `Dog` WHERE Name = ? AND OwnerId = ?";
        // $stmt = $conn->prepare($sql);
        // $stmt->bind_param('si', $newName, $newOwnerId);
        // $stmt->execute();
        // $stmt->bind_result($Name, $OwnerId, $EntryID);
        // $stmt->store_result();
        // $returned->DogList = array();
        // while($stmt->fetch()){
        //     $temp = array('name'=>$Name, 'OwnerId'=>$OwnerId, 'EntryID'=>$EntryID);
        //     array_push($returned->DogList, $temp);
        // }
        // $stmt->close();

        // if(empty($returned->DogList)){
        //     $returned->isValid = "valid";
        //     $sql2 = "UPDATE `Dog` SET Name=?,OwnerId=? WHERE Name = ? AND OwnerId = ?";
        //     $stmt2 = $conn->prepare($sql2);
        //     $stmt2->bind_param('sisi',$newName, $newOwnerId, $name, $ownerId);
        //     $stmt2->execute();
        //     $stmt2->close();
        // }
        // else{
        //     $returned->isValid = "notValid";
        // }
        // echo json_encode($returned);
    }
    /**
     * delete PmActivity from Activity id
     */
    function deletePmActivity(){

    }
/***************************AmActivity************************
 */
    /**
     * get one AmActivity where the entry id is equal to the json strings objects EntryID
     */
    function gatOneAmActivity(){

    }
    /**
     * get all of the AmActivitys in the AmActivity table
     */
    function getAmActivity(){

    }
    /**
     * create a new AmActivity entry
     */
    function createAmActivity(){

    }
    /**
     * update AmActivity entry
     */
    function updateAmActivity(){

    }
    /**
     * delete AmActivity from Activity id
     */
    function deleteAmActivity(){

    }
/***************************DogGuestListEntry*****************
 */
    /**
     * get one DogGuestListEntry where the entry id is equal to the json strings objects EntryID
     */
    function gatOneDogGuestListEntry(){

    }
    /**
     * get all of the DogGuestListEntrys in the DogGuestListEntry table
     */
    function getDogGuestListEntry(){

    }
    /**
     * create a new DogGuestListEntry entry
     */
    function createDogGuestListEntry(){

    }
    /**
     * update DogGuestListEntry entry
     */
    function updateDogGuestListEntry(){

    }
    /**
     * delete DogGuestListEntry from Entry id
     */
    function deleteDogGuestListEntry(){

    }
/***************************CatGuestListEntry*****************
 */
    /**
     * get one CatGuestListEntry where the entry id is equal to the json strings objects EntryID
     */
    function gatOneCatGuestListEntry(){

    }
    /**
     * get all of the CatGuestListEntrys in the CatGuestListEntry table
     */
    function getCatGuestListEntry(){

    }
    /**
     * create a new CatGuestListEntry entry
     */
    function createCatGuestListEntry(){

    }
    /**
     * update CatGuestListEntry entry
     */
    function updateCatGuestListEntry(){

    }
    /**
     * delete CatGuestListEntry from Entry id
     */
    function deleteCatGuestListEntry(){

    }
?>