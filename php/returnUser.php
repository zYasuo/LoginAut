<?php
function fetchUser($conn, $email, $password) {
    // cria o hash da senha inserida pelo usuário
    $password = hash('sha256', $password);

    $query = "SELECT id, senha FROM usuarios WHERE email = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        // Compara a senha inserida pelo usuário com a senha do banco de dados
        if($password === $user['senha']) {
            return $user;
        }
    }

    return false;
}