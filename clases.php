<?php

require_once("metodos.php");

class WebController
{
  public static function login()
  {
    crearLogin();
  }
}

class Cliente
{
    //Atributos relacionados con los campos de la tabla cliente
  private $id;
  private $nombre;
  private $direccion;
  private $ciudad;
  private $estado;
  private $codigoPostal;
  private $codigoDeArea;
  private $telefono;
  private $vendedor_ID;
  private $limite_de_credito;
  private $comentarios;

  public function __construct($nombre, $direccion, $ciudad, $estado, $codigoPostal, $codigoDeArea, $telefono, $vendedor_ID, $limite_de_credito, $comentarios)
  {
    $this->nombre = $nombre;
    $this->direccion = $direccion;
    $this->ciudad = $ciudad;
    $this->estado = $estado;
    $this->codigoPostal = $codigoPostal;
    $this->codigoDeArea = $codigoDeArea;
    $this->telefono = $telefono;
    $this->vendedor_ID = $vendedor_ID;
    $this->limite_de_credito = $limite_de_credito;
    $this->comentarios = $comentarios;
  }

  /**
   * Funcio que se encargará de añadir el cliente a la base de datos.
   */
  public static function añadirCliente($cliente)
  {
    $conexion = conectar("pufosa");
  }

  public static function crearTabla()
  {
    $conexion = conectar("pufosa");

    $contenedor = new Caja();
    $contenedor->añadirAtributo("class","container-fluid");

    $columnas = getCabeceraTabla("clientes");
    $clientes = new Tabla();
    $clientes->añadirCabecera($columnas);

    $registros = mysqli_query($conexion, getConsultaTabla("clientes"));
      //Creamos el array para almacenar todas las filas de la consulta.+
    $filas = array(); 
      // Mientras siga habiendo filas de la consulta, añadiremos una nueva fila al conjunto de las filas (Array $filas).
    while ($reg = mysqli_fetch_row($registros)) {
      for ($i = 1; $i < count($reg); $i++) {
        $filas[] = $reg[$i];
      }
      $filas[] = Cliente::crearBotones($reg[0]);

      $clientes->añadirFila($filas);
      $filas = array();
    }
    mysqli_close($conexion);
    $contenedor->añadirContenido($clientes);
    return $contenedor;
   
  }

  private function crearBotones($id)
  {
    //Creamos el contendor principal
    $contenedor = new Caja();
    $contenedor->añadirAtributo("class","container-fluid");

    //Creamos el formulario para añadir la opcion de modificar el registro
    $formularioModificar = new Formulario("POST","../operaciones/modificar.php");

    //Creamos el boton de modificar.
    $botonModificar = new Input("submit","","","MODIFICAR");
    $botonModificar->añadirAtributo("class","btn btn-warning");

    //Añadimos los campos al formulario
    $formularioModificar->añadirCampo("",$botonModificar);
    $formularioModificar->añadirCampo("",new Input("hidden","","CLIENTE",$id));

    //Creamos el formulario para añadir la opcion de borrar el registro
    $formularioBorrar = new Formulario("POST","../operaciones/borrar.php");

    //Creamos el boton de borrar.
    $botonBorrar = new Input("button","","","BORRAR");
    $botonBorrar->añadirAtributo("class","btn btn-danger");
    $botonBorrar->añadirAtributo("onclick",'if(confirm(\'¿Seguro que desea borrar este dato?\')){
                                                this.form.submit();}
                                            else{ 
                                                alert(\'Operacion Cancelada\');
                                            }');
    $botonBorrar->añadirAtributo("formaction","../operaciones/borrar.php");

    //Añadimos los campos al formulario
    $formularioBorrar->añadirCampo("",$botonBorrar);
    $formularioBorrar->añadirCampo("",new Input("hidden","","CLIENTE",$id));

    // Añadimos los dos formularios al contenedor.
    //$contenedorModificar = new Caja();
    //$contenedorModificar->añadirContenido($formularioModificar);
    $contenedorBorrar = new Caja();
    $contenedorBorrar->añadirContenido($formularioBorrar);

    //$contenedor->añadirContenido($contenedorModificar);
    $contenedor->añadirContenido($contenedorBorrar);

    return $contenedor;
  }
}

class Empleado
{
    //Atributos relacionados con los campos de la tabla empleados
        private $id;
  private $nombre;
  private $apellido;
  private $inicial;
  private $tra_id;
  private $jefe_id;
  private $fecha_contrato;
  private $salario;
  private $comision;
  private $dep_id;

