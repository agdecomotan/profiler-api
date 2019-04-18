<?php
namespace AGD\Profiler;
class Setting
{
    public $id;
    public $name;
    public $value;    

    public function __construct(array $data)
    {
        if ($data !== null) {
            $this->id = (int) $data['id'] ?? 0;
            $this->name = $data['name'] ?? null;
            $this->value = $data['value'] ?? null;
        }
    }
}