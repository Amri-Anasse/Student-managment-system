<?php
require_once 'connexion.php';
require_once 'includes/header.php';

$nomRecherche = trim($_GET['recherche'] ?? '');
$classeRecherche = trim($_GET['classe'] ?? '');

$sql = "SELECT * FROM etudiants";
$conditions = [];
$params = [];

if ($nomRecherche !== '') {
    $conditions[] = "nom LIKE ?";
    $params[] = "%$nomRecherche%";
}

if ($classeRecherche !== '') {
    $conditions[] = "classe = ?";
    $params[] = $classeRecherche;
}

if ($conditions) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

$sql .= " ORDER BY id DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$etudiants = $stmt->fetchAll();

require_once 'includes/header.php';
?>

<h1 class="mb-4">
    <i class="fas fa-list me-2"></i>Liste des étudiants
</h1>

<?php if (isset($_GET['msg']) && $_GET['msg'] === 'ajout_ok'): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i><strong>Succès !</strong> L'étudiant a été ajouté.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php elseif (isset($_GET['msg']) && $_GET['msg'] === 'modification_ok'): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i><strong>Succès !</strong> L'étudiant a été modifié.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php elseif (isset($_GET['msg']) && $_GET['msg'] === 'suppression_ok'): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i><strong>Succès !</strong> L'étudiant a été supprimé.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-5">
                <label class="form-label">Recherche par nom</label>
                <input type="text" name="recherche" class="form-control"
                       placeholder="Rechercher un étudiant..."
                       value="<?= htmlspecialchars($nomRecherche) ?>">
            </div>

            <div class="col-md-4">
                <label class="form-label">Classe</label>
                <select name="classe" class="form-select">
                    <option value="">Toutes les classes</option>
                    <option value="ILCS-1A" <?= $classeRecherche === 'ILCS-1A' ? 'selected' : '' ?>>ILCS-1A</option>
                    <option value="ILCS-1B" <?= $classeRecherche === 'ILCS-1B' ? 'selected' : '' ?>>ILCS-1B</option>
                </select>
            </div>

            <div class="col-md-3 d-flex align-items-end">
                <button class="btn btn-primary w-100">
                    <i class="fas fa-search me-1"></i>Chercher
                </button>
            </div>
        </form>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-striped table-hover table-bordered">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Classe</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($etudiants): ?>
                <?php foreach ($etudiants as $e): ?>
                    <tr>
                        <td><?= htmlspecialchars((string)$e['id']) ?></td>
                        <td><?= htmlspecialchars($e['nom']) ?></td>
                        <td><?= htmlspecialchars($e['prenom']) ?></td>
                        <td><?= htmlspecialchars($e['email']) ?></td>
                        <td>
                            <span class="badge bg-primary"><?= htmlspecialchars($e['classe']) ?></span>
                        </td>
                        <td>
                            <a href="details.php?id=<?= urlencode((string)$e['id']) ?>" class="btn btn-sm btn-info text-white">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="modifier.php?id=<?= urlencode((string)$e['id']) ?>" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="supprimer.php?id=<?= urlencode((string)$e['id']) ?>" class="btn btn-sm btn-danger"
                               onclick="return confirm('Confirmer la suppression ?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">Aucun étudiant trouvé.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once 'includes/footer.php'; ?>