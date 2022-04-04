<?php

namespace App\Models;

use App\Config\Database;

abstract class AbstractModel extends Database
{
    abstract protected function read();
    abstract protected function create();
    abstract protected function delete();
}