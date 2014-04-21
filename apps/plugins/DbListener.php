<?php

class DbListener
{
    protected $_logger;

    public function __construct()
    {
        $logfile = APP_PATH . '/logs/db_'. date('Y_m_d') .'.log';
        $this->_logger = new \Phalcon\Logger\Adapter\File($logfile);

        $this->_profiler = new \Phalcon\Db\Profiler();
    }

    public function beforeQuery($event, $connection)
    {
        $this->_profiler->startProfile($connection->getSQLStatement());
    }

    public function afterQuery($event, $connection)
    {
        $this->_logger->log($connection->getSQLStatement(), \Phalcon\Logger::INFO);
        $this->_profiler->stopProfile();
    }

    public function getProfiler()
    {
        return $this->_profiler;
    }

    public function getProfilerInfo(){
        foreach($this->_profiler->getProfiles() as $profile){
            echo "SQL Statement: ", $profile->getSQLStatement(), "<br />";
            echo "Start Time: ", $profile->getInitialTime(), "<br />";
            echo "Final Time: ", $profile->getFinalTime(), "<br />";
            echo "Total Elapsed Time: ", $profile->getTotalElapsedSeconds(), "<br />";
        }
    }
}