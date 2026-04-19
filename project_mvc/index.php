<?php
require_once 'connexion.php';

$totalStmt = $pdo->query("SELECT COUNT(*) as total FROM etudiants");
$total = $totalStmt->fetch()['total'];

$classesStmt = $pdo->query("SELECT classe, COUNT(*) as nb FROM etudiants GROUP BY classe ORDER BY classe");
$classes = $classesStmt->fetchAll();

$lastStmt = $pdo->query("SELECT * FROM etudiants ORDER BY date_inscription DESC LIMIT 1");
$lastStudent = $lastStmt->fetch();

require_once 'includes/header.php';
?>

<h1 class="mb-4">
    <i class="fas fa-chart-bar me-2"></i>Tableau de bord
</h1>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <i class="fas fa-users me-2"></i>Total étudiants
            </div>
            <div class="card-body text-center">
                <div class="display-6 fw-bold text-primary"><?= htmlspecialchars((string)$total) ?></div>
                <p class="text-muted mb-0">étudiants inscrits</p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white">
                <i class="fas fa-layer-group me-2"></i>Classes
            </div>
            <div class="card-body text-center">
                <div class="display-6 fw-bold text-success"><?= htmlspecialchars((string)count($classes)) ?></div>
                <p class="text-muted mb-0">classes actives</p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-header bg-info text-white">
                <i class="fas fa-user-plus me-2"></i>Dernier inscrit
            </div>
            <div class="card-body text-center">
                <?php if ($lastStudent): ?>
                    <div class="fw-bold">
                        <?= htmlspecialchars($lastStudent['nom']) . ' ' . htmlspecialchars($lastStudent['prenom']) ?>
                    </div>
                    <p class="text-muted mb-0"><?= htmlspecialchars($lastStudent['classe']) ?></p>
                <?php else: ?>
                    <p class="text-muted mb-0">Aucun étudiant</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-secondary text-white">
        <i class="fas fa-table me-2"></i>Répartition par classe
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Classe</th>
                        <th>Nombre</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($classes as $classe): ?>
                        <tr>
                            <td><?= htmlspecialchars($classe['classe']) ?></td>
                            <td><?= htmlspecialchars((string)$classe['nb']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>