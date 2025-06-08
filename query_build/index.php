<?php require_once "autoload.php";
$user = new User(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

</body>

</html>
<?php
$user = DB::table('users')->get();
foreach ($user as $u) {

    echo $u->name . "<br>";
}
?>