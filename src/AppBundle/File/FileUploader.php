<?php

namespace AppBundle\File;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Filesystem\Filesystem;

class FileUploader
{	
	private $pathToProject;
	private $uploadDirectoryFile;


	public function __construct($pathToProject, $uploadDirectoryFile) {
		$this->pathToProject = $pathToProject;
		$this->uploadDirectoryFile = $uploadDirectoryFile;
	}

	public function upload(UploadedFile $file, $salt) {
		
		$generatedFileName = time().'_'.$salt.'.'.$file->guessClientExtension();
         
        $path = $this->pathToProject.'/web'.$this->uploadDirectoryFile;

        $file->move($path, $generatedFileName);

        return $generatedFileName;
	}

	public function uploadReplace(UploadedFile $file, $salt, $old_file) {
		
		$generatedFileName = time().'_'.$salt.'.'.$file->guessClientExtension();
         
        $path = $this->pathToProject.'/web'.$this->uploadDirectoryFile;

        $filesystem = new Filesystem();
		$filesystem->remove($path.'/'.$old_file);

        $file->move($path, $generatedFileName);

        return $generatedFileName;
	}
}