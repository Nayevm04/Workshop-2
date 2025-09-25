<?php

// Conexión a la Base de Datos

$servidor   = "localhost";
$usuarioDB  = "root";
$claveDB    = "";
$nombreDB   = "registro";
$conexion = new mysqli($servidor, $usuarioDB, $claveDB, $nombreDB);

if ($conexion->connect_error) {
    die("❌ Error de conexión: " . $conexion->connect_error);
}

$conexion->set_charset("utf8");




// Procesar formulario
$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre   = trim($_POST['nombre']);
    $apellido = trim($_POST['apellido']);
    $correo   = trim($_POST['correo']);
    $telefono = trim($_POST['telefono']);

    // Preparar consulta SQL
    $sql = "INSERT INTO personas (nombre, apellido, correo, telefono) VALUES (?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ssss", $nombre, $apellido, $correo, $telefono);

    if ($stmt->execute()) {
        $mensaje = "✅ Registro guardado correctamente.";
    } else {
        $mensaje = "❌ Error al guardar: " . $stmt->error;
    }

    $stmt->close();
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Personas</title>
    <link rel="stylesheet" href="estilos.css?v=2.0">
</head>
<body>
    <div class="form-container">
        <h1 class="form-title">Registro de Personas</h1>

        <?php if (!empty($mensaje)): ?>
            <p class="<?= strpos($mensaje, '✅') !== false ? 'success' : 'error' ?>">
                <?= $mensaje ?>
            </p>
        <?php endif; ?>

        <form action="" method="post">
            <div class="input-group">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>

            <div class="input-group">
                <label for="apellido">Apellido</label>
                <input type="text" id="apellido" name="apellido" required>
            </div>

            <div class="input-group">
                <label for="correo">Correo Electrónico</label>
                <input type="email" id="correo" name="correo" required>
            </div>

            <div class="input-group">
                <label for="telefono">Teléfono</label>
                <input type="tel" id="telefono" name="telefono" required>
            </div>

            <div class="separator"></div>
            <button type="submit" class="btn-submit">Guardar</button>
        </form>
    </div>
</body>
</html>
