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
    if (substr($no_hp, 0, 2) === '08') {
        $no_hp = '62' . substr($no_hp, 1);
    }
    if (substr($no_hp, 0, 2) !== '62') {
        die("Nomor HP harus dimulai dengan 62.");
    }

    // Update data kontak
    $updateQuery = "UPDATE contact SET name='$nama', phone='$no_hp' WHERE id = $id";
    if ($conn->query($updateQuery)) {
        header('Location: index.php');
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

    <!-- navbar -->
    <nav class="navbar navbar-expand-lg bg-success navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Emergency Alert</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="blog.php">Blog</a>
                    </li>
                    <?php if ($_SESSION["id"] == 14): ?>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="admin.php">Admin</a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item ">
                        <a class="nav-link active text-dangger" aria-current="page" href="login/logout.php"> <i data-feather="log-out" style="color: tomato;"></i></a>
                    </li>
                </ul>
                <form action="" method="post" class="d-flex" role="search">
                    <input name="keyword" class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button name="cari" class="btn btn-outline-light" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="text-center mb-4">Edit Kontak</h1>
        <form method="POST" class="p-4 shadow-sm rounded border">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" name="nama" id="nama" class="form-control" value="<?= htmlspecialchars($data['name']); ?>" maxlength="7" required>
            </div>
            <div class="mb-3">
                <label for="no_hp" class="form-label">No HP</label>
                <input type="text" name="no_hp" id="no_hp" class="form-control" value="<?= htmlspecialchars($data['phone']); ?>" pattern="\d*" maxlength="15" required>
            </div>
            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="index.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
    <script>
        document.getElementById('no_hp').addEventListener('input', function(e) {
            let value = e.target.value;
            if (value.length > 15) {
                e.target.value = value.slice(0, 15);
            }
        });

        document.querySelector('form').addEventListener('submit', function(e) {
            let noHpInput = document.getElementById('no_hp');
            let noHpValue = noHpInput.value;

            if (!/^\d+$/.test(noHpValue)) {
                alert('Nomor HP harus berupa angka.');
                e.preventDefault();
                return;
            }

            if (noHpValue.startsWith('08')) {
                noHpInput.value = '62' + noHpValue.slice(1);
                noHpValue = noHpInput.value;
            }

            if (!noHpValue.startsWith('62')) {
                alert('Nomor HP harus dimulai dengan 62.');
                e.preventDefault();
            }
        });
    </script>

    <script src="https://unpkg.com/feather-icons"></script>
    <script>
        feather.replace();
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>

</html>