<?php

if (CakePlugin::loaded('Croogo')) {
	App::uses('CroogoTestFixture', 'Croogo.TestSuite');
}

class CacheManifestControllerTest extends ControllerTestCase {

	public $fixtures = array(
		'plugin.users.aco',
		'plugin.users.aro',
		'plugin.users.aros_aco',
		'plugin.blocks.block',
		'plugin.comments.comment',
		'plugin.contacts.contact',
//		'plugin.translate.i18n',
		'plugin.settings.language',
		'plugin.menus.link',
		'plugin.menus.menu',
		'plugin.contacts.message',
		'plugin.meta.meta',
		'plugin.nodes.node',
		'plugin.taxonomy.model_taxonomy',
		'plugin.blocks.region',
		'plugin.users.role',
		'plugin.settings.setting',
		'plugin.taxonomy.taxonomy',
		'plugin.taxonomy.term',
		'plugin.taxonomy.type',
		'plugin.taxonomy.types_vocabulary',
		'plugin.users.user',
		'plugin.taxonomy.vocabulary',
	);

	public function testIndexVariables() {
		Configure::write('debug', 2);
		$dt = $this->testAction('/app_cache/cache_manifest.appcache', array(
			'method' => 'get'
		));
		Configure::write('debug', 2);
		debug($dt);
		//a

		$this->assertContains('cache', $this->vars['_serialize']);
		$this->assertContains('network', $this->vars['_serialize']);
		$this->assertContains('fallback', $this->vars['_serialize']);
	}

	public function testIndexRouted() {
		AppCacheRoutes::cache();
		Configure::write('debug', 2);
		$dt = $this->testAction('/app_cache/cache_manifest.appcache', array(
			'method' => 'get'
		));
		Configure::write('debug', 2);
		debug($dt);
		//a

		$this->assertContains('cache', $this->vars['_serialize']);
		$this->assertContains('network', $this->vars['_serialize']);
		$this->assertContains('fallback', $this->vars['_serialize']);
	}

}