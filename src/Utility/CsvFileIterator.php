<?php

namespace Utility;

use Utility\Exception\CacheFileInvalidException;

class CsvFileIterator implements \Iterator
{
    const CACHE_TTL = 21600;
    const CACHE_MAX_TRIES = 10;
    const CACHE_SLEEP_RETRY = 5;

    protected $file;
    protected $fileUrl;
    protected $key = 0;
    protected $current;
    protected $cacheTries;

    public function __construct($file) 
    {
        $this->fileUrl = $file;
        $this->cacheTries = 0;

        if($this->isFileExternal() && $this->isCacheStillValid()) {
            $this->openCacheFile();
        }
        else {            
            if($this->isFileExternal()) {
                $this->processCache(); 
            }
            else {
                $this->openFile();
            }
        }
    }

    public function __destruct() 
    {
        fclose($this->file);
    }

    public function isCacheStillValid()
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

    public function openFile()
    {
        $this->file = fopen($this->fileUrl, 'r');
    }

    public function openCacheFile()
    {
        $this->file = fopen($this->getCacheFile(), 'r');
    }

    public function processCache()
    {
        try {
            $this->openFile();
            $this->saveCacheFile();
            $this->validateCacheFile();
            $this->openCacheFile();
        }
        catch (CacheFileInvalidException $e) {
            if($this->cacheTries < self::CACHE_MAX_TRIES) {
                sleep(self::CACHE_SLEEP_RETRY);
                $this->processCache();
            }
            else {
                throw new CacheFileInvalidException("Max tries reached. Aborting.");
            }
        }
    }

    public function validateCacheFile()
    {
        if(!(exec("file -I ".$this->getCacheFile()) == $this->getCacheFile().": text/plain; charset=us-ascii")) {
            unlink($this->getCacheFile());
            throw new CacheFileInvalidException("Cache file is not text/plain.");
        }
    }

    public function saveCacheFile()
    {
        file_put_contents($this->getCacheFile(), $this->file);
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