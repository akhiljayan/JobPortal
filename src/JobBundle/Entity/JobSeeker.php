<?php

namespace JobBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JobSeeker
 *
 * @ORM\Table(name="job_seeker")
 * @ORM\Entity(repositoryClass="JobBundle\Repository\JobSeekerRepository")
 */
class JobSeeker
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
     * @var guid
     *
     * @ORM\Column(name="gu_id", type="string",unique = true)
     */
    private $guId;

    /**
     * @var string
     *
     * @ORM\Column(name="firstName", type="string", length=60)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=60)
     */
    private $lastName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dob", type="datetime")
     */
    private $dob;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=100, unique=true)
     */
    private $email;

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
     * @ORM\Column(name="majors", type="string", length=60)
     */
    private $majors;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="cityTown", type="string", length=60)
     */
    private $cityTown;

    /**
     * @var string
     *
     * @ORM\Column(name="state", type="string", length=50)
     */
    private $state;

    /**
     * @var string
     *
     * @ORM\Column(name="zipCode", type="string", length=10)
     */
    private $zipCode;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=10)
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(name="phoneNumber", type="string", length=10)
     */
    private $phoneNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="aboutMe", type="text", nullable=true)
     */
    private $aboutMe;

    /**
     * @var bool
     *
     * @ORM\Column(name="priorityFlag", type="boolean")
     */
    private $priorityFlag;

    /**
     * @var bool
     *
     * @ORM\Column(name="registrationComplete", type="boolean")
     */
    private $registrationComplete;
    
    /**
     * @ORM\ManyToOne(targetEntity="\AkjnBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $userId;
    
    /**
     * @ORM\ManyToOne(targetEntity="\AkjnBundle\Entity\User")
     * @ORM\JoinColumn(name="created_by", referencedColumnName="id")
     */
    private $createdBy;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="userImage", type="blob",nullable=true)
     */
    private $userImage;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_date", type="datetime")
     */
    private $createdDate;
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->guId = md5(uniqid(php_uname('n')));
        $this->createdDate = new \DateTime("now");
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return JobSeeker
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return JobSeeker
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set dob
     *
     * @param \DateTime $dob
     *
     * @return JobSeeker
     */
    public function setDob($dob)
    {
        $this->dob = $dob;

        return $this;
    }

    /**
     * Get dob
     *
     * @return \DateTime
     */
    public function getDob()
    {
        return $this->dob;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return JobSeeker
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set educationLevelId
     *
     * @param string $educationLevelId
     *
     * @return JobSeeker
     */
    public function setEducationLevelId($educationLevelId)
    {
        $this->educationLevelId = $educationLevelId;

        return $this;
    }

    /**
     * Get educationLevelId
     *
     * @return string
     */
    public function getEducationLevelId()
    {
        return $this->educationLevelId;
    }

    /**
     * Set majors
     *
     * @param string $majors
     *
     * @return JobSeeker
     */
    public function setMajors($majors)
    {
        $this->majors = $majors;

        return $this;
    }

    /**
     * Get majors
     *
     * @return string
     */
    public function getMajors()
    {
        return $this->majors;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return JobSeeker
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set cityTown
     *
     * @param string $cityTown
     *
     * @return JobSeeker
     */
    public function setCityTown($cityTown)
    {
        $this->cityTown = $cityTown;

        return $this;
    }

    /**
     * Get cityTown
     *
     * @return string
     */
    public function getCityTown()
    {
        return $this->cityTown;
    }

    /**
     * Set state
     *
     * @param string $state
     *
     * @return JobSeeker
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set zipCode
     *
     * @param string $zipCode
     *
     * @return JobSeeker
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    /**
     * Get zipCode
     *
     * @return string
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return JobSeeker
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set phoneNumber
     *
     * @param string $phoneNumber
     *
     * @return JobSeeker
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * Get phoneNumber
     *
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * Set aboutMe
     *
     * @param string $aboutMe
     *
     * @return JobSeeker
     */
    public function setAboutMe($aboutMe)
    {
        $this->aboutMe = $aboutMe;

        return $this;
    }

    /**
     * Get aboutMe
     *
     * @return string
     */
    public function getAboutMe()
    {
        return $this->aboutMe;
    }

    /**
     * Set priorityFlag
     *
     * @param boolean $priorityFlag
     *
     * @return JobSeeker
     */
    public function setPriorityFlag($priorityFlag)
    {
        $this->priorityFlag = $priorityFlag;

        return $this;
    }

    /**
     * Get priorityFlag
     *
     * @return bool
     */
    public function getPriorityFlag()
    {
        return $this->priorityFlag;
    }

    /**
     * Set registrationComplete
     *
     * @param boolean $registrationComplete
     *
     * @return JobSeeker
     */
    public function setRegistrationComplete($registrationComplete)
    {
        $this->registrationComplete = $registrationComplete;

        return $this;
    }

    /**
     * Get registrationComplete
     *
     * @return bool
     */
    public function getRegistrationComplete()
    {
        return $this->registrationComplete;
    }

    /**
     * Set userId
     *
     * @param \AkjnBundle\Entity\User $userId
     *
     * @return JobSeeker
     */
    public function setUserId(\AkjnBundle\Entity\User $userId = null)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return \AkjnBundle\Entity\User
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set createdBy
     *
     * @param \AkjnBundle\Entity\User $createdBy
     *
     * @return JobSeeker
     */
    public function setCreatedBy(\AkjnBundle\Entity\User $createdBy = null)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return \AkjnBundle\Entity\User
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Set userImage
     *
     * @param string $userImage
     *
     * @return JobSeeker
     */
    public function setUserImage($userImage)
    {
        $this->userImage = $userImage;

        return $this;
    }

    /**
     * Get userImage
     *
     * @return string
     */
    public function getUserImage()
    {
        return $this->userImage;
    }

    /**
     * Set guId
     *
     * @param string $guId
     *
     * @return JobSeeker
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
     * Set createdDate
     *
     * @param \DateTime $createdDate
     *
     * @return JobSeeker
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
     * Set course
     *
     * @param string $course
     *
     * @return JobSeeker
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
}
