<?php
namespace Xypw\Lapshop\Service;
class Debug {
    private $timeStamp;
    private $timePrefix = '';
    private $logEntries;
    public function __construct()
    {
        $this->timeStamp = (new \DateTime())->getTimestamp();
        $this->timePrefix = substr($this->timeStamp, -6);
        $this->logEntries = [];
    }

    /**
     * @param string|array $data
     * @return void
     */
    public function writeToLog($data, $enableBacktrace = 0):void {
        if(!is_array($data))
            $data = [$data];
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 4);
        $dateTime = new \Bitrix\Main\Type\DateTime();
        $data['TIME_PREFIX'] = $this->timePrefix;
        if($enableBacktrace)
            $data = $dateTime->toString() . ' ' . print_r($data, true) . '\n' . print_r($backtrace, true) . PHP_EOL;
        else
            $data = $dateTime->toString() . ' ' . print_r($data, true) . PHP_EOL;

        file_put_contents($this->getLogFileName(), $data, FILE_APPEND | LOCK_EX);
    }

    public function addLogEntry($str, $key = '') {
        if($key)
            $this->logEntries[$key] = $str;
        else
            $this->logEntries[] = $str;
    }
    public function writeLogEntries() {
        $this->writeToLog($this->logEntries);
    }

    private function getLogFileName(): string
    {
        return $_SERVER['DOCUMENT_ROOT'] . '/local/' . '/modules/' . GetModuleID(__FILE__) . '/logLapshop.log';
    }

}