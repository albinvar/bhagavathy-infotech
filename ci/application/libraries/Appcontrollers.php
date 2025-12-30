<?php
$c=Appcontrollers::get_all_controllers();
foreach ($c as $controller)
{
	
      $dir            = APPPATH.'controllers/'.ADMIN_FOLDER;
	      $filename=$controller.".php";
            require_once($dir."/".$filename);	
}
 class Appcontrollers
   {
    public function get_all_controllers()
    {
	      $controllers    = array();

        $dir            = APPPATH.'controllers/'.ADMIN_FOLDER;
        $files          = scandir($dir);

        $controller_files = array_filter($files, function($filename) {
            return (substr(strrchr($filename, '.'), 1)=='php') ? true : false;
        });

foreach ($controller_files as $filename)
        {
	 $classname = ucfirst(substr($filename, 0, strrpos($filename, '.')));
	array_push($controllers, $classname);
}
	
	return  $controllers;
    }
    
    
    
    
    public function get_actions($controller1)
    {
	      $dir            = APPPATH.'controllers/'.ADMIN_FOLDER;
	      $filename=$controller1.".php";
            require_once($dir."/".$filename);

            $classname1 = ucfirst(substr($filename, 0, strrpos($filename, '.')));
            $controller1 = new $classname1();
            $methods1 = get_class_methods($controller1);
$methods=array();
            foreach ($methods1 as $method)
            {
                array_push($methods,$method);
            }

           return $methods;
        
    }
   }