  public function __construct($id, $nombre, $apellido, $inicial, $tra_id, $jefe_id, $fecha_contrato, $salario, $comision, $dep_id)
  {
    $this->id = $id;
    $this->nombre = $nombre;
    $this->apellido = $apellido;
    $this->inicial = $inicial;
    $this->tra_id = $tra_id;
    $this->jefe_id = $jefe_id;
    $this->fecha_contrato = $fecha_contrato;
    $this->salario = $salario;
    $this->comision = $comision;
    $this->dep_id = $dep_id;
  }

  public function __get($name)
  {
    return $this->$name;
  }

  public function __toString()
  {
    $text = "";
    $text .= 'ID: ' . $this->id . '<br>' .
      'Nombre: ' . $this->nombre . ' ' . $this->apellido . ' ' . $this->inicial . '<br>' .
      'Trabajo: ' . $this->tra_id . '<br>' .
      'Jefe: ' . $this->jefe_id . '<br>' .
      'Fecha_contrato' . $this->fecha_contrato . '<br>' .
      'Salario: ' . $this->salario . '<br>' .
      'Comision: ' . $this->comision . '<br>' .
      'Departamento: ' . $this->dep_id . '<br>';
    return $text;
  }
}

class Menu extends ElementoHTML
{
  private $contenido = array();

  public function __construct(){}

  public function añadirContenido($contenido)
  {
    $this->contenido[] = $contenido;
  }

  public function __toString()
  {
    $text = '<nav ' . $this->imprimirAtributos() . '>';
    for ($i = 0; $i < count($this->contenido); $i++) {
      $text .= $this->contenido[$i];
    }
    $text .= '</nav>';
    return $text;
  }
}

class Lista extends ElementoHTML
{
  private $elementos = array();

  public function __construct(){}
  
  public function añadirElemento($elemento)
  {
    $this->elementos[] = $elemento;
  }
  public function __toString()
  {
    $text = '<ul ' . $this->imprimirAtributos() . '>';
    for ($i=0; $i < count($this->elementos); $i++) { 
      $text .= '<li>' . $this->elementos[$i] . '</li>';
    }
    $text .= '</ul>';
    return $text;
  }
}

class Enlace extends ElementoHTML
{
  private $nombre;
  private $enlace;

  public function __construct($nombre,$enlace = "")
  {
    $this->nombre = $nombre;
    $this->enlace = $enlace;
  }

  public function __toString()
  {
    return '<a href="' . $this->enlace . '"'. $this->imprimirAtributos() . '>' . $this->nombre . '</a>';
  }
}

class Span extends ElementoHTML
{
  private $contenido;

  public function __construct($contenido)
  {
    $this->contenido = $contenido;
  }

  public function __toString()
  {
    return '<span '.$this->imprimirAtributos().'>' . $this->contenido . '</span>';
  }
}

// CLASES PADRE
class ElementoHTML
{
  protected $atributos = array();
  protected $nombreAtributo = array();
  private $tag;
  private $contenido;

  public function __construct($etiqueta,$contenido = "")
  {
    $this->tag = $etiqueta;
    $this->contenido = $contenido;
  }

  public function añadirAtributo($nombre, $valor)
  {
    $this->atributos[] = $valor;
    $this->nombreAtributo[] = $nombre;
  }

  public function imprimirAtributos()
  {
    $atributos = " ";
    for ($i = 0; $i < count($this->atributos); $i++) {
      $atributos .= $this->nombreAtributo[$i] . '="' . $this->atributos[$i] . '" ';
    }

    return $atributos;
  }

  public function __toString()
  {
    return '<'.$this->tag.' ' . $this->imprimirAtributos() . '>' . $this->contenido . '</' . $this->tag . '>';
  }

}

class Controlador extends ElementoHTML
{
  protected $name;
  protected $value;

  public function __construct($name, $value)
  {
    $this->name = $name;
    $this->value = $value;
  }

}

// CLASES PARA TABLAS
class Tabla extends ElementoHTML
{
  private $cabecera = array();
  private $filas = array();

  public function __construct(){}

  public function añadirCabecera($fila)
  {
    if (gettype($fila) == "array" && count($this->cabecera) == 0) {
      $this->cabecera[] = new Fila($fila, "header");
      return true;
    }
    return false;
  }

  public function añadirFila($fila)
  {
    if (gettype($fila) == "array" && count($this->cabecera) > 0) {
      $this->filas[] = new Fila($fila);
      return true;
    }
    return false;
  }

  public function __toString()
  {
    $text = '<table class="table table-hover table-striped">
                <thead style="background-color: rgba(0,0,0,0.85);color:white;">
              ';
    foreach ($this->cabecera as $cabecera) {
      $text .= $cabecera;
    }
    $text .= '</thead>
                <tbody id="tableData">';
    foreach ($this->filas as $fila) {
      $text .= $fila;
    }
    $text .= "</tbody>
          </table>";
    return $text;
  }

}

class Fila extends ElementoHTML
{
  private $celdas = array();

