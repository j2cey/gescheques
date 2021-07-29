<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WorkflowObjectFieldType;

class WorkflowObjectFieldTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createNew("Nombre Entier", "BIGINT_value");
        $this->createNew("Valeur Binaire", "BLOB_value");
        $this->createNew("Valeur booléenne", "BOOLEAN_value");
        $this->createNew("Caractère", "CHAR_value");
        $this->createNew("Date & Heure", "DATETIME_value");
        $this->createNew("Date", "DATE_value");
        $this->createNew("Nombre décimal (de précision 8.2)", "DECIMAL_value");
        $this->createNew("Nombre décimal (grande taille)", "DOUBLE_value");
        $this->createNew("Nombre décimal (petite taille)", "FLOAT_value");
        $this->createNew("Nombre entier (petite taille)", "INTEGER_value");
        $this->createNew("Adresse IP", "IPADDRESS_value");
        $this->createNew("Chaine de caractères", "STRING_value");
        $this->createNew("Texte", "TEXT_value");

        $this->createNew("Fichier", "FILE_ref");
    }

    private function createNew($name, $code)
    {
        $data = ['name' => $name, 'code' => $code];

        return WorkflowObjectFieldType::create($data);
    }
}
