<?php
$filename = $argv[1];

$link = mysqli_connect("127.0.0.1","vagus", "agustin", "chakra_stock");

$result = $link->query("SHOW TABLES")->fetch_all();

$dbtablesfile = fopen($filename, "w");

foreach($result as $table){
    $create_table = $link->query("SHOW CREATE TABLE ". $table[0])->fetch_assoc();
    fwrite($dbtablesfile,$create_table["Create Table"]."\n");
}

?>