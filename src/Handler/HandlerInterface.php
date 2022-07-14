<?php

namespace Logger\Handler;

interface HandlerInterface
{
  public function handle(string $level, string $message, array $context = []): void;
}
