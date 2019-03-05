<?php
namespace AGD\Profiler;
class Profile
{
    public $id;
    public $dateCreated;
    public $stageOneDate;
    public $stageTwoDate;    
    public $stageOneResult; 
    public $stageTwoResult;
    public $finalResult;
    public $status;
    public $studentId;
    public $userId;

    public function __construct(array $data)
    {
        if ($data !== null) {
            $this->id = (int) $data['id'] ?? 0;
            $this->dateCreated = $data['dateCreated'] ?? null;
            $this->stageOneDate = $data['stageOneDate'] ?? null;
            $this->stageTwoDate = $data['stageTwoDate'] ?? null;
            $this->stageOneResult = $data['stageOneResult'] ?? null;
            $this->stageTwoResult = $data['stageTwoResult'] ?? null;
            $this->finalResult = $data['finalResult'] ?? null;
            $this->status = $data['status'] ?? null;
            $this->studentId = $data['studentId'] ?? null;
            $this->userId = $data['userId'] ?? null;
        }
    }
}