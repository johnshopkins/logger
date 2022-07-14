<?php

namespace Logger\Handler;

class MonologHandler implements HandlerInterface
{
  protected $client;

  public function __construct($loggerName, $logFile)
  {
    $this->client = new \Monolog\Logger($loggerName);

    if (is_writable($logFile)) {
      $handler = new \Monolog\Handler\StreamHandler($logFile);
      $this->client->pushHandler($handler);
    }
  }

  public function handle(string $level, string $message, array $context = []): void
  {
    $this->client->log($level, $message, $context);
  }
}
