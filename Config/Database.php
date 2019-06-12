<?php
    $_host      = 'localhost';
    $_password  = '';
    $_account   = 'root';
    $_database  = 'einvoice_data';

    $_connection = new mysqli($_host,$_account,$_password,$_database);
    if ($_connection->connect_error)
	{
        echo "Failed to connect to MySQL: " . $_connection->connect_error;
        die();
	}
    mysqli_set_charset($_connection, "utf8");
?>
