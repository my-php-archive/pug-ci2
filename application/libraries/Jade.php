<?php

/**
 * @author kylekatarnls
 * @author WCLab
 */

class Jade {

	protected $CI;
	protected $jade;
	protected $views_path;
	protected $ext;

	public function __construct(array $options = NULL) {

		if(is_null($options)) {
			$options = defined('static::SETTINGS') ? ((array) static::SETTINGS) : array();
		}
	   
		if(isset($options["extension"])){
			$this->ext = $options["extension"];
			unset($options['extension']);
		}else{
			$this->ext = ".jade";
		}

	   if(isset($options['views_path'])) {
			$this->views_path = $options['views_path'];
			unset($options['views_path']);
		} else {
			$this->views_path = APPPATH . 'views';
		}

		if(isset($options['cache'])) {
			if($options['cache'] === TRUE) {
				$options['cache'] = APPPATH . 'cache/jade';
			}
			if(! file_exists($options['cache']) && ! mkdir($options['cache'], 0777, TRUE)) {
				throw new Exception("Cache folder does not exists and cannot be created.", 1);
			}
		}
		$this->CI =& get_instance();
		// if(! class_exists('Jade\\Jade')) {
		//     spl_autoload_register(function ($className) {
		//         if(strpos($className, 'Jade\\') === 0) {
		//             $path = __DIR__ . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $className) . '.php';
		//             if(file_exists($path)) {
		//                 include_once $path;
		//             }
		//         }
		//     });
		// }
		$this->jade = new Jade\Jade($options);

	}

	public function view($view, $data = array(), $return = false) {
		# view($data,true)
		if (is_array($view)) {
			$return = $data===true ? true : false;
			$data = $view;
			$view = null;
		}

		//view(true)
		if ($view===true) {
			$data = array();
			$view = null;
			$return = true;
		}
		
		if(! $this->jade) {
			$this->settings();
		}

		$views_path = str_replace("\\", "/", $this->views_path . DIRECTORY_SEPARATOR);

		//Views expected
		$views = array(
			"original" => $view.$this->ext,
			"method" => $this->CI->router->method.$this->ext,
			"module" => $this->CI->router->class.DIRECTORY_SEPARATOR.$this->CI->router->method.$this->ext
		);


		if (is_null($view)){
			if (file_exists($this->views_path.DIRECTORY_SEPARATOR.$views['method'])) {
				$view = $this->views_path.DIRECTORY_SEPARATOR.$views['method'];
			}
			elseif(file_exists($this->views_path.DIRECTORY_SEPARATOR.$views['module'])){
				$view = $this->views_path.DIRECTORY_SEPARATOR.$views['module'];
			}
			else{
				show_error("Unable to load the requested file: {$views['method']}","500");
			}
		}else{
			if (is_string($view)) {
				if (file_exists($this->views_path.DIRECTORY_SEPARATOR.$views['original'])) {
					$view = $this->views_path.DIRECTORY_SEPARATOR.$views['original'];
				}else{
					show_error("Unable to load the requested file: {$views['original']}","500");
				}
			}
		}

		if($return) 
			return $this->jade->render($view, $data);
		else 
			$this->CI->output->set_output($this->jade->render($view, $data));
	}

}
