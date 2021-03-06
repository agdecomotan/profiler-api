<?php
namespace AGD\Profiler;
class Student
{
    public $id;
    public $studentNumber;
    public $firstName;
    public $lastName;    
    public $yearLevel; 
    public $gender; 
    public $program;
    public $email;
    public $datecreated;

    public function __construct(array $data)
    {
        if ($data !== null) {
            $this->id = (int) $data['id'] ?? 0;
            $this->studentNumber = $data['studentNumber'] ?? null;
            $this->firstName = $data['firstName'] ?? null;
            $this->lastName = $data['lastName'] ?? null;
            $this->yearLevel = $data['yearLevel'] ?? null;
            $this->gender = $data['gender'] ?? null;
            $this->program = $data['program'] ?? null;
            $this->email = $data['email'] ?? null;
            $this->datecreated = $data['datecreated'] ?? null;
        }
    }
}