<?php
namespace AGD\Profiler;
class Grade
{
    public $id;
    public $courseId;
    public $studentId;
    public $value;    
    public $term; 
    public $year;

    public function __construct(array $data)
    {
        if ($data !== null) {
            $this->id = (int) $data['id'] ?? 0;
            $this->courseId = $data['courseId'] ?? null;
            $this->studentId = $data['studentId'] ?? null;
            $this->value = $data['value'] ?? null;
            $this->term = $data['term'] ?? null;
            $this->year = $data['year'] ?? null;
        }
    }
}