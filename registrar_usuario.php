<?php
// Verifica si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Incluye el archivo que contiene la clase de Usuario
    require_once 'usuario.php';

    // Obtiene los datos del formulario
    $nombre = $_POST['name'];
    $apellidos = $_POST['last-name'];
    $puesto = $_POST['spot'];
    $organizacion = $_POST['group'];
    $correo = $_POST['email'];
    $contrasena = $_POST['password'];
    $confirmacion_contrasena = $_POST['password-confirmation'];

    // Realiza algunas validaciones adicionales si es necesario
    // Por ejemplo, verifica que la contraseña y la confirmación coincidan

    if ($contrasena !== $confirmacion_contrasena) {
        $mensaje = "Las contraseñas no coinciden.";
    } else {
        // Crea una instancia de la clase Usuario
        $usuario = new Usuario();

        // Intenta registrar el usuario en la base de datos
        $resultado = $usuario->registrarUsuario($correo, $contrasena, $nombre, $apellidos, $puesto, $organizacion);

        if (is_int($resultado)) {
            $mensaje = "Se registro con exito, nuevo usuario con ID: " . $resultado;
        }
    }

    // Vuelve a la página signup.html con el mensaje de éxito o error
    header("Location: signup.html?mensaje=" . urlencode($mensaje));
    exit;
}
?>
