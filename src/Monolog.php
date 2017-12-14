<?php

namespace Logger;

class Monolog implements LoggerInterface
{
	public function __construct($client)
	{
    $this->client = $client;
	}

  /**
   * Log a message to monolog
   * @param  string $level   Message level
   * @param  string $message Message to log
   * @param  array  $data    Additional logging data (key => value)
   * @return null
   */
  protected function log($level, $message, array $data = [])
  {
    $this->client->log($level, $message, $data);
  }

  public function addDebug($message, array $data = [])
  {
    return $this->log(100, $message, $data);
  }

	public function addInfo($message, array $data = [])
  {
    return $this->log(200, $message, $data);
  }

	public function addWarning($message, array $data = [])
  {
    return $this->log(300, $message, $data);
  }

	public function addError($message, array $data = [])
  {
    return $this->log(400, $message, $data);
  }

  public function addFatal($message, array $data = [])
  {
    return $this->log(500, $message, $data);
  }

}
