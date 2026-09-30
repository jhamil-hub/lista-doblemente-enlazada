# Gestión de Productos con Lista Doblemente Enlazada (PHP + MySQL)

Proyecto en PHP que carga los productos de una base de datos MySQL en una *lista doblemente enlazada* y los muestra recorriéndola hacia adelante (cabeza → cola) y hacia atrás (cola → cabeza). Permite agregar, eliminar y buscar productos.

# Requisitos

 [XAMPP](https://www.apachefriends.org/) (incluye Apache, PHP y MySQL/MariaDB)
 PHP 7.4 o superior
 Un navegador web

# Estructura del proyecto

proyecto/
├── index.php        # Página principal (interfaz y lógica de la aplicación)
├── conexion.php     # Conexión a la base de datos con mysqli
├── Producto.php     # Clase Producto (id, nombre, precio, stock)
├── Nodo.php         # Nodo de la lista (dato, siguiente, anterior)
├── ListaDoble.php   # Lista doblemente enlazada
├── database.sql     # Script para crear la base de datos y la tabla
└── README.md

## Base de datos

bd
└── productos
    ├── id      (INT, AUTO_INCREMENT, PRIMARY KEY)
    ├── nombre  (VARCHAR 100)
    ├── precio  (DECIMAL 10,2)
    └── stock   (INT)

## Instalación

1: **Iniciar XAMPP**: abre el Panel de Control y pulsa *Start* en **Apache** y **MySQL**.
2: **Crear la base de datos**:
    Entra a `http://localhost/phpmyadmin`
    Ve a la pestaña **SQL**
    Pega el contenido de `database.sql` y pulsa **Continuar**
3: **Copiar el proyecto** a la carpeta pública de XAMPP:
   
   C:\xampp\htdocs\proyecto\
   
4: **Abrir la aplicación**: `http://localhost/proyecto/index.php`

# Configuración de la conexión

Los valores por defecto de `conexion.php` coinciden con una instalación estándar de XAMPP:

| Parámetro | Valor       |
|-----------|-------------|
| Host      | `localhost` |
| Usuario   | `root`      |
| Contraseña| (vacía)     |
| Base      | `bd`        |
| Puerto    | `3308`      |

#  Métodos de la lista doblemente enlazada

| Método                   | Descripción                                   |
|--------------------------|-----------------------------------------------|
| `insertarInicio($p)`     | Inserta un producto al inicio de la lista     |
| `insertarFinal($p)`      | Inserta un producto al final de la lista      |
| `buscarPorId($id)`       | Devuelve el producto con ese ID o `null`      |
| `eliminarPorId($id)`     | Elimina el nodo con ese ID                    |
| `recorrerAdelante()`     | Devuelve los productos de cabeza a cola       |
| `recorrerAtras()`        | Devuelve los productos de cola a cabeza       |
| `estaVacia()`            | Indica si la lista no tiene nodos             |
| `getTamano()`            | Cantidad de nodos de la lista                 |

#  Solución de problemas

| Error                              | Causa y solución                                                              |
|------------------------------------|-------------------------------------------------------------------------------|
| `Connection refused`               | MySQL no está iniciado en XAMPP. Pulsa *Start* en MySQL.                      |
| `Unknown database 'bd'`            | No se ejecutó `database.sql`. Ejecútalo en phpMyAdmin.                        |
| `Access denied for user 'root'`    | Root tiene contraseña. Colócala en `$password` de `conexion.php`.             |
| MySQL no inicia (puerto 3306)      | Otro programa usa el puerto. Cambia el puerto en XAMPP y en `$puerto`.        |
| Página en blanco o código PHP visible | Abriste el archivo directo. Usa `http://localhost/proyecto/index.php`.     |
| `404 Not Found`                    | La carpeta no está en `htdocs` o el nombre no coincide.                       |
