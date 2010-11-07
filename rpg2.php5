<?php
require "Job.php5";
require "Profile.php5";

class Rpg
{
    const users_config_file = "users.ini";

    function run()
    {
        $users = $this->getUsers();
        foreach ($users as $u)
        {
            $format = <<< EOF
%s
- %sは「%s」。%s
- HP %d
- MP %d
EOF;
            $message = sprintf(
                $format,
                $u->name, $u->my_calling, $u->job->name, $u->job->features_messag,
                $u->hit_point, $u->magic_point
            );
            echo $message. "\n";
        }
    }

    private function getUsers()
    {
        $config = parse_ini_file(self::users_config_file, true);
        if (empty($config))
        {
            trigger_error("config:". self::users_config_file. " is not found.");
        }

        $profileFactory = ProfileFactory::getInstance();
        $users = array();
        foreach ($config["user"] as $uid) {
            $profile = $profileFactory->getProfile($uid);
            $users[] = $profile;
        }

        return $users;
    }
}

$runner = new Rpg();
$runner->run();
