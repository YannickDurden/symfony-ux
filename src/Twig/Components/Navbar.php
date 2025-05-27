<?php

namespace App\Twig\Components;

use Symfony\Bundle\SecurityBundle\Security;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class Navbar
{
    public function __construct(
        private Security $security
    ) {
    }

    public function getUser(): ?string
    {
        return $this->security->getUser()?->getEmail();
    }

    public function getImageProfile(): string
    {
        return 'https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp';
    }
}
