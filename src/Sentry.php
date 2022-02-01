<?php

namespace Logger;

class Sentry implements LoggerInterface
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
  protected function log($level, $message, array $data = [])
  {
		$compiled = ['level' => $level];

		if (isset($data['tags'])) {
			$compiled['tags'] = $data['tags'];
			unset($data['tags']);
		}

		// // throw the rest into extra
		// $compiled['extra'] = $data;

    return $this->client->captureMessage($message, $data, $compiled);
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
