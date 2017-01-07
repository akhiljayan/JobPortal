<?php

namespace AkjnBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\AttributeOverride;
use Doctrine\ORM\Mapping\AttributeOverrides;

/**
 * @ORM\Entity
 * @ORM\Table(name="job_portal_users")
 *
 */
class User extends BaseUser {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     *
     * @ORM\Column(type="integer",length=1, options={ "default"=0 })
     */
    protected $attempted = 0;

    /**
     * @ORM\Column(type="smallint",name="is_logged", options={ "default"=0 })
     */
    protected $isLogged = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50, nullable=true)
     */
    private $name;

    /**
     *
     * @ORM\Column(type="datetime",name="attempted_at", nullable=true)
     */
    protected $attemptedAt;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_date", type="datetime")
     */
    private $createdDate;
    
    /**
     * @var guid
     *
     * @ORM\Column(name="gu_id", type="string",unique = true)
     */
    private $guId;

    
    /**
     * @var string
     *
     * @ORM\Column(name="userType", type="string", length=20, nullable=true)
     */
    private $userType;
    
    /**
     * @var string
     *
     * @ORM\Column(name="mobileNumber", type="string", length=10, nullable=true)
     */
    private $mobileNumber;

    public function __construct() {
        parent::__construct();
        $this->guId = md5(uniqid(php_uname('n')));
        $this->createdDate = new \DateTime("now");
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    public function setCredentialsExpireAt(\DateTime $date = null) {
        $date = new \DateTime('now');
        $date->add(new \DateInterval('P60D'));
        $this->credentialsExpireAt = $date;

        return $this;
    }

    /**
     * Set attempted
     *
     * @param integer $attempted
     * @return User
     */
    public function setAttempted($attempted) {
        if (is_null($attempted)) {
            $attempted = 0;
        }
        $this->attempted = $attempted;

        return $this;
    }

    /**
     * Get attempted
     *
     * @return integer
     */
    public function getAttempted() {
        return $this->attempted;
    }

    /**
     * Set attemptedAt
     *
     * @param \DateTime $attemptedAt
     * @return User
     */
    public function setAttemptedAt($attemptedAt = null) {
        $dt = new \DateTime('now');
        $this->attemptedAt = $dt;

        return $this;
    }

    /**
     * Get attemptedAt
     *
     * @return \DateTime
     */
    public function getAttemptedAt() {
        return $this->attemptedAt;
    }

    /**
     * Set is_logged
     *
     * @param smallint $isLogged
     * @return User
     */
    public function setIsLogged($islogged = 1) {
        $this->isLogged = $islogged;

        return $this;
    }

    /**
     * Get login_flag
     *
     * @return integer
     */
    public function getIsLogged() {
        return $this->isLogged;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Name
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }


//    public function getRoles() {
//        parent::getRoles();
//    }
//
//    public function hasRole($role) {
//        parent::hasRole($role);
//    }
    
    /**
     * Set userType
     *
     * @param string $userType
     *
     * @return User
     */
    public function setUserType($userType)
    {
        $this->userType = $userType;

        return $this;
    }

    /**
     * Get userType
     *
     * @return string
     */
    public function getUserType()
    {
        return $this->userType;
    }


    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     *
     * @return User
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
     * Set guId
     *
     * @param string $guId
     *
     * @return User
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
     * Set mobileNumber
     *
     * @param string $mobileNumber
     *
     * @return User
     */
    public function setMobileNumber($mobileNumber)
    {
        $this->mobileNumber = $mobileNumber;

        return $this;
    }

    /**
     * Get mobileNumber
     *
     * @return string
     */
    public function getMobileNumber()
    {
        return $this->mobileNumber;
    }
}
