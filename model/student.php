<?php
namespace AGD\Profiler;

class Student
{
    public $id;
    public $number;
    public $firstname;
    public $lastname;    
    public $yearlevel; 
    public $program;
    public $email;

    public function __construct(array $data)
    {
        if ($data !== null) {
            $this->id = (int) $data['id'] ?? 0;
            $this->number = $data['number'] ?? null;
            $this->firstname = $data['firstname'] ?? null;
            $this->lastname = $data['lastname'] ?? null;
            $this->yearlevel = $data['yearlevel'] ?? null;
            $this->program = $data['program'] ?? null;
            $this->email = $data['email'] ?? null;
        }
    }
}