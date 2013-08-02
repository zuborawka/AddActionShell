<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Zuborawka
 * Date: 13/08/02
 * Time: 23:02
 */

App::uses('Shell', 'Console');
App::uses('AddActionShell', 'Console/Command');
App::uses('File', 'Utility');

/**
 * For testing console I/O
 *
 * Class AppShell
 */
class AppShell extends Shell
{
	public $inputs = array();

	public function in($prompt, $options = null, $default = null)
	{
		if ($this->inputs) {
			return array_shift($this->inputs);
		}
	}
}

/**
 * For testing file I/O
 *
 * Class FileDemo
 */
class FileDemo extends File
{
}


class AddActionShellTest {

	/**
	 * @var AddActionShell
	 */
	public $shell;

	public function setUp()
	{
		$this->shell = new AddActionShell();
		$this->shell->fileClass = 'FileDemo';
	}

	public function test_selectPlugin()
	{
		$this->markTestIncomplete(
			'このテストは、まだ実装されていません。'
		);
	}

	public function test_goodBye()
	{
		$this->markTestIncomplete(
			'このテストは、まだ実装されていません。'
		);
	}

	public function test_getPath()
	{
		$this->markTestIncomplete(
			'このテストは、まだ実装されていません。'
		);
	}

	public function test_selectControllers()
	{
		$this->markTestIncomplete(
			'このテストは、まだ実装されていません。'
		);
	}

	public function test_selectAction()
	{
		$this->markTestIncomplete(
			'このテストは、まだ実装されていません。'
		);
	}

	public function test_writeAction()
	{
		$this->markTestIncomplete(
			'このテストは、まだ実装されていません。'
		);
	}

	public function test_generateView()
	{
		$this->markTestIncomplete(
			'このテストは、まだ実装されていません。'
		);
	}

	public function test_getFileClass()
	{
		$this->markTestIncomplete(
			'このテストは、まだ実装されていません。'
		);
	}

}
