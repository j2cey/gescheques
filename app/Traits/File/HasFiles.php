<?php

namespace App\Traits\File;

use SplFileInfo;
use App\Models\File;
use Illuminate\Http\Request;
use App\Traits\Data\HasData;

trait HasFiles
{
    use HasData;

    public function files() {
        $elem_type = get_called_class();
        return $this->hasMany(File::class, 'model_id', 'id')
            ->where('model_type', $elem_type)
            ;
    }

    public function file() {
        $elem_type = get_called_class();
        return $this->hasOne(File::class, 'model_id', 'id')
            ->where('model_type', $elem_type)->oldest()
            ;
    }

    public function deleteAllFiles() {
        //dd('HasFiles.deleteAllFiles',$this->files);
        //$this->files()->get(['id'])->each->delete();
        foreach ($this->files as $file) {
            $file->delete();
        }
    }

    public static function bootHasFiles()
    {
        static::deleting(function ($model) {
            //dd('bootHasFiles.deleting',$model);
            $model->deleteAllFiles();
        });
    }

    /**
     * @param Request $request
     * @param $fieldname_rqst
     * @param $file_role
     * @param string $directory
     * @param File $curr_file
     * @return File|null
     */
    public function verifyAndStoreFile( Request $request, $fieldname_rqst, $file_role, $directory = 'unknown', File $curr_file = null ) {

        if( $request->hasFile( $fieldname_rqst ) ) {

            if (!$request->file($fieldname_rqst)->isValid()) {

                flash('Fichier Invalide!')->error()->important();

                return null;//redirect()->back()->withInput();
            }

            $file_dir = config('app.' . $directory);

            // Check if the old file exists inside folder
            if (is_null($curr_file)) {
                $file_obj = new File();
            } else {
                $curr_file->deleteRawFile();
                $file_obj = $curr_file;
            }

            //dd("verifyAndStoreFile: ",$file_obj);

            $elem_type = get_called_class();

            // Set image name
            $file = $request->file($fieldname_rqst);
            $file_name = md5($directory . '_' . time()) . '.' . $file->getClientOriginalExtension();

            // Move image to folder
            $file->move($file_dir, $file_name);

            $file_obj->config_dir = $directory;
            $file_obj->model_type = $elem_type;
            $file_obj->model_id = $this->id;
            $file_obj->name = $file_name;
            $file_obj->role = $file_role;
            $file_obj->type = $file->getClientMimeType();
            $file_obj->size = $file->getSize();
            $file_obj->extension = $file->getClientOriginalExtension();

            $file_obj->save();

            return $file_obj;
        }

        return null;
    }

    public function createFile($name, $role, $config_dir, $filepath) {
        $elem_type = get_called_class();
        //$file_arr = explode($relativepath, "/");
        $file = new \SplFileInfo($filepath);
        $file = File::create([
            'model_type' => $elem_type,
            'model_id' => $this->id,
            'name' => $name,
            'role' => $role,
            'config_dir' => $config_dir,
            'type' => mime_content_type($filepath),
            'size' => $file->getSize(),
            'extension' => $file->getExtension(),
        ]);

        return $file;
    }

    public function splitFileIntoSubfiles($from_dir, $from_file, $to_dir, $subfile_max_line,$entete_premiere_ligne = false) {
        $raw_dir = config('app.RAW_FOLDER');
        $path = $raw_dir . '/' . config('app.' . $from_dir) . '/' . $from_file;
        //dd($path);
        //$file = File::get($path);
        $file_info = new SplFileInfo($path);
        $subfiles = [];

        $file_arr = file($file_info->getPathname());//file($path);

        if ($entete_premiere_ligne) {
            //remove first line
            $data = array_slice($file_arr, 1);
        } else {
            $data = $file_arr;
        }

        $parts = (array_chunk($data, $subfile_max_line));
        $parts_count = count($parts);

        if ($parts_count > 0) {
            $i = 1;
            $nb_rows_all = 0;
            $dest_dir = config('app.' . $to_dir);
            foreach ($parts as $line) {
                $filename = str_replace(['-', ' ', ':'], "", gmdate('Y-m-d h:i:s')) . '_' . $i . '.csv';
                $filename_full = $raw_dir.'/'.$dest_dir . '/' . $filename;

                file_put_contents($filename_full, $line);
                $i++;

                $nb_rows_curr = intval(exec("wc -l '" . $filename_full . "'"));
                //$subfiles[] = ['name' => $filename,'nb_rows' => $nb_rows_curr];
                array_push($subfiles, ['name' => $filename,'nb_rows' => $nb_rows_curr]);
            }
        }

        return $subfiles;
    }

    public static function getFileUploadMaxSize($type_wanted) {
        $val_mo = config('Settings.files.uploads.max_size.any');
        return self::convert_bytes($val_mo, "Mo", $type_wanted);
    }

    public static function getImageUploadMaxSize($type_wanted) {
        $val_mo = config('Settings.files.uploads.max_size.image');
        return self::convert_bytes($val_mo, "Mo", $type_wanted);
    }

    public static function getVideoUploadMaxSize($type_wanted) {
        $val_mo = config('Settings.files.uploads.max_size.video');
        return self::convert_bytes($val_mo, "Mo", $type_wanted);
    }

    public function setFile(File $file) : File {
        $elem_type = get_called_class();
        $file->update(['model_type' => $elem_type]);

        $this->files()->save($file);

        return $file;
    }
}
