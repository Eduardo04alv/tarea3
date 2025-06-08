<?php
class Personajes{
    public $Id;
    public $Nombre;
    public $Apellido;
    public $Fecha_de_nacimiento;
    public $Foto;
    public $Nivel_de_experiencia;
   public  $Profesiones = array();
}
class  Profesiones {
   public $id_Profesiones;
   public $Nombre_de_la_profesión;
   public $Categoría;
   public $Salario; 
}
class Datos{
public static function Nivel_de_experiencia(){
return array(
'Principiante' => 'Principiante',
'Intermedio' => 'Intermedio',
'Avanzado' => 'Avanzado'
);
}
public static function Categoria_profecion(){
return array(
'Ciencia' => 'Ciencia',
'Arte' => 'Arte',
'Deporte' => 'Deporte',
'Entretenimiento' => 'Entretenimiento'
);
}
}
?>
