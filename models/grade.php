<?php
namespace AGD\Profiler;
class Grade
{
    public $id;
    public $courseId;
    public $studentId;
    public $title;
    public $value;    
    public $term; 
    public $year;
    public $courseSpecialization;

    public function __construct(array $data)
    {
        if ($data !== null) {
            $this->id = (int) $data['id'] ?? 0;
            $this->courseId = $data['courseId'] ?? null;
            $this->studentId = $data['studentId'] ?? null;
            $this->title = $data['title'] ?? null;
            $this->value = $data['value'] ?? null;
            $this->term = $data['term'] ?? null;
            $this->year = $data['year'] ?? null;
            $this->courseSpecialization = $data['specialization'] ?? null;
        }
    }
}