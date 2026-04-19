<?php
require_once 'connexion.php';

$errors = [];
$id = $_GET['id'] ?? $_POST['id'] ?? '';

if (!ctype_digit($id)) {
    die('ID invalide');
}

$stmt = $pdo->prepare("SELECT * FROM etudiants WHERE id = ?");
$stmt->execute([$id]);
$etudiant = $stmt->fetch();

if (!$etudiant) {
    die('Étudiant introuvable');
}

$nom = $etudiant['nom'];
$prenom = $etudiant['prenom'];
$email = $etudiant['email'];
$classe = $etudiant['classe'];
$date_naissance = $etudiant['date_naissance'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $classe = trim($_POST['classe'] ?? '');
    $date_naissance = trim($_POST['date_naissance'] ?? '');

    if ($nom === '') $errors[] = 'Le nom est obligatoire.';
    if ($prenom === '') $errors[] = 'Le prénom est obligatoire.';
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Email invalide.';
    }
    if ($classe === '') $errors[] = 'La classe est obligatoire.';

    if (empty($errors)) {
        $update = $pdo->prepare(
            "UPDATE etudiant
             SET nom = ?, prenom = ?, email = ?, classe = ?, date_naissance = ?
             WHERE id = ?"
        );
        $update->execute([
            $nom,
            $prenom,
            $email,
            $classe,
            $date_naissance !== '' ? $date_naissance : null,
            $id
        ]);

        header('Location: liste.php?msg=modification_ok');
        exit;
    }
}

require_once 'includes/header.php';
?>

<h1 class="mb-4">
    <i class="fas fa-edit me-2"></i>Modifier l'étudiant
</h1>

<?php if ($errors): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<div class="card shadow-sm">
    <div class="card-body">
        <form method="POST">
            <input type="hidden" name="id" value="<?= htmlspecialchars((string)$id) ?>">

            <div class="mb-3">
                <label class="form-label">Nom</label>
                <input type="text" name="nom" class="form-control" required value="<?= htmlspecialchars($nom) ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Prénom</label>
                <input type="text" name="prenom" class="form-control" required value="<?= htmlspecialchars($prenom) ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required value="<?= htmlspecialchars($email) ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Classe</label>
                <select name="classe" class="form-select" required>
                    <option value="">-- Choisir --</option>
                    <option value="ILCS-1A" <?= $classe === 'ILCS-1A' ? 'selected' : '' ?>>ILCS-1A</option>
                    <option value="ILCS-1B" <?= $classe === 'ILCS-1B' ? 'selected' : '' ?>>ILCS-1B</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Date de naissance</label>
                <input type="date" name="date_naissance" class="form-control" value="<?= htmlspecialchars((string)$date_naissance) ?>">
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-1"></i>Mettre à jour
            </button>
            <a href="liste.php" class="btn btn-secondary ms-2">Annuler</a>
        </form>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
