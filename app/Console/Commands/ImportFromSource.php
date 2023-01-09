<?php

namespace App\Console\Commands;

use App\Imports\ZipCodeImport;
use App\Models\ZipCodeStates;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class ImportFromSource extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:sources';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import from the different xls to the DB';

    /*
     * Define the different xls sources in the public/sources folder
     * */

    protected array $sources = ['Aguascalientes', 'Baja California Sur', 'Baja California', 'Campeche', 'Chiapas', 'Chihuahua', 'Ciudad de México', 'Coahuila de Zaragoza',
        'Colima', 'Durango', 'Guanajuato', 'Guerrero', 'Hidalgo', 'Jalisco', 'México', 'Michoacán de Ocampo', 'Morelos', 'Nayarit' , 'Nuevo León', 'Oaxaca',
        'Puebla', 'Querétaro', 'Quintana Roo', 'San Luis Potosí', 'Sinaloa', 'Sonora', 'Tabasco', 'Tamaulipas', 'Tlaxcala', 'Veracruz de Ignacio de la Llave', 'Yucatán',
        'Zacatecas'];

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {


        foreach ($this->sources as $source) {
            $route = public_path('sources\\' . $source . '.xls');
            $data = Excel::toArray(new ZipCodeImport, $route);
            array_shift($data);


            foreach ($data[0] as $key => $row) {

                if ($key != 0) {
                    ZipCodeStates::create([
                        'd_codigo' => $row[0] ?? '',
                        'd_asenta' => $row[1] ?? '',
                        'd_tipo_asenta' => $row[2] ?? '',
                        'd_mnpio' => $row[3] ?? '',
                        'd_estado' => $row[4] ?? '',
                        'd_ciudad' => $row[5] ?? '',
                        'd_cp' => $row[6] ?? '',
                        'c_estado' => $row[7] ?? '',
                        'c_oficina' => $row[8] ?? '',
                        'c_cp' => $row[9] ?? '',
                        'c_tipo_asenta' => $row[10] ?? '',
                        'c_mnpio' => $row[11] ?? '',
                        'id_asenta_cpcons' => $row[12] ?? '',
                        'd_zona' => $row[13] ?? '',
                        'c_cve_ciudad' => $row[14] ?? '',
                    ]);
                }
            }

        }


        return Command::SUCCESS;
    }
}
