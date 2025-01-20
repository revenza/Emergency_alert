<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("location: splash.php");
    exit();
}

include('db_conn.php');

$title = $content = $image = "";
$title_err = $content_err = $image_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];

    if (empty($title)) {
        $title_err = "Please enter a title.";
    }

    if (empty($content)) {
        $content_err = "Please enter content.";
    }

    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        $imageName = $_FILES["image"]["name"];
        $imageTmpName = $_FILES["image"]["tmp_name"];
        $imageType = $_FILES["image"]["type"];
        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        if (!in_array($imageType, $allowedTypes)) {
            $image_err = "Only JPG, JPEG, and PNG files are allowed.";
        } else {
            $image = "uploads/" . basename($imageName);
            if (!move_uploaded_file($imageTmpName, $image)) {
                $image_err = "Failed to upload image. Please try again.";
            }
        }
    } else {
        $image_err = "Please upload an image.";
    }

    if (empty($title_err) && empty($content_err) && empty($image_err)) {
        $title = mysqli_real_escape_string($conn, $title);
        $content = mysqli_real_escape_string($conn, $content);
        $image = mysqli_real_escape_string($conn, $image);

        $sql = "INSERT INTO blogs (title, content, user_id, image) VALUES ('$title', '$content', '$_SESSION[id]', '$image')";
        if (mysqli_query($conn, $sql)) {
            header("location: blog.php");
            exit();
        } else {
            echo "Something went wrong. Please try again later.";
            echo "Error: " . mysqli_error($conn);
        }
    }

    mysqli_close($conn);
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Blog</title>
    <link rel="stylesheet" href="style/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
        <h2>Create a New Blog</h2>
        <form action="create_blog.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="title" class="form-label">Blog Title</label>
                <input type="text" class="form-control <?php echo (!empty($title_err)) ? 'is-invalid' : ''; ?>" id="title" name="title" value="<?php echo $title; ?>" required>
                <div class="invalid-feedback"><?php echo $title_err; ?></div>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Blog Content</label>
                <textarea class="form-control <?php echo (!empty($content_err)) ? 'is-invalid' : ''; ?>" id="content" name="content" rows="5" required><?php echo $content; ?></textarea>
                <div class="invalid-feedback"><?php echo $content_err; ?></div>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Upload Image</label>
                <input type="file" class="form-control <?php echo (!empty($image_err)) ? 'is-invalid' : ''; ?>" id="image" name="image" accept="image/*">
                <div class="invalid-feedback"><?php echo $image_err; ?></div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>


    <script src="https://unpkg.com/feather-icons"></script>
    <script>
        feather.replace();
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>

</html>