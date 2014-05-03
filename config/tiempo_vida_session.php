<?php
session_start();

if(isset($_SESSION['EXPIRE'])){
    echo 'existe';
}else{
    echo ' no existe';
}


