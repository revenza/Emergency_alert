<?php
session_start();

include 'db_conn.php';

if (!isset($_SESSION["id"]) || !isset($_SESSION["username"])) {
    header("location: splash.php/index.php");
    exit();
}

$user_id = $_SESSION["id"];
$result = $conn->query("SELECT id, name, phone FROM contact WHERE user_id = '$user_id'");

if (isset($_POST['addContact'])) {
    $nama = trim($_POST['contactName']);
    $no_hp = trim($_POST['contactPhone']);

    if ($no_hp === "62") {
        $error = "Nomor HP tidak boleh hanya 62. Silakan masukkan nomor lengkap.";
    } elseif (!is_numeric($no_hp)) {
        $error = "Nomor HP hanya boleh berisi angka.";
    } else {
        $stmt = $conn->prepare("INSERT INTO contact (name, phone, user_id) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $nama, $no_hp, $user_id);

        if ($stmt->execute()) {
            header('Location: home.php');
            exit();
        } else {
            $error = "Gagal menambahkan kontak. Silakan coba lagi.";
        }
    }
}

if (isset($_POST['cari'])) {
    $result = cari($_POST['keyword']);
}

function cari($keyword)
{
    global $conn;
    $user_id = $_SESSION["id"];

    $stmt = $conn->prepare("SELECT id, name, phone FROM contact WHERE user_id = ? AND name LIKE ?");
    $like_keyword = "%" . $keyword . "%";
    $stmt->bind_param("is", $user_id, $like_keyword);
    $stmt->execute();

    return $stmt->get_result();
}
?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emergency Alert</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Righteous&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style/style.css">

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
                        <a class="nav-link active" aria-current="page" href="Home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="blog.php">Blog</a>
                    </li>
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
    <!-- Main Content -->
    <div class="container-fluid main mt-5">
        <!-- Tombol Add Kontak -->
        <div class="add-kontak">
            <button type="button" class="btn  d-flex align-items-center" data-bs-target="#addContactModal" data-bs-toggle="modal">
                <i data-feather="user-plus"></i>
                <p class="text ms-2 mb-0">add contact</p>

            </button>
        </div>
        <!-- Modal Add Contact -->
        <div class="modal fade" id="addContactModal" tabindex="-1" aria-labelledby="addContactModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addContactModalLabel">Tambah Kontak Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="home.php" method="post">
                        <div class="modal-body">
                            <div class="mb-3">
                                <input type="text" name="contactName" class="form-control" id="contactName" placeholder="Masukkan Nama" maxlength="7" required>
                            </div>
                            <div class="mb-3">
                                <input type="number" name="contactPhone" class="form-control" id="contactPhone" placeholder="Masukkan Nomor HP" value="62" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" name="addContact" class="btn btn-success">Simpan Kontak</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- kalo user ga ngisi no hp -->
        <?php if (isset($error)): ?>
            <div class="alert alert-danger">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <div class="main-content w-100 mt-2">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="contact-card d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center p-3 shadow-sm rounded">
                    <div class="contact-info d-flex flex-column align-items-start mb-2 mb-md-0">
                        <div class="contact-name">
                            <h5 class="mb-0"><?php echo htmlspecialchars($row['name']); ?></h5>
                        </div>
                    </div>
                    <div class="contact-actions d-flex flex-wrap justify-content-start justify-content-md-end">
                        <a href="edit_contact.php?id=<?php echo $row['id']; ?>" class="mx-2 mb-2 mb-md-0">
                            <i data-feather="edit-3" style="color: black;"></i>
                        </a>
                        <a href="delete_contact.php?id=<?php echo $row['id']; ?>" class="mx-2 mb-2 mb-md-0" onclick="return confirm('Are you sure you want to delete this contact?');">
                            <i data-feather="trash-2" style="color: black;"></i>
                        </a>
                        <button class="btn btn-success btn-sm mx-2" data-bs-toggle="modal" data-bs-target="#shareLocationModal<?php echo $row['id']; ?>">Kirim Lokasi</button>
                    </div>
                </div>


                <!-- Modal untuk Share Location -->
                <div class="modal fade" id="shareLocationModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="shareLocationModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="shareLocationModalLabel">Share Location</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Share location for: <strong><?php echo htmlspecialchars($row['name']); ?></strong></p>
                                <p>Phone: <?php echo htmlspecialchars($row['phone']); ?></p>
                                <p>Note!: Harap menginstall aplikasi whatsapp pada pc atau handphone anda</p>
                                <a href="#" id="sendLocation<?php echo $row['id']; ?>" class="btn btn-info">Kirim</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>



        <!-- Modal untuk Share Location -->
        <div class="modal fade" id="shareLocationModal" tabindex="-1" aria-labelledby="shareLocationModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="shareLocationModalLabel">Kirim Lokasi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Lokasi Anda: (Masukkan lokasi atau peta yang sesuai)</p>
                        <button class="btn btn-success">Kirim Lokasi</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- event listener untuk tombol kirim -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            <?php foreach ($result as $row) : ?>
                document.getElementById('sendLocation<?php echo $row['id']; ?>').addEventListener('click', function() {
                    const phoneNumber = "<?php echo $row['phone']; ?>";
                    sendLocation(<?php echo $row['id']; ?>, phoneNumber);
                });
            <?php endforeach; ?>
        });
    </script>

    <!-- function untuk ngirim lokasi -->
    <script>
        function sendLocation(contactId, phoneNumber) {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;

                    const message = `Saya dalam keadaan darurat!!!Lokasi saya:
                        https://www.google.com/maps?q=${latitude},${longitude}`;
                    const whatsappUrl = `https://api.whatsapp.com/send?phone=${phoneNumber}&text=${encodeURIComponent(message)}`;

                    // Membuka WhatsApp Web dan mengisi pesan otomatis
                    window.open(whatsappUrl, '_blank'); // Membuka tab baru dengan WhatsApp Web

                }, function(error) {
                    alert("Gagal mendapatkan lokasi. Pastikan GPS aktif.");
                });
            } else {
                alert("Geolocation tidak didukung oleh browser ini.");
            }
        }
    </script>

    <script src="https://unpkg.com/feather-icons"></script>
    <script>
        feather.replace();
    </script>
    <script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>