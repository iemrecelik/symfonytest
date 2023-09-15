<?php

// src/Service/FileUploader.php
namespace App\Service;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class FileUploader
{
    private ?string $fullPathName = null;

    public function __construct(
        private string $targetDirectory,
        private SluggerInterface $slugger,
    ) {
    }

    public function upload(UploadedFile $file): string
    {
        $this->setFullPathName($file);

        try {
            $file->move($this->getTargetDirectory(), $this->getFullPathName());
        } catch (FileException $e) {
            dd($e);
            // ... handle exception if something happens during file upload
        }

        return $this->getFullPathName();
    }

    public function remove(String $path): bool
    {
        $filesystem = new Filesystem();
        $filesystem->remove("/var/images/$path");
        return true;
    }

    public function getTargetDirectory(): string
    {
        return $this->targetDirectory;
    }

    /**
     * Get the value of fullPathName
     */ 
    public function getFullPathName(): string
    {
        return $this->fullPathName;
    }

    /**
     * Set the value of fullPathName
     *
     */ 
    public function setFullPathName(UploadedFile $file): self
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        /* $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = $safeFilename.'-'.uniqid().'.'.$file->guessExtension(); */
        $fileName = uniqid().'.'.$file->guessExtension();

        $pathName = implode('/', [
			date('Y'),
			date('m'),
			date('d'),
			date('H'),
		]);

        $this->fullPathName = "{$pathName}/{$fileName}";

        return $this;
    }
}