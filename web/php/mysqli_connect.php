<?php



$dbhost = 'mastelottoplan.backups.uky.edu';

$dbname = 'db_name(username for sql db usually same as user)';

$dbuser = 'multi_lab user_name';

$dbpass = 'multi_lab password';

$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die("could not connect to mysql" .

mysqli_connect_error());

?>