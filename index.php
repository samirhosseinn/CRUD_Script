<?php
require_once "./services.php";


$Udb = new UserDatabaseService();

echo $Udb->createUser("test", "test@test.com", "test1234");

echo json_encode($Udb->readUser("test"));
echo json_encode($Udb->readAllUsers());

echo $Udb->updateUser("test", "password", "StRongP@ssw0rd");

echo $Udb->deleteUser("test");



