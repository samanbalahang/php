<?php
$dbh = new PDO("mysql:host=localhost;dbname=test", "root","");
function test(){
    $dbh = new PDO("mysql:host=localhost;dbname=test", "root","");
    $stmt = $dbh->query("SELECT COUNT(*) FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = 'retest'");
    // return (bool) $stmt->fetchColumn();
    // print_r($stmt);
    return $stmt->fetch()["COUNT(*)"];   
}

if(isset($_REQUEST["LastName"])){
    // echo $_REQUEST["LastName"];
    $stmt = $dbh->prepare("SELECT * FROM Persons WHERE `LastName` LIKE ? ");
    $stmt->execute([$_REQUEST["LastName"]]); 
    while ($row = $stmt->fetch()) {
        echo $row['LastName']."<br />\n";
        echo $row['FirstName']."<br />\n";
        echo $row['Age']."<br />\n";
    }
    

}else{
    if(test() != 1){
        $dbh->query("create database retest");
        $dbh->query("use retest");
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $sql = "CREATE TABLE Persons (
        ID int NOT NULL AUTO_INCREMENT,
        LastName varchar(255) NOT NULL,
        FirstName varchar(255),
        Age int,
        PRIMARY KEY (ID)
        )";
        $dbh->exec(statement: $sql); 
        $LastName = "LastName";
        $FirstName = "FirstName";
        $Age      = 12;
        $sql = "INSERT INTO Persons (LastName, FirstName, Age) VALUES (?,?,?)";
        $stmt= $dbh->prepare($sql);
        $stmt->execute([$LastName, $FirstName, $Age]);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="#" method="POST">
        <input type="text" name="LastName" id="LastName">
        <br>
        <input type="submit">
    </form>
</body>
</html>








