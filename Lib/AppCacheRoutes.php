<?php

class AppCacheRoutes {

	public static function cache($route = null) {
		if (!Configure::check('AppCache.routes.cache')) {
			Configure::write('AppCache.routes.cache', array());
		}
		$routes = Configure::read('AppCache.routes.cache');

		if ($route === null) {
			return $routes;
		}

		$routes[] = $route;

		Configure::write('AppCache.routes.cache', $routes);

		return true;
	}

	public static function network($route = null) {
		if (!Configure::check('AppCache.routes.network')) {
			Configure::write('AppCache.routes.network', array());
		}
		$routes = Configure::read('AppCache.routes.network');

		if ($route === null) {
			return $routes;
		}

		$routes[] = $route;

		Configure::write('AppCache.routes.network', $routes);

		return true;
	}

	public static function fallback($path = null, $route = null) {
		if (!Configure::check('AppCache.routes.fallback')) {
			Configure::write('AppCache.routes.fallback', array());
		}
		$routes = Configure::read('AppCache.routes.fallback');

		if ($path === null) {
			return $routes;
		}

		$routes[$path] = $route;

		Configure::write('AppCache.routes.fallback', $routes);

		return true;
	}

	/**
	 * Adds a timestamp to a file based resource based on the value of `Asset.timestamp` in
	 * Configure. If Asset.timestamp is true and debug > 0, or Asset.timestamp === 'force'
	 * a timestamp will be added.
	 *
	 * @param string $path The file path to timestamp, the path must be inside WWW_ROOT
	 * @return string Path with a timestamp added, or not.
	 */
	public static function assetTimestamp($path) {
		$stamp = Configure::read('Asset.timestamp');
		$timestampEnabled = $stamp === 'force' || ($stamp === true && Configure::read('debug') > 0);
		if ($timestampEnabled && strpos($path, '?') === false) {
			$filepath = preg_replace(
				'/^' . preg_quote(WWW_ROOT, '/') . '/',
				'',
				urldecode($path)
			);
			$webrootPath = WWW_ROOT . str_replace('/', DS, $filepath);
			if (file_exists($webrootPath)) {
				//@codingStandardsIgnoreStart
				return $path . '?' . @filemtime($webrootPath);
				//@codingStandardsIgnoreEnd
			}
			$segments = explode('/', ltrim($filepath, '/'));
			if ($segments[0] === 'theme') {
				$theme = $segments[1];
				unset($segments[0], $segments[1]);
				$themePath = App::themePath($theme) . 'webroot' . DS . implode(DS, $segments);
				//@codingStandardsIgnoreStart
				return $path . '?' . @filemtime($themePath);
				//@codingStandardsIgnoreEnd
			} else {
				$plugin = Inflector::camelize($segments[0]);
				if (CakePlugin::loaded($plugin)) {
					unset($segments[0]);
					$pluginPath = CakePlugin::path($plugin) . 'webroot' . DS . implode(DS, $segments);
					//@codingStandardsIgnoreStart
					return $path . '?' . @filemtime($pluginPath);
					//@codingStandardsIgnoreEnd
				}
			}
		}

		return $path;
	}

}