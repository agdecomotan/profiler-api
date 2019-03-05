<?php
namespace AGD\Profiler;
class Course
{
    public $id;
    public $courseNumber;
    public $title;
    public $specialization;    
    public $credit; 
    public $active;

    public function __construct(array $data)
    {
        if ($data !== null) {
            $this->id = (int) $data['id'] ?? 0;
            $this->courseNumber = $data['courseNumber'] ?? null;
            $this->title = $data['title'] ?? null;
            $this->specialization = $data['specialization'] ?? null;
            $this->credit = $data['credit'] ?? null;
            $this->active = $data['active'] ?? null;
        }
    }
}