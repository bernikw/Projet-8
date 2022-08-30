<?php

namespace App\Entity\Trait;

use Doctrine\ORM\Mapping\Column;

trait SlugTrait
{

    #[Column(length: 255)]
    private ?string $slug = null;

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

}