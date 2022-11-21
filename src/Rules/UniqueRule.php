<?php

namespace App\Rules;

use App\Classes\DB;
use Rakit\Validation\MissingRequiredParameterException;
use Rakit\Validation\Rule;

class UniqueRule extends Rule
{
    protected $message = ":attribute :value is not unique.";

    protected $fillableParams = ['table', 'column', 'exceptId'];

    /**
     * @throws MissingRequiredParameterException
     */
    public function check($value): bool
    {
        $this->requireParameters(['table']);

        $exceptId = $this->parameter('exceptId');
        $column = $this->parameter('column') ?? $this->getAttribute()?->getKey() ?? 'id';
        $table = $this->parameter('table');

        $query = 'SELECT id FROM ' . $table . ' WHERE ' . $column . ' = :value';

        $params = [
            'value' => $value
        ];

        if ($exceptId) {
            $query .= ' AND id <> :exceptId';
            $params['exceptId'] = $exceptId;
        }

        $data = DB::fetch($query, $params);

        return !isset($data['id']);
    }
}