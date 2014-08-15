<?php

App::uses('AppController', 'Controller');

class CacheManifestController extends AppController {

	public function index() {
		$cache = AppCacheRoutes::cache();

		$network = AppCacheRoutes::network();

		$fallback = AppCacheRoutes::fallback();

		$this->set(compact('cache', 'network', 'fallback'));
		$this->set('_serialize', array('cache', 'network', 'fallback'));
	}

}