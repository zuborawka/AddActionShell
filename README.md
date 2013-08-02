AddActionShell
==============

This plugin is a shell command class of CakePHP to add a empty method into specified controller.
And it also generate a empty view file for the action.

このプラグインは、指定したコントローラに空のアクションを追加するシェルコマンドです。
アクションに対応する空のビューファイルも生成します。


Instalation
-----------

If you'd like to use as a plugin,
set the file like below.
And load the plugin in bootstrap.php:

プラグインとして用いる場合
下記の要領でファイルを設置して、bootstrap.php でプラグインを有効化して下さい。::

  // set the file
  app/Plugins/AddActionShell/Console/Command/AddActionShell.php
  
  // bootstrap.php
  CakePlugin::load('AddActionShell');


In the case which you want to include it in your application:

あなたのアプリケーション内で使いたい場合::

  app/Console/Command/AddActionShell.php

Usage
-----

$Console/cake AddActionShell.AddAction
