<?php

namespace Touki\MVF\Router;

/**
 * Base interface for a controller reference
 *
 * @author Touki <g.vincendon@vithemis.com>
 */
interface ControllerReferenceInterface
{
    /**
     * Get controller
     *
     * @return callable Controller
     */
    public function getController();
}
