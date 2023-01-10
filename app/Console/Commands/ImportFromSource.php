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
                        'd_asenta' => strtoupper($this->formatString($row[1])) ?? '',
                        'd_tipo_asenta' => $row[2] ?? '',
                        'd_mnpio' => $row[3] ?? '',
                        'd_estado' => strtoupper($this->formatString($row[4])) ?? '',
                        'd_ciudad' => strtoupper($this->formatString($row[5])) ?? '',
                        'd_cp' => $row[6] ?? '',
                        'c_estado' => $this->formatString($row[7]) ?? '',
                        'c_oficina' => $row[8] ?? '',
                        'c_cp' => $row[9] ?? '',
                        'c_tipo_asenta' => $row[10] ?? '',
                        'c_mnpio' => $row[11] ?? '',
                        'id_asenta_cpcons' => $row[12] ?? '',
                        'd_zona' => strtoupper($this->formatString($row[13])) ?? '',
                        'c_cve_ciudad' => $row[14] ?? '',
                    ]);
                }
            }

        }


        return Command::SUCCESS;
    }

    function formatString($string){



        $string = str_replace(
            array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
            array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
            $string
        );

        $string = str_replace(
            array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
            array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
            $string );

        $string = str_replace(
            array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
            array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
            $string );

        $string = str_replace(
            array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
            array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
            $string );

        $string = str_replace(
            array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
            array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
            $string );

        $string = str_replace(
            array('ñ', 'Ñ', 'ç', 'Ç'),
            array('n', 'N', 'c', 'C'),
            $string
        );

        return $string;
    }
}
