<?php
namespace App\Traits;

use Illuminate\Http\Request;

trait Uploadable {
    public function upload($file, $directory) {
        if ($file) {
            $name = mt_rand().'.'.$file->clientExtension();
            $file->move($directory, $name);
            return $name;
        }
        else {
            return null;
        }
    }
}