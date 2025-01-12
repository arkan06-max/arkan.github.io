<?php
// Memulai atau melanjutkan session yang sudah ada
session_start();

// Menyertakan file koneksi database
include "koneksi.php";

// Cek jika user sudah login, arahkan ke halaman admin
if (isset($_SESSION['username'])) { 
    header("location:admin.php"); 
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['user'];
    $password = md5($_POST['pass']); // Enkripsi MD5

    // Prepared statement untuk query login
    $stmt = $conn->prepare("SELECT username FROM user WHERE username=? AND password=?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $hasil = $stmt->get_result();

    // Jika user ditemukan
    if ($hasil->num_rows > 0) {
        $row = $hasil->fetch_assoc();
        $_SESSION['username'] = $row['username']; // Set session username
        header("location:admin.php");
        exit;
    } else {
        // Login gagal
        echo "<script>alert('Username atau Password salah!');</script>";
    }

    // Tutup koneksi database
    $stmt->close();
    $conn->close();
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login MyDailyJourney</title>
    <link rel="icon" href="img/logoWI.png" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
</head>
<body class="bg-danger-subtle">
    <div class="container mt-4 pt-2 ">
        <div class="row justify-content-center align-items-center vh-100">
            <div class="col-12 col-sm-8 col-md-6 m-auto">
                <div class="card login-card rounded-4">
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <i class="bi bi-person-circle h1 text-primary"></i>
                            <h4 class="mt-3">My Daily Life</h4>
                            <p class="text-muted">Login to your account</p>
                            <hr />
                        </div>
                        <form action="" method="post">
                            <div class="mb-3">
                                <input type="text" name="user" class="form-control rounded-4" placeholder="Username" required />
                            </div>
                            <div class="mb-4">
                                <input type="password" name="pass" class="form-control rounded-4" placeholder="Password" required />
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-danger rounded-4">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="text-center mt-3">
                    <p class="text-muted">© 2024 Muhammad Arkan Yumna</p>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

<?php
//set variable username dan password dummy
$username = "admin";
$password = "123456";

//check apakah ada request dengan method POST yang dilakukan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
//tampilkan isi dari variable array POST menggunakan perulangan
    foreach($_POST as $key => $val){
        echo $key . " : " . $val ."<br>";
    } 

//check apakah username dan password yang di POST sama dengan data dummy
    if($_POST['user'] == $username AND $_POST['passw'] == $password){
        echo "Username dan Password Benar";
    }else{
        echo "Username dan Password Salah";
    }
};
?>
