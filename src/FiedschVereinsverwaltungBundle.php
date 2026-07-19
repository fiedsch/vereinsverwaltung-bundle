<?php

namespace Fiedsch\VereinsverwaltungBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Configures the Vereinsverwaltung bundle.
 *
 * @author Andreas Fieger
 */
class FiedschVereinsverwaltungBundle extends Bundle
{
    public function getPath(): string
    {
        return dirname(__DIR__);
    }
}
