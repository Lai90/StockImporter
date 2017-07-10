<?php

namespace Domain;

abstract class AbstractCollection implements \Iterator, \JsonSerializable
{
	protected $collection;

	public function __construct()
	{
		$this->collection = array();
	}

	public function getCollection()
	{
		return $this->collection;
	}

    public function setCollection(Array $collection) 
    {
        $this->collection = $collection;
    }
	
	public function count() : int
	{
		return count($this->collection);
	}

	public function jsonSerialize() 
	{
		return $this->collection;
	}

	public function rewind()
    {
        reset($this->collection);
    }
  
    public function current()
    {
        $var = current($this->collection);
        return $var;
    }
  
    public function key() 
    {
        $var = key($this->collection);
        return $var;
    }
  
    public function next() 
    {
        $var = next($this->collection);
        return $var;
    }
  
    public function valid()
    {
        $key = key($this->collection);
        $var = ($key !== NULL && $key !== FALSE);
        return $var;
    }

    public function last()
    {
        $var = end($this->collection);
        return $var;
    }
}