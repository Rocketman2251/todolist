<?php
include("conexion.php");

// Obtener tareas
$sql = "SELECT * FROM tareas";
$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <link rel="stylesheet" href="styles.css"> <!-- Enlace al archivo CSS -->
    <script>
        // Función para mostrar el mensaje flotante
        function mostrarMensaje(mensaje) {
            const mensajeFlotante = document.getElementById('mensaje-flotante');
            mensajeFlotante.innerText = mensaje;
            mensajeFlotante.style.display = 'block';

            // Ocultar después de 3 segundos
            setTimeout(() => {
                mensajeFlotante.style.display = 'none';
            }, 3000);
        }

        // Función para eliminar una tarea usando AJAX
        function mostrarMensaje(mensaje) {
    const mensajeFlotante = document.getElementById('mensaje-flotante');
    mensajeFlotante.innerText = mensaje;
    mensajeFlotante.style.display = 'block';

    // Ocultar después de 3 segundos
            setTimeout(() => {
                mensajeFlotante.style.display = 'none';
            }, 3000);
        }

        function eliminarTarea(id) {
            if (confirm('¿Estás seguro de que deseas eliminar esta tarea?')) {
                fetch('eliminar.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `id=${id}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        mostrarMensaje(data.message);
                        // Eliminar la fila de la tabla
                        document.getElementById(`tarea-${id}`).remove();
                    } else {
                        mostrarMensaje(data.message);
                    }
                })
                .catch(() => {
                    mostrarMensaje("Error en la conexión.");
                });
            }
        }

    </script>
</head>
<body>
    <h1>To-Do List</h1>

    <!-- Formulario para agregar tareas -->
    <form action="agregar.php" method="POST">
        <input type="text" name="tarea" placeholder="Nueva tarea" required>
        <button type="submit" class="action-button">Agregar</button>
    </form>

    <!-- Tabla para mostrar las tareas -->
    <table>
        <thead>
            <tr>
                <th>Tarea</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($fila = $resultado->fetch_assoc()): ?>
                <tr id="tarea-<?php echo $fila['id']; ?>">
                    <td><?php echo htmlspecialchars($fila['tarea']); ?></td>
                    <td>
                        <?php if (!$fila['completado']): ?>
                            <a href="completar.php?id=<?php echo $fila['id']; ?>" class="action-button complete-button">Completar</a>
                        <?php else: ?>
                            <span class="completada">Completada</span>
                        <?php endif; ?>
                        <a href="#" class="action-button delete-button" onclick="eliminarTarea(<?php echo $fila['id']; ?>)">Eliminar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Mensaje flotante -->
    <div id="mensaje-flotante"></div>
</body>
</html>
