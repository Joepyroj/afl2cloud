<?php
require_once 'firebase_config.php';


function readUsers() {
    global $database;
    $usersRef = $database->getReference('users');
    $snapshot = $usersRef->getSnapshot();

    if ($snapshot->exists() && is_array($snapshot->getValue())) {
        return $snapshot->getValue();
    } else {
        return [];
    }
}

$users = readUsers();

echo "<!DOCTYPE html>";
echo "<html>";
echo "<head>";
echo "<title>Daftar Pengguna</title>";
echo "<link rel='stylesheet' href='style.css'>";
echo "</head>";
echo "<body>";
echo "<div class='container'>";
if (!empty($users)) {
    echo "<h2>Daftar Pengguna:</h2>";
    echo "<ul class='user-list'>";
    foreach ($users as $userId => $userData) {
        echo "<li class='user-item'>";
        echo "<strong class='user-detail'>Nama:</strong> " . $userData['name'] . "<br>";
        echo "<strong class='user-detail'>Email:</strong> " . $userData['email'] . "<br>";
        echo "<strong class='user-detail'>Usia:</strong> " . $userData['age'] . "<br>";
        echo "<strong class='user-detail'>Kelas:</strong> " . $userData['kelas'] . "<br>";
        echo "<div class='user-actions'>";
        echo "<form method='GET' action='edit.php' style='display:inline;' class='edit-form'>";
        echo "<input type='hidden' name='id' value='" . $userId . "'>";
        echo "<button type='submit' class='edit-button'>Edit</button>";
        echo "</form>";
        echo "<form method='GET' action='delete.php' style='display:inline;' class='delete-form'>";
        echo "<input type='hidden' name='id' value='" . $userId . "'>";
        echo "<button type='submit' class='delete-button'>Delete</button>";
        echo "</form>";
        echo "</div>";
        echo "</li>";
    }
    echo "</ul>";
} else {
    echo "<p class='no-data'>Tidak ada data pengguna.</p>";
}
?>

<form method="GET" action="form.php" class="back-form">
    <button type="submit" class="back-button">Back</button>
</form>
</div>
</body>
</html>