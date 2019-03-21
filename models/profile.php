<?php
namespace AGD\Profiler;
class Profile
{
    public $id;
    public $dateCreated;
    public $initialDate;
    public $finalDate;    
    public $initialResult; 
    public $finalResult;
    public $status;
    public $studentId;
    public $userId;
    public $sdExam;
    public $dsExam;
    public $msExam;
    public $sdInterview;
    public $dsInterview;
    public $msInterview;
    public $studentFirstName;
    public $studentLastName;
    public $email;
    //public $studentNumber;


    public function __construct(array $data)
    {
        if ($data !== null) {
            $this->id = (int) $data['id'] ?? 0;
            $this->dateCreated = $data['dateCreated'] ?? null;
            $this->initialDate = $data['initialDate'] ?? null;
            $this->finalDate = $data['finalDate'] ?? null;
            $this->initialResult = $data['initialResult'] ?? null;
            $this->finalResult = $data['finalResult'] ?? null;
            $this->status = $data['status'] ?? null;
            $this->studentId = $data['studentId'] ?? null;
            $this->userId = $data['userId'] ?? null;
            $this->sdExam = $data['sdExam'] ?? null;
            $this->dsExam = $data['dsExam'] ?? null;
            $this->msExam = $data['msExam'] ?? null;
            $this->sdInterview = $data['sdInterview'] ?? null;
            $this->dsInterview = $data['dsInterview'] ?? null;
            $this->msInterview = $data['msInterview'] ?? null;
            $this->studentFirstName = $data['firstName'] ?? null;
            $this->studentLastName = $data['lastName'] ?? null;
            $this->email = $data['email'] ?? null;        
            //$this->studentNumber = $data['studentNumber'] ?? null;
        }
    }
}