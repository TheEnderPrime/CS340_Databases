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
    /***************************COUNTS*******************************
    * */
    function getAnimalCount(){
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if (!$conn) {
            die('Could not connect: ' . mysqli_error());
        }
        $json = file_get_contents('php://input');
        $obj = json_decode($json,true);

        $returned->isValid = 'valid';

        $sql = "SELECT (SELECT COUNT(ID) FROM Cat) + (SELECT COUNT(ID) FROM Dog) AS animalCount";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->bind_result($AnimalCount);
        $stmt->store_result();
        $returned->animalCountList = array();
        while($stmt->fetch()){
            $temp = array('animalCount'=>$AnimalCount);
            array_push($returned->animalCountList, $temp);
        }
        $stmt->close();

        echo json_encode($returned);
    }

    function getEmployeeCount(){
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if (!$conn) {
            die('Could not connect: ' . mysqli_error());
        }
        $json = file_get_contents('php://input');
        $obj = json_decode($json,true);

        $returned->isValid = 'valid';

        $sql = "SELECT COUNT(EmployeeID) AS employeeCount FROM Employee";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->bind_result($EmployeeCount);
        $stmt->store_result();
        $returned->employeeCountList = array();
        while($stmt->fetch()){
            $temp = array('employeeCount'=>$EmployeeCount);
            array_push($returned->employeeCountList, $temp);
        }
        $stmt->close();

        echo json_encode($returned);
    }

    function getEntriesCount(){
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if (!$conn) {
            die('Could not connect: ' . mysqli_error());
        }
        $json = file_get_contents('php://input');
        $obj = json_decode($json,true);

        $returned->isValid = 'valid';

        $sql = "SELECT (SELECT COUNT(EntryID) FROM CatGuestListEntry) + (SELECT COUNT(EntryID) FROM DogGuestListEntry) AS entryCount";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->bind_result($EntryCount);
        $stmt->store_result();
        $returned->entryCountList = array();
        while($stmt->fetch()){
            $temp = array('entryCount'=>$EntryCount);
            array_push($returned->entryCountList, $temp);
        }
        $stmt->close();

        echo json_encode($returned);
    }

    function getActivityCount(){
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if (!$conn) {
            die('Could not connect: ' . mysqli_error());
        }
        $json = file_get_contents('php://input');
        $obj = json_decode($json,true);

        $returned->isValid = 'valid';

        $sql = "SELECT (SELECT COUNT(ActivityId) FROM AmActivity) + (SELECT COUNT(ActivityId) FROM PmActivity) AS activityCount";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->bind_result($ActivityCount);
        $stmt->store_result();
        $returned->activityCountList = array();
        while($stmt->fetch()){
            $temp = array('activityCount'=>$ActivityCount);
            array_push($returned->activityCountList, $temp);
        }
        $stmt->close();

        echo json_encode($returned);
    }

    function getOpenSpace(){
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if (!$conn) {
            die('Could not connect: ' . mysqli_error());
        }
        $json = file_get_contents('php://input');
        $obj = json_decode($json,true);

        $returned->isValid = 'valid';

        $sql = "SELECT 81 - (SELECT (SELECT COUNT(EntryID) FROM CatGuestListEntry) + (SELECT COUNT(EntryID) FROM DogGuestListEntry) AS entryCount) AS openSpace";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->bind_result($OpenSpace);
        $stmt->store_result();
        $returned->openSpaceList = array();
        while($stmt->fetch()){
            $temp = array('openSpace'=>$OpenSpace);
            array_push($returned->openSpaceList, $temp);
        }
        $stmt->close();

        echo json_encode($returned);
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
        $stmt->bind_result($Name, $OwnerId, $ID);
        $stmt->store_result();
        $returned->CatList = array();
        while($stmt->fetch()){
            $temp = array('name'=>$Name, 'ownerID'=>$OwnerId, 'ID'=>$ID);
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
        
        $name = $obj['Name'];
        $ownerId = $obj['OwnerID'];

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

        $ID = $obj['ID'];
        $newName = $obj['Name'];
        $newOwnerId = $obj['OwnerID'];

        $returned->isValid = "valid";
        $sql2 = "UPDATE `Cat` SET Name=?,OwnerId=? WHERE ID = ? ";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->bind_param('sii',$newName, $newOwnerId, $ID);
        $stmt2->execute();
        $stmt2->close();
        echo json_encode($returned);
    }
    /**
     * delete cat from entry id
     */
    function deleteCat(){
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if (!$conn) {
            die('Could not connect: ' . mysqli_error());
        }
        $json = file_get_contents('php://input');
        $obj = json_decode($json,true);

        $ID = $obj['ID'];

        //search if dog with this id is in any of the DogGuestListEntry

        $returned->isValid = 'valid';
        $sql = "DELETE FROM `Cat` WHERE ID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $ID);
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

        $ID = $obj['ID'];

        $returned->isValid = 'valid';
        $sql = "SELECT * FROM `Dog` WHERE ID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $ID);
        $stmt->execute();
        $stmt->bind_result($Name, $OwnerId, $ID);
        $stmt->store_result();
        $returned->DogList = array();
        while($stmt->fetch()){
            $temp = array('name'=>$Name, 'ownerID'=>$OwnerId, 'ID'=>$ID);
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
        $stmt->bind_result($Name, $OwnerId, $ID);
        $stmt->store_result();
        $returned->DogList = array();
        while($stmt->fetch()){
            $temp = array('name'=>$Name, 'ownerID'=>$OwnerId, 'ID'=>$ID);
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
        $ownerId = $obj['OwnerID'];

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

        $ID = $obj['ID'];
        $newName = $obj['Name'];
        $newOwnerId = $obj['OwnerID'];

        $returned->isValid = "valid";
        $sql2 = "UPDATE `Dog` SET Name=?,OwnerId=? WHERE ID = ? ";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->bind_param('sii',$newName, $newOwnerId, $ID);
        $stmt2->execute();
        $stmt2->close();
        echo json_encode($returned);
    }
    /**
     * delete Dog from entry id
     */
    function deleteDog(){
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if (!$conn) {
            die('Could not connect: ' . mysqli_error());
        }
        $json = file_get_contents('php://input');
        $obj = json_decode($json,true);

        $ID = $obj['ID'];

        //search if dog with this id is in any of the DogGuestListEntry

        $returned->isValid = 'valid';
        $sql = "DELETE FROM `Dog` WHERE ID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $ID);
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
     */
    function updateEmployee(){
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if (!$conn) {
            die('Could not connect: ' . mysqli_error());
        }
        $json = file_get_contents('php://input');
        $obj = json_decode($json,true);

        $newFirstName = $obj['FirstName'];
        $newLastName = $obj['LastName'];
        $EmployeeID = $obj['EmployeeID'];

        $returned->isValid = "valid";
        $sql2 = "UPDATE `Employee` SET `FirstName`=?,`LastName`=? WHERE `EmployeeID` = ?";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->bind_param('ssi',$newFirstName, $newLastName, $EmployeeID);
        $stmt2->execute();
        $stmt2->close();
        echo json_encode($returned);
    }
    /**
     * delete Employee from Employee id
     */
    function deleteEmployee(){
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if (!$conn) {
            die('Could not connect: ' . mysqli_error());
        }
        $json = file_get_contents('php://input');
        $obj = json_decode($json,true);

        $employeeId = $obj['EmployeeId'];

        $returned->isValid = 'valid';
        $sql = "DELETE FROM `Employee` WHERE EmployeeID = ?";
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
        $stmt->bind_param('i',$activityID);
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
        $sql = "SELECT `PmActivity`.`EntryIDCat`, 
        `PmActivity`.`EntryIDDog`, 
        `PmActivity`.`EmployeeID`, 
        `PmActivity`.`Type`, 
        `PmActivity`.`Hours`, 
        `PmActivity`.`Date`, 
        `PmActivity`.`ActivityId`,
        CONCAT(`Employee`.`FirstName` , ' ' , `Employee`.`LastName`) AS 'Employee',
        `Dog`.`Name`,
        `Cat`.`Name` 
        FROM `PmActivity` 
        INNER JOIN `Employee` ON `PmActivity`.`EmployeeID` = `Employee`.`EmployeeID`
        LEFT JOIN `DogGuestListEntry` ON `PmActivity`.`EntryIDDog` = `DogGuestListEntry`.`EntryID`
        LEFT JOIN `Dog` ON `DogGuestListEntry`.`DogIn` = `Dog`.`ID`
        LEFT JOIN `CatGuestListEntry` ON `PmActivity`.`EntryIDCat` = `CatGuestListEntry`.`EntryID` 
        LEFT JOIN `Cat` ON `CatGuestListEntry`.`CatIn` = `Cat`.`ID`";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->bind_result($EntryIDCat, $EntryIDDog, $EmployeeID, $Type, $Hours, $Date, $ActivityId, $Employee, $DogName, $CatName);
        $stmt->store_result();
        $returned->PmActivityList = array();
        while($stmt->fetch()){
            $temp = array('EntryIDCat'=>$EntryIDCat, 'EntryIDDog'=>$EntryIDDog, 'EmployeeID'=>$EmployeeID, 'Type'=>$Type, 'Hours'=>$Hours, 'Date'=>$Date, 'ActivityId'=>$ActivityId, 'EmployeeName'=>$Employee, 'DogName'=>$DogName, 'CatName'=>$CatName);
            array_push($returned->PmActivityList, $temp);
        }
        $stmt->close();

        echo json_encode($returned);
    }
    /**
     * create a new PmActivity entry
     */
    function createDogPmActivity(){
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if (!$conn) {
            die('Could not connect: ' . mysqli_error());
        }
        $json = file_get_contents('php://input');
        $obj = json_decode($json,true);

        $entryIDDog = $obj['EntryIDDog'];
        $employeeID = $obj['EmployeeID'];
        $type = $obj['Type'];
        $hours = $obj['Hours'];
        $date = $obj['ActivityDate'];

        $returned->isValid = 'valid';

        $sql = "INSERT INTO `PmActivity`(`EntryIDDog`, `EmployeeID`, `Type`, `Hours`, `Date`) VALUES (?,?,?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('iisis', $entryIDDog, $employeeID, $type, $hours, $date);
        $stmt->execute();
        $stmt->close();

        echo json_encode($returned);
    }
    /**
     * create a new PmActivity entry
     */
    function createCatPmActivity(){
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if (!$conn) {
            die('Could not connect: ' . mysqli_error());
        }
        $json = file_get_contents('php://input');
        $obj = json_decode($json,true);

        $entryIDCat = $obj['EntryIDCat'];
        $employeeID = $obj['EmployeeID'];
        $type = $obj['Type'];
        $hours = $obj['Hours'];
        $date = $obj['ActivityDate'];

        $returned->isValid = 'valid';

        $sql = "INSERT INTO `PmActivity`(`EntryIDCat`, `EmployeeID`, `Type`, `Hours`, `Date`) VALUES (?,?,?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('iisis', $entryIDCat, $employeeID, $type, $hours, $date);
        $stmt->execute();
        $stmt->close();

        echo json_encode($returned);
    }
    /**
     * update PmActivity entry
     */
    function updateDogPmActivity(){
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if (!$conn) {
            die('Could not connect: ' . mysqli_error());
        }
        $json = file_get_contents('php://input');
        $obj = json_decode($json,true);

        $entryIDDog = $obj['EntryIDDog'];
        $employeeID = $obj['EmployeeID'];
        $type = $obj['Type'];
        $hours = $obj['Hours'];
        $date = $obj['ActivityDate'];
        $activityID = $obj['ActivityID'];
        $returned->isValid = "valid";
        $sql = "UPDATE `PmActivity` SET `EntryIDCat`=null,`EntryIDDog`=?,`EmployeeID`=?,`Type`=?,`Hours`=?,`Date`=? WHERE `ActivityId`=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('iisisi', $entryIDDog, $employeeID, $type, $hours, $date, $activityID);
        $stmt->execute();
        $stmt->close();
        echo json_encode($returned);
    }
        /**
     * update PmActivity entry
     */
    function updateCatPmActivity(){
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if (!$conn) {
            die('Could not connect: ' . mysqli_error());
        }
        $json = file_get_contents('php://input');
        $obj = json_decode($json,true);

        $entryIDCat = $obj['EntryIDCat'];
        $employeeID = $obj['EmployeeID'];
        $type = $obj['Type'];
        $hours = $obj['Hours'];
        $date = $obj['ActivityDate'];
        $activityID = $obj['ActivityID'];
        $returned->isValid = "valid";
        $sql = "UPDATE `PmActivity` SET `EntryIDCat`=null,`EntryIDCat`=?,`EmployeeID`=?,`Type`=?,`Hours`=?,`Date`=? WHERE `ActivityId`=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('iisisi', $entryIDCat, $employeeID, $type, $hours, $date, $activityID);
        $stmt->execute();
        $stmt->close();
        echo json_encode($returned);
    }
    /**
     * delete PmActivity from Activity id
     */
    function deletePmActivity(){
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if (!$conn) {
            die('Could not connect: ' . mysqli_error());
        }
        $json = file_get_contents('php://input');
        $obj = json_decode($json,true);

        $activityId = $obj['ActivityId'];

        $returned->isValid = 'valid';
        $sql = "DELETE FROM `PmActivity` WHERE `ActivityId`=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $activityId);
        $stmt->execute();
        $stmt->close();

        echo json_encode($returned);
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
     * SELECT `AmActivity`.`EntryIDCat`, `AmActivity`.`EntryIDDog`, `AmActivity`.`EmployeeID`,
     *  `AmActivity`.`Type`, `AmActivity`.`Hours`, `AmActivity`.`Date`,
     *  `AmActivity`.`ActivityId`, CONCAT(`Employee`.`FirstName` , ' ' , `Employee`.`LastName`)
     *  AS "Employee" FROM `AmActivity` INNER JOIN `Employee` ON `AmActivity`.`EmployeeID` = `Employee`.`EmployeeID`
     */
    function getAmActivity(){
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if (!$conn) {
            die('Could not connect: ' . mysqli_error());
        }
        $json = file_get_contents('php://input');
        $obj = json_decode($json,true);

        $returned->isValid = 'valid';

        $sql = "SELECT `AmActivity`.`EntryIDCat`, 
        `AmActivity`.`EntryIDDog`, 
        `AmActivity`.`EmployeeID`, 
        `AmActivity`.`Type`, 
        `AmActivity`.`Hours`, 
        `AmActivity`.`Date`, 
        `AmActivity`.`ActivityId`,
        CONCAT(`Employee`.`FirstName` , ' ' , `Employee`.`LastName`) AS 'Employee',
        `Dog`.`Name`,
        `Cat`.`Name` 
        FROM `AmActivity` 
        INNER JOIN `Employee` ON `AmActivity`.`EmployeeID` = `Employee`.`EmployeeID`
        LEFT JOIN `DogGuestListEntry` ON `AmActivity`.`EntryIDDog` = `DogGuestListEntry`.`EntryID`
        LEFT JOIN `Dog` ON `DogGuestListEntry`.`DogIn` = `Dog`.`ID`
        LEFT JOIN `CatGuestListEntry` ON `AmActivity`.`EntryIDCat` = `CatGuestListEntry`.`EntryID` 
        LEFT JOIN `Cat` ON `CatGuestListEntry`.`CatIn` = `Cat`.`ID`";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->bind_result($EntryIDCat, $EntryIDDog, $EmployeeID, $Type, $Hours, $Date, $ActivityId, $Employee, $DogName, $CatName);
        $stmt->store_result();
        $returned->AmActivityList = array();
        while($stmt->fetch()){
            $temp = array('EntryIDCat'=>$EntryIDCat, 'EntryIDDog'=>$EntryIDDog, 'EmployeeID'=>$EmployeeID, 'Type'=>$Type, 'Hours'=>$Hours, 'Date'=>$Date, 'ActivityId'=>$ActivityId, 'EmployeeName'=>$Employee, 'DogName'=>$DogName, 'CatName'=>$CatName);
            array_push($returned->AmActivityList, $temp);
        }
        $stmt->close();

        echo json_encode($returned);
    }
    /**
     * create a new AmActivity entry
     */
    function createDogAmActivity(){
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if (!$conn) {
            die('Could not connect: ' . mysqli_error());
        }
        $json = file_get_contents('php://input');
        $obj = json_decode($json,true);

        $entryIDDog = $obj['EntryIDDog'];
        $employeeID = $obj['EmployeeID'];
        $type = $obj['Type'];
        $hours = $obj['Hours'];
        $date = $obj['ActivityDate'];

        $returned->isValid = 'valid';

        $sql = "INSERT INTO `AmActivity`(`EntryIDDog`, `EmployeeID`, `Type`, `Hours`, `Date`) VALUES (?,?,?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('iisis', $entryIDDog, $employeeID, $type, $hours, $date);
        $stmt->execute();
        $stmt->close();

        echo json_encode($returned);
    }
    /**
     * create a new AmActivity entry
     */
    function createCatAmActivity(){
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if (!$conn) {
            die('Could not connect: ' . mysqli_error());
        }
        $json = file_get_contents('php://input');
        $obj = json_decode($json,true);

        $entryIDCat = $obj['EntryIDCat'];
        $employeeID = $obj['EmployeeID'];
        $type = $obj['Type'];
        $hours = $obj['Hours'];
        $date = $obj['ActivityDate'];

        $returned->isValid = 'valid';

        $sql = "INSERT INTO `AmActivity`(`EntryIDCat`, `EmployeeID`, `Type`, `Hours`, `Date`) VALUES (?,?,?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('iisis', $entryIDCat, $employeeID, $type, $hours, $date);
        $stmt->execute();
        $stmt->close();

        echo json_encode($returned);
    }
    /**
     * update AmActivity entry
     */
    function updateDogAmActivity(){
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if (!$conn) {
            die('Could not connect: ' . mysqli_error());
        }
        $json = file_get_contents('php://input');
        $obj = json_decode($json,true);

        $entryIDDog = $obj['EntryIDDog'];
        $employeeID = $obj['EmployeeID'];
        $type = $obj['Type'];
        $hours = $obj['Hours'];
        $date = $obj['ActivityDate'];
        $activityID = $obj['ActivityID'];
        $returned->isValid = "valid";
        $sql = "UPDATE `AmActivity` SET `EntryIDCat`=null,`EntryIDDog`=?,`EmployeeID`=?,`Type`=?,`Hours`=?,`Date`=? WHERE `ActivityId`=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('iisisi', $entryIDDog, $employeeID, $type, $hours, $date, $activityID);
        $stmt->execute();
        $stmt->close();
        echo json_encode($returned);
    }
        /**
     * update AmActivity entry
     */
    function updateCatAmActivity(){
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if (!$conn) {
            die('Could not connect: ' . mysqli_error());
        }
        $json = file_get_contents('php://input');
        $obj = json_decode($json,true);

        $entryIDCat = $obj['EntryIDCat'];
        $employeeID = $obj['EmployeeID'];
        $type = $obj['Type'];
        $hours = $obj['Hours'];
        $date = $obj['ActivityDate'];
        $activityID = $obj['ActivityID'];
        $returned->isValid = "valid";
        $sql = "UPDATE `AmActivity` SET `EntryIDCat`=null,`EntryIDCat`=?,`EmployeeID`=?,`Type`=?,`Hours`=?,`Date`=? WHERE `ActivityId`=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('iisisi', $entryIDCat, $employeeID, $type, $hours, $date, $activityID);
        $stmt->execute();
        $stmt->close();
        echo json_encode($returned);
    }
    /**
     * delete AmActivity from Activity id
     */
    function deleteAmActivity(){
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if (!$conn) {
            die('Could not connect: ' . mysqli_error());
        }
        $json = file_get_contents('php://input');
        $obj = json_decode($json,true);

        $activityId = $obj['ActivityId'];

        $returned->isValid = 'valid';
        $sql = "DELETE FROM `AmActivity` WHERE `ActivityId`=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $activityId);
        $stmt->execute();
        $stmt->close();

        echo json_encode($returned);
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
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if (!$conn) {
            die('Could not connect: ' . mysqli_error());
        }
        $json = file_get_contents('php://input');
        $obj = json_decode($json,true);

        $returned->isValid = 'valid';
        $sql = "SELECT * FROM `DogGuestListEntry`";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->bind_result($EntryID, $HomeDate, $Package, $Extras, $DogIn);
        $stmt->store_result();
        $returned->dogEntryList = array();
        while($stmt->fetch()){
            $temp = array('EntryID'=>$EntryID, 'HomeDate'=>$HomeDate, 'Package'=>$Package,'Extras'=>$Extras,'DogIn'=>$DogIn);
            array_push($returned->dogEntryList, $temp);
        }
        $stmt->close();

        echo json_encode($returned);
    }
    /**
     * create a new DogGuestListEntry entry
     */
    function createDogGuestListEntry(){
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if (!$conn) {
            die('Could not connect: ' . mysqli_error());
        }
        $json = file_get_contents('php://input');
        $obj = json_decode($json,true);
        
        $Date = $obj['Date'];
        $Package = $obj['Package'];
        $Extras = $obj['Extras'];
        $dogId = $obj['dogId'];

        $returned->isValid = 'valid';
        
        $sql = 'INSERT INTO `DogGuestListEntry`(`HomeDate`, `Package`, `Extras`, `DogIn`) VALUES (?,?,?,?)';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssi', $Date, $Package, $Extras, intval($dogId));
        $stmt->execute();
        $stmt->close();

        echo json_encode($returned);
    }
    /**
     * update DogGuestListEntry entry
     */
    function updateDogGuestListEntry(){
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if (!$conn) {
            die('Could not connect: ' . mysqli_error());
        }
        $json = file_get_contents('php://input');
        $obj = json_decode($json,true);

        $EntryID = $obj['EntryID'];
        $newHomeDate = $obj['HomeDate'];
        $newPackage = $obj['Package'];
        $newExtras = $obj['Extras'];
        $newDogIn = $obj['DogIn'];

        $returned->isValid = "valid";
        $sql = "UPDATE `DogGuestListEntry` SET `HomeDate`=?,`Package`=?,`Extras`=?,`DogIn`=? WHERE `EntryID` = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssii',$newHomeDate, $newPackage, $newExtras, $newDogIn, $EntryID);
        $stmt->execute();
        $stmt->close();
        echo json_encode($returned);
    }
    /**
     * delete DogGuestListEntry from Entry id
     */
    function deleteDogGuestListEntry(){
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if (!$conn) {
            die('Could not connect: ' . mysqli_error());
        }
        $json = file_get_contents('php://input');
        $obj = json_decode($json,true);

        $entryId = $obj['EntryID'];

        $returned->isValid = 'valid';
        $sql = "DELETE FROM `DogGuestListEntry` WHERE `EntryID`=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $entryId);
        $stmt->execute();
        $stmt->close();

        echo json_encode($returned);
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
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if (!$conn) {
            die('Could not connect: ' . mysqli_error());
        }
        $json = file_get_contents('php://input');
        $obj = json_decode($json,true);

        $returned->isValid = 'valid';
        $sql = "SELECT * FROM `CatGuestListEntry`";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->bind_result($EntryID, $HomeDate, $Package, $Extras, $CatIn);
        $stmt->store_result();
        $returned->catEntryList = array();
        while($stmt->fetch()){
            $temp = array('EntryID'=>$EntryID, 'HomeDate'=>$HomeDate, 'Package'=>$Package,'Extras'=>$Extras,'CatIn'=>$CatIn);
            array_push($returned->catEntryList, $temp);
        }
        $stmt->close();

        echo json_encode($returned);
    }
    /**
     * create a new CatGuestListEntry entry
     */
    function createCatGuestListEntry(){
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if (!$conn) {
            die('Could not connect: ' . mysqli_error());
        }
        $json = file_get_contents('php://input');
        $obj = json_decode($json,true);
        
        $Date = $obj['Date'];
        $Package = $obj['Package'];
        $Extras = $obj['Extras'];
        $catId = $obj['catId'];

        $returned->isValid = 'valid';
        
        $sql = 'INSERT INTO `CatGuestListEntry`(`HomeDate`, `Package`, `Extras`, `CatIn`) VALUES (?,?,?,?)';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssi', $Date, $Package, $Extras, intval($catId));
        $stmt->execute();
        $stmt->close();

        echo json_encode($returned);
    }
    /**
     * update CatGuestListEntry entry
     */
    function updateCatGuestListEntry(){
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if (!$conn) {
            die('Could not connect: ' . mysqli_error());
        }
        $json = file_get_contents('php://input');
        $obj = json_decode($json,true);

        $EntryID = $obj['EntryID'];
        $newHomeDate = $obj['HomeDate'];
        $newPackage = $obj['Package'];
        $newExtras = $obj['Extras'];
        $newCatIn = $obj['CatIn'];

        $returned->isValid = "valid";
        $sql = "UPDATE `CatGuestListEntry` SET `HomeDate`=?,`Package`=?,`Extras`=?,`CatIn`=? WHERE `EntryID` = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssii',$newHomeDate, $newPackage, $newExtras, $newCatIn, $EntryID);
        $stmt->execute();
        $stmt->close();
        echo json_encode($returned);
    }
    /**
     * delete CatGuestListEntry from Entry id
     */
    function deleteCatGuestListEntry(){
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if (!$conn) {
            die('Could not connect: ' . mysqli_error());
        }
        $json = file_get_contents('php://input');
        $obj = json_decode($json,true);

        $entryId = $obj['EntryID'];

        $returned->isValid = 'valid';
        $sql = "DELETE FROM `CatGuestListEntry` WHERE `EntryID`=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $entryId);
        $stmt->execute();
        $stmt->close();

        echo json_encode($returned);
    }
?>