<?php
declare(strict_types=1);

namespace App\Entity;

use App\Repository\FileRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FileRepository::class)
 * @ORM\Table(name="files")
 */
class File
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
    private $providerName;

    /**
     * @ORM\Column(type="json")
     */
    private $tags = [];

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $uri;


    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }


    public function getId(): ?int
    {
        return $this->id;
    }


    public function getProviderName(): ?string
    {
        return $this->providerName;
    }


    public function setProviderName(string $providerName): self
    {
        $this->providerName = $providerName;

        return $this;
    }


    public function getTags(): ?array
    {
        return $this->tags;
    }


    public function setTags(array $tags): self
    {
        $this->tags = $tags;

        return $this;
    }


    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }


    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }


    public function getUri(): string
    {
        return $this->uri;
    }


    public function setUri(string $uri): self
    {
        $this->uri = $uri;

        return $this;
    }
}
