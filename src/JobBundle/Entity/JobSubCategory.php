<?php

namespace JobBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SubCategory
 *
 * @ORM\Table(name="job_sub_category")
 * @ORM\Entity(repositoryClass="JobBundle\Repository\JobSubCategoryRepository")
 */
class JobSubCategory
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
     * @ORM\Column(name="sub_category", type="string", length=150)
     */
    private $subCategory;

    /**
     * @ORM\ManyToOne(targetEntity="\JobBundle\Entity\JobCategory")
     * @ORM\JoinColumn(name="category", referencedColumnName="id")
     */
    private $category;

    /**
     * @var bool
     *
     * @ORM\Column(name="status", type="boolean")
     */
    private $status;
    
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
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set subCategory
     *
     * @param string $subCategory
     *
     * @return JobSubCategory
     */
    public function setSubCategory($subCategory)
    {
        $this->subCategory = $subCategory;

        return $this;
    }

    /**
     * Get subCategory
     *
     * @return string
     */
    public function getSubCategory()
    {
        return $this->subCategory;
    }

    /**
     * Set status
     *
     * @param boolean $status
     *
     * @return JobSubCategory
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
     * Set category
     *
     * @param \JobBundle\Entity\JobCategory $category
     *
     * @return JobSubCategory
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
}
