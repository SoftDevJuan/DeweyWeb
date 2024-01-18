<?php
// Verifica si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Incluye el archivo que contiene la clase de Usuario
    require_once 'usuario.php';

    // Obtiene los datos del formulario
    $correo = $_POST['email'];
    $contrasena = $_POST['password'];

    // Crea una instancia de la clase Usuario
    $usuario = new Usuario();

    // Intenta iniciar sesión en la base de datos
    $resultado = $usuario->iniciarSesion($correo, $contrasena);

    if (is_numeric($resultado)) {
        // Autenticación exitosa. Redirecciona según el tipo de usuario
        $tipo_usuario = $usuario->obtenerTipoUsuario($resultado);

        if ($tipo_usuario === 'Gerente') {
            $usuario_data = $usuario->obtenerUsuarioPorIdMensaje($resultado);
            $nombre_completo = $usuario_data['nombre'] . ' ' . $usuario_data['apellidos'];
            $mensaje = "Bienvenid@ Gerente " . $nombre_completo . ".";
            
            header("Location: home-admin.html?mensaje=" . urldecode($mensaje));
            exit;
        } else {
            // Obtenemos el nombre y apellidos del usuario para mostrarlo en el mensaje de bienvenida
            $usuario_data = $usuario->obtenerUsuarioPorIdMensaje($resultado);
            $nombre_completo = $usuario_data['nombre'] . ' ' . $usuario_data['apellidos'];
            $mensaje = "Bienvenid@ " . $nombre_completo . ".";
            header("Location: home.html?mensaje=" . urldecode($mensaje));
            exit;
        }
    } else {
        // Hubo un error en la autenticación. Mostrar el mensaje de error en login.html.
        $mensaje = $resultado;
        header("Location: login.html?mensaje=" . urlencode($mensaje));
        exit;
    }
}

?>
