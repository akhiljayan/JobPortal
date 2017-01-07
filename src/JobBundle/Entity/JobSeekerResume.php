<?php

namespace JobBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * JobSeekerResume
 *
 * @ORM\Table(name="job_seeker_resume")
 * @ORM\Entity(repositoryClass="JobBundle\Repository\JobSeekerResumeRepository")
 */
class JobSeekerResume {

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
     * @ORM\Column(name="guId", type="string", length=32, unique=true)
     */
    private $guId;

    /**
     * @ORM\ManyToOne(targetEntity="\JobBundle\Entity\JobSeeker")
     * @ORM\JoinColumn(name="jobSeekerId", referencedColumnName="id")
     */
    private $jobSeekerId;

    /**
     * @var string
     *
     * @ORM\Column(name="resume", type="string", length=100)
     */
    private $resume;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_date", type="datetime")
     */
    private $createdDate;
    
    /**
     * @ORM\OneToMany(targetEntity="\JobBundle\Entity\ResumeEducation", mappedBy="resumeId",cascade={"persist"}, orphanRemoval=true)
     */
    protected $resumeEducation;
    
    /**
     * @ORM\OneToMany(targetEntity="\JobBundle\Entity\WorkExpResume", mappedBy="resumeId",cascade={"persist"}, orphanRemoval=true)
     */
    protected $workExpResume;
    
    /**
     * @var string
     *
     * @ORM\Column(name="aditionalInfo", type="text", nullable=true)
     */
    private $aditionalInfo;
    
    /**
     * @var string
     *
     * @ORM\Column(name="skills", type="text", nullable=true)
     */
    private $skills;
    
    /**
     * @var bool
     *
     * @ORM\Column(name="show_in_front_page", type="boolean")
     */
    private $showInFrontPage;


    /**
     * Constructor
     */
    public function __construct() {
        $this->guId = md5(uniqid(php_uname('n')));
        $this->createdDate = new \DateTime("now");
        $this->resumeEducation = new ArrayCollection();
        $this->workExpResume = new ArrayCollection();
        $this->showInFrontPage = false;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set guId
     *
     * @param string $guId
     *
     * @return JobSeekerResume
     */
    public function setGuId($guId) {
        $this->guId = $guId;

        return $this;
    }

    /**
     * Get guId
     *
     * @return string
     */
    public function getGuId() {
        return $this->guId;
    }

    /**
     * Set jobSeekerId
     *
     * @param string $jobSeekerId
     *
     * @return JobSeekerResume
     */
    public function setJobSeekerId($jobSeekerId) {
        $this->jobSeekerId = $jobSeekerId;

        return $this;
    }

    /**
     * Get jobSeekerId
     *
     * @return string
     */
    public function getJobSeekerId() {
        return $this->jobSeekerId;
    }

    /**
     * Set resume
     *
     * @param string $resume
     *
     * @return JobSeekerResume
     */
    public function setResume($resume) {
        $this->resume = $resume;

        return $this;
    }

    /**
     * Get resume
     *
     * @return string
     */
    public function getResume() {
        return $this->resume;
    }


    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     *
     * @return JobSeekerResume
     */
    public function setCreatedDate($createdDate)
    {
        $this->createdDate = $createdDate;

        return $this;
    }

    /**
     * Get createdDate
     *
     * @return \DateTime
     */
    public function getCreatedDate()
    {
        return $this->createdDate;
    }
    
    /**
     * Get resumeEducation
     *
     */
    public function getResumeEducation()
    {
        return $this->resumeEducation;
    }
    
    /**
     * Get workExpResume
     *
     */
    public function getWorkExpResume()
    {
        return $this->workExpResume;
    }

    /**
     * Set aditionalInfo
     *
     * @param string $aditionalInfo
     *
     * @return JobSeekerResume
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
     * Add resumeEducation
     *
     * @param \JobBundle\Entity\ResumeEducation $resumeEducation
     *
     * @return JobSeekerResume
     */
    public function addResumeEducation(\JobBundle\Entity\ResumeEducation $resumeEducation)
    {
        $this->resumeEducation[] = $resumeEducation;

        return $this;
    }

    /**
     * Remove resumeEducation
     *
     * @param \JobBundle\Entity\ResumeEducation $resumeEducation
     */
    public function removeResumeEducation(\JobBundle\Entity\ResumeEducation $resumeEducation)
    {
        $this->resumeEducation->removeElement($resumeEducation);
    }

    /**
     * Add workExpResume
     *
     * @param \JobBundle\Entity\WorkExpResume $workExpResume
     *
     * @return JobSeekerResume
     */
    public function addWorkExpResume(\JobBundle\Entity\WorkExpResume $workExpResume)
    {
        $this->workExpResume[] = $workExpResume;

        return $this;
    }

    /**
     * Remove workExpResume
     *
     * @param \JobBundle\Entity\WorkExpResume $workExpResume
     */
    public function removeWorkExpResume(\JobBundle\Entity\WorkExpResume $workExpResume)
    {
        $this->workExpResume->removeElement($workExpResume);
    }

    /**
     * Set skills
     *
     * @param string $skills
     *
     * @return JobSeekerResume
     */
    public function setSkills($skills)
    {
        $this->skills = $skills;

        return $this;
    }

    /**
     * Get skills
     *
     * @return string
     */
    public function getSkills()
    {
        return $this->skills;
    }

    /**
     * Set showInFrontPage
     *
     * @param boolean $showInFrontPage
     *
     * @return JobSeekerResume
     */
    public function setShowInFrontPage($showInFrontPage)
    {
        $this->showInFrontPage = $showInFrontPage;

        return $this;
    }

    /**
     * Get showInFrontPage
     *
     * @return boolean
     */
    public function getShowInFrontPage()
    {
        return $this->showInFrontPage;
    }
}
