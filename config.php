<?php
$db=pg_connect('host=localhost dbname=votingbersama user=postgres password=bicuke124574');
if( !$db ){
    die("Gagal terhubung dengan database: " . pg_connect_error());
}
?>