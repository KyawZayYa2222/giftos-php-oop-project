<?php
namespace App\Helper;

use Exception;

class FileUpload {

    // Note : upload files and folders will always store under 'assets' folder 
    // target directory is always under 'assets' folder

    private $targetDir;
    private $file;
    private $oldFile;

    function __construct($targetDir, $file, $oldFile = null) {
        $this->targetDir = $targetDir;
        $this->file = $file;
        $this->oldFile = $oldFile;
    }


    public function upload() {
        // making target directory to be under 'assets; folder 
        $maxDir = 6;
        $assetDir = '';
        for ($i=1; $i < $maxDir; $i++) { 
            if(is_dir(dirname(__DIR__,$i) . '/assets')) {
                $assetDir = dirname(__DIR__,$i) . '/assets/';
                break;
            }
        }

        // delete old file
        // this is for update {optional}
        $oldFileDir = $assetDir . $this->oldFile;
        if($this->oldFile != null && file_exists($oldFileDir)) {
            unlink($oldFileDir);
        }

        $targetFile = $assetDir . $this->targetDir . basename($this->file['name']);
        // $extension = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // move file to target dir 
        try {
            if(!is_dir($this->targetDir)) {
                if(!mkdir($this->targetDir, 0777, true)) {
                    throw new Exception("Fail creating directory");
                }
            } else {
                // if(file_exists($targetFile)) {
                //     unlink($targetFile);
                // }

                if(!move_uploaded_file($this->file['tmp_name'], $targetFile)) {
                    throw new Exception("Fail moving file to directory");
                };

                return $this->targetDir . $this->file['name'];
            }
        } catch(Exception $err) {
            echo "<div class='err-exception-con'>$err->getMessage()</div>";
        }
    }
}