<?php
include('libreria/plantilla.php');
include('objeto.php');
plantilla::aplicar();

$Ids = $_GET['ID'] ?? null;
$ruta = "datos/$Ids.json";

$Profesiones = new Profesiones();

if ($_POST) {
    if (file_exists($ruta)) {
        $contenido = file_get_contents($ruta);
        $Personajes = json_decode($contenido);

        $Profesiones->id_Profesiones = $_POST['id_Profesiones'];
        $Profesiones->Nombre_de_la_profesión = $_POST['Nombre_de_la_profesión'];
        $Profesiones->Categoría = $_POST['Categoría'];
        $Profesiones->Salario = $_POST['Salario'];

        if (!isset($Personajes-> Profesiones) || !is_array($Personajes-> Profesiones)) {
            $Personajes-> Profesiones = [];
        }

        $Personajes->Profesiones[] = $Profesiones;

        file_put_contents($ruta, json_encode($Personajes, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        $mensaje = "<div class='alert alert-success'>Profesión agregada correctamente</div>";
    } else {
        $mensaje = "<div class='alert alert-danger'>Personaje no encontrado</div>";
    }

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

<div class="container mt-4">
    <form method="post">
        <div class="mb-3">
            <label>ID de la Profesión</label>
            <input type="text" name="id_Profesiones" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Nombre de la Profesión</label>
            <input type="text" name="Nombre_de_la_profesión" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Categoría</label>
            <select class="form-select" name="Categoría" required>
                <option value="">Selecciona</option>
                <?php
                foreach (Datos::Categoria_profecion() as $key => $value) {
                    echo "<option value='$key'>$value</option>";
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label>Salario</label>
            <input type="number" step="0.01" name="Salario" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
            <?php
            echo "<a href='Profesiones.php?ID={$Ids}' class='btn btn-secondary'>cancelar</a>"
            ?>
    </form>
</div>
