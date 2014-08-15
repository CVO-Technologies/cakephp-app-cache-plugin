<?php

App::uses('AppCacheRoutes', 'AppCache.Lib');

class AppCacheRoutesTest extends CakeTestCase {

	public function testViewLoad() {
		$this->assertEmpty(AppCacheRoutes::cache());

		$this->assertTrue(AppCacheRoutes::cache(array(
			'controller' => 'controller1'
		)));
		$this->assertTrue(AppCacheRoutes::cache(array(
			'controller' => 'controller2'
		)));

		$this->assertContains(array(
			'controller' => 'controller1'
		), AppCacheRoutes::cache());
		$this->assertContains(array(
			'controller' => 'controller2'
		), AppCacheRoutes::cache());
	}

	public function testViewLoadd() {
		$this->assertEmpty(AppCacheRoutes::network());

		$this->assertTrue(AppCacheRoutes::network(array(
			'controller' => 'controller1'
		)));
		$this->assertTrue(AppCacheRoutes::network(array(
			'controller' => 'controller2'
		)));

		$this->assertContains(array(
			'controller' => 'controller1'
		), AppCacheRoutes::network());
		$this->assertContains(array(
			'controller' => 'controller2'
		), AppCacheRoutes::network());
	}

	public function testViewLoaddd() {
		$this->assertEmpty(AppCacheRoutes::fallback());

		$this->assertTrue(AppCacheRoutes::fallback('/url1', array(
			'controller' => 'controller1'
		)));
		$this->assertTrue(AppCacheRoutes::fallback('/url2', array(
			'controller' => 'controller2'
		)));

		$this->assertContains(array(
			'controller' => 'controller1'
		), AppCacheRoutes::fallback());
		$this->assertContains(array(
			'controller' => 'controller2'
		), AppCacheRoutes::fallback());

		$this->assertEquals(AppCacheRoutes::fallback()['/url1'], array(
			'controller' => 'controller1'
		));
		$this->assertEquals(AppCacheRoutes::fallback()['/url2'], array(
			'controller' => 'controller2'
		));
	}

}
