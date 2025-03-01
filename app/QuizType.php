<?php

namespace App;

class QuizType
{
    public static $Beginner;
    public static $Intermediate;
    public static $Advanced;
    public static $Expert;
    public static $Master;

    public static function init()
    {
        static::$Beginner = [
            'name' => 'Beginner',
            'description' => 'This is a beginner quiz',
            'no_of_que' => 6,
            'time' => "1 min 30 sec",
            'level' => 1
        ];
        static::$Intermediate = [
            'name' => 'Intermediate',
            'description' => 'This is an intermediate quiz',
            'no_of_que' => 10,
            'time' => "2 min 30 sec",
            'level' => 2
        ];
        static::$Advanced = [
            'name' => 'Advanced',
            'description' => 'This is an advanced quiz',
            'no_of_que' => 15,
            'time' => "3 min 30 sec",
            'level' => 3
        ];
        static::$Expert = [
            'name' => 'Expert',
            'description' => 'This is an expert quiz',
            'no_of_que' => 20,
            'time' => "5 min",
            'level' => 4
        ];
        static::$Master = [
            'name' => 'Master',
            'description' => 'This is a master quiz',
            'no_of_que' => 25,
            'time' => "10 min",
            'level' => 5
        ];
    }

    public static function getQuiz($level)
    {
        switch ($level) {
            case 1:
                return static::$Beginner;
            case 2:
                return static::$Intermediate;
            case 3:
                return static::$Advanced;
            case 4:
                return static::$Expert;
            case 5:
                return static::$Master;
            default:
                return null;
        }
    }
}

// Initialize static properties
QuizType::init();
