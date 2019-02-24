<?php
namespace AGD\Profiler;
class Student
{
    public $id;
    public $studentNumber;
    public $firstName;
    public $lastName;    
    public $yearLevel; 
    public $program;
    public $email;

    public function __construct(array $data)
    {
        echo $data;
        if ($data !== null) {
            $this->id = (int) $data['id'] ?? 0;
            $this->studentNumber = $data['studentNumber'] ?? null;
            $this->firstName = $data['firstName'] ?? null;
            $this->lastName = $data['lastName'] ?? null;
            $this->yearLevel = $data['yearLevel'] ?? null;
            $this->program = $data['program'] ?? null;
            $this->email = $data['email'] ?? null;
        }
    }
}