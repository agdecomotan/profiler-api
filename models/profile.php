<?php
namespace AGD\Profiler;
class Profile
{
    public $id;
    public $dateCreated;
    public $initialDate;
    public $finalDate;    
    public $initialResultRank; 
    public $initialResult1; 
    public $initialResult2; 
    public $initialResult3; 
    public $finalResultRank;
    public $studentChoice;
    public $finalResult1;
    public $finalResult2;
    public $finalResult3;
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
    public $studentNumber;
    public $gender;


    public function __construct(array $data)
    {
        if ($data !== null) {
            $this->id = (int) $data['id'] ?? 0;
            $this->dateCreated = $data['dateCreated'] ?? null;
            $this->initialDate = $data['initialDate'] ?? null;
            $this->finalDate = $data['finalDate'] ?? null;
            $this->initialResultRank = $data['initialResultRank'] ?? null;
            $this->initialResult1 = $data['initialResult1'] ?? null;
            $this->initialResult2 = $data['initialResult2'] ?? null;
            $this->initialResult3 = $data['initialResult3'] ?? null;
            $this->finalResultRank = $data['finalResultRank'] ?? null;
            $this->studentChoice = $data['studentChoice'] ?? null;
            $this->finalResult1 = $data['finalResult1'] ?? null;
            $this->finalResult2 = $data['finalResult2'] ?? null;
            $this->finalResult3 = $data['finalResult3'] ?? null;
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
            $this->studentNumber = $data['studentNumber'] ?? null;
            $this->gender = $data['gender'] ?? null;
        }
    }
}