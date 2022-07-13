<?php

namespace Logger;

use Logger\Handler\HandlerInterface;
use Psr\Log\AbstractLogger;

class Logger extends AbstractLogger
{
  public function __construct(private HandlerInterface $handler) {}

  public function log($level, $message, array $context = [])
  {
    $this->handler->handle($level, (string) $message, $context);
  }
}
