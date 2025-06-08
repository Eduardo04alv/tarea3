<?php
include('libreria/plantilla.php');
include('objeto.php');
$Personajes = new Personajes();
plantilla::aplicar();
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

<div class="text-and mb-3">
    <a href="add.php" class="btn btn-barbie">Agregar Personaje</a>
    <a href="grafico.php" class="btn btn-barbie">Ver Gráfico</a>
</div> 

<div>
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Fecha de nacimiento</th>
                <th>Foto</th>
                <th>Nivel de experiencia</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $ruta = 'datos/';
            if (is_dir($ruta)) {
                $archivos = scandir($ruta);
                foreach ($archivos as $archivo) {
                    if (pathinfo($archivo, PATHINFO_EXTENSION) === 'json') {
                        $contenido = file_get_contents($ruta . $archivo);
                        $Personajes = json_decode($contenido);

                        echo "<tr>";
                        echo "<td>{$Personajes->Id}</td>";
                        echo "<td>{$Personajes->Nombre}</td>";
                        echo "<td>{$Personajes->Apellido}</td>";
                        echo "<td>{$Personajes->Fecha_de_nacimiento}</td>";
                        echo "<td><img src='{$Personajes->Foto}' alt='Foto' style='width: 100px; height: auto;'></td>";
                        echo "<td>{$Personajes->Nivel_de_experiencia}</td>";
                        echo "<td class='acciones'>
                            <a href='Profesiones.php?ID={$Personajes->Id}' class='btn btn-info btn-sm'>Ver profesiones</a>
                            <a href='editar.php?ID={$Personajes->Id}' class='btn btn-warning btn-sm'>Editar</a>
                            <a href='eliminar.php?ID={$Personajes->Id}' class='btn btn-danger btn-sm'>Eliminar</a>
                        </td>";
                        echo "</tr>";
                    }
                }
            } else {
                echo "<tr><td colspan='7'>No hay personajes registrados.</td></tr>";
            }
            ?>
        </tbody>
    </table> 
</div>
</body>
</html>
