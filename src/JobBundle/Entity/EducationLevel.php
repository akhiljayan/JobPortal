<?php

namespace JobBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EducationLevel
 *
 * @ORM\Table(name="education_level")
 * @ORM\Entity(repositoryClass="JobBundle\Repository\EducationLevelRepository")
 */
class EducationLevel
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
     * @ORM\Column(name="eduLevel", type="string", length=100)
     */
    private $eduLevel;

    /**
     * @var string
     *
     * @ORM\Column(name="eduLevelCd", type="string", length=20)
     */
    private $eduLevelCd;


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
     * Set eduLevel
     *
     * @param string $eduLevel
     *
     * @return EducationLevel
     */
    public function setEduLevel($eduLevel)
    {
        $this->eduLevel = $eduLevel;

        return $this;
    }

    /**
     * Get eduLevel
     *
     * @return string
     */
    public function getEduLevel()
    {
        return $this->eduLevel;
    }

    /**
     * Set eduLevelCd
     *
     * @param string $eduLevelCd
     *
     * @return EducationLevel
     */
    public function setEduLevelCd($eduLevelCd)
    {
        $this->eduLevelCd = $eduLevelCd;

        return $this;
    }

    /**
     * Get eduLevelCd
     *
     * @return string
     */
    public function getEduLevelCd()
    {
        return $this->eduLevelCd;
    }
}

