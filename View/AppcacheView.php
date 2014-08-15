<?php

App::uses('View', 'View');

App::uses('AppCacheRoutes', 'AppCache.Lib');

class AppcacheView extends View {

	/**
	 * JSON views are always located in the 'json' sub directory for
	 * controllers' views.
	 *
	 * @var string
	 */
	public $subDir = 'appcache';

	/**
	 * Constructor
	 *
	 * @param Controller $controller
	 */
	public function __construct(Controller $controller = null) {
		parent::__construct($controller);

		if (isset($controller->response) && $controller->response instanceof CakeResponse) {
			$controller->response->type('appcache');
		}
	}

	/**
	 * Skip loading helpers if this is a _serialize based view.
	 *
	 * @return void
	 */
	public function loadHelpers() {
		if (isset($this->viewVars['_serialize'])) {
			return;
		}

		parent::loadHelpers();
	}

	/**
	 * Render a JSON view.
	 *
	 * ### Special parameters
	 * `_serialize` To convert a set of view variables into a JSON response.
	 *   Its value can be a string for single variable name or array for multiple names.
	 *   You can omit the`_serialize` parameter, and use a normal view + layout as well.
	 * `_jsonp` Enables JSONP support and wraps response in callback function provided in query string.
	 *   - Setting it to true enables the default query string parameter "callback".
	 *   - Setting it to a string value, uses the provided query string parameter for finding the
	 *     JSONP callback name.
	 *
	 * @param string $view The view being rendered.
	 * @param string $layout The layout being rendered.
	 * @return string The rendered view.
	 */
	public function render($view = null, $layout = null) {
		$return = null;
		if (isset($this->viewVars['_serialize'])) {
			$return = $this->renderLayout($this->_serialize($this->viewVars['_serialize']));
		} elseif ($view !== false && $this->_getViewFileName($view)) {
			$return = parent::render($view, false);
		}

		return $return;
	}


	/**
	 * Serialize view vars
	 *
	 * @param array $serialize The viewVars that need to be serialized
	 * @return string The serialized data
	 */
	protected function _serialize($serialize) {
		if (is_array($serialize)) {
			$data = array();
			foreach ($serialize as $alias => $key) {
				if (is_numeric($alias)) {
					$alias = $key;
				}
				if (array_key_exists($key, $this->viewVars)) {
					$data[$alias] = $this->viewVars[$key];
				}
			}
			$data = !empty($data) ? $data : null;
		} else {
			$data = isset($this->viewVars[$serialize]) ? $this->viewVars[$serialize] : null;
		}

		extract($data);

		$lines = array();
		$lines[] = 'CACHE:';
		foreach ($cache as $path) {
			$lines[] = Router::url($path);
		}
		$lines[] = '';
		$lines[] = 'NETWORK:';
		foreach ($network as $path) {
			if ($path === '*') {
				$lines[] = '*';

				continue;
			}

			$lines[] = Router::url($path);
		}
		$lines[] = '';
		$lines[] = 'FALLBACK:';
		foreach ($fallback as $path => $fallbackPath) {
			$lines[] = Router::url($path) . ' ' . Router::url($fallbackPath);
		}

		return implode($lines, PHP_EOL);
	}

}