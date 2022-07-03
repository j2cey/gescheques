<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class ModelType
 * @package App\Models
 *
 * @property integer $id
 * @property string $code
 *
 * @property string $label
 * @property string $namespace
 * @property string $relative_type
 * @property string $full_type
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class ModelType extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * @return HasMany|ModelAttribute
     */
    public function modelattributes() {
        return $this->hasMany(ModelAttribute::class, 'model_type_id');
    }

    private function getModels($path, $namespace){
        $out = [];

        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator(
                $path
            ), \RecursiveIteratorIterator::SELF_FIRST
        );
        foreach ($iterator as $item) {
            /**
             * @var \SplFileInfo $item
             */
            if($item->isReadable() && $item->isFile() && mb_strtolower($item->getExtension()) === 'php'){
                $out[] =  $namespace .
                    str_replace("/", "\\", mb_substr($item->getRealPath(), mb_strlen($path), -4));
            }
        }
        return $out;
    }

    public static function getAllModels(): array
    {
        $composer = json_decode(file_get_contents(base_path('composer.json')), true);
        $models = [];
        foreach ((array)data_get($composer, 'autoload.psr-4') as $namespace => $path) {
            $models = array_merge(collect(File::allFiles(base_path($path)))
                ->map(function ($item) use ($namespace) {
                    $path = $item->getRelativePathName();
                    return sprintf('\%s%s',
                        $namespace, strtr(substr($path, 0, strrpos($path, '.')), '/', '\\')
                    );
                })
                ->filter(function ($class) {
                    $valid = false;
                    if (class_exists($class)) {
                        $reflection = new \ReflectionClass($class);
                        $valid = $reflection->isSubclassOf(\Illuminate\Database\Eloquent\Model::class) &&
                            !$reflection->isAbstract();
                    }
                    return $valid;
                })
                ->values()
                ->toArray(), $models);
        }

        $models_final_array = [];

        $id = 0;
        foreach ($models as $model) {
            $model = trim($model);
            $model = trim($model, '\\');

            $model_tmp_arr = explode('\\', $model );
            // split string by ucfirst
            $val_arr = preg_split('/(?=[A-Z])/', $model_tmp_arr[2] );
            $label = trim( implode(" ", $val_arr ) );
            $models_final_array[] = [
                'code' => implode('', $model_tmp_arr),
                'label' => $label,
                'namespace' => $model_tmp_arr[0] . '\\' . $model_tmp_arr[1],
                'relative_type' => $model_tmp_arr[2],
                'full_type' => implode('\\', $model_tmp_arr),
            ];
            $id++;
        }

        return $models_final_array;
    }

    public static function getModelAttributes($model) {
        $attributes_raw = \Schema::getColumnListing((new $model)->getTable());
        $modelattributes = [];

        foreach ($attributes_raw as $attribute) {
            $modelattributes[] = ['label' => $attribute];
        }

        return $modelattributes;
    }

    public static function updateList() {
        $curr_models_arr = self::getAllModels();
        foreach ($curr_models_arr as $curr_model) {
            if( ! ModelType::where('code', $curr_model['code'])->first() ) {
                $modeltype = ModelType::create($curr_model);
                $modeltype->modelattributes()->createMany(
                    self::getModelAttributes($modeltype->full_type)
                );
            }
        }
    }
}
