<?php
namespace AGD\Profiler;
class User
{
    public $id;
    public $firstName;
    public $lastName;    
    public $position; 
    public $email;
    public $username;
    public $password;

    public function __construct(array $data)
    {
        if ($data !== null) {
            $this->id = (int) $data['id'] ?? 0;
            $this->firstName = $data['firstName'] ?? null;
            $this->lastName = $data['lastName'] ?? null;
            $this->position = $data['position'] ?? null;
            $this->email = $data['email'] ?? null;
            $this->username = $data['username'] ?? null;
            $this->password = $data['password'] ?? null;
        }
    }
}