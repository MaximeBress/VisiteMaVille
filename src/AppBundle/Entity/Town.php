<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Town
 *
 * @ORM\Table(name="town")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TownRepository")
 */
class Town
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=255)
     */
    private $code;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Enterprise", mappedBy="town")
     */
    private $enterprises;

    /**
     * @var string
     *
     * @ORM\Column(name="latitude", type="string", length=255)
     */
    private $latitude;

    /**
     * @var string
     *
     * @ORM\Column(name="longitude", type="string", length=255)
     */
    private $longitude;

    /**
     * @var string
     *
     * @ORM\Column(name="zoom", type="integer")
     */
    private $zoom;


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
     * Set name
     *
     * @param string $name
     *
     * @return Town
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->enterprises = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add enterprise
     *
     * @param \AppBundle\Entity\Enterprise $enterprise
     *
     * @return Town
     */
    public function addEnterprise(\AppBundle\Entity\Enterprise $enterprise)
    {
        $this->enterprises[] = $enterprise;

        return $this;
    }

    /**
     * Remove enterprise
     *
     * @param \AppBundle\Entity\Enterprise $enterprise
     */
    public function removeEnterprise(\AppBundle\Entity\Enterprise $enterprise)
    {
        $this->enterprises->removeElement($enterprise);
    }

    /**
     * Get enterprises
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEnterprises()
    {
        return $this->enterprises;
    }

    /**
     * Set code
     *
     * @param string $code
     *
     * @return Town
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set latitude
     *
     * @param string $latitude
     *
     * @return Town
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return string
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param string $longitude
     *
     * @return Town
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return string
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set zoom
     *
     * @param integer $zoom
     *
     * @return Town
     */
    public function setZoom($zoom)
    {
        $this->zoom = $zoom;

        return $this;
    }

    /**
     * Get zoom
     *
     * @return integer
     */
    public function getZoom()
    {
        return $this->zoom;
    }
}
