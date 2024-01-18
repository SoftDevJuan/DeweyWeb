<?php
require_once 'conexion.php';

class Usuario {
    private $conn;

    public function __construct() {
        // Crea un objeto de la clase Conexion
        $conexion = new Conexion();

        // Obtiene la conexión
        $this->conn = $conexion->getConnection();
    }

    public function registrarUsuario($correo, $password, $nombre, $apellidos, $tipo_usuario, $nombre_area) {
        // Enviar los datos al procedimiento almacenado
        $stmt = $this->conn->prepare("CALL RegistrarDatos(?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $correo, $password, $nombre, $apellidos, $tipo_usuario, $nombre_area);
        $stmt->execute();
        $stmt->bind_result($message);
        $stmt->fetch();

        
        return $message;
        
    }

    public function obtenerUsuarioPorID($id_usuario) {
        // Enviar los datos al procedimiento almacenado
        $stmt = $this->conn->prepare("SELECT nombre, apellidos, correo FROM usuario WHERE id_user = ?");
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $stmt->bind_result($nombre, $apellidos, $correo);
        $stmt->fetch();
        $stmt->close();

        if ($nombre && $apellidos && $correo) {
            return array('nombre' => $nombre, 'apellidos' => $apellidos, 'correo' => $correo);
        } else {
            return false;
        }
    }


    public function iniciarSesion($correo, $contrasena) {
        // Enviar los datos al procedimiento almacenado
        $stmt = $this->conn->prepare("CALL IniciarSesion(?, ?)");
        $stmt->bind_param("ss", $correo, $contrasena);
        $stmt->execute();
        $stmt->bind_result($user_id);
        $stmt->fetch();
        $stmt->close();

        // Devolver el ID del usuario si existe, o un mensaje de error si no
        return $user_id ?? "Correo electrónico o contraseña incorrectos.";
    }

    // ...

    public function obtenerTipoUsuario($user_id) {
        // Obtener el tipo de usuario en base al ID del usuario
        $stmt = $this->conn->prepare("SELECT tipo_usuario FROM usuario WHERE id_user = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($tipo_usuario);
        $stmt->fetch();
        $stmt->close();

        return $tipo_usuario;
    }

    public function obtenerUsuarioPorIdMensaje($user_id) {
        // Obtener los datos completos del usuario por su ID
        $stmt = $this->conn->prepare("SELECT nombre, apellidos FROM usuario WHERE id_user = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($nombre, $apellidos);
        $stmt->fetch();
        $stmt->close();

        return array(
            'nombre' => $nombre,
            'apellidos' => $apellidos
        );
    }

    // ...






}//class

// Crear una instancia de la clase Usuario
/*$usuario = new Usuario();

// Datos del formulario para registrar usuario (simulación)
$correo = "ejemplo@correo.com";
$password = "contrasena123";
$nombre = "Juan";
$apellidos = "Gonzalez";
$tipo_usuario = "Empleado";
$nombre_area = "Área de Gerencia";

// Realizar el registro
$resultado = $usuario->registrarUsuario($correo, $password, $nombre, $apellidos, $tipo_usuario, $nombre_area);

if (is_numeric($resultado)) {
    echo "Registro exitoso. ID de usuario: " . $resultado;
} else {
    echo $resultado; // Mensaje de error
}

/* Crear una instancia de la clase Usuario
$usuario1 = new Usuario();

// Datos del formulario para registrar usuario (simulación)
$correo = "ejemplo16@correo.com";
$password = "contrasena123";
$nombre = "Juan";
$apellidos = "Gonzalez";
$tipo_usuario = "Empleado";
$nombre_area = "Desarrollo Backend";

// Realizar el registro
$resultado = $usuario->registrarUsuario($correo, $password, $nombre, $apellidos, $tipo_usuario, $nombre_area);

if (is_numeric($resultado)) {
    echo "Registro exitoso. ID de usuario: " . $resultado;
} else {
    
    echo "\n" . $resultado; // Mensaje de error
}*/

?>

