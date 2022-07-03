<?php

namespace FatemeMahmoodi\LaravelToDo\Enums;

class TaskStatus
{
    const OPEN = 1;
    const CLOSE = 2;
    const ALL = [
        self::OPEN,
        self::CLOSE
    ];


}
