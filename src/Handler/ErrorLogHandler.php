<?php

namespace Logger\Handler;

class ErrorLogHandler implements HandlerInterface
{
  protected array $colors = [
    'purple' => '1;35',
    'cyan' => '1;36',
    'yellow' => '1;33',
    'red' => '1;31',
  ];

  protected array $levelColors = [
    'debug' => 'purple',
    'info' => 'cyan',
    'warning' => 'yellow',
    'error' => 'red',
    'critical' => 'red',
    'alert' => 'red',
    'emergency' => 'red',
  ];

  public function __construct(protected $datetimeFormat = 'Y-m-d H:i:s') {}

  protected function colorize($text, $color)
  {
    return "\033[" . $this->colors[$color] . "m" . $text . " \033[0m";
  }

  public function handle(string $level, string $message, array $context = []): void
  {
    $datetime = (new \DateTimeImmutable())->format($this->datetimeFormat);
    $string = $this->colorize("$datetime " . strtoupper($level) . ": $message", $this->levelColors[$level]);

    if (!empty($context)) {
      $string .= "\n" . JSON_ENCODE($context, JSON_PRETTY_PRINT) . "\n";
    }

    error_log($string);
  }
}
