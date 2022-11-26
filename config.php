<?php
$db=pg_connect('host=localhost dbname=votingbersama user=postgres password=R@bbaniku2003');
if( !$db ){
    die("Gagal terhubung dengan database: " . pg_connect_error());
}
?>