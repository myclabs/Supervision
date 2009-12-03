<?php

require_once 'PHPUnit/Framework.php';
require_once 'config_test/config_test.php';

/*
 * Test de l'objet métier Exemple
 */
class ExempleTest extends PHPUnit_Framework_TestCase
{

	/**
	 * Méthode appelée avant l'exécution des tests
	 */
	function setUp()
	{
	}

	function testConstruct()
	{
		$o = new Mycsense_Model_Exemple();
		$this->assertTrue($o instanceof Mycsense_Model_Exemple);
		return $o;
	}

	/**
	 * @depends testConstruct
	 */
	function testSave(Mycsense_Model_Exemple $o)
	{
		$o->nom = "Jacqueline";
		$this->assertEquals("Jacqueline", $o->nom);
		$o->save();
		$id = $o->id;
		$this->assertTrue($id > 0, 'La sauvegarde en base de données a échouée');
		return $id;
	}

	/**
	 * @depends testSave
	 */
	function testLoad($id)
	{
		$o = Mycsense_Model_Exemple::load($id);
		$this->assertTrue($o instanceof Mycsense_Model_Exemple);
		$this->assertEquals($o->id, $id);
		return $o;
	}

	/**
	 * @depends testLoad
	 */
	function testDelete(Mycsense_Model_Exemple $o)
	{
		$o->delete();
		$this->assertEquals(null, $o->id, 'La suppression de l\'élément a échouée');
	}

	/**
	 * Méthode appelée à la fin des test
	 */
	protected function tearDown()
	{
	}

}
