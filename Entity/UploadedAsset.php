<?php

namespace EMS\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use EMS\CommonBundle\Helper\EmsFields;

/**
 * DataField
 *
 * @ORM\Table(name="uploaded_asset")
 * @ORM\Entity(repositoryClass="EMS\CoreBundle\Repository\UploadedAssetRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class UploadedAsset
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
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modified", type="datetime")
     */
    private $modified;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=64, nullable=true)
     */
    private $status;
    
    /**
     * @var string
     *
     * @ORM\Column(name="sha1", type="string", length=128)
     */
    private $sha1;
    
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=1024)
     */
    private $name;
    
    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=1024)
     */
    private $type;
    
    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255)
     */
    private $user;

    /**
     * @var bool
     *
     * @ORM\Column(name="available", type="boolean")
     */
    private $available;

    /**
     * @var int
     *
     * @ORM\Column(name="size", type="bigint")
     */
    private $size;

    /**
     * @var int
     *
     * @ORM\Column(name="uploaded", type="bigint")
     */
    private $uploaded;

    /**
     * @var string
     *
     * @ORM\Column(name="hash_algo", type="string", length=32, options={"default" : "sha1"})
     */
    private $hashAlgo;
    


    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updateModified(): void
    {
        $this->modified = new \DateTime();
        if (!isset($this->created)) {
            $this->created = $this->modified;
        }
    }

    /**
     * @return array{sha1:string, type:string, available:bool, name:string, size:int, status:string, uploaded:int, user:string}
     */
    public function getResponse(): array
    {
        return [
            'sha1' => $this->getSha1(),
            'type' => $this->getType(),
            'available' => $this->getAvailable(),
            'name' => $this->getName(),
            'size' => $this->getSize(),
            'status' => $this->getStatus(),
            'uploaded' => $this->getUploaded(),
            'user' => $this->getUser(),
        ];
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
     * Set created
     *
     * @param \DateTime $created
     *
     * @return UploadedAsset
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set modified
     *
     * @param \DateTime $modified
     *
     * @return UploadedAsset
     */
    public function setModified($modified)
    {
        $this->modified = $modified;

        return $this;
    }

    /**
     * Get modified
     *
     * @return \DateTime
     */
    public function getModified()
    {
        return $this->modified;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return UploadedAsset
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return UploadedAsset
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
     * Set type
     *
     * @param string $type
     *
     * @return UploadedAsset
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set user
     *
     * @param string $user
     *
     * @return UploadedAsset
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set available
     *
     * @param boolean $available
     *
     * @return UploadedAsset
     */
    public function setAvailable($available)
    {
        $this->available = $available;

        return $this;
    }

    /**
     * Get available
     *
     * @return boolean
     */
    public function getAvailable()
    {
        return $this->available;
    }

    /**
     * Set size
     *
     * @param integer $size
     *
     * @return UploadedAsset
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return integer
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set uploaded
     *
     * @param integer $uploaded
     *
     * @return UploadedAsset
     */
    public function setUploaded($uploaded)
    {
        $this->uploaded = $uploaded;

        return $this;
    }

    /**
     * Get uploaded
     *
     * @return integer
     */
    public function getUploaded()
    {
        return $this->uploaded;
    }

    /**
     * Set sha1
     *
     * @param string $sha1
     *
     * @return UploadedAsset
     */
    public function setSha1($sha1)
    {
        $this->sha1 = ($sha1);

        return $this;
    }

    /**
     * Get sha1
     *
     * @return string
     */
    public function getSha1()
    {
        return ($this->sha1);
    }

    /**
     * @return array{filename:string,filesize:int,mimetype:string,sha1:string,_hash_algo:string}
     */
    public function getData():array
    {
        return [
            EmsFields::CONTENT_FILE_NAME_FIELD => $this->getName(),
            EmsFields::CONTENT_FILE_SIZE_FIELD => $this->getSize(),
            EmsFields::CONTENT_MIME_TYPE_FIELD => $this->getType(),
            EmsFields::CONTENT_FILE_HASH_FIELD => $this->getSha1(),
            EmsFields::CONTENT_HASH_ALGO_FIELD => $this->getHashAlgo(),
        ];
    }

    /**
     * @return string
     */
    public function getHashAlgo(): string
    {
        return $this->hashAlgo;
    }

    /**
     * @param string $hashAlgo
     * @return UploadedAsset
     */
    public function setHashAlgo(string $hashAlgo): UploadedAsset
    {
        $this->hashAlgo = $hashAlgo;
        return $this;
    }
}
