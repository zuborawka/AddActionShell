<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Zuborawka
 * Date: 13/08/02
 * Time: 20:49
 */

App::uses('AppShell', 'Console/Command');

class AddActionShell extends AppShell {


	public function main()
	{
		$this->out('このシェルは、指定したコントローラに任意のアクションと空のビューを追加します。');
		$this->out('コントローラは既に設置されている必要があります。');
		$this->out('すべての入力において、空の状態のまま入力するとこのシェルから抜けます。');
		$this->hr();
		$this->out('[0] 中止する');
		$this->out('[1] app 内のコントローラを使用する');
		$this->out('[2] プラグイン内のコントローラを使用する');
		$appOrPlugin = $this->in('選択して下さい。', array('0', '1', '2'), '0');
		$appOrPlugin = intval($appOrPlugin);
		if (!$appOrPlugin) {
			return $this->_goodBye();
		}
		if ($appOrPlugin === 2) {
			$plugin = $this->_selectPlugin();
			if (!$plugin) {
				return $this->_goodBye();
			}
		} else {
			$plugin = false;
		}
		$controller = $this->_selectController($plugin);
		if (!$controller) {
			return $this->_goodBye();
		}
		$action = $this->_selectAction();
		if (!$action) {
			return $this->_goodBye();
		}
		$path = $this->_getPath($plugin);

		if ($this->_writeAction($path, $controller, $action)) {
			$this->out($controller . 'Controller::' . $action . '() を追加しました');
		}

		if ($this->_generateView($path, $controller, $action)) {
			$this->out($controller . '/' . $action . '.ctp を追加しました');
		}
	}

	public function _selectPlugin()
	{
		$loaded = CakePlugin::loaded();
		array_unshift($loaded, '中止する');
		foreach ($loaded as $i => $_loaded) {
			$this->out(sprintf('[%s]    %s', $i, $_loaded));
		}

		do {
			$in = $this->in('選んで入力して下さい');
			$in = intval($in);
			if ($in === 0) {
				$plugin = false;
			} elseif (isset($loaded[$in])) {
				$plugin = $loaded[$in];
			}
		} while (!isset($plugin));

		return $plugin;
	}

	public function _goodBye()
	{
		$this->out('Good Bye!');
		return true;
	}

	/**
	 * @param $plugin
	 *
	 * @return string
	 */
	public function _getPath($plugin)
	{
		if ($plugin) {
			$path = CakePlugin::path($plugin);
		}
		else {
			$path = APP ;
		}
		return $path;
	}

	public function _getControllers($plugin = false)
	{
		$path = $this->_getPath($plugin) . 'Controller';
		$this->out($path);
		App::uses('Folder', 'Utility');
		$Folder = new Folder($path);
		list(,$controllers) = $Folder->read();
		foreach ($controllers as $i => $controller) {
			if (!preg_match('/^(.+)Controller\.php$/', $controller, $m)) {
				unset($controllers[$i]);
				continue;
			}
			$controllers[$i] = $m[1];
		}
		return array_values($controllers);
	}

	public function _selectController($plugin = false)
	{
		$options = $this->_getControllers($plugin);
		array_unshift($options, '中止する');
		foreach ($options as $i => $option) {
			$this->out(sprintf('[%s]  %s', $i, $option));
		}
		do {
			$in = $this->in('選択して下さい');
			$in = intval($in);
			if ($in === 0) {
				return false;
			} elseif (isset($options[$in])) {
				$controller = $options[$in];
			}
		} while (!isset($controller));
		return $controller;
	}

	public function _selectAction()
	{
		$in = $this->in('アクション名を入力して下さい。');
		return $in;
	}

	public function _writeAction($path, $controller, $action)
	{
		$file = $path . 'Controller' . DS . $controller . 'Controller.php';
		if (!file_exists($file)) {
			return false;
		}
		$lines = file($file);
		$count = count($lines);
		for ($i = $count-1; $i >= 0; $i--) {
			$line = $lines[$i];
			if (trim($i) === '}') {
				break;
			}
		}
		if (! $i) {
			return false;
		}
		$insert = <<<INSERT

	/**
	 * Added By MyCakeEx.AddActionShell
	 */
	public function {$action}()
	{
	}


INSERT;
		$content = join('', array_slice($lines, 0, $i));
		$content .= $insert;
		$content .= join('', array_slice($lines, $i));
		$fp = fopen($file, 'w');
		fwrite($fp, $content);
		fclose($fp);
		return true;
	}

	public function _generateView($path, $controller, $action)
	{
		$file = $path . 'View' . DS . $controller . DS . $action . '.ctp';
		if (file_exists($file)) {
			return false;
		}
		$date = date('Y-m-d');
		$time = date('H:i:s');
		$content = <<<CONTENT
<?php
/**
 * Created by MyCakeEx.AddActionShell.
 * Date: $date
 * Time: $time
 * @var \$this View
 */


CONTENT;

		App::uses('File', 'Utility');
		$File = new File($file, true);
		$File->write($content);
		return true;
	}
}
