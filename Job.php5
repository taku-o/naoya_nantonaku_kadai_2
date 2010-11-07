<?php
class Job
{
    public $id;
    public $name;
    public $features_message;
}

class JobFactory
{
    const config_file = "job.ini";
    private static $instance = false;
    private $config = false;
    private $loaded = array();

    private function JobFactory()
    {
        $this->config = parse_ini_file(self::config_file, true);
        if (empty($this->config))
        {
            trigger_error("config:". self::config_file. " is not found.");
        }
    }

    public static function getInstance()
    {
        if (empty(self::$instance))
        {
            self::$instance = new JobFactory();
        }
        return self::$instance;
    }

    public function getJob($id)
    {
        if (empty($this->loaded[$id]) == false)
        {
            return $this->loaded[$id];
        }

        $job_config = $this->config[$id];
        if (empty($job_config))
        {
            trigger_error("job:$id is not found.");
        }

        $job = new Job();
        $job->id = $job_config["id"];
        $job->name = $job_config["name"];
        $job->features_message = $job_config["features_message"];

        $this->loaded[$id] = $job;
        return $job;
    }
}
