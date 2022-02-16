<?php

namespace App\Entity;

use App\Repository\MemoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MemoRepository::class)]
class Memo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'text')]
    private $memo_text;

    #[ORM\Column(type: 'integer')]
    private $memo_delay;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $expiration_time;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMemoText(): ?string
    {
        return $this->memo_text;
    }

    public function setMemoText(string $memo_text): self
    {
        $this->memo_text = $memo_text;

        return $this;
    }

    public function getMemoDelay(): ?int
    {
        return $this->memo_delay;
    }

    public function setMemoDelay(int $memo_delay): self
    {
        $this->memo_delay = $memo_delay;

        return $this;
    }

    public function getExpirationTime(): ?\DateTimeInterface
    {
        return $this->expiration_time;
    }

    public function setExpirationTime(?\DateTimeInterface $expiration_time): self
    {
        $this->expiration_time = $expiration_time;

        return $this;
    }
}
