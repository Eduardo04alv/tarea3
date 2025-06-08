<?php
include('libreria/plantilla.php');
plantilla::aplicar();

$id = $_GET['ID'] ?? null;

if ($id) {
    $ruta = "datos/$id.json";

    if (file_exists($ruta)) {
        unlink($ruta);
        echo "<div class='alert alert-success'>Personaje eliminado correctamente.</div>";
    } else {
        echo "<div class='alert alert-danger'>El Personaje no existe.</div>";
    }
} else {
    echo "<div class='alert alert-warning'>ID no especificado.</div>";
}
?>

<style>
    body {
        background: linear-gradient(135deg, #ffe6f0, #fcd6ff);
        font-family: 'Comic Sans MS', cursive, sans-serif;
        color: #880e4f;
    }

    h1 {
        color: #d81b60;
        font-weight: bold;
        text-shadow: 1px 1px 2px #fff;
    }

    .btn-barbie {
        background-color: #ff69b4;
        border-color: #ff69b4;
        color: white;
        border-radius: 25px;
        transition: 0.3s ease;
    }

    .btn-barbie:hover {
        background-color: #ff1493;
        border-color: #ff1493;
    }

    table {
        background-color: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 0 15px rgba(255, 105, 180, 0.3);
    }

    thead {
        background-color: #f8bbd0;
        color: #880e4f;
    }

    .table td img {
        border-radius: 10px;
        box-shadow: 0 0 5px #ffb6c1;
    }

    .acciones a {
        margin: 2px;
    }

    .text-and {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }
</style>

<a href="index.php" class="btn btn-primary mt-3">Volver al inicio</a>