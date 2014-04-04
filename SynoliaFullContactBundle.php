<?php

namespace Synolia\Bundle\FullContactBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class SynoliaFullContactBundle extends Bundle
{
    public function getParent()
    {
        return 'OroCRMContactBundle';
    }
}
