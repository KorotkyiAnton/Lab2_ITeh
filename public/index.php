<?php

namespace Db;

require_once __DIR__."/../vendor/autoload.php";

$db = new DbAccess();

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Library</title>

    <style>
        table, td, th {
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>

    <script src="script.js"></script>

</head>
<body>

<?php
echo \Db\DbAccess::$fosrmStart;
$db->viewSelect("Publisher");
echo \Db\DbAccess::$formEnd;

echo \Db\DbAccess::$fosrmStart;
$db->viewDate();
echo \Db\DbAccess::$formEnd;

echo \Db\DbAccess::$fosrmStart;
$db->viewSelect("Author");
echo \Db\DbAccess::$formEnd;
?>
<hr>

<div id="savedContent"></div>

<hr>
<?php
if (isset($_POST)) {
    $db->chooseRequest($_POST);
}
?>
</body>
</html>
