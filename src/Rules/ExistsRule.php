<?php

namespace App\Rules;

use App\Classes\DB;
use Rakit\Validation\Rule;

class ExistsRule extends Rule
{
    protected $message = ":attribute :value does not exist.";

    protected $fillableParams = ['table', 'column'];

    public function check($value): bool
    {
        if ((int) $value != $value) {
            return false;
        }

        $this->requireParameters(['table']);

        $column = $this->parameter('column') ?? 'id';
        $table = $this->parameter('table');

        $data = DB::fetch('SELECT id FROM ' . $table . ' WHERE ' . $column . ' = ' . (int) $value);

        return isset($data['id']);
    }
}