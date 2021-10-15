<?php

namespace App;


use mysql_xdevapi\Exception;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

class FileLogger extends LogLevel implements LoggerInterface
{
    public $handle;
    const FILE_NAME = 'log.txt';

    public function __construct()
    {
        $this->handle = fopen(self::FILE_NAME, "a+");
    }

    public function __destruct()
    {
        fclose($this->handle);
    }


    public function emergency($message, array $context = array())
    {
        $this->log(self::EMERGENCY, $message, $context);
    }

    public function alert($message, array $context = array())
    {
        $this->log(self::ALERT, $message, $context);
    }

    public function critical($message, array $context = array())
    {
        $this->log(self::CRITICAL, $message, $context);
    }

    public function error($message, array $context = array())
    {
        $this->log(self::ERROR, $message, $context);
    }

    public function warning($message, array $context = array())
    {
        $this->log(self::WARNING, $message, $context);
    }

    public function notice($message, array $context = array())
    {
        $this->log(self::NOTICE, $message, $context);
    }

    public function info($message, array $context = array())
    {
        $this->log(self::INFO, $message, $context);
    }

    public function debug($message, array $context = array())
    {
        $this->log(self::DEBUG, $message, $context);
    }

    public function log($level, $message, array $context = array())
    {
        if ($level !== self::EMERGENCY &&
            $level !== self::ALERT &&
            $level !== self::CRITICAL &&
            $level !== self::ERROR &&
            $level !== self::WARNING &&
            $level !== self::NOTICE &&
            $level !== self::INFO &&
            $level !== self::DEBUG) {
            throw new Exception("level not found");
        }


        foreach ($context as $key => $value) {
            $message = str_replace('{' . $key . '}', $value, $message);
        }

        $message = sprintf("%s [%s] - %s ", date('Y-m-d H:m:s'), strtolower($level), $message);

        $fileSize = filesize(self::FILE_NAME);

        fwrite($this->handle, ($fileSize > 0) ? "\n" . $message : $message);


    }
}