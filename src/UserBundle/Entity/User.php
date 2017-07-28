<?php

namespace UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="UserBundle\Repository\UserRepository")
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255)
     */
    private $prenom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Enterprise", inversedBy="users")
     * @ORM\JoinColumn(nullable=true)
     */
    private $entite;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Deal", mappedBy="createdBy")
     */
    private $deals;

    public function __construct()
    {
        parent::__construct();
        $this->createdAt = new \DateTime();
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return User
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     *
     * @return User
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return User
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
     * Set entite
     *
     * @param \AppBundle\Entity\Enterprise $entite
     *
     * @return User
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

    public function getFullName()
    {
        return $this->getPrenom().' '.$this->getNom();
    }

    /**
     * Add deal
     *
     * @param \AppBundle\Entity\Deal $deal
     *
     * @return User
     */
    public function addDeal(\AppBundle\Entity\Deal $deal)
    {
        $this->deals[] = $deal;

        return $this;
    }

    /**
     * Remove deal
     *
     * @param \AppBundle\Entity\Deal $deal
     */
    public function removeDeal(\AppBundle\Entity\Deal $deal)
    {
        $this->deals->removeElement($deal);
    }

    /**
     * Get deals
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDeals()
    {
        return $this->deals;
    }
}
