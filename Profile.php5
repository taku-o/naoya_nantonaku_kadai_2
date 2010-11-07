<?php
class Profile
{
    public $name;
    public $hit_point;
    public $magic_point;
    public $job;
    public $my_calling;
}

class ProfileFactory
{
    const config_file = "profile.ini";
    private static $instance = false;
    private $config = false;
    private $loaded = array();

    private function ProfileFactory()
    {
        $this->config = parse_ini_file(self::config_file, true);
        if (empty($this->config))
        {
            trigger_error("config:".self::config_file. " is not found.");
        }
    }

    public static function getInstance()
    {
        if (empty(self::$instance))
        {
            self::$instance = new ProfileFactory();
        }
        return self::$instance;
    }

    public function getProfile($id)
    {
        if (empty($this->loaded[$id]) == false)
        {
            return $this->loaded[$id];
        }

        $user_config = $this->config[$id];
        if (empty($user_config))
        {
            trigger_error("profile:$id is not found.");
        }

        $profile = new Profile();
        $profile->name = $user_config["name"];
        $profile->hit_point = $user_config["hit_point"];
        $profile->magic_point = $user_config["magic_point"];
        $profile->my_calling = $user_config["my_calling"];

        $jobFactory = JobFactory::getInstance();
        $profile->job = $jobFactory->getJob($user_config["job"]);

        $this->loaded[$id] = $profile;
        return $profile;
    }
}
