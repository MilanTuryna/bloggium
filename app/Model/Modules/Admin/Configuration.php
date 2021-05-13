<?php

namespace App\Model\Admin;

use Nette\Caching\Cache;
use Nette\Caching\Storage;
use Nette\Neon\Neon;
use Nette\Utils\FileSystem;
use Throwable;

/**
 * Class Configuration
 * @package App\Model\Admin
 */
abstract class Configuration
{
    private string $filePath;
    private string $cacheKey;
    private ?Cache $cache = null;

    protected array $configuration;

    /**
     * Configuration constructor.
     * @param string $filePath
     * @param Storage $storage
     * @throws Throwable
     */
    public function __construct(string $filePath, ?Storage $storage)
    {
        $this->filePath = $filePath;
        $this->cacheKey = basename(__FILE__);
        if($storage) $this->cache = new Cache($storage);
        $fileContent = $this->cache->load($this->cacheKey) ?? null;
        if(!$fileContent) {
            $fileContent = file_get_contents($filePath);
            if($this->cache) $this->cache->save($this->cacheKey, $fileContent);
        }
        $this->configuration = Neon::decode($fileContent);
    }

    /**
     * @return bool
     */
    public function isCachingEnabled(): bool {
        return (bool)$this->cache;
    }

    /**
     * @return string
     */
    public function getCacheKey(): string {
        return $this->cacheKey;
    }

    /**
     * @param string $id
     * @return mixed
     */
    public function getValue(string $id) {
        return $this->configuration[$id];
    }

    /**
     * @param string $id
     * @param string $value
     */
    public function setValue(string $id, string $value) {
        $this->configuration[$id] = $value;
    }

    /**
     * @return bool
     */
    public function updateChanges(): bool {
        $encodedConfiguration = Neon::encode($this->configuration);
        FileSystem::write($this->filePath, $encodedConfiguration);
        if($this->cache) $this->cache->remove($this->cacheKey);
        return true;
    }
}

