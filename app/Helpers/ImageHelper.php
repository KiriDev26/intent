<?php


namespace App\Helpers;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ImageHelper
{
    protected const PATH_AVATAR = 'public/avatar/';

    protected const PATH_IMAGE_TO_POST = 'public/post/';

    /**
     * @param Request $request
     * @param Model $model
     * @param string $field
     * @return bool
     */
    public static function saveImage(Request $request, Model $model, $field = 'avatar')
    {
        $validator = self::validate($request, $field);

        if ($request->file($field) && $validator->validate()) {

            $newName = self::PATH_AVATAR . $request->file($field)->getClientOriginalName();

            Storage::put($newName, $request->file($field));
            $model->update([
                $field => $newName
            ]);

            return true;
        }

        return false;
    }

    /**
     * @param Request $request
     * @param string $field
     * @return array
     */
    public static function saveImages(Request $request, $field = 'images')
    {
        $output = [];

        if ($request->$field) {
            foreach ($request->$field as $image) {
                $output[] = $image->store(self::PATH_IMAGE_TO_POST . $field);
            }
        }

        return $output;
    }

    /**
     * @param Request $request
     * @param $field
     * @return \Illuminate\Contracts\Validation\Validator
     */
    private static function validate(Request $request, $field)
    {
        return Validator::make($request->file(), [
            $field => 'image',
        ]);
    }
}
