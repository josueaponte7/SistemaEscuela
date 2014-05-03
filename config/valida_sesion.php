<?php
session_start();
if(isset( $_SESSION['id_session']) && isset($_SESSION['date_session'])){
    header('location:menu.php');
}
