<?php

namespace Logger\Handler;

class SentryHandler implements HandlerInterface
{
  public function __construct($dsn, $options = [])
  {
    \Sentry\init(array_merge($options, ['dsn' => $dsn]));
  }

  public function handle(string $level, string $message, array $context = []): void
  {
    if (in_array($level, ['critical', 'alert', 'emergency'])) {
      // sentry only has fatal level
      $level = 'fatal';
    }

    \Sentry\withScope(function (\Sentry\State\Scope $scope) use ($level, $message, $context): void {

      $scope->setLevel(\Sentry\Severity::$level());

      if (isset($context['context']) && is_array($context['context'])) {
        // note: that data WILL get clipped, so limit what you send to relevant data only
        // docs: https://docs.sentry.io/platforms/php/enriching-events/context/#size-limitations
        $scope->setContext('app context', $context['context']);
      }

      if (isset($context['tags']) && is_array($context['context'])) {
        // examples: wp.theme, wp.plugin
        // docs: https://docs.sentry.io/platforms/php/enriching-events/tags/
        foreach ($context['tags'] as $key => $value) {
          $scope->setTag($key, $value);
        }
      }

      \Sentry\captureMessage($message);
    });
  }
}
