<?php

namespace Logger;

class CommandLine implements LoggerInterface
{
  public $foregroundColors = [
    'debug' => '0;36',    // cyan
    'info' => '0;36',     // cyan
    'warning' => '1;33',  // yellow
    'error' => '0;31',    // red
    'fatal' => '0;31'     // red
  ];

  public $backgroundColors = [
    'debug' => '40',
    'info' => '40',
    'warning' => '40',
    'error' => '40',
    'fatal' => '40'
  ];

  /**
   * Log a message to the command line
   * @param  string $level   Message level (debug, info, warning, error, fatal)
   * @param  string $message Message to log
   * @param  array  $data    Additional logging data (key => value)
   * @return null
   */
  protected function log($level, $message, array $data = [])
  {
    $string = "";

    if (isset($this->foregroundColors[$level])) {
      $string .= "\033[" . $this->foregroundColors[$level] . "m";
    }

    if (isset($this->backgroundColors[$level])) {
      $string .= "\033[" . $this->backgroundColors[$level] . "m";
    }

    $string .=  strtoupper($level) . "\033[0m" . " {$message}\n";
    echo $string;

  }

  public function addDebug($message, array $data = [])
  {
    return $this->log("debug", $message, $data);
  }

	public function addInfo($message, array $data = [])
  {
    return $this->log("info", $message, $data);
  }

	public function addWarning($message, array $data = [])
  {
    return $this->log("warning", $message, $data);
  }

	public function addError($message, array $data = [])
  {
    return $this->log("error", $message, $data);
  }

  public function addFatal($message, array $data = [])
  {
    return $this->log("fatal", $message, $data);
  }

}
