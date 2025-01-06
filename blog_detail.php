<?php
session_start();
if (!isset($_SESSION["id"]) || !isset($_SESSION["username"])) {
    header("location: splash.php/index.php");
    exit();
}

include('db_conn.php');

$blog_id = $_GET['id'];

$sql = "SELECT * FROM blogs WHERE id = $blog_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "Blog not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $row['title']; ?> - Blog Detail</title>
    <link rel="stylesheet" href="style/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <!-- navbar -->
    <nav class="navbar navbar-expand-lg bg-success navbar-dark position-fixed top-0 w-100 mb-5" style="z-index: 999;">
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

    <!-- Blog Detail Section -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-8">
                <h2><?php echo $row['title']; ?></h2>
                <p><strong>Created At:</strong> <?php echo $row['created_at']; ?></p>
                <?php if ($row['image']): ?>
                    <img src="<?php echo $row['image']; ?>" alt="Blog Image" class="img-fluid mb-4">
                <?php endif; ?>
                <p><?php echo nl2br($row['content']); ?></p>
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