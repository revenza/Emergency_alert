<?php
session_start();
if (!isset($_SESSION["id"]) || $_SESSION["id"] != 14) {
    header("location: splash.php");
    exit();
}

include('db_conn.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete'])) {
        $user_id = $_POST['user_id'];
        $sql = "DELETE FROM users WHERE id = '$user_id'";
        if (mysqli_query($conn, $sql)) {
            header("location: admin.php");
            exit();
        } else {
            echo "Error deleting record: " . mysqli_error($conn);
        }
    } elseif (isset($_POST['edit'])) {
        $user_id = $_POST['user_id'];
        $username = $_POST['username'];

        $sql = "UPDATE users SET username = '$username' WHERE id = '$user_id'";
        if (mysqli_query($conn, $sql)) {
            header("location: admin.php");
            exit();
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
    } elseif (isset($_POST['create'])) {
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (username,  password) VALUES ('$username','$password')";
        if (mysqli_query($conn, $sql)) {
            header("location: admin.php");
            exit();
        } else {
            echo "Error creating record: " . mysqli_error($conn);
        }
    }
}

$sql = "SELECT * FROM users";
$result = $conn->query($sql);

function cari($keyword)
{
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM users WHERE username LIKE ?");
    $like_keyword = "%" . $keyword . "%";
    $stmt->bind_param("s", $like_keyword);
    $stmt->execute();

    return $stmt->get_result();
}

if (isset($_POST['cari'])) {
    $keyword = $_POST['keyword'];
    $result = cari($keyword);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="style/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
                        <a class="nav-link" aria-current="page" href="home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="blog.php">Blog</a>
                    </li>
                    <?php if ($_SESSION["id"] == 14): ?>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="admin.php">Admin</a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link active text-danger" aria-current="page" href="login/logout.php"> <i data-feather="log-out" style="color: tomato;"></i></a>
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
        <h2>Manage Users</h2>
        <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#createUserModal">Create User</button>
        <div class="user-list">
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row['username']; ?></h5>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editUserModal<?php echo $row['id']; ?>">Edit</button>
                        <form action="admin.php" method="post" class="d-inline">
                            <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                            <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>

                <!-- Edit User Modal -->
                <div class="modal fade" id="editUserModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="admin.php" method="post">
                                    <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="username" name="username" value="<?php echo $row['username']; ?>" required>
                                    </div>
                                    <button type="submit" name="edit" class="btn btn-primary">Save changes</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <!-- Create User Modal -->
    <div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createUserModalLabel">Create User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="admin.php" method="post">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" name="create" class="btn btn-success">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/feather-icons"></script>
    <script>
        feather.replace();
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>

</html>