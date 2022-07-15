<?php

namespace Logger\Handler;

class CommandLineHandler implements HandlerInterface
{
  protected $colors = [];
  protected $backgroundColors = [];

  public function __construct(protected $datetimeFormat = 'Y-m-d H:i:s', $colors = [])
  {
    $this->colors = array_merge($colors, [
      'debug' => '1;36',     // green
      'info' => '1;32',      // cyan
      'warning' => '1;33',   // yellow
      'error' => '1;31',     // red
      'critical' => '1;31',  // red
      'alert' => '1;31',     // red
      'emergency' => '1;31', // red
    ]);
  }

  public function handle(string $level, string $message, array $context = []): void
  {
    // start with the timestamp
    $string = (new \DateTimeImmutable())->format($this->datetimeFormat) . ' ';

    if (isset($this->colors[$level])) {
      $string .= "\033[" . $this->colors[$level] . "m";
    }

    $string .= strtoupper($level) . " \033[0m" . $message . "\n";

    if (!empty($context)) {
      $string .= JSON_ENCODE($context, JSON_PRETTY_PRINT) . "\n";
    }

    echo $string;
  }
}
