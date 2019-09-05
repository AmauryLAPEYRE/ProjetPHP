<?php

$mysqli = new mysqli("localhost", "root", "", "site");
if ($mysqli->connect_error) die('Un problème est survenu lors de la tentative de connexion à la Base de données : ' . $mysqli->connect_error);

session_start();
$contenu = '';

require_once("fonction.php");
