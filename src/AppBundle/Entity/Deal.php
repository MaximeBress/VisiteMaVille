<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Deal
 *
 * @ORM\Table(name="deal")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DealRepository")
 */
class Deal
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
     * @ORM\Column(name="token", type="string", length=255)
     */
    private $token;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="beginAt", type="datetime", nullable=true)
     */
    private $beginAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="endAt", type="datetime", nullable=true)
     */
    private $endAt;

    /**
     * @var int
     *
     * @ORM\Column(name="duration", type="integer")
     */
    private $duration;

    /**
     * @var int
     *
     * @ORM\Column(name="price", type="integer", nullable=true)
     */
    private $price;

    /**
     * @var int
     *
     * @ORM\Column(name="active", type="boolean", nullable=true)
     */
    private $active;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Enterprise", inversedBy="deals")
     */
    private $entite;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="deals")
     */
    private $createdBy;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Category", inversedBy="deals")
     */
    private $category;

    /**
     * @var int
     *
     * @ORM\Column(name="availability", type="integer", nullable=true)
     */
    private $availability;

    /**
     * @var int
     *
     * @ORM\Column(name="sold", type="integer", nullable=true)
     */
    private $sold;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
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
     * Set name
     *
     * @param string $name
     *
     * @return Deal
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
     * Set description
     *
     * @param string $description
     *
     * @return Deal
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Deal
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set beginAt
     *
     * @param \DateTime $beginAt
     *
     * @return Deal
     */
    public function setBeginAt($beginAt)
    {
        $this->beginAt = $beginAt;

        return $this;
    }

    /**
     * Get beginAt
     *
     * @return \DateTime
     */
    public function getBeginAt()
    {
        return $this->beginAt;
    }

    /**
     * Set endAt
     *
     * @param \DateTime $endAt
     *
     * @return Deal
     */
    public function setEndAt($endAt)
    {
        $this->endAt = $endAt;

        return $this;
    }

    /**
     * Get endAt
     *
     * @return \DateTime
     */
    public function getEndAt()
    {
        return $this->endAt;
    }

    /**
     * Set price
     *
     * @param integer $price
     *
     * @return Deal
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set entite
     *
     * @param \AppBundle\Entity\Enterprise $entite
     *
     * @return Deal
     */
    public function setEntite(\AppBundle\Entity\Enterprise $entite = null)
    {
        $this->entite = $entite;

        return $this;
    }

    /**
     * Get entite
     *
     * @return \AppBundle\Entity\Enterprise
     */
    public function getEntite()
    {
        return $this->entite;
    }

    /**
     * Set createdBy
     *
     * @param \UserBundle\Entity\User $createdBy
     *
     * @return Deal
     */
    public function setCreatedBy(\UserBundle\Entity\User $createdBy = null)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return \UserBundle\Entity\User
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Set duration
     *
     * @param integer $duration
     *
     * @return Deal
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get duration
     *
     * @return integer
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set token
     *
     * @param string $token
     *
     * @return Deal
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return Deal
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set availability
     *
     * @param integer $availability
     *
     * @return Deal
     */
    public function setAvailability($availability)
    {
        $this->availability = $availability;

        return $this;
    }

    /**
     * Get availability
     *
     * @return integer
     */
    public function getAvailability()
    {
        return $this->availability;
    }

    /**
     * Set category
     *
     * @param \AppBundle\Entity\Category $category
     *
     * @return Deal
     */
    public function setCategory(\AppBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \AppBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set sold
     *
     * @param integer $sold
     *
     * @return Deal
     */
    public function setSold($sold)
    {
        $this->sold = $sold;

        return $this;
    }

    /**
     * Get sold
     *
     * @return integer
     */
    public function getSold()
    {
        return $this->sold;
    }
}
