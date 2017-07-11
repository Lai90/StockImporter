<?php

namespace Utility;

class CsvFileIterator implements \Iterator
{
    const CACHE_TTL = 21600;
    protected $file;
    protected $fileUrl;
    protected $key = 0;
    protected $current;

    public function __construct($file) 
    {
        $this->fileUrl = $file;

        if($this->isFileExternal() && $this->isCacheValid()) {
            $this->file = fopen($this->getCacheFile(), 'r');
        }
        else {
            $this->file = fopen($file, 'r');
            
            if($this->isFileExternal()) {
                file_put_contents($this->getCacheFile(), $this->file);
            }
        }
    }

    public function __destruct() 
    {
        fclose($this->file);
    }

    public function isCacheValid()
    {
        return file_exists($this->getCacheFile()) && (filemtime($this->getCacheFile()) > (time() - self::CACHE_TTL));
    }

    public function isFileExternal()
    {
        if(stristr($this->fileUrl, "http")) {
            return true;
        }

        return false;
    }

    public function getCacheFile()
    {
        return __DIR__."/../../var/cache/".basename($this->fileUrl);
    }

    public function rewind() 
    {
        rewind($this->file);
        $this->current = fgetcsv($this->file);
        $this->key = 0;
    }

    public function valid() 
    {
        return !feof($this->file);
    }

    public function key() 
    {
        return $this->key;
    }

    public function current() 
    {
        return $this->current;
    }

    public function next() 
    {
        $this->current = fgetcsv($this->file);
        $this->key++;
    }
}