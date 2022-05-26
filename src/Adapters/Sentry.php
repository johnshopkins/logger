<?php

namespace Logger\Adapters;

use Logger\Interfaces\Logger;

class Sentry implements Logger
{
  public function __construct($dsn, $options = [])
  {
    \Sentry\init(array_merge($options, ['dsn' => $dsn]));
  }

  /**
   * Log a message to sentry
   * @param  string $level   Message level (debug, info, warning, error, fatal)
   * @param  string $message Message to log
   * @param  array  $options Additional data to send to Sentry (tags, context, etc...)
   * @return null
   */
  protected function log(string $level = 'debug', string $message = '', array $data = [])
  {
    \Sentry\withScope(function (\Sentry\State\Scope $scope) use ($level, $message, $data): void {

      $scope->setLevel(\Sentry\Severity::$level());

      if (isset($data['context']) && is_array($data['context'])) {
        // note: that data WILL get clipped, so limit what you send to relevant data only
        // docs: https://docs.sentry.io/platforms/php/enriching-events/context/#size-limitations
        $scope->setContext('app context', $data['context']);
      }

      if (isset($data['tags']) && is_array($data['context'])) {
        // examples: wp.theme, wp.plugin
        // docs: https://docs.sentry.io/platforms/php/enriching-events/tags/
        foreach ($data['tags'] as $key => $value) {
          $scope->setTag($key, $value);
        }
      }

      \Sentry\captureMessage($message);

    });
  }

  public function addDebug($message, array $data = [])
  {
    return $this->log('debug', $message, $data);
  }

  public function addInfo($message, array $data = [])
  {
    return $this->log('info', $message, $data);
  }

  public function addWarning($message, array $data = [])
  {
    return $this->log('warning', $message, $data);
  }

  public function addError($message, array $data = [])
  {
    return $this->log('error', $message, $data);
  }

  public function addFatal($message, array $data = [])
  {
    return $this->log('fatal', $message, $data);
  }

}
