<?php
require_once 'php/conectionDB.php';
require_once 'php/returnUser.php';

session_start();

// Verifique se o token anti-CSRF é válido
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['token']) && $_POST['token'] === $_SESSION['token']) {
    if (isset($_POST['email']) && isset($_POST['senha'])) {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['senha']);
        error_log("Tentativa de login recebida. Email: " . $email);
        $user = fetchUser($conn, $email, $password);

        if ($user) {
            $_SESSION['login_user'] = $email;
            header("location: https://www.nrconexoes.com.br/");
            exit;
        } else {
            $error = "Seu nome de usuário ou senha está incorreto";
            error_log("Falha na autenticação. " . $error);
        }
    }
} else {
    // Gerar um novo token anti-CSRF
    $_SESSION['token'] = bin2hex(random_bytes(32));
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    
    <title>Document</title>
</head>

<body>
<form method="POST">
    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
    <div class="container py-5">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="card border-0 shadow">
                    <div class="card-body p-5 d-flex flex-column align-items-center">
                        <h3 class="card-title text-center mb-4">Acesse sua conta</h3>
                            <div class="mb-4 position-relative">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp" style="max-width: 300px;">
                                <i class="fas fa-envelope position-absolute icon-input"></i>
                            </div>
                            <div class="mb-4 position-relative">
                                <label for="senha" class="form-label">Senha</label>
                                <input type="password" name="senha" class="form-control" id="senha" style="max-width: 300px;">
                                <i class="fas fa-lock position-absolute icon-input" id="togglePassword"></i>
                            </div>
                        <div class="mb-4 form-check text-center">
                            <input type="checkbox" class="form-check-input" id="lembrar">
                            <label class="form-check-label" for="lembrar">Lembrar de mim</label>
                        </div>
                        <button type="submit" class="btn btn-primary py-2" style="width: auto;">Entrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>


    <!-- Bootstrap JS -->
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>
