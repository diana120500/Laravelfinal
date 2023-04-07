@extends('layouts.layout')
{{-- Para escribir el contenido de la pagina, hay que hacer una section con mismo nombre del yield en el archivo layout.balde.php  --}}
@section('content')
<div class="container">
    <form action="theraces" method="post">
        @csrf
        <div class="input-group col-lg-12" style="margin:20px 0 20px;">
            
                <input type="text" name="buscador" class="form-control col-lg-12" placeholder="Búsqueda..." aria-label="Recipient's username" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                    <input type="submit" value="Buscar" name="buscButton" class="btn btn-outline-secondary" type="button">
                    </div>
        </div>
    </form>

        <div class="divCarreras">
            <h1>Próximas Carreras</h1>

    
            <div class="row">
                <?php $limit=0; ?>
                @foreach($races as $race)
                    <?php
                    if ($limit!=12){
                        $id = $race['id'];

                        //control de fechas ESTO SÍ QUE FUNCIONA
                        $fecha_actual = strtotime(date("d-m-Y H:i:00",time()));
                        $newDate = strtotime($race['date']); 

                    if ($newDate>$fecha_actual){
                    ?>
                    <div class="col-lg-3">
                        <?php $prom=preg_replace('([^A-Za-z0-9 ])', '', $race['promotion'])?>
                        <img class="carrerasproximas" src="../resources/img/<?php echo strtolower($prom) ?>.jpg" alt="">
                        <h2>{{$race['title']}}</h2>
                        <p>{{$race['description']}}</p>
                        <p>{{$race['date']}}</p>
                        <a href="infoRace/{{$id}}"><div class="info but"><p>Más información</p></div></a>
                    </div>
                    <?php 
                    $limit++;
                    }
                    }
                    ?>
                @endforeach
            </div>
        </div>

        <!-- Fotos -->
        
        <!-- Finalizadas -->
        <div class="row">
                <h1>Últimas carreras finalizadas</h1>
                <?php $cont=0; ?>
                @foreach($fin as $f)
                    <?php
                    if($cont<4){
                        $id = $f['id'];

                        $fecha_actual = strtotime(date("d-m-Y H:i:00",time()));
                        $newDate = strtotime($f['date']); 

                        $hoy=now();
                        $carrera=$f->date;
                        $intervalo = $hoy->diff($carrera);

                        //Cogemos las carreras del ultimo mes con limite de 2, lo cogemos por descendente por lo tanto siempre saldrá la mas cercana primero
                        if ($newDate<$fecha_actual && $intervalo->m<=3){
                    ?>
                    <div class="col-lg-6">
                        <?php $prom=preg_replace('([^A-Za-z0-9 ])', '', $f['promotion'])?>
                        <img class="carrerasproximas"  src="../resources/img/<?php echo strtolower($prom) ?>.jpg" alt="">
                        <h2>{{$f['title']}}</h2>
                        <p>{{$f['description']}}</p>
                        <p>{{$f['date']}}</p>
                        <a href="infoRace/{{$id}}"><div class="info but"><p>Más información</p></div></a>
                    </div>
                        <?php 
                    //Limit 2
                    $cont++;
                    } 
                }?>
                @endforeach
            </div>
</div>
@endsection