<?php
declare (strict_types = 1);
namespace memCrab\File;
use memCrab\Cache\FileCache;
use memCrab\Exceptions\FileException;

class Yaml extends File {
	public function load(string $filePath, FileCache $Cache = null): File {
		if (is_a($Cache, 'memCrab\Cache\RedisCache')) {
			$key = $Cache->fileKey($filePath);
			if ($Cache->exists($key)) {
				$this->content = $Cache->get($key);
			} else {
				$this->parseYamlFile($filePath);
				$Cache->set($key, $this->content);
			}
		} else {
			$this->parseYamlFile($filePath);
		}

		return $this;
	}

	private function parseYamlFile(string $filePath) {
		$this->checkFilePath($filePath);

		$this->content = \yaml_parse_file($filePath);
		if ($this->content === false) {
			throw new FileException(
				_("Can't parse yaml content from file:") . " " . $this->fullPath,
				501
			);
		}
	}
}
