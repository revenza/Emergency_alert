<?php
session_start();
if (!isset($_SESSION["id"]) || !isset($_SESSION["username"])) {
    header("location: splash.php/index.php");
    exit();
}

include('db_conn.php');

$sql = "SELECT * FROM blogs ORDER BY created_at DESC LIMIT 5";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&family=Righteous&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style/style.css">
    <style>
        .card-body {
            max-height: 150px;
            overflow: hidden;
        }

        .card-text {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .carousel {
            margin-top: 56px;
        }
    </style>
</head>

<body>
    <!-- navbar -->
    <nav class="navbar navbar-expand-lg bg-success navbar-dark position-fixed top-0 w-100" style="z-index: 999;">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Emergency Alert</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="Home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="blog.php">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active text-dangger" aria-current="page" href="login/logout.php"> <i data-feather="log-out" style="color: tomato;"></i></a>
                    </li>
                </ul>
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-light" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- hero -->
    <div id="carouselExampleCaptions" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="uploads/3.jpg" class="d-block w-100" alt="Slide 1">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Bencana Alam</h5>
                    <p>This is a wider card with supporting text below as a natural lead-in to additional content.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="uploads/1.jpg" class="d-block w-100" alt="Slide 2">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Angka Pembunuhan yang kini semakin bertambah</h5>
                    <p>This is another card with supporting text below as a natural lead-in to additional content.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="uploads/2.jpg" class="d-block w-100" alt="Slide 3">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Kasus Pemerkosaan</h5>
                    <p>Banyaknya kasus pemerkosaan yang terjadi menyebabkan kebanyakan orang tidak tenang.</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <!-- Main Content -->
    <div class="container mt-5">
        <div class="row">
            <!-- Blog Section -->
            <div class="col-lg-8">
                <h2 class="mb-4">Latest Blogs</h2>
                <div class="blog" style="height: 500px; overflow: scroll;">
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <div class="card mb-3">
                            <a href="blog_detail.php?id=<?php echo $row['id']; ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $row['title']; ?></h5>
                                    <p class="card-text"><?php echo $row['content']; ?></p>
                                    <?php if ($row['image']): ?>
                                        <img src="<?php echo $row['image']; ?>" alt="Blog Image" class="img-fluid" style="max-height: 400px;">
                                    <?php endif; ?>
                                </div>
                            </a>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>

            <!-- Sidebar Section -->
            <div class="col-lg-4">
                <a href="create_blog.php" class="btn btn-success w-100 mb-4">Buat Blog</a>
                <a href="manage_blog.php" class="btn btn-primary w-100 mb-4">Manage Blog</a>
                <h3>Categories</h3>
                <ul class="list-group mb-4">
                    <li class="list-group-item">Bencana Alam</li>
                    <li class="list-group-item">Kriminal</li>
                </ul>
                <h3>Popular Blogs</h3>
                <ul class="list-group">
                    <li class="list-group-item">Pembunuh Berantai</li>
                    <li class="list-group-item">Pelaku Pencabulan Dihukum Mati</li>
                    <li class="list-group-item">Pemuda Diduga menjadi Korban begal</li>
                </ul>
            </div>

        </div>
    </div>

    </div>

    <script src="https://unpkg.com/feather-icons"></script>
    <script>
        feather.replace();
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

</body>

</html>