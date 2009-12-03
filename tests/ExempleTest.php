<?php

require_once 'PHPUnit/Framework.php';
require_once 'config_test/config_test.php';

/*
 * Test de l'objet m�tier Exemple
 */
class ExempleTest extends PHPUnit_Framework_TestCase
{

	/**
	 * M�thode appel�e avant l'ex�cution des tests
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
		$this->assertTrue($id > 0, 'La sauvegarde en base de donn�es a �chou�e');
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
		$this->assertEquals(null, $o->id, 'La suppression de l\'�l�ment a �chou�e');
	}

	/**
	 * M�thode appel�e � la fin des test
	 */
	protected function tearDown()
	{
	}

}
