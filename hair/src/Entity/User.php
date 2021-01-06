<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Booking;
use App\Entity\Service;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
//use Symfony\Component\Security\Core\User\UserInterface::getSalt;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 */
class User implements UserInterface, \Serializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="array")
     */
    private $roles = []; 

    /**
     * 
     * @ORM\OneToMany(targetEntity="App\Entity\Booking", mappedBy="customerId")
     */
    private $bookingId; 

    public function __construct()
    {
        $this->booking = new ArrayCollection();
        
        // may not be needed, see section on salt below
        // $this->salt = md5(uniqid('', true));
    }
    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRoles(): ?array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @return Collection|Booking[]
     */
    public function getBookingId(): Collection
    {
        return $this->bookingId;
    }

    public function addBookingId(Booking $bookingId): self
    {
        if (!$this->bookingId->contains($bookingId)) {
            $this->bookingId[] = $bookingId;
            $bookingId->setCustomerId($this);
        }

        return $this;
    }

    public function removeBookingId(Booking $bookingId): self
    {
        if ($this->bookingId->contains($bookingId)) {
            $this->bookingId->removeElement($bookingId);
            // set the owning side to null (unless already changed)
            if ($bookingId->getCustomerId() === $this) {
                $bookingId->setCustomerId(null);
            }
        }

        return $this;
    }

    public function getUsername()
    {
        return $this->name;
    }

    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }

    public function eraseCredentials()
    {
    }

    /**
     * @see \Serializable::serialize()
     */
    public function serialize()
    {
        return serialize(
            array(
            $this->id,
            $this->name,
            $this->password,
            
                // see section on salt below
                // $this->salt,
            )
        );
    }

    /**
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized)
    {
        list(
                $this->id,
                $this->name,
                $this->password,

                // see section on salt below
                // $this->salt
                ) = unserialize($serialized);
    }
    
}
