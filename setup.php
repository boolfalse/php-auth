<?php

require_once "env.php";
require_once "migrations.php";

// Attempt to connect to MySQL database
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

foreach ($migrations as $migration) {
    try {
        $stmt = mysqli_prepare($link, $migration['query']);

        if(mysqli_stmt_execute($stmt))
        {
            echo "Executed migration for table: " . $migration['table'] . "\n";
        }
        else{
            echo "Something went wrong with table: " . $migration['table'] . "\n";
            mysqli_close($link);
            die();
        }
    }
    catch (Exception $e)
    {
        echo "Something went wrong:\n" . $e->getMessage() . "\n";
        mysqli_close($link);
        die();
    }
}

// Close connection
mysqli_close($link);

echo "\n";
echo "Migrations executed successfully!\n";
