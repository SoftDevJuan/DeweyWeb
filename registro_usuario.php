<?php
if (isset($_POST['correo'], $_POST['password'], $_POST['nombre'], $_POST['apellidos'], $_POST['tipo_usuario'], $_POST['nombre_area'])) {
    require_once 'Usuario.php'; // Asegúrate de que el archivo Usuario.php tenga la clase Usuario definida

    $usuario = new Usuario();

    $correo = $_POST['correo'];
    $password = $_POST['password'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $tipo_usuario = $_POST['tipo_usuario'];
    $nombre_area = $_POST['nombre_area'];

    $resultado = $usuario->registrarUsuario($correo, $password, $nombre, $apellidos, $tipo_usuario, $nombre_area);

    if (is_numeric($resultado)) {
        echo "Registro exitoso. ID de usuario: " . $resultado;
    } else {
        echo $resultado; // Mensaje de error
    }
}
?>
