<?php

namespace Touki\MVF\Router;

/**
 * Lazy controller reference implementation
 *
 * @author Touki <g.vincendon@vithemis.com>
 */
class LazyControllerReference implements ControllerReferenceInterface
{
    protected $class;
    protected $method;
    protected $provider;
    protected $instance;

    /**
     * Constructor
     *
     * @param string $class  Class to instanciate
     * @param string $method Method to call
     */
    public function __construct($class = null, $method = null)
    {
        $this->class  = $class;
        $this->method = $method;
    }

    /**
     * Set Controller
     *
     * @param string $class  Class to instanciate
     * @param string $method Method to call
     */
    public function setController($class, $method)
    {
        $this->class  = $class;
        $this->method = $method;
    }

    /**
     * Sets arguments provider, arguments to pass on instanciation
     *
     * @param callable $provider Argument provider
     */
    public function setArgumentsProvider($provider)
    {
        if (!is_callable($provider)) {
            throw new \InvalidArgumentException(sprintf(
                "Invalid argument provider given. Expected callable got %s",
                gettype($provider)
            ));
        }

        $this->provider = $provider;
    }

    /**
     * {@inheritDoc}
     */
    public function getController()
    {
        if (null !== $this->instance) {
            return array($this->instance, $this->method);
        }

        $ref = new \ReflectionClass($this->class);
        $this->instance = $ref->newInstanceArgs(call_user_func_array($this->provider, array()));

        return array($this->instance, $this->method);
    }
}
