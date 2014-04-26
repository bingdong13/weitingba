<?php

use \Phalcon\Mvc\User\Plugin as PhPlugin,
    \Phalcon\Logger\Adapter\File as FileAdapter;

class DbListener extends PhPlugin
{

    public function __construct()
    {
        $this->_profiler = new \Phalcon\Db\Profiler();
    }

    public function beforeQuery($event, $connection)
    {
        $this->_profiler->startProfile($connection->getSQLStatement());
    }

    public function afterQuery($event, $connection)
    {
        $logger = new FileAdapter($this->config->log->db);
        $logger->info($connection->getSQLStatement());
        
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