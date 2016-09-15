<?php

namespace Logger;

class Logger
{
	protected $niceName;
	protected $machineName;
	protected $logfile;

	public function __construct($niceName, $machineName, $localFile, $stagingFile, $productionFile, $cache = null)
	{
		$this->niceName = $niceName;
		$this->machineName = $machineName;
		$this->cache = $cache;

		$this->logger = new \Monolog\Logger($this->machineName);

		if (ENV == "local") {
			$this->logfile = $localFile;
		} else if (ENV == "staging") {
			$this->logfile = $stagingFile;
		} else if (ENV == "beta") {
			$this->logfile = $productionFile;
		} else {
			$this->logfile = $productionFile;
		}

		$this->setupStreamHandler();

		if (ENV != "local") {
			$this->setupEmailHandler();
		}
	}

  public function get()
  {
    return new \LoggerExchange\adapters\Monolog($this->logger, $this->cache);
  }

	protected function setupStreamHandler()
	{
		// make sure file is writable before creating handler
		if (is_writable($this->logfile)) {
			$handler = new \Monolog\Handler\StreamHandler($this->logfile, \Monolog\Logger::DEBUG);
			$this->logger->pushHandler($handler);
		}
	}

	protected function setupEmailHandler()
	{
		$transport = \Swift_MailTransport::newInstance();
		$mailer = \Swift_Mailer::newInstance($transport);
		$message = \Swift_Message::newInstance()
			->setSubject("Error on {$this->niceName}")
			->setFrom(array("noreply@jhu.edu" => "jhu.edu"))
			->setTo(array("jwachter@jhu.edu"));

		$this->logger->pushHandler(new \Monolog\Handler\SwiftMailerHandler($mailer, $message, \Monolog\Logger::WARNING));
	}

}
