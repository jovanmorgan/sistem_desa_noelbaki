<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Login</title>
    <!-- Link untuk Font Awesome -->
    <link href="../Font-Awesome/css/all.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="../assets/img-umum/umum/logo.png" type="" />
    <link rel="stylesheet" href="../bootstrap/dist/css/bootstrap.min.css" type="" />
    <link rel="stylesheet" href="../assets/css/login.css?v=<?= time(); ?>">

</head>

<body>
    <div class="wrapper">
        <div class="text-center mb-2 name">
            SILAKAN LOGIN
        </div>
        <div class="logo">
            <img src="../assets/img-umum/umum/icon login.png" alt="">
        </div>

        <form class="p-3 mt-3" id="login">
            <div class="form-field d-flex align-items-center">
                <span class="far fa-user m-2"></span>
                <input type="text" name="username" id="userName" placeholder="Username">
            </div>
            <div class="form-field d-flex align-items-center">
                <span class="fas fa-key m-2"></span>
                <input type="password" name="password" id="password" placeholder="Password">
                <span class="fas fa-eye toggle-password m-3 text-secondary"
                    onclick="togglePasswordVisibility('password')" style="cursor: pointer;"></span>
            </div>

            <button type="submit" class="btn mt-3">Login</button>
        </form>
    </div>
    <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
    <script src="../assets/js/sweetalert2.all.min.js"></script>

    <script>
        function togglePasswordVisibility(inputId) {
            var passwordInput = document.getElementById(inputId);
            var passwordIcon = document.querySelector(".toggle-password");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                passwordIcon.classList.remove("fa-eye-slash");
                passwordIcon.classList.add("fa-eye");
            } else {
                passwordInput.type = "password";
                passwordIcon.classList.remove("fa-eye");
                passwordIcon.classList.add("fa-eye-slash");
            }
        }

        document.getElementById("login").addEventListener("submit", function(event) {
            event.preventDefault();

            var formData = new FormData(this);

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "../keamanan/proses_login", true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        var response = xhr.responseText;
                        var responseArray = response.split(':');
                        if (responseArray[0].trim() === "success") {
                            Swal.fire({
                                icon: 'success',
                                title: 'Login berhasil!',
                                text: 'Selamat datang ' + responseArray[1],
                                timer: 2000,
                                timerProgressBar: true,
                                didOpen: () => {
                                    Swal.showLoading()
                                }
                            }).then((result) => {
                                switch (responseArray[2].trim()) {
                                    case "admin":
                                        window.location.href = "../pengguna/admin/";
                                        break;
                                    case "rt":
                                        window.location.href = "../pengguna/rt/";
                                        break;
                                    case "pimpinan":
                                        window.location.href = "../pengguna/pimpinan/";
                                        break;
                                    default:
                                        window.location.href = "login";
                                        break;
                                }
                            });

                            if (rememberMe) {
                                var username = formData.get('username');
                                var password = formData.get('password');
                                document.cookie = "username=" + encodeURIComponent(
                                    username) + "; path=/";
                                document.cookie = "password=" + encodeURIComponent(password) + "; path=/";
                            }
                        } else if (responseArray[0].trim() === "error_password") {
                            Swal.fire("Error", "Password yang dimasukkan salah", "info");
                        } else if (responseArray[0].trim() === "error_username") {
                            Swal.fire("Error", "Username tidak ditemukan", "info");
                        } else if (responseArray[0].trim() === "username_tidak_ada") {
                            Swal.fire("Info", "Username belum diisi", "info");
                        } else if (responseArray[0].trim() === "password_tidak_ada") {
                            Swal.fire("Info", "Password belum diisi", "info");
                        } else if (responseArray[0].trim() === "tidak_ada_data") {
                            Swal.fire("Info", "Username dan Password belum diisi", "info");
                        } else {
                            Swal.fire("Error", "Terjadi kesalahan saat proses login", "error");
                        }
                    } else {
                        Swal.fire("Error", "Gagal", "error");
                    }
                }
            };
            xhr.onerror = function() {
                Swal.fire("Error", "Gagal melakukan request", "error");
            };
            xhr.send(formData);
        });
    </script>
</body>

</html>