<?php
require_once 'connexion.php';

$id = $_GET['id'] ?? '';

if (!ctype_digit($id)) {
    die('ID invalide');
}

$stmt = $pdo->prepare("SELECT * FROM etudiant WHERE id = ?");
$stmt->execute([$id]);
$etudiant = $stmt->fetch();

if (!$etudiant) {
    die('Étudiant introuvable');
}

require_once 'includes/header.php';
?>

<h1 class="mb-4">
    <i class="fas fa-id-card me-2"></i>Détails de l'étudiant
</h1>

<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <?= htmlspecialchars($etudiant['nom']) . ' ' . htmlspecialchars($etudiant['prenom']) ?>
    </div>
    <div class="card-body">
        <p><strong>ID :</strong> <?= htmlspecialchars((string)$etudiant['id']) ?></p>
        <p><strong>Nom :</strong> <?= htmlspecialchars($etudiant['nom']) ?></p>
        <p><strong>Prénom :</strong> <?= htmlspecialchars($etudiant['prenom']) ?></p>
        <p><strong>Email :</strong> <?= htmlspecialchars($etudiant['email']) ?></p>
        <p><strong>Classe :</strong> <?= htmlspecialchars($etudiant['classe']) ?></p>
        <p><strong>Date de naissance :</strong> <?= htmlspecialchars((string)($etudiant['date_naissance'] ?? '')) ?></p>
        <p><strong>Date d'inscription :</strong> <?= htmlspecialchars((string)$etudiant['date_inscription']) ?></p>

        <a href="modifier.php?id=<?= urlencode((string)$etudiant['id']) ?>" class="btn btn-warning">Modifier</a>
        <a href="supprimer.php?id=<?= urlencode((string)$etudiant['id']) ?>" class="btn btn-danger"
           onclick="return confirm('Confirmer la suppression ?')">Supprimer</a>
        <a href="liste.php" class="btn btn-secondary">Retour</a>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>