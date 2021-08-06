<?php


namespace App\Traits\File;

use Illuminate\Support\Facades\File;

trait FilesScanning
{
    public function moveFiles($path, $config_dir_destination, $delete_origin_file = false) {

        $raw_dir = config('app.RAW_FOLDER');
        $config_dir_path = $raw_dir . '/' . config('app.' . $config_dir_destination) . '/';

        $files = File::allFiles($path);
        $files_count = count($files);

        $file_paths = [];

        $i = 0;
        foreach ($files as $file) {
            $newfile_name = str_replace(['-', ' ', ':'], "", gmdate('Y-m-d h:i:s')) . '_' . $i . '_.' . $file->getExtension();
            $newfile_path  = $config_dir_path . $newfile_name;
            File::copy($file->getPathname(), $newfile_path);
            $file_paths[$newfile_name] = $newfile_path;

            if ($delete_origin_file) {
                unlink($file->getPathname());
            }

            $i++;
        }

        return $file_paths;
    }
}
