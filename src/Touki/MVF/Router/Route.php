<?php

namespace Touki\MVF\Router;

use Symfony\Component\HttpFoundation\Request;

/**
 * Route class contains basic infos about routes - Very descriptive
 *
 * @author Touki <g.vincendon@vithemis.com>
 */
class Route
{
    protected $name;
    protected $matcher;
    protected $reference;

    /**
     * Constructor
     *
     * @param string                       $name      Route name
     * @param callable                     $matcher   Matcher
     * @param ControllerReferenceInterface $reference Reference
     */
    public function __construct($name, $matcher, ControllerReferenceInterface $reference)
    {
        $this->name = $name;
        $this->reference = $reference;
        $this->setMatcher($matcher);
    }

    /**
     * Get Name
     *
     * @return string Route name
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Set Name
     *
     * @param string $name Route name
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get Matcher
     *
     * @return callable Matcher
     */
    public function getMatcher()
    {
        return $this->matcher;
    }
    
    /**
     * Set Matcher
     *
     * @param callable $matcher Matcher
     */
    public function setMatcher($matcher)
    {
        if (!is_callable($matcher)) {
            throw new \InvalidArgumentException(sprintf(
                "Invalid matcher given. Expected callable got %s",
                gettype($matcher)
            ));
        }

        $this->matcher = $matcher;

        return $this;
    }

    /**
     * Get Reference
     *
     * @return ControllerReferenceInterface Reference
     */
    public function getReference()
    {
        return $this->reference;
    }
    
    /**
     * Set Reference
     *
     * @param ControllerReferenceInterface $reference Reference
     */
    public function setReference(ControllerReferenceInterface $reference)
    {
        $this->reference = $reference;
    
        return $this;
    }

    /**
     * Checks if the routes matches the request
     *
     * @param Request $request Request
     *
     * @return boolean
     */
    public function match(Request $request)
    {
        return true === call_user_func_array($this->matcher, array($request));
    }
}
