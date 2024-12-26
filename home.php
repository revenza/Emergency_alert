<?php
session_start();

include 'db_conn.php';

if (!isset($_SESSION["id"]) || !isset($_SESSION["username"])) {
    header("location: login/login.php");
    exit();
}

$user_id = $_SESSION["id"];
$result = $conn->query("SELECT id, name, phone FROM contact WHERE user_id = '$user_id'");

// Jika tombol tambah kontak ditekan
if (isset($_POST['addContact'])) {
    $nama = $_POST['contactName'];
    $no_hp = $_POST['contactPhone'];
    $conn->query("INSERT INTO contact (name, phone, user_id) VALUES ('$nama', '$no_hp', '$user_id')");
    header('Location: home.php');
}

// Jika tombol cari ditekan
if (isset($_POST['cari'])) {
    $result = cari($_POST['keyword']);
}

function cari($keyword)
{
    global $conn;
    $user_id = $_SESSION["id"];
    $result = $conn->query("SELECT id, name, phone FROM contact WHERE user_id = '$user_id' AND name LIKE '%$keyword%'");
    return $result;
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
    <div class="sidenav">
        <div class="sidenav-header">
            <h2>EMERGENCY ALERT</h2>
        </div>

        <nav>
            <ul>
                <li><a href=#>Dashboard</a></li>
                <li><a href="blog.php">Blog</a></li>
                <li><a href="login/logout.php"><button>logout</button></a></li>
            </ul>
        </nav>
    </div>
    <div class="main">
        <!-- Navbar -->
        <nav class="navbar bg-body-tertiary mb-5" style="margin-left:0">
            <div class="container d-flex justify-content-between">
                <!-- Form Pencarian -->
                <form action="" method="post" class="d-flex" role="search" style="position: fixed;">
                    <input name="keyword" class="form-control" style="width: 1000px; padding:20px; padding-right: 60px;" type="search" placeholder="Search" aria-label="Search" autofocus>
                    <button name="cari" class="btn" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%);" type="submit">
                        <i data-feather="search"></i>
                    </button>
                </form>

                <!-- Tombol Add Kontak -->
                <div class="add-kontak">
                    <button type="button" class="btn btn-success" data-bs-target="#addContactModal" data-bs-toggle="modal">
                        <i data-feather="user-plus"></i>
                    </button>
                </div>
            </div>
        </nav>


        <!-- Modal untuk Add Contact -->
        <!-- Modal Add Contact -->
        <div class="modal fade" id="addContactModal" tabindex="-1" aria-labelledby="addContactModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addContactModalLabel">Tambah Kontak Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="home.php" method="post"> <!-- Form khusus untuk tambah kontak -->
                        <div class="modal-body">
                            <div class="mb-3">
                                <input type="text" name="contactName" class="form-control" id="contactName" placeholder="Masukkan Nama" required>
                            </div>
                            <div class="mb-3">
                                <input type="text" name="contactPhone" class="form-control" id="contactPhone" placeholder="Masukkan Nomor HP" value="62" required>
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


        <div class="main-content w-100 mx-3">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="contact-card d-flex justify-content-between align-items-center p-3 shadow-sm rounded">
                    <div class="contact-info align-items-center">
                        <div class="contact-name">
                            <h5 class="mb-0"><?php echo htmlspecialchars($row['name']); ?></h5>
                        </div>
                    </div>
                    <div class="contact-actions">
                        <a href="edit_contact.php?id=<?php echo $row['id']; ?>" class="mx-2">
                            <i data-feather="edit-3" style="color: black;"></i>
                        </a>
                        <a href="delete_contact.php?id=<?php echo $row['id']; ?>" class="mx-2" onclick="return confirm('Are you sure you want to delete this contact?');">
                            <i data-feather="trash-2" style="color: black;"></i>
                        </a>
                        <button class="btn btn-info btn-sm mx-2" data-bs-toggle="modal" data-bs-target="#shareLocationModal<?php echo $row['id']; ?>">Kirim Lokasi</button>
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



        <!-- Modal for Share Location -->
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

                        // Membuat URL WhatsApp dengan pesan lokasi yang sudah di-encode
                        const message = `Lokasi saya adalah https://www.google.com/maps?q=${latitude},${longitude}`;
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