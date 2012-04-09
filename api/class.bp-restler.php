<?php

/**
 * Extends the Restler class for some BP-specific modifications
 */
class BP_Restler extends Restler {
	/**
	* Parses the requst url and get the api path
	*
	* Extended from the Restler base to account for the unique way in which WP/BP builds URLs
	*
	* @return string api path
	*/
	protected function getPath () {
		global $bp;
		
		$path = str_replace( bp_get_root_domain() . '/' . $bp->pages->api->slug . '/', '', wp_guess_url() );
		
		$path = preg_replace('/(\/*\?.*$)|(\/$)/', '', $path);
		$path = str_replace($this->format_map['extensions'], '', $path);
		return $path;
	}
	
	/**
	 * Generates cachable url to method mapping
	 * @param string $class_name
	 * @param string $base_path
	 */
	protected function generateMap ($class_name, $base_path = '') {
		$reflection = new ReflectionClass($class_name);
		$class_metadata = parse_doc($reflection->getDocComment());
		$methods = $reflection->getMethods(
		ReflectionMethod::IS_PUBLIC + ReflectionMethod::IS_PROTECTED);
		foreach ($methods as $method) {
			$doc = $method->getDocComment();
			$arguments = array();
			$defaults = array();
			$metadata = $class_metadata+parse_doc($doc);
			$params = $method->getParameters();
			$position=0;
			foreach ($params as $param){
				$arguments[$param->getName()] = $position;
				$defaults[$position] = $param->isDefaultValueAvailable() ?
					$param->getDefaultValue() : NULL;
				$position++;
			}
			$method_flag = $method->isProtected() ?
			(isRestlerCompatibilityModeEnabled() ? 2 :  3) :
			(isset($metadata['protected']) ? 1 : 0);

			//take note of the order
			$call = array(
			'class_name'=>$class_name,
			'method_name'=>$method->getName(),
			'arguments'=>$arguments,
			'defaults'=>$defaults,
			'metadata'=>$metadata,
			'method_flag'=>$method_flag
			);
			$method_url = strtolower($method->getName());
			
			if (preg_match_all(
			'/@url\s+(GET|POST|PUT|DELETE|HEAD|OPTIONS)[ \t]*\/?(\S*)/s', 
			$doc, $matches, PREG_SET_ORDER)) {
				foreach ($matches as $match) {
					$http_method = $match[1];
					$url = rtrim($match[2],'/');
					$this->routes[$http_method][$url] = $call;
				}
			}elseif($method_url[0] != '_'){ //not prefixed with underscore
				// no configuration found so use convention
				if (preg_match_all('/^(GET|POST|PUT|DELETE|HEAD|OPTIONS)/i', 
				$method_url, $matches)) {
					$http_method = strtoupper($matches[0][0]);
					$method_url = substr($method_url, strlen($http_method));
				}else{
					$http_method = 'GET';
				}
				$url = $base_path. ($method_url=='index' || 
				$method_url=='default' ? '' : $method_url);
				$url = rtrim($url,'/');
				$this->routes[$http_method][$url] = $call;
				foreach ($params as $param){
					if($param->getName()=='request_data'){
						break;
					}
					$url .= $url=='' ? ':' : '/:';
					$url .= $param->getName();
					$this->routes[$http_method][$url] = $call;
				}
			}
		}
	}
	
	protected function mapUrlToMethod () {
		if(!isset($this->routes[$this->request_method])){
			return array();
		}
		$urls = $this->routes[$this->request_method];
		if(!$urls)return array();

		$found = FALSE;
		$this->request_data += $_GET;
		$params = array('request_data'=>$this->request_data);
		$params += $this->request_data;
		
		foreach ($urls as $url => $call) {
			//echo PHP_EOL.$url.' = '.$this->url.PHP_EOL;
			$call = (object)$call;
			
			if ( $url == $this->url && isset( $params['action'] ) && $params['action'] == $call->method_name ){
				$found = TRUE;
				break;
			}
		}
		if($found){
			//echo PHP_EOL."Found $url ";
			//print_r($call);
			$p = $call->defaults;
			foreach ($call->arguments as $key => $value) {
				//echo "$key => $value \n";
				if(isset($params[$key]))$p[$value] = $params[$key];
			}
			$call->arguments=$p;
			return $call;
		}

	}
}

?>