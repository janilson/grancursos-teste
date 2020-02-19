<?php

namespace Modules\GranCursos\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\GranCursos\Entities\Assunto;

class AssuntoSeedTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Assunto::query()->delete();

        // Assunto Pai
        factory(Assunto::class, 5)->create();

        // Assunto Filhos
        Assunto::select()
            ->whereNull('id_assunto_pai')
            ->get()
            ->each(function (Assunto $assunto) {
                factory(Assunto::class, rand(2, 5))->make([
                    'id_assunto_pai' => $assunto->id_assunto
                ])->each(function (Assunto $assunto) {
                    $assunto->save();
                });
            });

        // Assunto Netos
        Assunto::select()
            ->whereNotNull('id_assunto_pai')
            ->limit(10)
            ->get()
            ->each(function (Assunto $assunto) {
                factory(Assunto::class, rand(1, 5))->make([
                    'id_assunto_pai' => $assunto->id_assunto
                ])->each(function (Assunto $assunto) {
                    $assunto->save();
                });
            });
    }
}
