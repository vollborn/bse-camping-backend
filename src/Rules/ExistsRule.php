<?php

namespace App\Rules;

use App\Classes\DB;
use Rakit\Validation\MissingRequiredParameterException;
use Rakit\Validation\Rule;

class ExistsRule extends Rule
{
    protected $message = ":attribute :value does not exist.";

    protected $fillableParams = ['table', 'column'];

    /**
     * @throws MissingRequiredParameterException
     */
    public function check($value): bool
    {
        $this->requireParameters(['table']);

        $column = $this->parameter('column') ?? 'id';
        $table = $this->parameter('table');

        $data = DB::fetch('SELECT id FROM ' . $table . ' WHERE ' . $column . ' = :value', [
            'value' => $value
        ]);

        return isset($data['id']);
    }
}