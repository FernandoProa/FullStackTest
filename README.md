<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>


<p align="center">
<h1 align="center">Reto tecnico</h1>
</p>


<p>
    Se requirió el uso del framework Laravel para replicar la funcionalidad de una API dada (<a href="https://jobs.backbonesystems.io/api/zip-codes/%7Bzip_code">https://jobs.backbonesystems.io/api/zip-codes/%7Bzip_code</a>)   
</p>

<p>  
    Para ello se nos otorgó una fuente de información de la cual se extrajo lo necesario, para abordar este reto técnico priorizando el tiempo de respuesta de la aplicación se tomaron en cuenta las consideraciones siguientes:
</p>

<ul>
<li>El tiempo que toma la busqueda directamente desde los archivos de excel, sin la necesidad de una base de datos</li>
<li>La optimización de las búsquedas mediante el ORM de laravel y el uso de query builder (en caso de usar una base de datos)</li>
</ul>

<p>
   Dado lo anterior se tomó la decisión de crear un comando artisan para la realización de la migración de la información tomada desde los archivos de excel (php artisan import:sources) el cual se encarga de tomar la información, procesarla y crear los registros en la tabla para la cual ya se cuenta con su migración correspondiente.
   
</p>

<p>
Para continuar con un tiempo de respuesta óptimo, se usó Query builder en lugar de Orm para mejorar los tiempos de consulta de manera significativa, conservandolos por debajo de 300ms.
</p>

<p>
    Finalmente se crearon 3 sencillos test, los cuales pueden correrse desde su comando correspondiente (php artisan test) en el cual se probaron 3 casos:
</p>
  <ul>
    <li>Una búsqueda satisfactoria con la estructura json correspondiente</li>
    <li>Una búsqueda sin resultados</li>
    <li>Una búsqueda errónea, en la cual se ingrese algún tipo de dato no admitido o que no corresponde</li>
    </ul>
    
<h3>Correr el proyecto:</h3>
<ul>
<li>Crear la base de datos y configurar el .env</li>
<li>Correr las migraciones con php artisan migrate</li>
<li>Correr el comando php artisan import:sources (tomará un par de minutos en procesar los archivos) </li>
<li>Realizar las búsquedas necesarias por medio del endpoint /api/zip-codes/77560</li>
</ul>
