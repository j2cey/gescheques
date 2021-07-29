<?php

namespace Database\Seeders;

use App\Models\MimeType;
use Illuminate\Database\Seeder;

class MimeTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MimeType::createNew("image png","image/png","png");
        MimeType::createNew("image jpeg","image/jpeg","jpg");
        MimeType::createNew("image bmp","image/bmp","bmp");
        MimeType::createNew("fichier pdf","application/pdf","pdf");
    }
}
