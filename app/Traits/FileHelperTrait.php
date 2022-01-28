<?php

namespace App\Traits;

use App\Persistence\Models\TemporaryFiles;
use Illuminate\Http\UploadedFile;

trait FileHelperTrait {

    /**
     * This function handles deleting existing file
     *
     * @param String $file_path
     * @return void
     */
    public function removeExistingFile($file_path) {
        if ($this->checkFile($file_path))
            unlink(public_path($file_path));
    }

    /**
     * This function handles uploading a file
     *
     * @param Object $file
     * @param String $file_path
     * @return String
     */
    public function handleFileUpload(UploadedFile $file, string $file_path, bool $toPublic = true, bool $temporary = false) {
        $public = $toPublic ? '/public/' : '';
        $newFileName  = uniqid()."-".time();
        $extension    = $file->getClientOriginalExtension();
        $newPhotoName  = $newFileName.'.'.$extension;
        $path         = $file->storeAs($public.$file_path, $newPhotoName);
        if($temporary){
            $this->saveTemporaryFile($newPhotoName, $file_path);
        }
        return $newPhotoName;
    }

    /** Save temporary file reference to database
     * @param string $filename
     * @param string $directory
     */
    private function saveTemporaryFile(string $filename, string $directory){
        TemporaryFiles::create([
            'directory' => $directory,
            'filename' => $filename
        ]);
    }

    private function deleteTempFile(string $filename, bool $removeFile = true){
        $tempFile = TemporaryFiles::where('filename', $filename)->first();
        //delete from folder
        if($removeFile) $this->removeExistingFile($tempFile->directory . $tempFile->filename);
        //remove from DB
        return $tempFile->delete();
    }

    /**
     * Checks if a file exist.
     * @param string $file
     * @return bool
     */
    public function checkFile(string $file='') : bool
    {
        $file       = "/".ltrim($file, "/");
        $filePath   = public_path($file);
        return !empty($filePath) && is_file($filePath) && file_exists($filePath);
    }
}
