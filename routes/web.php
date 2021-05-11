<?php

use Illuminate\Support\Facades\Route;

use Intervention\Image\ImageManagerStatic as Image;

use Johntaa\Arabic\Arabic;

Route::get('/', function () {
    return view('index');
});

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

Route::post('/', function () {
    $name = (string) request('name');

    $Arabic = new Arabic('Glyphs');
    $text = $Arabic->utf8Glyphs($name);

    $image_path = public_path('images\1.png');
    $image = Image::make($image_path);

    $image->text('" '.$text.' "', 500, 550, function($font) {
        $font->file(public_path('fonts\trado.ttf'));
        
        $font->size(60);
        
        $font->color('#ffffff');

        $font->align('center');

        $font->valign('bottom');
    });

    $tempPath = generateRandomString(15).'.png';

    $image->save(public_path("images\\".$tempPath), 80, 'png');

    return response()
        ->download(public_path("images\\".$tempPath))
        ->deleteFileAfterSend(true);
});