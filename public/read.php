<?php
require_once 'firebase_config.php';

function readUsers() {
    global $database;

    // Cek jika database gagal di-load
    if (!$database) {
        return [];
    }

    $usersRef = $database->getReference('users');
    $snapshot = $usersRef->getSnapshot();

    if ($snapshot->exists() && is_array($snapshot->getValue())) {
        return $snapshot->getValue();
    } else {
        return [];
    }
}

$users = readUsers();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Daftar Pengguna</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <?php if (!empty($users)): ?>
            <h2>Daftar Pengguna:</h2>
            <ul class="user-list">
                <?php foreach ($users as $userId => $userData): ?>
                    <li class="user-item">
                        <strong class="user-detail">Nama:</strong> <?= htmlspecialchars($userData['name']) ?><br>
                        <strong class="user-detail">Email:</strong> <?= htmlspecialchars($userData['email']) ?><br>
                        <strong class="user-detail">Usia:</strong> <?= htmlspecialchars($userData['age']) ?><br>
                        <strong class="user-detail">Kelas:</strong> <?= htmlspecialchars($userData['kelas']) ?><br>

                        <div class="user-actions">
                            <form method="GET" action="edit.php" class="edit-form" style="display:inline;">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($userId) ?>">
                                <button type="submit" class="edit-button">Edit</button>
                            </form>

                            <form method="GET" action="delete.php" class="delete-form" style="display:inline;">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($userId) ?>">
                                <button type="submit" class="delete-button">Delete</button>
                            </form>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="no-data">Tidak ada data pengguna.</p>
        <?php endif; ?>

        <form method="GET" action="form.php" class="back-form">
            <button type="submit" class="back-button">Back</button>
        </form>
    </div>
</body>
</html>
