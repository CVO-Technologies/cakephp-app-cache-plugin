<?php

App::uses('AppcacheView', 'AppCache.View');
App::uses('AppCacheRoutes', 'AppCache.Lib');

Configure::write('AppCache.manifest_route', array(
	'plugin'     => 'app_cache',
	'controller' => 'cache_manifest',
	'ext'        => 'appcache'
));

//AppCacheRoutes::cache(array('plugin' => 'app_cache', 'controller' => 'offline'));
//AppCacheRoutes::fallback('/', array('plugin' => 'app_cache', 'controller' => 'offline'));
//AppCacheRoutes::network('*');
