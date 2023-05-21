<?php 
namespace Lib; 
// para almacenar las rutas que configuremos desde el archivo indexold.php 

class Router { 

    private static array $routes = []; 
    //para ir añadiendo los métodos y las rutas en el tercer parámetro. 
    public static function add(string $method, string $action, Callable $controller):void{ 

        $action = trim($action, '/'); 
        //var_dump($action); die;
        self::$routes[$method][$action] = $controller; 
    } 
    
    // Este método se encarga de obtener el sufijo de la URL que permitirá seleccionar 
    // la ruta y mostrar el resultado de ejecutar la función pasada al metodo add para esa ruta 
    // usando call_user_func() 

    public static function dispatch():void { 
        $method = $_SERVER['REQUEST_METHOD'];  
        //var_dump($_SERVER['REQUEST_URI']); die;
        $action = preg_replace("/\/cofradia\/public\//",'',$_SERVER['REQUEST_URI']);
        //var_dump($action); die;
       //$_SERVER['REQUEST_URI'] almacena la cadena de texto que hay después del nombre del host en la URL 
        $action = trim($action, '/'); 
        //var_dump($action); die;
        $urlarray = explode('/',$action);
        //var_dump($urlarray); die;
        $param = null; 
        
        if (isset($urlarray[2])){ 
            $param = $urlarray[2]; 
            //die($param);
            $action=preg_replace('/'.$param.'/',':id',$action); 
            //die($action); 
            
        }

        $fn = self::$routes[$method][$action] ?? null; 
        //var_dump($fn); die;
        if ($fn) { 
            $callback = self::$routes[$method][$action]; 
            echo call_user_func($callback, $param); 
        } else { 
            echo "Página no encontrada"; 
        } 
    } 
}