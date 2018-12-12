<?php
require_once("metodos.php");

class WebController
{
  public static function crearLogin()
  {
    // Creamos el contenedor de toda la pagina excepto el menu y le asignamos la clase 'container-fluid' para que haga efecto BOOTSTRAP (Version 3)
    $contenedor = new Caja();
    $contenedor->añadirAtributo("class", "container-fluid");
    $contenedorFormulario = new Caja();
    $contenedorFormulario->añadirAtributo("class", "container-fluid login-container");

    
    // Creamos el formulario que recogerá el id del empleado.
    $formulario = new Formulario("post", "access.php");
    $formulario->añadirAtributo("class", "form");
    $formulario->añadirAtributo("style", "width:400px;padding:40px;");

    //Creamos los campos del formulario
    $inputID = new Input("text", "", "emp_id");
    $inputID->añadirAtributo("class", "form-control");

    $submitInput = new Input("submit", "", "", "Acceder");
    $submitInput->añadirAtributo("class", "btn btn-primary form-control");
    //Añadimos los campos al formulario
    $formulario->añadirCampo("ID del empleado", $inputID);
    $formulario->añadirCampo("", $submitInput);

    //Creamos le objeto Imagen que ocntendrá la imagen del logo de la empresa.
    $imgLogo = new Imagen("img/logo.png", "Logo de la empresa");

    //Añadimos la imagen al contenedor secudario.
    $contenedorFormulario->añadirContenido($imgLogo);
    //Añadimos el formulario.
    $contenedorFormulario->añadirContenido($formulario);

    //Añadimos el contenedor secundario al principal.
    $contenedor->añadirContenido($contenedorFormulario);

    echo $contenedor;
  }

