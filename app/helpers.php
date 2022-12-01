<?php 
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

function getName($file)
{
    return Str::slug(preg_replace('/\s+/', '_', $file->getClientOriginalName())) . '-' . time() . '.' . $file->getClientOriginalExtension();
}
function upload($file, $uploadPath)
{
    $name = getName($file);
    $path = $uploadPath . '/' . $name;

    $disk = getDisk();
    Storage::disk($disk)->put($path, file_get_contents($file));

    return $name;
}
function getDisk()
{
    return  config('custom.upload.disk', 'local');
}
function addOrdinalNumberSuffix($num)
{
    if (!in_array(($num % 100), array(11, 12, 13))) {
        switch ($num % 10) {
                // Handle 1st, 2nd, 3rd
            case 1:
                return $num . 'st';
            case 2:
                return $num . 'nd';
            case 3:
                return $num . 'rd';
        }
    }
    return $num . 'th';
}
function clientUniqueCode($code, $key)
{
    $newOne = "";
    $newOne = $code . '-' . str_pad($key + 1, 6, '0', STR_PAD_LEFT);
    return $newOne;
}
