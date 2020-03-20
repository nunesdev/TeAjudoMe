<?php
use Illuminate\Database\Seeder;

class UfTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (DB::table('ufs')->count() > 0) {
            $this->command->info('ufs table already has records. Skipping!');
            return;
        }
        
        DB::table('ufs')->insert([ 'name' => 'Acre', 'abbr' => 'AC']);
        DB::table('ufs')->insert([ 'name' => 'Alagoas', 'abbr' => 'AL']);
        DB::table('ufs')->insert([ 'name' => 'Amapá', 'abbr' => 'AP']);
        DB::table('ufs')->insert([ 'name' => 'Amazonas', 'abbr' => 'AM']);
        DB::table('ufs')->insert([ 'name' => 'Bahia', 'abbr' => 'BA']);
        DB::table('ufs')->insert([ 'name' => 'Ceará', 'abbr' => 'CE']);
        DB::table('ufs')->insert([ 'name' => 'Distrito Federal', 'abbr' => 'DF']);
        DB::table('ufs')->insert([ 'name' => 'Espírito Santo', 'abbr' => 'ES']);
        DB::table('ufs')->insert([ 'name' => 'Goiás', 'abbr' => 'GO']);
        DB::table('ufs')->insert([ 'name' => 'Maranhão', 'abbr' => 'MA']);
        DB::table('ufs')->insert([ 'name' => 'Mato Grosso', 'abbr' => 'MT']);
        DB::table('ufs')->insert([ 'name' => 'Mato Grosso do Sul', 'abbr' => 'MS']);
        DB::table('ufs')->insert([ 'name' => 'Minas Gerais', 'abbr' => 'MG']);
        DB::table('ufs')->insert([ 'name' => 'Pará', 'abbr' => 'PA']);
        DB::table('ufs')->insert([ 'name' => 'Paraíba', 'abbr' => 'PB']);
        DB::table('ufs')->insert([ 'name' => 'Paraná', 'abbr' => 'PR']);
        DB::table('ufs')->insert([ 'name' => 'Pernambuco', 'abbr' => 'PE']);
        DB::table('ufs')->insert([ 'name' => 'Piauí', 'abbr' => 'PI']);
        DB::table('ufs')->insert([ 'name' => 'Rio de Janeiro', 'abbr' => 'RJ']);
        DB::table('ufs')->insert([ 'name' => 'Rio Grande do Norte', 'abbr' => 'RN']);
        DB::table('ufs')->insert([ 'name' => 'Rio Grande do Sul', 'abbr' => 'RS']);
        DB::table('ufs')->insert([ 'name' => 'Rondônia', 'abbr' => 'RO']);
        DB::table('ufs')->insert([ 'name' => 'Roraima', 'abbr' => 'RR']);
        DB::table('ufs')->insert([ 'name' => 'Santa Catarina', 'abbr' => 'SC']);
        DB::table('ufs')->insert([ 'name' => 'São Paulo', 'abbr' => 'SP']);
        DB::table('ufs')->insert([ 'name' => 'Sergipe', 'abbr' => 'SE']);
        DB::table('ufs')->insert([ 'name' => 'Tocantins', 'abbr' => 'TO']);
        $this->command->info('Records 1 to 200 seeded!');
        
    }
}
