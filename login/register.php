<?php
session_start();
include "../db_conn.php";

$registerSuccess = false;
$registerError = false;

if (isset($_POST["create_account"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "INSERT INTO users(username, password) VALUES ('$username','$password')";

    if ($conn->query($sql)) {
        $registerSuccess = true;
    } else {
        $registerError = true;
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Emergency Alert</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
            <h2>REGISTER</h2>
            <p>Create your account.</p>
        </div>
    </div>
    <div class="main">
        <div class="col-md-6 col-sm-12">
            <div class="login-form">
                <form action="register.php" method="post">
                    <div class="form-group">
                        <label>Create Username</label>
                        <input type="text" name="username" class="form-control" placeholder="User Name" required>
                    </div>
                    <div class="form-group">
                        <label>Create Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                    </div>
                    <button type="submit" name="create_account" value="create_account" class="btn btn-black mt-2">Create Account</button>
                    <a href="login.php" class="btn btn-secondary mt-1">back</a>

            </div>
        </div>
    </div>


    <!-- Modal YANG BERHASIL -->
    <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Success</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Registration successful!
                </div>
                <div class="modal-footer">
                    <a href="../home.php" class="btn btn-primary">Go to Login</a>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL KALO NAMA DAN PASSWORD SUDAH ADA -->
    <div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="errorModalLabel">Error</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Username or password is already in use.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- BIAR MODAL NYA MUNCUL -->
    <script>
        <?php if ($registerSuccess): ?>
            var successModal = new bootstrap.Modal(document.getElementById('successModal'));
            successModal.show();
        <?php elseif ($registerError): ?>
            var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
            errorModal.show();
        <?php endif; ?>
    </script>
</body>

</html>