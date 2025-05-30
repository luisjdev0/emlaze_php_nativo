<?php
$title = 'Iniciar Sesión';

include 'templates/template.php';

if (isset($_POST['email'], $_POST['pwd'])) {
    $email = $_POST['email'];
    $password = hash('sha256', $_POST['pwd']);

    // Verificar si el usuario existe
    $query = "SELECT * FROM users WHERE email = :email AND password = :password";
    $params = [
        ':email' => $email,
        ':password' => $password
    ];
    $user = pdo_execute_query($query, $params);

    if (empty($user)) {
        $error = 'Usuario o contraseña incorrectos';
    } else {
        $_SESSION = $user[0];
        header('Location: /index.php');
        exit();
    }
}

session_destroy();

?>

<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card p-4 shadow" style="width: 100%; max-width: 400px;">
            <h2 class="text-center mb-4">Iniciar Sesión</h2>
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">Correo electrónico</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="nombre@ejemplo.com" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" name="pwd" id="pwd" placeholder="Contraseña" required>
                </div>
                <button type="submit" class="btn btn-primary w-100 mt-3">Entrar</button>
            </form>
            <?php if (isset($error)) { ?>
                <div class="alert alert-danger mt-3 text-center" role="alert">Usuario o contraseña incorrectos</div>
            <?php } ?>
        </div>
    </div>
</body>

</html>