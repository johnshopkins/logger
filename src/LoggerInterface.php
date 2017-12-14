<?php

namespace Logger;

interface LoggerInterface
{
  public function addDebug($message, array $data = []);
	public function addInfo($message, array $data = []);
	public function addWarning($message, array $data = []);
	public function addError($message, array $data = []);
  public function addFatal($message, array $data = []);
}