  public static function imprimirMenu()
  {
    //Creamos el menu.
    $menu = new Menu();
    //Añadimos las clases.
    $menu->añadirAtributo("class", "navbar navbar-inverse");
    $menu->añadirAtributo("style", "border-radius: 0px;");

    //Creamos el contenedor para dentro del menu.
    $contenedorMenu = new Caja();
    //Le añadimos las clases
    $contenedorMenu->añadirAtributo("class", "container-fluid");

    //Creamos el contenedor para la cabecera del menu
    $cabeceraMenu = new Caja();
    //Le añadimos las clases
    $cabeceraMenu->añadirAtributo("class", "navbar-header");

    $textoCabecera = new ElementoHTML("p", "PUFO S.A.");
    $textoCabecera->añadirAtributo("class", "navbar-text");
    $textoCabecera->añadirAtributo("style", "font-weight:bold;color:white;");
    $cabeceraMenu->añadirContenido($textoCabecera);
    //Creamos la lista para las opciones del menu sobre las tablas
    $listaTablas = new Lista();
    $listaTablas->añadirAtributo("class", "nav navbar-nav");
    $textoNombre = new ElementoHTML("p", getNombreEmpleado($_SESSION['emp_id']));
    $textoNombre->añadirAtributo("class", "navbar-text");
    $textoNombre->añadirAtributo("style", "font-weight:bold;color:white;");
    $enlaceClientes = new Enlace("Clientes", "");
    $enlaceClientes->añadirAtributo("class", "active");

    $listaTablas->añadirElemento($enlaceClientes);

    //Creamos la lista para las otras opciones del menu
    $listaOpciones = new Lista();
    $listaOpciones->añadirAtributo("class", "nav navbar-nav navbar-right");
    $listaOpciones->añadirElemento($textoNombre);
    $listaOpciones->añadirElemento(new Enlace("Cerrar sesion", "../operaciones/logout.php"));

    //Creamos el texto para le nombre del empleado.
    /*$empleado = $_SESSION['empleado'];
    $nombreEmpleado = $empleado->get("nombre") . ' ' . $empleado->get("apellido") . ' ' . $empleado->get("inicial");
    $textoNombre = new ElementoHTML("p",$nombreEmpleado);
    $textoNombre->añadirAtributo("class","navbar-text");

    $listaOpciones->añadirElemento($textoNombre);*/

    $contenedorMenu->añadirContenido($cabeceraMenu);
    $contenedorMenu->añadirContenido($listaTablas);
    $contenedorMenu->añadirContenido($listaOpciones);

    $menu->añadirContenido($contenedorMenu);

    return $menu;
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
//
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
    $contenedor->añadirAtributo("class", "container-fluid");

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
    $contenedor->añadirAtributo("class", "container-fluid");
    $contenedor->añadirAtributo("style", "display:flex;justify-content:space-between;");

    //Creamos el formulario para añadir la opcion de modificar el registro
    $formularioModificar = new Formulario("POST", "../operaciones/modificar.php");

    //Creamos el boton de modificar.
    $botonModificar = new Input("submit", "", "", "MODIFICAR");
    $botonModificar->añadirAtributo("class", "btn btn-warning");
    $botonModificar->añadirAtributo("formaction", "../operaciones/modificar.php");

    //Añadimos los campos al formulario
    $formularioModificar->añadirCampo("", $botonModificar);
    $formularioModificar->añadirCampo("", new Input("hidden", "", "CLIENTE_ID", $id));

    //Añadimos el formulario al contenedor
    $contenedor->añadirContenido(new Caja($formularioModificar));

    //Creamos el formulario para añadir la opcion de borrar el registro
    $formularioBorrar = new Formulario("POST", "../operaciones/borrar.php");

    //Creamos el boton de borrar.
    $botonBorrar = new Input("button", "", "", "BORRAR");
    $botonBorrar->añadirAtributo("class", "btn btn-danger");
    $botonBorrar->añadirAtributo("onclick", 'if(confirm(\'¿Seguro que desea borrar este dato?\')){
                                                this.form.submit();}
                                            else{ 
                                                alert(\'Operacion Cancelada\');
                                            }');

    //Añadimos los campos al formulario
    $formularioBorrar->añadirCampo("", $botonBorrar);
    $formularioBorrar->añadirCampo("", new Input("hidden", "", "CLIENTE_ID", $id));

    //Añadimos el formulario al contenedor
    $contenedor->añadirContenido(new Caja($formularioBorrar));

    return $contenedor;
  }

  public static function añadirModal()
  {
    //Creamos el contenedor para le modal
    $contenedor = new Caja();
    $contenedor->añadirAtributo("class", "modal fade");
    $contenedor->añadirAtributo("role", "dialog");
    $contenedor->añadirAtributo("id", "añadir");

    //Creamos el contenedor que contendrá el modal
    $contenedorDialog = new Caja();
    $contenedorDialog->añadirAtributo("class", "modal-dialog");
    
    //Creamos el contenedor para el modal
    $contenedorModal = new Caja();
    $contenedorModal->añadirAtributo("class", "modal-content");

    //Creamos la cabecera del modal
    $contenedorCabecera = new Caja();
    $contenedorCabecera->añadirAtributo("class", "modal-header");
    $contenedorCabecera->añadirAtributo("style", "background-color: rgba(0,0,0,0.85);color:white;");

    //Creamos el titulo del modal
    $titulo = new ElementoHTML("h4", "Añadir cliente");

    //Añadimos el titulo a su respectivo contenedor.
    $contenedorCabecera->añadirContenido($titulo);

    //Añadimos el contenedor de la cabecera al contenedor del modal
    $contenedorModal->añadirContenido($contenedorCabecera);

    //Creamos el contenedor del cuerpo del modal
    $contenedorCuerpo = new Caja();
    $contenedorCuerpo->añadirAtributo("class", "modal-body");

    //Creamos el formulario para añadir el cliente.
    $formularioAñadir = new Formulario("POST", "../operaciones/añadir.php");
    $formularioAñadir->añadirAtributo("id", "formularioAñadir");

    //Añadimos todos los campos necesarios al formulario

    $campoNombre = new Input("text", "", "nombre", "");
    $campoNombre->añadirAtributo("class", "form-control");
    $campoNombre->añadirAtributo("required", "none");

    $campoDireccion = new Input("text", "", "direccion", "");
    $campoDireccion->añadirAtributo("class", "form-control");
    $campoDireccion->añadirAtributo("required", "none");

    $campoCiudad = new Input("text", "", "ciudad", "");
    $campoCiudad->añadirAtributo("class", "form-control");
    $campoCiudad->añadirAtributo("required", "none");


    $campoEstado = new Input("text", "", "estado", "");
    $campoEstado->añadirAtributo("class", "form-control");
    $campoEstado->añadirAtributo("required", "none");

    $campoCodigoPostal = new Input("number", "", "codigopostal", "0");
    $campoCodigoPostal->añadirAtributo("class", "form-control");

    $campoCodigoDeArea = new Input("number", "", "codigodearea", "0");
    $campoCodigoDeArea->añadirAtributo("class", "form-control");

    $campoTelefono = new Input("number", "", "telefono", "0");
    $campoTelefono->añadirAtributo("class", "form-control");

    $campoVendedor = crearSelectVendedor();

    $campoLimite = new Input("number", "", "limite", "0");
    $campoLimite->añadirAtributo("class", "form-control");

    $campoComentarios = new Textarea("comentarios");
    $campoComentarios->añadirAtributo("class", "form-control");
    

    //Añadimos los campos al formulario

    $formularioAñadir->añadirCampo("Nombre", $campoNombre);
    $formularioAñadir->añadirCampo("Direccion", $campoDireccion);
    $formularioAñadir->añadirCampo("Ciudad", $campoCiudad);
    $formularioAñadir->añadirCampo("Estado", $campoEstado);
    $formularioAñadir->añadirCampo("Codigo postal", $campoCodigoPostal);
    $formularioAñadir->añadirCampo("Codigo de area", $campoCodigoDeArea);
    $formularioAñadir->añadirCampo("Telefono", $campoTelefono);
    $formularioAñadir->añadirCampo("Vendedor", $campoVendedor);
    $formularioAñadir->añadirCampo("Limite de credito", $campoLimite);
    $formularioAñadir->añadirCampo("Comentarios", $campoComentarios);

    //Añadimos el formulario al el contenedor del cuerpo del modal.
    $contenedorCuerpo->añadirContenido($formularioAñadir);

    //Añadimos el cuerpo del modal al contenedor del modal
    $contenedorModal->añadirContenido($contenedorCuerpo);

    //Creamos el contenedor del pie del modal
    $contenedorPie = new Caja();
    $contenedorPie->añadirAtributo("class", "modal-footer");
    $contenedorPie->añadirAtributo("style", "display:flex;background-color: rgba(0,0,0,0.85);color:white;justify-content:space-around;");
    
    //Añdimos al pie del modal dos botones, uno para añadir el cliente, y otro para cancelar la operación
    $botonAñadir = new Input("submit", "", "", "Añadir");
    $botonAñadir->añadirAtributo("class", "btn btn-primary btn-lg");
    $botonAñadir->añadirAtributo("form", "formularioAñadir");

    $botonCancelar = new Boton("Cancelar");
    $botonCancelar->añadirAtributo("class", "btn btn-danger btn-lg");
    $botonCancelar->añadirAtributo("data-dismiss", "modal");

    //Añadimos los botones al pie del modal
    $contenedorPie->añadirContenido($botonAñadir);
    $contenedorPie->añadirContenido($botonCancelar);

    //Añadimos el pie del modal al contenedor del modal
    $contenedorModal->añadirContenido($contenedorPie);

    //Añadimos el modal al dialog
    $contenedorDialog->añadirContenido($contenedorModal);

    //Añadimos el dialog al contenedor principal
    $contenedor->añadirContenido($contenedorDialog);

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

  public function get($name)
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

  public function __construct()
  {
  }

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

class Boton extends ElementoHTML
{
  public function __construct($contenido = "Click Me!")
  {
    $this->contenido = $contenido;
  }

  public function __toString()
  {
    return '<button ' . $this->imprimirAtributos() . '>' . $this->contenido . '</button>';
  }
}


class Lista extends ElementoHTML
{
  private $elementos = array();

  public function __construct()
  {
  }

  public function añadirElemento($elemento)
  {
    $this->elementos[] = $elemento;
  }
  public function __toString()
  {
    $text = '<ul ' . $this->imprimirAtributos() . '>';
    for ($i = 0; $i < count($this->elementos); $i++) {
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

  public function __construct($nombre, $enlace = "")
  {
    $this->nombre = $nombre;
    $this->enlace = $enlace;
  }

  public function __toString()
  {
    return '<a href="' . $this->enlace . '"' . $this->imprimirAtributos() . '>' . $this->nombre . '</a>';
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
    return '<span ' . $this->imprimirAtributos() . '>' . $this->contenido . '</span>';
  }
}

// CLASES PADRE
class ElementoHTML
{
  protected $atributos = array();
  protected $nombreAtributo = array();
  private $tag;
  private $contenido;

  public function __construct($etiqueta, $contenido = "")
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
      if ($this->atributos[$i] == "none") {
        $atributos .= $this->nombreAtributo[$i] . ' ';
      } else {
        $atributos .= $this->nombreAtributo[$i] . '="' . $this->atributos[$i] . '" ';
      }
    }

    return $atributos;
  }

  public function __toString()
  {
    return '<' . $this->tag . ' ' . $this->imprimirAtributos() . '>' . $this->contenido . '</' . $this->tag . '>';
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

  public function __construct()
  {
  }

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
                <tbody id="tablaDatos">';
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

  public function __construct($method, $action)
  {
    $this->action = $action;
    $this->method = $method;
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

    for ($i = 0; $i < count($this->campos); $i++) {
      $text .= $this->nombreCampos[$i];
      $text .= $this->campos[$i] . '<br>';
    }

    return $text . '</form>';
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
    $text = '<select name="' . $this->name . '"' . $this->imprimirAtributos() . '>';
    for ($i = 0; $i < count($this->opciones); $i++) {
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
    return '<option value="' . $this->value . '">' . $this->contenido . '</option>';;
  }
}

class Textarea extends Controlador
{
  private $contenido;

  public function __construct($name, $contenido = "")
  {
    $this->name = $name;
    $this->value = $contenido;
  }

  public function __toString()
  {
    return '<textarea name="' . $this->name . '"' . $this->imprimirAtributos() . '>' . $this->value . '</textarea>';
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