<?php

require_once '../vendor/autoload.php';

use Dotenv\Dotenv;
use App\Helper\Auth;

$dotenv = Dotenv::createImmutable(dirname(__DIR__, 2));
$dotenv->load();

session_start();

// Auth check 
if(!Auth::check()) {
    header("Location: \login.php");
    exit();
}

if(Auth::user()->userType !== 'admin') {
    header("Location: index.php");
}
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title> <?php echo $_ENV['APP_NAME'] ?> - Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="../assets/css/fontawesome/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

        <link href="../assets/css/style.css" rel="stylesheet" />
    <!-- Custom styles for this template-->
    <link href="../assets/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- select 2  -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

</head>

<body id="page-top">