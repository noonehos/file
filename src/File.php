<?php
declare (strict_types = 1);
namespace memCrab\File;
use memCrab\Exceptions\FileException;

class File {
	protected $content;

	public function load(string $filePath, FileCache $Cache = null): File{
		$this->checkFilePath($filePath);

		$this->content = file_get_contents($this->filePath);
		return $this;
	}

	protected function checkFilePath(string $filePath): File {
		if (!is_readable($filePath)) {
			throw new FileException(
				_("Can't find or read file:") . " " . $filePath,
				501
			);
		}
		return $this;
	}

	public function getContent():  ? string {
		return $this->content;
	}
}