<?php
$db=pg_connect('host=localhost dbname=votingbersama user=postgres password= password_postgre');
if( !$db ){
    die("Gagal terhubung dengan database: " . pg_connect_error());
}
?>
