<?php

use App\Models\Item;
use Illuminate\Database\Seeder;

class ItemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $i = 1;

        while ($i <= 10) {
            Item::create([
                'nome' => 'ItemSeeder(' . $i . ')',
                'quantidade' => 5 + $i,
                'unidade' => 'Kilos/Kg',
                'instituicao_id' => 1
            ]);
            $i++;
        }
    }
}
