<?php

namespace Logger;

class Sentry
{
	public function __construct($client)
	{
    $this->client = $client;
	}

  /**
   * Log a message to sentry
   * @param  string $level   Message level (debug, info, warning, error, fatal)
   * @param  string $message Message to log
   * @param  array  $data    Additional logging data (key => value)
   * @return null
   */
  protected function log($level, $message, $data = array())
  {
    $this->client->captureMessage($message, array("log"), array(
      "extra" => $data,
      "level" => $level
    ));
  }

  public function addDebug($message, $data = array())
  {
    return $this->log("debug", $message, $data);
  }

	public function addInfo($message, $data = array())
  {
    return $this->log("info", $message, $data);
  }

	public function addWarning($message, $data = array())
  {
    return $this->log("warning", $message, $data);
  }

	public function addError($message, $data = array())
  {
    return $this->log("error", $message, $data);
  }

  public function addFatal($message, $data = array())
  {
    return $this->log("fatal", $message, $data);
  }

}
