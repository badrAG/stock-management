<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Category::class,10)->create();
        factory(App\Marque::class,10)->create();
        factory(App\Modele::class,10)->create();
        factory(App\Fournisseur::class,10)->create();
        factory(App\Service::class,10)->create();
        factory(App\Agent::class,10)->create();
        factory(App\Article::class,11)->create();
        factory(App\Command::class,10)->create();
        factory(App\Reteurn::class,10)->create();
        factory(App\Demande::class,10)->create();

    }
}
