<?php

namespace App\Domain\Ports;

use App\Domain\Exception\LocationProviderException;

interface LocationProvider
{
    /** @throws LocationProviderException */
    public function getAll(): array;
}
