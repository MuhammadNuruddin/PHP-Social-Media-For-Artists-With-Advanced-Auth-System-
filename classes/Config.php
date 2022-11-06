<?php 

class Config 
{
	public static function get($path = null) {
		if ($path) {
			$config = $GLOBALS['config'];
			$path = explode('.', $path);

			foreach ($path as $sub_path) {
				if (isset($config[$sub_path])) {
					$config = $config[$sub_path];
				}
			}
			return $config;
		}
		return false;
	}

}