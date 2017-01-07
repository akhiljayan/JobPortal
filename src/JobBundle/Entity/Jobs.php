<?php

namespace JobBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Jobs
 *
 * @ORM\Table(name="jobs")
 * @ORM\Entity(repositoryClass="JobBundle\Repository\JobsRepository")
 */
class Jobs
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
     * @var string
     *
     * @ORM\Column(name="job_title", type="string", length=100)
     */
    private $jobTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="company", type="string", length=200)
     */
    private $company;
    
     /**
     * @var string
     *
     * @ORM\Column(name="location", type="string", length=100)
     */
    private $location;

    /**
     * @var int
     *
     * @ORM\Column(name="exper_year_from", type="integer")
     */
    private $experYearFrom;

    /**
     * @var string
     *
     * @ORM\Column(name="expr_year_to",  type="integer")
     */
    private $exprYearTo;

    /**
     * @var string
     *
     * @ORM\Column(name="job_description", type="text")
     */
    private $jobDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="responsibilities", type="text",nullable=true)
     */
    private $responsibilities;

    /**
     * @var int
     *
     * @ORM\Column(name="slary_start", type="integer",nullable=true)
     */
    private $slaryStart;

    /**
     * @var int
     *
     * @ORM\Column(name="salary_to", type="integer",nullable=true)
     */
    private $salaryTo;

    /**
     * @ORM\ManyToOne(targetEntity="\JobBundle\Entity\JobCategory")
     * @ORM\JoinColumn(name="category", referencedColumnName="id")
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="\JobBundle\Entity\JobSubCategory")
     * @ORM\JoinColumn(name="sub_category", referencedColumnName="id")
     */
    private $subCategory;

    /**
     * @var string
     *
     * @ORM\Column(name="job_designation", type="string", length=100)
     */
    private $jobDesignation;

    /**
     * @var string
     *
     * @ORM\Column(name="skills_required", type="text", nullable=true)
     */
    private $skillsRequired;

    /**
     * @var string
     *
     * @ORM\Column(name="qualification", type="text",nullable=true)
     */
    private $qualification;

    /**
     * @var bool
     *
     * @ORM\Column(name="status", type="boolean")
     */
    private $status;

    /**
     * @var bool
     *
     * @ORM\Column(name="priority", type="boolean")
     */
    private $priority;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="added_date", type="datetime")
     */
    private $addedDate;

    /**
     * @var int
     *
     * @ORM\Column(name="vacancy", type="integer")
     */
    private $vacancy;

     /**
     * @ORM\ManyToOne(targetEntity="\AkjnBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $addedByUser;
    
    /**
     * @ORM\Column(type="string", length=32, name="gu_id", unique=true)
     */
    private $guId;
    
    /**
     * @ORM\Column(name="image", type="blob",nullable=true)
     */
    private $image;
    
     /**
     * @var bool
     *
     * @ORM\Column(name="front_page_visible", type="boolean")
     */
    private $frontPageVisible;
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->guId = md5(uniqid(php_uname('n')));
        $this->status = TRUE;
        $this->priority = FALSE;
        $this->frontPageVisible = FALSE;
        $this->addedDate = new \DateTime('now');
    }

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
     * Set jobTitle
     *
     * @param string $jobTitle
     *
     * @return Jobs
     */
    public function setJobTitle($jobTitle)
    {
        $this->jobTitle = $jobTitle;

        return $this;
    }

    /**
     * Get jobTitle
     *
     * @return string
     */
    public function getJobTitle()
    {
        return $this->jobTitle;
    }

    /**
     * Set company
     *
     * @param string $company
     *
     * @return Jobs
     */
    public function setCompany($company)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company
     *
     * @return string
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set experYearFrom
     *
     * @param integer $experYearFrom
     *
     * @return Jobs
     */
    public function setExperYearFrom($experYearFrom)
    {
        $this->experYearFrom = $experYearFrom;

        return $this;
    }

    /**
     * Get experYearFrom
     *
     * @return integer
     */
    public function getExperYearFrom()
    {
        return $this->experYearFrom;
    }

    /**
     * Set exprYearTo
     *
     * @param integer $exprYearTo
     *
     * @return Jobs
     */
    public function setExprYearTo($exprYearTo)
    {
        $this->exprYearTo = $exprYearTo;

        return $this;
    }

    /**
     * Get exprYearTo
     *
     * @return integer
     */
    public function getExprYearTo()
    {
        return $this->exprYearTo;
    }

    /**
     * Set jobDescription
     *
     * @param string $jobDescription
     *
     * @return Jobs
     */
    public function setJobDescription($jobDescription)
    {
        $this->jobDescription = $jobDescription;

        return $this;
    }

    /**
     * Get jobDescription
     *
     * @return string
     */
    public function getJobDescription()
    {
        return $this->jobDescription;
    }

    /**
     * Set responsibilities
     *
     * @param string $responsibilities
     *
     * @return Jobs
     */
    public function setResponsibilities($responsibilities)
    {
        $this->responsibilities = $responsibilities;

        return $this;
    }

    /**
     * Get responsibilities
     *
     * @return string
     */
    public function getResponsibilities()
    {
        return $this->responsibilities;
    }

    /**
     * Set slaryStart
     *
     * @param integer $slaryStart
     *
     * @return Jobs
     */
    public function setSlaryStart($slaryStart)
    {
        $this->slaryStart = $slaryStart;

        return $this;
    }

    /**
     * Get slaryStart
     *
     * @return integer
     */
    public function getSlaryStart()
    {
        return $this->slaryStart;
    }

    /**
     * Set salaryTo
     *
     * @param integer $salaryTo
     *
     * @return Jobs
     */
    public function setSalaryTo($salaryTo)
    {
        $this->salaryTo = $salaryTo;

        return $this;
    }

    /**
     * Get salaryTo
     *
     * @return integer
     */
    public function getSalaryTo()
    {
        return $this->salaryTo;
    }

    /**
     * Set jobDesignation
     *
     * @param string $jobDesignation
     *
     * @return Jobs
     */
    public function setJobDesignation($jobDesignation)
    {
        $this->jobDesignation = $jobDesignation;

        return $this;
    }

    /**
     * Get jobDesignation
     *
     * @return string
     */
    public function getJobDesignation()
    {
        return $this->jobDesignation;
    }

    /**
     * Set skillsRequired
     *
     * @param string $skillsRequired
     *
     * @return Jobs
     */
    public function setSkillsRequired($skillsRequired)
    {
        $this->skillsRequired = $skillsRequired;

        return $this;
    }

    /**
     * Get skillsRequired
     *
     * @return string
     */
    public function getSkillsRequired()
    {
        return $this->skillsRequired;
    }

    /**
     * Set qualification
     *
     * @param string $qualification
     *
     * @return Jobs
     */
    public function setQualification($qualification)
    {
        $this->qualification = $qualification;

        return $this;
    }

    /**
     * Get qualification
     *
     * @return string
     */
    public function getQualification()
    {
        return $this->qualification;
    }

    /**
     * Set status
     *
     * @param boolean $status
     *
     * @return Jobs
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set priority
     *
     * @param boolean $priority
     *
     * @return Jobs
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * Get priority
     *
     * @return boolean
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * Set addedDate
     *
     * @param \DateTime $addedDate
     *
     * @return Jobs
     */
    public function setAddedDate($addedDate)
    {
        $this->addedDate = $addedDate;

        return $this;
    }

    /**
     * Get addedDate
     *
     * @return \DateTime
     */
    public function getAddedDate()
    {
        return $this->addedDate;
    }

    /**
     * Set vacancy
     *
     * @param integer $vacancy
     *
     * @return Jobs
     */
    public function setVacancy($vacancy)
    {
        $this->vacancy = $vacancy;

        return $this;
    }

    /**
     * Get vacancy
     *
     * @return integer
     */
    public function getVacancy()
    {
        return $this->vacancy;
    }

    /**
     * Set guId
     *
     * @param string $guId
     *
     * @return Jobs
     */
    public function setGuId($guId)
    {
        $this->guId = $guId;

        return $this;
    }

    /**
     * Get guId
     *
     * @return string
     */
    public function getGuId()
    {
        return $this->guId;
    }

    /**
     * Set category
     *
     * @param \JobBundle\Entity\JobCategory $category
     *
     * @return Jobs
     */
    public function setCategory(\JobBundle\Entity\JobCategory $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \JobBundle\Entity\JobCategory
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set subCategory
     *
     * @param \JobBundle\Entity\JobSubCategory $subCategory
     *
     * @return Jobs
     */
    public function setSubCategory(\JobBundle\Entity\JobSubCategory $subCategory = null)
    {
        $this->subCategory = $subCategory;

        return $this;
    }

    /**
     * Get subCategory
     *
     * @return \JobBundle\Entity\JobSubCategory
     */
    public function getSubCategory()
    {
        return $this->subCategory;
    }

    /**
     * Set addedByUser
     *
     * @param \AkjnBundle\Entity\User $addedByUser
     *
     * @return Jobs
     */
    public function setAddedByUser(\AkjnBundle\Entity\User $addedByUser = null)
    {
        $this->addedByUser = $addedByUser;

        return $this;
    }

    /**
     * Get addedByUser
     *
     * @return \AkjnBundle\Entity\User
     */
    public function getAddedByUser()
    {
        return $this->addedByUser;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Jobs
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set location
     *
     * @param string $location
     *
     * @return Jobs
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set frontPageVisible
     *
     * @param boolean $frontPageVisible
     *
     * @return Jobs
     */
    public function setFrontPageVisible($frontPageVisible)
    {
        $this->frontPageVisible = $frontPageVisible;

        return $this;
    }

    /**
     * Get frontPageVisible
     *
     * @return boolean
     */
    public function getFrontPageVisible()
    {
        return $this->frontPageVisible;
    }
}
