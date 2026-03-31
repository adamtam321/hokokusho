<?php
class Student
{
    private $id;
    private $name;
    private $email;
    private $student_code;
    private $gender;
    private $status;
    public function __construct($_name, $_email, $_student_code, $_gender, $_status)
    {
        $this->name = $_name;
        $this->email = $_email;
        $this->student_code = $_student_code;
        $this->gender = $_gender;
        $this->status = $$_status;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }
    public function getStudentCode()
    {
        return $this->student_code;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getGender()
    {
        return $this->gender;
    }

    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
}
