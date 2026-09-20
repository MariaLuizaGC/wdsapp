<?php
include_once 'controllers/model.php';
include_once 'controllers/functions.php';

$model = new model();
$functions = new functions();
$conn = new connect();

$sql = "SELECT * FROM clients";
$query = $conn->query($sql);

$sqlUpdateResult = null;
$sqlSaltResult = null;

while ($result = $conn->fetch_array($query)) {
 
    $salt = hash('sha1', $functions->createPassword());
    $checkSalt = $functions->search("hashc","ref",$result["id"]);

    if($checkSalt){
        continue;
    }
    else
    {
        $sqlSalt = "INSERT INTO hashc (ref, hash) VALUES (".$result["id"].", '".$salt."');";        
    }

    $sqlSaltResult .= "<br> ".$sqlSalt;
    $rssExecSalt = true;
    // $rsExecSalt = $model->model_exec($sqlSalt);

    if($rssExecSalt)
    {
        $newPassword = hash('sha256', md5($salt . hash('sha256', $result["password"])));
        $sqlUpdate = "UPDATE clients SET password = '".$newPassword."' WHERE id = ".$result["id"].";";
        $sqlUpdateResult .= "<br> ".$sqlUpdate;
        // $rsExecUpdate = $model->model_exec($sqlUpdate);
    }    
}


echo $sqlSaltResult;
echo "<br><br>";
echo $sqlUpdateResult;