<?php

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

function get_connection()
{
    $HOST = "localhost";
    $USER = "root";
    $PASS = "";
    $DB = "petmanagement";
    $PORT = 3306;

    $conn = null;

    try {
        $conn = new mysqli($HOST, $USER, $PASS, $DB, $PORT);
    }
    catch (mysqli_sql_exception $se) {
        die("Connection Error: " . $se->getMessage());
    }

    return $conn;
}

?>
