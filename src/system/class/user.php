<?php
require '../package/icrud.php';

// instance
$user = new icrud(['user'], ['id', 'name', 'postname', 'age', 'birthday'], true);

if ($_GET['action'] == 'create') {
    $user->create([$_GET['name'], $_GET['postname'], $_GET['age'], $_GET['birthday']]);
} else if ($_GET['action'] == 'update') {
    // it needs the table of datas
    $tab = [$_GET['name'], $_GET['postname'], $_GET['age'], $_GET['birthday']];
    $user->update($_GET['id'], $tab);
}else if ($_GET['action'] == 'delete') {
    $user->delete($_GET['id']);
}


    $tabUser = $user->read(
        [
            'id', 
            'name', 
            'postname', 
            'age', 
            'birthday'
        ], isset($_GET['search']) ? 'name=:name' : null, 
            isset($_GET['search']) ? ['name' => $_GET['search']] : null
        , 
        null);
    header("Access-Control-Allow-Origin: *");
    header("Access-type: application/json");
    echo json_encode($tabUser);










// $db = new PDO('mysql:host=localhost; dbname=icrud', 'root', '');
// $sel = $db->query("SELECT `id`, `name`, `age` FROM `user` WHERE 1");
// // $allData = [];
// while ($data = $sel->fetch(PDO::FETCH_OBJ)) {
//     $allData[] = $data;
// }

// header("Access-Control-Allow-Origin: *");
// header("Access-type: application/json");
// echo json_encode($allData);

?>

