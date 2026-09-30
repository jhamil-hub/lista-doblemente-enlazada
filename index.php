<?php
require_once 'conexion.php';
require_once 'Nodo.php';
require_once 'Producto.php';
require_once 'ListaDoble.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'] ?? '';
    $mensaje = '';
    try {
        if ($accion === 'agregar') {
            $nombre = trim($_POST['nombre'] ?? '');
            $precio = (float) ($_POST['precio'] ?? 0);
            $stock  = (int) ($_POST['stock'] ?? 0);

            if ($nombre === '' || $precio < 0 || $stock < 0) {
                $mensaje = 'Datos inválidos.';
            } else {
                $stmt = $conexion->prepare("INSERT INTO productos (nombre, precio, stock) VALUES (?, ?, ?)");
                $stmt->bind_param("sdi", $nombre, $precio, $stock);
                $stmt->execute();
                $stmt->close();
                $mensaje = 'Producto agregado.';
            }
        } elseif ($accion === 'eliminar') {
            $id = (int) ($_POST['id'] ?? 0);
            $stmt = $conexion->prepare("DELETE FROM productos WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->close();
            $mensaje = 'Producto eliminado.';
        }
    } catch (mysqli_sql_exception $e) {
        $mensaje = 'Error: ' . $e->getMessage();
    }
    header("Location: index.php?msg=" . urlencode($mensaje));
    exit;
}


$lista = new ListaDoble();
$resultado = $conexion->query("SELECT id, nombre, precio, stock FROM productos ORDER BY id");
while ($fila = $resultado->fetch_assoc()) {
    $lista->insertarFinal(new Producto($fila['id'], $fila['nombre'], $fila['precio'], $fila['stock']));
}

$encontrado = null;
$buscado = isset($_GET['buscar']) && $_GET['buscar'] !== '' ? (int) $_GET['buscar'] : null;
if ($buscado !== null) {
    $encontrado = $lista->buscarPorId($buscado);
}

function tabla(array $productos, bool $conEliminar = false)
{
    if (empty($productos)) {
        echo "<p>No hay productos.</p>";
        return;
    }
    echo "<table><tr><th>ID</th><th>Nombre</th><th>Precio</th><th>Stock</th>" . ($conEliminar ? "<th></th>" : "") . "</tr>";
    foreach ($productos as $p) {
        echo "<tr><td>{$p->getId()}</td><td>" . htmlspecialchars($p->getNombre()) . "</td>";
        echo "<td>" . number_format($p->getPrecio(), 2) . "</td><td>{$p->getStock()}</td>";
        if ($conEliminar) {
            echo "<td><form method='post'><input type='hidden' name='accion' value='eliminar'>
                  <input type='hidden' name='id' value='{$p->getId()}'><button>Eliminar</button></form></td>";
        }
        echo "</tr>";
    }
    echo "</table>";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Productos - Lista Doblemente Enlazada</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 30px auto; padding: 0 15px; }
        table { border-collapse: collapse; width: 100%; margin-bottom: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background: #f0f0f0; }
        form.inline input { margin-right: 6px; }
        .msg { background: #e8f5e9; padding: 10px; border-radius: 4px; }
    </style>
</head>
<body>
    <h1>Gestión de Productos</h1>

    <?php if (!empty($_GET['msg'])): ?>
        <p class="msg"><?= htmlspecialchars($_GET['msg']) ?></p>
    <?php endif; ?>

    <h2>Agregar producto</h2>
    <form method="post" class="inline">
        <input type="hidden" name="accion" value="agregar">
        <input type="text" name="nombre" placeholder="Nombre" required>
        <input type="number" step="0.01" min="0" name="precio" placeholder="Precio" required>
        <input type="number" min="0" name="stock" placeholder="Stock" required>
        <button>Agregar</button>
    </form>

    <h2>Buscar por ID (en la lista)</h2>
    <form method="get" class="inline">
        <input type="number" name="buscar" placeholder="ID">
        <button>Buscar</button>
    </form>
    <?php if ($buscado !== null): ?>
        <?php if ($encontrado): tabla([$encontrado]); else: ?>
            <p>No se encontró el ID <?= $buscado ?>.</p>
        <?php endif; ?>
    <?php endif; ?>

    <h2>Recorrido hacia adelante (cabeza → cola) — <?= $lista->getTamano() ?> nodos</h2>
    <?php tabla($lista->recorrerAdelante(), true); ?>

    <h2>Recorrido hacia atrás (cola → cabeza)</h2>
    <?php tabla($lista->recorrerAtras()); ?>
</body>
</html>
