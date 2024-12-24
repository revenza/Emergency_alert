<?php
session_start();
if (!isset($_SESSION["id"]) || !isset($_SESSION["username"])) {
    header("location: login/login.php");
    exit();
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
                <form class="d-flex" role="search" style="position: fixed;">
                    <input class="form-control" style="width: 1000px; padding:20px; padding-right: 60px;" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%);" type="submit">
                        <i data-feather="search"></i>
                    </button>
                </form>
            </div>
            <div class="add-kontak">
                <button type="button" class="btn btn-success" data-bs-target="#addContactModal" data-bs-toggle="modal"><i data-feather="user-plus"></i></button>
            </div>
        </nav>

        <!-- Modal for Add Contact -->
        <div class="modal fade" id="addContactModal" tabindex="-1" aria-labelledby="addContactModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addContactModalLabel">Add Contact</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="mb-3">
                                <input type="text" class="form-control" id="contactName" placeholder="Enter name">
                            </div>
                            <div class="mb-3">
                                <input type="text" class="form-control" id="contactPhone" placeholder="Enter phone number">
                            </div>
                            <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="main-content w-100 mx-3">
            <div class="contact-card d-flex justify-content-between align-items-center p-3 shadow-sm rounded">
                <div class="contact-info align-items-center">
                    <div class="contact-name">
                        <h5 class="mb-0">Ravenza Raditya</h5>
                    </div>
                </div>
                <div class="contact-actions">
                    <a href="#" class="mx-2">
                        <i data-feather="edit-3" style="color: black;"></i>
                    </a>
                    <a href="#" class="mx-2">
                        <i data-feather="trash-2" style="color: black;"></i>
                    </a>
                    <a href="#" class="mx-2">
                        <i class="mx-2" data-feather="more-vertical" style="color: black;" data-bs-toggle="modal" data-bs-target="#locationModal"></i>
                        <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#shareLocationModal">Kirim Lokasi</button>
                    </a>
                </div>
            </div>
        </div>

        <!-- Modal for Detail -->
        <div class="modal fade" id="locationModal" tabindex="-1" aria-labelledby="locationModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="locationModalLabel">Detail Kontak</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Nomor HP: +62 83183273382</p>
                    </div>
                </div>
            </div>
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


        <script src="https://unpkg.com/feather-icons"></script>
        <script>
            feather.replace();
        </script>
        <script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>