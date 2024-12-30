<?php
session_start();

include 'db_conn.php';

if (!isset($_SESSION['id']) || !isset($_SESSION['username'])) {
    header("Location: login/login.php");
    exit();
}

$id = $_GET['id'];

$result = $conn->query("SELECT * FROM contact WHERE id = $id");
$data = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $conn->real_escape_string($_POST['nama']);
    $no_hp = $conn->real_escape_string($_POST['no_hp']);

    // Update data kontak
    $updateQuery = "UPDATE contact SET name='$nama', phone='$no_hp' WHERE id = $id";
    if ($conn->query($updateQuery)) {
        header('Location: home.php');
        exit();
    } else {
        die("Gagal mengupdate data: " . $conn->error);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kontak</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Edit Kontak</h1>
        <form method="POST" class="p-4 shadow-sm rounded border">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" name="nama" id="nama" class="form-control" value="<?= htmlspecialchars($data['name']); ?>" maxlength="7" required>
            </div>
            <div class="mb-3">
                <label for="no_hp" class="form-label">No HP</label>
                <input type="text" name="no_hp" id="no_hp" class="form-control" value="<?= htmlspecialchars($data['phone']); ?>" required>
            </div>
            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="home.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</body>

</html>