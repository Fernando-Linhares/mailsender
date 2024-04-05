<?php

namespace Fernando\Mailsender;

class Dotenv
{
    private static array $vars = [];

    public function __construct()
    {
        if(empty(self::$vars)) {
            $content = file_get_contents('.env');

            foreach(explode("\n", $content) as $row) {
                [$key, $value] = explode('=', $row);
                self::$vars[$key] = $value;
            }
        }
    }

    public function get(string $var)
    {
        return self::$vars[$var];
    }
}