<?php
session_start();
include '../koneksi.php';

if (isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM admin 
    WHERE username='$username'
    AND password='$password'");

    $cek = mysqli_num_rows($query);

    if ($cek > 0) {

        $_SESSION['login'] = true;

        header("Location: dashboard.php");
        exit;

    } else {
        echo "
        <script>
            alert('Username atau Password Salah')
        </script>
        ";
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        
    <title>Login Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>

        body{
            background: #f4f7fe;
            font-family: Poppins;
        }

        .login-box{
            width: 400px;
            background: white;
            padding: 40px;
            border-radius: 15px;
            margin: 100px auto;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }

        .btn-login{
            background: #1e3a8a;
            color: white;
            width: 100%;
            border: none;
            padding: 12px;
            border-radius: 10px;
        }

        .btn-login:hover{
            background: #162d69;
        }

    </style>
    </head>

    <body>
            <div class="login-box">
                <h3 class="text-center mb-4">
                    Login Admin
                </h3>

                <form method="POST">
                    <div class="mb-3">

                        <label>UserName</label>

                        <input type="text"
                        name="username"
                        class="form-control"
                        required>

                    </div>
                    <div class="mb-3">
                        <label>Password</label>

                    
                        <input type="password"
                        name="password"
                        class="form-control"
                        required>
                    </div>

                    <button type="submit"
                    name="login"
                    class="btn-login">
                
                        Login

                </button>
                </form>
            </div>
    </body>
</html>