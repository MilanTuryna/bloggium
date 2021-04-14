<?php

namespace App\Model\Admin;

use Nette\IOException;
use Nette\Neon\Neon;
use Nette\Utils\FileSystem;

/**
 * Class Configuration
 * @package App\Model\Admin
 */
abstract class Configuration
{
    private string $filePath;
    protected array $configuration;

    /**
     * Configuration constructor.
     * @param string $filePath
     */
    public function __construct(string $filePath)
    {
        $this->configuration = Neon::decode(file_get_contents($filePath));
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
     * @throws IOException
     */
    public function updateChanges(): bool {
        FileSystem::write($this->filePath, Neon::encode($this->configuration));
        return true;
    }
}