  public function __construct($celdas, $tipo = "data")
  {
    for ($i = 0; $i < count($celdas); $i++) {
      $this->celdas[$i] = new Celda($celdas[$i], $tipo);
    }
  }

  public function __toString()
  {
    $text = '<tr' . $this->imprimirAtributos() . '>';
    foreach ($this->celdas as $celda) {
      $text .= $celda;
    }
    $text .= "</tr>";
    return $text;
  }
}

class Celda extends ElementoHTML
{
  private $data;
  private $tipo;

  public function __construct($data, $tipo = "data")
  {
    $this->data = $data;
    $this->tipo = $tipo;
  }

  public function __toString()
  {
    if ($this->tipo == "header") {
      return '<th' . $this->imprimirAtributos() . '>' . $this->data . "</th>";
    }
    return "<td" . $this->imprimirAtributos() . ">" . $this->data . "</td>";
  }

}
//

//CLASES PARA FORMULARIO

class Formulario extends ElementoHTML
{
  private $method;
  private $action;
  private $nombreCampos = array();
  private $campos = array();
  private $header = null;
  private $footer = null;
  public function __construct($method, $action)
  {
    $this->action = $action;
    $this->method = $method;
  }

  public function añadirHeader($header)
  {
    $this->header = $header;
  }

  public function añadirFooter($footer)
  {
    $this->footer = $footer;
  }

  public function añadirCampo($nombre, $contenido)
  {
    if ($nombre == "") {
      $this->nombreCampos[] = "";
    } else {
      $this->nombreCampos[] = new Label($nombre);
    }
    $this->campos[] = $contenido;
  }
  public function __toString()
  {
    $text = '<form action="' . $this->action . '" method="' . $this->method . '" ' . $this->imprimirAtributos() . '>';
    if ($this->header != null) {
      $text .= $this->header;
    }
    for ($i = 0; $i < count($this->nombreCampos); $i++) {
      $text .= $this->nombreCampos[$i];
      $text .= $this->campos[$i] . '<br>';
    }
    if ($this->footer != null) {
      $text .= $this->footer;
    }
    return $text;
  }
}

class Label extends ElementoHTML
{
  private $contenido;

  public function __construct($contenido)
  {
    $this->contenido = $contenido;
  }

  public function __toString()
  {
    return '<label>' . $this->contenido . '</label>';
  }
}

class Input extends Controlador
{
  private $type;
  private $id = "";

  function __construct($type, $id, $name, $value = null)
  {
    $this->type = $type;
    $this->id = $id;
    parent::__construct($name, $value);
  }

  public function __set($name, $value)
  {
    $this->$name = $value;
  }

  public function __toString()
  {
    return '<input type="' . $this->type . '" name="' . $this->name . '" id="' . $this->id . '"' . ' value="' . $this->value . '"' . $this->imprimirAtributos() . '>';
  }

}

class Select extends Controlador
{
  private $opciones = array();

  public function __construct($name)
  {
    $this->name = $name;
  }

  public function añadirOpcion($opcion)
  {
    $this->opciones[] = $opcion;
  }

  public function __toString()
  {
    $text = '<select name="'.$this->name.'>';
    for ($i=0; $i < count($this->opciones); $i++) { 
      $text .= $this->opciones[$i];
    }
    $text .= '</select>';

    return $text;
  }
}

class Option extends Controlador
{
  private $contenido;
  
  public function __construct($contenido, $value)
  {
    $this->contenido = $contenido;
    $this->value = $value;
  }

  public function __toString()
  {
    return '<option value="'.$this->value.'">'.$contenido.'</option>';;
  }
}

  
// OTRAS CLASES
class Caja extends ElementoHTML
{
  private $contenido = array();

  public function __construct($contenido = null)
  {
    if ($contenido != null)
      $this->contenido[] = $contenido;
  }

  public function añadirContenido($value)
  {
    $this->contenido[] = $value;
  }

  private function getContenido()
  {
    $texto = "";
    for ($i = 0; $i < count($this->contenido); $i++) {
      $texto .= $this->contenido[$i];
    }
    return $texto;
  }

  public function __toString()
  {
    return '<div ' . $this->imprimirAtributos() . '>' . $this->getContenido() . '</div>';
  }
}

class Imagen extends ElementoHTML
{
  private $source;
  private $alternative;

  public function __construct($src, $alt = "")
  {
    $this->source = $src;
    $this->alternative = $alt;
  }

  public function __toString()
  {
    return '<img src="' . $this->source . '" alt="' . $this->alternative . '"' . $this->imprimirAtributos() . '>';
  }
}
?>