<?php

namespace JobBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ResumeEducation
 *
 * @ORM\Table(name="resume_education")
 * @ORM\Entity(repositoryClass="JobBundle\Repository\resumeEducationRepository")
 */
class ResumeEducation
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="\JobBundle\Entity\JobSeekerResume")
     * @ORM\JoinColumn(name="resumeId", referencedColumnName="id")
     */
    private $resumeId;

    /**
     * @var string
     *
     * @ORM\Column(name="collegeSchool", type="string", length=100)
     */
    private $collegeSchool;

    /**
     * @var string
     *
     * @ORM\Column(name="universityBoard", type="string", length=100)
     */
    private $universityBoard;

    /**
     * @ORM\ManyToOne(targetEntity="\JobBundle\Entity\EducationLevel")
     * @ORM\JoinColumn(name="educationLevelId", referencedColumnName="id")
     */
    private $educationLevelId;

    /**
     * @var string
     *
     * @ORM\Column(name="course", type="string", length=100)
     */
    private $course;

    /**
     * @var string
     *
     * @ORM\Column(name="specialisation", type="string", length=100)
     */
    private $specialisation;

    /**
     * @var string
     *
     * @ORM\Column(name="gpaPercentage", type="string", length=1)
     */
    private $gpaPercentage;

    /**
     * @var string
     *
     * @ORM\Column(name="result", type="string", length=10)
     */
    private $result;
    
    /**
     * @var string
     *
     * @ORM\Column(name="aditionalInfo", type="text", nullable=true)
     */
    private $aditionalInfo;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fromDate", type="datetime")
     */
    private $fromDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="toDate", type="datetime")
     */
    private $toDate;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set collegeSchool
     *
     * @param string $collegeSchool
     *
     * @return ResumeEducation
     */
    public function setCollegeSchool($collegeSchool)
    {
        $this->collegeSchool = $collegeSchool;

        return $this;
    }

    /**
     * Get collegeSchool
     *
     * @return string
     */
    public function getCollegeSchool()
    {
        return $this->collegeSchool;
    }

    /**
     * Set universityBoard
     *
     * @param string $universityBoard
     *
     * @return ResumeEducation
     */
    public function setUniversityBoard($universityBoard)
    {
        $this->universityBoard = $universityBoard;

        return $this;
    }

    /**
     * Get universityBoard
     *
     * @return string
     */
    public function getUniversityBoard()
    {
        return $this->universityBoard;
    }

    /**
     * Set course
     *
     * @param string $course
     *
     * @return ResumeEducation
     */
    public function setCourse($course)
    {
        $this->course = $course;

        return $this;
    }

    /**
     * Get course
     *
     * @return string
     */
    public function getCourse()
    {
        return $this->course;
    }

    /**
     * Set specialisation
     *
     * @param string $specialisation
     *
     * @return ResumeEducation
     */
    public function setSpecialisation($specialisation)
    {
        $this->specialisation = $specialisation;

        return $this;
    }

    /**
     * Get specialisation
     *
     * @return string
     */
    public function getSpecialisation()
    {
        return $this->specialisation;
    }

    /**
     * Set gpaPercentage
     *
     * @param string $gpaPercentage
     *
     * @return ResumeEducation
     */
    public function setGpaPercentage($gpaPercentage)
    {
        $this->gpaPercentage = $gpaPercentage;

        return $this;
    }

    /**
     * Get gpaPercentage
     *
     * @return string
     */
    public function getGpaPercentage()
    {
        return $this->gpaPercentage;
    }

    /**
     * Set result
     *
     * @param string $result
     *
     * @return ResumeEducation
     */
    public function setResult($result)
    {
        $this->result = $result;

        return $this;
    }

    /**
     * Get result
     *
     * @return string
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * Set aditionalInfo
     *
     * @param string $aditionalInfo
     *
     * @return ResumeEducation
     */
    public function setAditionalInfo($aditionalInfo)
    {
        $this->aditionalInfo = $aditionalInfo;

        return $this;
    }

    /**
     * Get aditionalInfo
     *
     * @return string
     */
    public function getAditionalInfo()
    {
        return $this->aditionalInfo;
    }

    /**
     * Set fromDate
     *
     * @param \DateTime $fromDate
     *
     * @return ResumeEducation
     */
    public function setFromDate($fromDate)
    {
        $this->fromDate = $fromDate;

        return $this;
    }

    /**
     * Get fromDate
     *
     * @return \DateTime
     */
    public function getFromDate()
    {
        return $this->fromDate;
    }

    /**
     * Set toDate
     *
     * @param \DateTime $toDate
     *
     * @return ResumeEducation
     */
    public function setToDate($toDate)
    {
        $this->toDate = $toDate;

        return $this;
    }

    /**
     * Get toDate
     *
     * @return \DateTime
     */
    public function getToDate()
    {
        return $this->toDate;
    }

    /**
     * Set resumeId
     *
     * @param \JobBundle\Entity\JobSeekerResume $resumeId
     *
     * @return ResumeEducation
     */
    public function setResumeId(\JobBundle\Entity\JobSeekerResume $resumeId = null)
    {
        $this->resumeId = $resumeId;

        return $this;
    }

    /**
     * Get resumeId
     *
     * @return \JobBundle\Entity\JobSeekerResume
     */
    public function getResumeId()
    {
        return $this->resumeId;
    }

    /**
     * Set educationLevelId
     *
     * @param \JobBundle\Entity\EducationLevel $educationLevelId
     *
     * @return ResumeEducation
     */
    public function setEducationLevelId(\JobBundle\Entity\EducationLevel $educationLevelId = null)
    {
        $this->educationLevelId = $educationLevelId;

        return $this;
    }

    /**
     * Get educationLevelId
     *
     * @return \JobBundle\Entity\EducationLevel
     */
    public function getEducationLevelId()
    {
        return $this->educationLevelId;
    }
}
