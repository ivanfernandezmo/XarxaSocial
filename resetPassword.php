<?php
session_start();
require_once('connecta_db.php'); // Connexió a la BD

if (isset($_GET['code']) && isset($_GET['email'])&& $_SERVER['REQUEST_METHOD'] == 'GET') {
    $code = $_GET['code'];
    $email = $_GET['email'];
    $_SESSION['email'] = $email;
    $_SESSION['code'] = $code;

    // Comprovar si el token és vàlid i no ha expirat
    $stmt = $db->prepare("SELECT resetPassExpiry FROM usuario WHERE mail = ? AND resetPassCode = ?");
    $stmt->execute([$email, $code]);
    
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    $_SESSION['data'] = $data['resetPassExpiry'];
}

    // Si s'envia el formulari
    if (strtotime($_SESSION['data']) > time() && $_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = $_SESSION['email'];
        $password = $_POST['new_password'];
        $confirmPassword = $_POST['confirm_password'];

        if ($password !== $confirmPassword) {
            $error_message = "Les contrasenyes no coincideixen.";
        } elseif (strlen($password) < 6) {
            $error_message = "La contrasenya ha de tenir almenys 6 caràcters.";
        } else {
            // Hash de la nova contrasenya
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
            // Actualitzar la contrasenya a la BD i eliminar el token
            $stmt = $db->prepare("UPDATE usuario SET passHash = ?, resetPassCode = NULL, resetPassExpiry = NULL WHERE mail = ?");
            $stmt->execute([$hashedPassword, $email]);
        
            // Enviar Correu
            header("Location: ./mailing/mailCanviPassword.php");
            exit();
        }
    }

    


?>

<?php if (isset($error_message)): ?>
    <script>
        window.onload = function() {
            showErrorPopup("<?php echo $error_message; ?>");
        }
    </script>
<?php endif; ?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablir Contrasenya</title>
    <script>
    function showErrorPopup(message) {
        let errorModal = document.createElement("div");
        errorModal.innerHTML = `
            <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title text-danger" id="errorModalLabel">Error</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            ${message}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tancar</button>
                        </div>
                    </div>
                </div>
            </div>
        `;

        document.body.appendChild(errorModal);
        var modal = new bootstrap.Modal(document.getElementById("errorModal"));
        modal.show();
    }
</script>

<!--  ¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡ AREGLAR EL POP-UP !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        /* Estilos generales */
        html, body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            background-image: url('imatges/mountain-and-sunset-sky-landscape-vector.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        /* Contenedor del formulario */
        .reset-container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        /* Imagen */
        .reset-image {
            display: block;
            margin: 0 auto;
            max-width: 100%;
            height: auto;
        }

        /* Título */
        h2 {
            color: #5b3a88;
            margin-bottom: 20px;
            font-size: 1.5em;
        }

        /* Campos del formulario */
        .form-input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        /* Botón */
        .reset-btn {
            width: 100%;
            padding: 10px;
            background: linear-gradient(to right, #ff758c, #ff7eb3);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: 0.3s ease;
        }

        .reset-btn:hover {
            background: linear-gradient(to right, #ff99ac, #ffb3c6);
        }

        /* Enlace */
        .back-link {
            display: block;
            margin-top: 10px;
            font-size: 14px;
            color: #007bff;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }


    </style>
</head>
<body>
    
    <div class="reset-container">
        <h2>Restablir la contrasenya</h2>
        <img src="logos/sinfondo.png" alt="Imagen de inicio" class="reset-image">
        <form action="resetPassword.php" method="POST">
            <label for="new-password">Nova contrasenya:</label>
            <input type="password" id="new-password" name="new_password" class="form-input" required>
            
            <label for="confirm-password">Confirmar contrasenya:</label>
            <input type="password" id="confirm-password" name="confirm_password" class="form-input" required>

            <button type="submit" class="reset-btn">Canviar contrasenya</button>
        </form>

        <a href="index.php" class="back-link">Tornar a l'inici</a>
    </div>

</body>
</html>
