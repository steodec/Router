<?php

namespace Steodec\Router\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class Route
{
    private ?string $_path;
    private ?string $_callable;
    private ?string $_method;
    private ?string $_name;
    private ?string $_is_granted;


    public function __construct(?string $method = null, string $path = null, string $name = null, string $isGranted = null)
    {
        $this->_path = $path;
        $this->_name = $name;
        $this->_method = $method;
        $this->_is_granted = $isGranted;
    }

    public function setCallable(string $string)
    {
        $this->_callable = $string;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->_name = $name;
    }

    /**
     * @param string|null $method
     */
    public function setMethod(?string $method): void
    {
        $this->_method = $method;
    }

    /**
     * @param string|null $path
     */
    public function setPath(?string $path): void
    {
        $this->_path = $path;
    }


    /**
     * @return string|null
     */
    public function getPath(): ?string
    {
        return $this->_path;
    }

    /**
     * @return string
     */
    public function getCallable(): string
    {
        return $this->_callable;
    }

    /**
     * @return string|null
     */
    public function getMethod(): ?string
    {
        return $this->_method;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->_name;
    }

    /**
     * @return string|null
     */
    public function getIsGranted(): ?string
    {
        return $this->_is_granted;
    }
    

}