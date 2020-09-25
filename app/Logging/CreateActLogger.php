<?php

namespace App\Logging;

use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Formatter\LineFormatter;

// https://note.kiriukun.com/entry/20190824-logging-sql-queries-to-other-logfile-using-custom-channel-in-laravel
class CreateActLogger
{
    /**
     * SQLクエリ用Monologインスタンス生成
     * @param  array  $config
     * @return \Monolog\Logger
     */
    public function __invoke(array $config)
    {
        // 引数の $config には、config/logging.php で sqlQueryLog に設定した path とか days とかが入ってる！

        // 'debug' とかの文字列をMonologが使えるログレベルに変換
        $level = Logger::toMonologLevel($config['level']);

        // 日ごとにログローテートするハンドラ作成
        $hander = new RotatingFileHandler($config['path'], $config['days'], $level);

        // 改行コードを出力する＆カラのコンテキストを出力しないフォーマッタを設定
        $hander->setFormatter(new LineFormatter(null, null, true, true));

        // Monologインスタンス作成してハンドラ設定して返却
        $logger = new Logger('Act');  // ロガー名は 'SQL' にした。これはログに出力される
        $logger->pushHandler($hander);
        return $logger;
    }
}
