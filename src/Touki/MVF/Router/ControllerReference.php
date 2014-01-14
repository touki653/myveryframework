<?php

namespace Touki\MVF\Router;

/**
 * Base implementation for a controller reference
 *
 * @author Touki <g.vincendon@vithemis.com>
 */
class ControllerReference implements ControllerReferenceInterface
{
    protected $controller;

    /**
     * Constructor
     *
     * @param callable $controller Controller
     */
    public function __construct($controller = null)
    {
        if (null !== $controller) {
            $this->setController($controller);
        }
    }

    /**
     * Set Controller
     *
     * @param callable $controller Controller
     */
    public function setController($controller)
    {
        if (!is_callable($controller)) {
            throw new \InvalidArgumentException(sprintf(
                "Invalid controller given. Expected callable got %s",
                gettype($controller)
            ));
        }

        $this->controller = $controller;
    }

    /**
     * {@inheritDoc}
     */
    public function getController()
    {
        return $this->controller;
    }
}
