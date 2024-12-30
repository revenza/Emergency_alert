<?php
session_start();
include "../db_conn.php";

if (isset($_POST["username"]) && isset($_POST["password"])) {

    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $username = validate($_POST["username"]);
    $password = validate($_POST["password"]);

    if (empty($username)) {
        $error = "Username is required";
    } elseif (empty($password)) {
        $error = "Password is required";
    } else {
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();

            if (password_verify($password, $row['password'])) {
                $_SESSION['username'] = $row['username'];
                $_SESSION['name'] = $row['name'];
                $_SESSION['id'] = $row['id'];
                header("Location: ../home.php");
                exit;
            } else {
                $error = "Incorrect username or password";
            }
        } else {
            $error = "Incorrect username or password";
        }

        $stmt->close();
    }
}
?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Emergency Alert</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: "Lato", sans-serif;
        }

        .main-head {
            height: 150px;
            background: #fff;
        }

        .sidenav {
            height: 100%;
            background-color: #4CAF50;
            overflow-x: hidden;
            padding-top: 20px;
        }

        .main {
            padding: 0px 10px;
            animation: fadeIn 0.5s ease-out;

        }

        @media screen and (max-height: 450px) {
            .sidenav {
                padding-top: 15px;
            }
        }

        @media screen and (max-width: 450px) {
            .login-form {
                margin-top: 10%;
            }

            .register-form {
                margin-top: 10%;
            }
        }

        @media screen and (min-width: 768px) {
            .main {
                margin-left: 40%;
            }

            .sidenav {
                width: 40%;
                position: fixed;
                z-index: 1;
                top: 0;
                left: 0;
            }

            .login-form {
                margin-top: 80%;
            }

            .register-form {
                margin-top: 20%;
            }
        }

        .login-main-text {
            margin-top: 20%;
            padding: 60px;
            color: #fff;
            animation: fadeIn 1.5s ease-out;
        }


        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .login-main-text h2 {
            font-size: 3rem;
            font-weight: 900;
        }

        .btn-black {
            background-color: #4CAF50 !important;
            color: #fff;
        }
    </style>
</head>

<body>
    <div class="sidenav">
        <div class="login-main-text">
            <h2>LOGIN</h2>
            <p>Login or register from here to access.</p>
        </div>
    </div>

    <div class="main">
        <div class="col-md-6 col-sm-12">
            <div class="login-form">
                <form action="login.php" method="post">
                    <div class="form-group">
                        <label>User Name</label>
                        <input type="text" name="username" class="form-control" placeholder="User Name">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Password">
                    </div>
                    <button type="submit" class="btn btn-black">Login</button>
                    <a href="register.php" class="btn btn-secondary">Register</a>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal-->
    <div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="errorModalLabel">Login Error</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?= htmlspecialchars($error); ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- ngetriger modal -->
    <script>
        <?php if (isset($error)): ?>
            var errorModal = new bootstrap.Modal(document.getElementById('errorModal'), {
                backdrop: 'static',
                keyboard: false
            });
            errorModal.show();
        <?php endif; ?>
    </script>
</body>

</html>