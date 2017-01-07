<?php

namespace JobBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WorkExpResume
 *
 * @ORM\Table(name="work_exp_resume")
 * @ORM\Entity(repositoryClass="JobBundle\Repository\workExpResumeRepository")
 */
class WorkExpResume
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
     * @ORM\Column(name="jobPosition", type="string", length=100, nullable=true)
     */
    private $jobPosition;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fromDate", type="datetime", nullable=true)
     */
    private $fromDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="toDate", type="datetime", nullable=true)
     */
    private $toDate;

    /**
     * @var string
     *
     * @ORM\Column(name="company", type="string", length=150, nullable=true)
     */
    private $company;

    /**
     * @var string
     *
     * @ORM\Column(name="details", type="text", nullable=true)
     */
    private $details;



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
     * Set jobPosition
     *
     * @param string $jobPosition
     *
     * @return WorkExpResume
     */
    public function setJobPosition($jobPosition)
    {
        $this->jobPosition = $jobPosition;

        return $this;
    }

    /**
     * Get jobPosition
     *
     * @return string
     */
    public function getJobPosition()
    {
        return $this->jobPosition;
    }

    /**
     * Set fromDate
     *
     * @param \DateTime $fromDate
     *
     * @return WorkExpResume
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
     * @return WorkExpResume
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
     * Set company
     *
     * @param string $company
     *
     * @return WorkExpResume
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
     * Set details
     *
     * @param string $details
     *
     * @return WorkExpResume
     */
    public function setDetails($details)
    {
        $this->details = $details;

        return $this;
    }

    /**
     * Get details
     *
     * @return string
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * Set resumeId
     *
     * @param \JobBundle\Entity\JobSeekerResume $resumeId
     *
     * @return WorkExpResume
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
}
