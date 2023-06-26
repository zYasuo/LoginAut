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
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <title>Document</title>
</head>
<body class="bg-light">
    <form method="POST">
    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
        <div class="container py-5">
            <div class="row justify-content-center align-items-center min-vh-100">
                <div class="col-12 col-md-8 col-lg-6">
                    <div class="card border-0 shadow">
                        <div class="card-body p-5">
                            <h3 class="card-title text-center mb-4">Acesse sua conta</h3>
                            <div class="mb-4">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp">
                            </div>
                            <div class="mb-4">
                                <label for="senha" class="form-label">Senha</label>
                                <input type="password" name="senha" class="form-control" id="senha">
                            </div>
                            <div class="mb-4 form-check">
                                <input type="checkbox" class="form-check-input" id="lembrar">
                                <label class="form-check-label" for="lembrar">Lembrar de mim</label>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 py-2">Entrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- Bootstrap JS -->
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
