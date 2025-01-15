<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("location: splash.php");
    exit();
}

include('db_conn.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete'])) {
        $blog_id = $_POST['blog_id'];
        $sql = "DELETE FROM blogs WHERE id = '$blog_id' AND user_id = '$_SESSION[id]'";
        if (mysqli_query($conn, $sql)) {
            header("location: manage_blog.php");
            exit();
        } else {
            echo "Error deleting record: " . mysqli_error($conn);
        }
    } elseif (isset($_POST['edit'])) {
        $blog_id = $_POST['blog_id'];
        $title = $_POST['title'];
        $content = $_POST['content'];

        $sql = "UPDATE blogs SET title = '$title', content = '$content' WHERE id = '$blog_id' AND user_id = '$_SESSION[id]'";
        if (mysqli_query($conn, $sql)) {
            header("location: manage_blog.php");
            exit();
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
    }
}

$sql = "SELECT * FROM blogs WHERE user_id = '$_SESSION[id]' ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Blogs</title>
    <link rel="stylesheet" href="style/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
                        <a class="nav-link" aria-current="page" href="home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="blog.php">Blog</a>
                    </li>
                    <?php if ($_SESSION["id"] == 14): ?>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="admin.php">Admin</a>
                        </li>
                    <?php endif; ?>
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

    <div class="container mt-5">
        <h2>Manage Your Blogs</h2>
        <div class="blog-list">
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row['title']; ?></h5>
                        <p class="card-text"><?php echo $row['content']; ?></p>
                        <?php if ($row['image']): ?>
                            <img src="<?php echo $row['image']; ?>" alt="Blog Image" class="img-fluid" style="max-height: 400px;">
                        <?php endif; ?>
                        <form action="manage_blog.php" method="post" class="mt-3">
                            <input type="hidden" name="blog_id" value="<?php echo $row['id']; ?>">
                            <div class="mb-3">
                                <label for="title" class="form-label">Edit Title</label>
                                <input type="text" class="form-control" id="title" name="title" value="<?php echo $row['title']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="content" class="form-label">Edit Content</label>
                                <textarea class="form-control" id="content" name="content" rows="5" required><?php echo $row['content']; ?></textarea>
                            </div>
                            <a href="blog.php"><button type="submit" name="edit" class="btn btn-primary">Edit</button></a>
                            <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            <?php endwhile; ?>
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