<?php

namespace Logger;

use Logger\Handler\HandlerInterface;
use Psr\Log\AbstractLogger;

class Logger extends AbstractLogger
{
  public function __construct(private HandlerInterface $handler) {}

  public function log($level, string|\Stringable $message, array $context = []): void
  {
    $this->handler->handle($level, (string) $message, $context);
  }
}
