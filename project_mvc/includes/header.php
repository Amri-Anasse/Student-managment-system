<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GestEtu – Gestion des étudiants</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <i class="fas fa-graduation-cap me-2"></i>GestEtu
        </a>

        <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                <a class="nav-link <?= $currentPage === 'index.php' ? 'active' : '' ?>" href="index.php">
                    Tableau de bord
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $currentPage === 'liste.php' ? 'active' : '' ?>" href="liste.php">
                    Liste
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $currentPage === 'ajouter.php' ? 'active' : '' ?>" href="ajouter.php">
                    Ajouter
                </a>
            </li>
        </ul>
    </div>
</nav>

<div class="container mt-4">