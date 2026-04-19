<?php
require 'connexion.php';

$id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM etudiant WHERE id=?");
$stmt->execute([$id]);

header("Location: liste.php");