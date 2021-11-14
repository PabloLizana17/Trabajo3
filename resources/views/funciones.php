<?php

    require("Administracion_de_datos.php");

    use Illuminate\Foundation\Inspiring;
    use Illuminate\Support\Facades\Artisan;
    use Illuminate\Support\Facades\Log;

    function crearmatriz()
    {
        $data1=lectura_automata("AFD_status.txt");
        $data=lectura_caminos("AFD_relleno.txt");
        $matriz=array();
        $aux=array();

        Log::info("Creando matriz para AFD");

        for($i=0;$i<$data1["Cnodos"];$i++)
        {
            for($j=0;$j<$data1["Cnodos"];$j++)
            {
                array_push($aux,array());
            }
            array_push($matriz,$aux);
        }

        Log::info("Matriz creada con exito");
        Log::info("Inicio de llenado de matriz con datos del usuario");

        for($k=0;$k<sizeof($data["conexiones"]);$k++)
        {
            array_push($matriz[$data["conexiones"][$k][0]][$data["conexiones"][$k][2]],$data["conexiones"][$k][1]);
        }

        Log::info("Matriz llenada con exito");

        return $matriz;
    }

    function camino()  
    {
        $data1=lectura_automata("AFD_status.txt");
        $matriz=crearmatriz();
        $final=$data1["Fin"];
        $auto="";
        $j=$data1["inicio"];
        $l=0;

        Log::info("Inicio de recorrido matriz de AFD");

        for($n=0;$n<sizeof($final);$n++)
        {
            $auto=$auto."[";
            while($j!=$final[$n])
            {
                if(!empty($matriz[$j][$l]))
                { 
                    $auto=$auto."(";
                    $aux=$matriz[$j][$l];
                    for($k=0;$k<sizeof($aux);$k++)
                    {
                        if($k==0)
                        {
                            $auto=$auto.$aux[$k];
                        }
                        else
                        {
                            $auto=$auto."+".$aux[$k];
                        }
                    }
                    $auto=$auto.")";
                    if($j==$l)
                    {
                        $auto=$auto."*";
                        $l++;
                    }
                    else
                        $j=$l;
                }
                else
                    $l++;
            }
            if($n==sizeof($final)-1)
            {
                $auto=$auto."]";
            }
            else
                $auto=$auto."]+";
        }

        Log::info("Recorrido completado");
        Log::info("Camino obtenido exitosamente");

        print($auto);
    }

    function crearmatrizap($archivo1,$archivo2)
    {
        $data1=lectura_ap($archivo1);
        $data=lectura_datos_ap($archivo2);
        $matriz=array();
        $aux=array();

        Log::info("Creando matriz para AP");

        for($i=0;$i<$data1["cantidad"];$i++)
        {
            for($j=0;$j<$data1["cantidad"];$j++)
            {
                array_push($aux,array());
            }
            array_push($matriz,$aux);
        }

        Log::info("Matriz creada con exito");
        Log::info("Inicio de llenado de matriz con datos del usuario");

        for($k=0;$k<sizeof($data["conexiones"]);$k++)
        {
            array_push($matriz[$data["inicios"][$k]][$data["fines"][$k]],$data["conexiones"][$k]);
        }

        Log::info("Matriz llenada con exito");

        return $matriz;
    }

    function camino_ap($matriz,$archivo,$archivo1)
    {
        $data1=lectura_datos_ap($archivo1);
        $data=lectura_ap($archivo);
        $auto="";
        $i=$data["inicio"];
        $final=$data["fin"];
        $aux=array();
        $aux2="";
        $j=$i;
        $m=0;
        $pila=array();
        $k=array();
        $h=array();
        $f=array();
        $g=array();
        $cont=0;

        Log::info("Inicio de recorrido de matriz de AP");

        do
        {
            if(!empty($matriz[$i][$j]))
            {
                for($x=0;$x<sizeof($matriz[$i][$j]);$x++)
                {
                    array_push($aux,$matriz[$i][$j][$x]);
                }

                $aux2=$aux2.$aux[$m];
            
                if($aux2[2]=="E")
                {
                    if($aux2[0]!="E" && $aux2[4]!="E")
                    {
                        array_push($pila,$aux2[4]);
                        array_push($k,$aux2[0]);
                    }
                    elseif($aux2[0]=="E" && $aux2[4]!="E")
                    {
                        array_push($pila,$aux2[4]);;
                    }
                    elseif($aux2[0]!="E" && $aux2[4]=="E")
                    {
                        array_push($k,$aux2[0]);
                    }
                    if($aux=="E/E/E" && $i==$j)
                    {
                        do
                        {
                            $m++;
                            if($m>=sizeof($aux))
                            {
                                $j++;
                                $m=0;
                            }
                            if($j>=$data1["cantidad"])
                            {
                                array_pop($pila);
                                array_pop($k);
                                $i=array_pop($h);
                                $j=array_pop($f);
                                $m=array_pop($g)+1;
                            }
                        }while($m>=sizeof($aux));
                    }
                    else
                    {
                        array_push($h,$i);
                        array_push($f,$j);
                        array_push($g,$m);
                        $i=$j;
                    }
                }
                elseif($aux2[2]!="E" && empty($pila))
                {
                    do
                    {
                        $m++;
                        if($m>=sizeof($aux))
                        {
                            $j++;
                            $m=0;
                        }
                        if($j>=$data1["cantidad"])
                        {
                            array_pop($pila);
                            array_pop($k);
                            $i=array_pop($h);
                            $j=array_pop($f);
                            $m=array_pop($g)+1;
                        }
                    }while($m>=sizeof($aux));
                }
                elseif($aux2[2]!="E" && !empty($pila))
                {
                    $a=array_pop($pila);
                    if($a!=$aux2)
                    {
                        do
                        {
                            $m++;
                            if($m>=sizeof($aux))
                            {
                                $j++;
                                $m=0;
                            }
                            if($j>=$data1["cantidad"])
                            {
                                array_pop($pila);
                                array_pop($k);
                                $i=array_pop($h);
                                $j=array_pop($f);
                                $m=array_pop($g)+1;
                            }
                        }while($m>=sizeof($aux));
                    }
                    else
                    {
                        if($aux2[0]!="E" && $aux2[4]!="E")
                        {
                            array_push($pila,$aux2[4]);
                            array_push($k,$aux2[0]);
                        }
                        elseif($aux2[0]=="E" && $aux2[4]!="E")
                        {
                            array_push($pila,$aux2[4]);
                        }
                        elseif($aux2[0]!="E" && $aux2[4]=="E")
                        {
                            array_push($k,$aux2[0]);
                        }
                        if($aux=="E/E/E" && $i==$j)
                        {
                            do
                            {
                                $m++;
                                if($m>=sizeof($aux))
                                {
                                    $j++;
                                    $m=0;
                                }
                                if($j>=$data1["cantidad"])
                                {
                                    array_pop($pila);
                                    array_pop($k);
                                    $i=array_pop($h);
                                    $j=array_pop($f);
                                    $m=array_pop($g)+1;
                                }
                            }while($m>=sizeof($aux));
                        }
                        else
                        {
                            array_push($h,$i);
                            array_push($f,$j);
                            array_push($g,$m);
                            $i=$j;
                        }
                    }
                }
            }
            else
                $j++;

            if($cont>=75)
                break;
            $cont++;

        }while($i!=$final && !empty($pila));

        if($cont<75)
        {
            Log::info("Recorrido completado con exito");
            Log::info("Inicio obtencion de camino");

            for($i=0;$i<sizeof($k);$i++)
            {
                $auto=$auto.$k[$i];
            }

            Log::info("Camino obtenido correctamente");
        }
        else
            Log::error("Hubo un error para obtener su camino, por favor revise que sus datos sean ingresados correctamente, en caso de mas problemas pongase en contacto con el programador");

        return $auto;
    }

    function union()
    {
        $matriz1=crearmatrizap("AP_status1.txt","AP_relleno1.txt");
        $matriz2=crearmatrizap("AP_status2.txt","AP_relleno2.txt");
        $auto="";
        $camino1=camino_ap($matriz1,"AP_status1.txt","AP_relleno1.txt");
        $camino2=camino_ap($matriz2,"AP_status2.txt","AP_relleno2.txt");

        if($camino1=="")
        {
            Log::warning("No hay camino para automata de pila 1");
            print("No se encontro camino para automata de pila 1");
            echo "</br>";
        }
        if($camino2=="")
        {
            Log::warning("No hay camino para automata de pila 2");
            print("No se encontro camino para automata de pila 2");
        }

        Log::info("Inicio obtencion de union de AP 1 y AP 2");

        $auto=$camino1.$camino2;

        if($auto!="")
        {
            Log::info("Union obtenida con exito");
            print($auto);
        }
        else
        {
            Log::error("No se logro obtener la union de sus AP, por favor revise que sus datos sean ingresados correctamente, en caso de mas problemas pongase en contacto con el programador");
        }
    }

    function concatenacion()
    {
        $matriz1=crearmatrizap("AP_status1.txt","AP_relleno1.txt");
        $matriz2=crearmatrizap("AP_status2.txt","AP_relleno2.txt");
        $auto="";
        $camino1=camino_ap($matriz1,"AP_status1.txt","AP_relleno1.txt");
        $camino2=camino_ap($matriz2,"AP_status2.txt","AP_relleno2.txt");

        if($camino1=="")
        {
            Log::warning("No hay camino para automata de pila 1");
            print("No se encontro camino para automata de pila 1");
        }
        if($camino2=="")
        {
            Log::warning("No hay camino para automata de pila 2");
            print("No se encontro camino para automata de pila 2");
        }

        Log::info("Inicio obtencion de concatenacion de AP 1 y AP 2");

        for($i=0;$i<strlen($camino1);$i++)
        {
            $auto=$auto.$camino1[$i];
            if($i<strlen($camino2))
                $auto=$auto.$camino2[$i];
            else
                $auto=$auto.$camino1[$i];
        }
        if($i<strlen($camino2))
        {
            for($j=$i;$j<strlen($camino2);$j++)
            {
                $auto=$auto.$camino2[$j];
            }
        }

        if($auto!="")
        {
            Log::info("Concatenacion obtenida con exito");
            print($auto);
        }
        else
        {
            Log::error("No se logro obtener la concatenacion de sus AP, por favor revise que sus datos sean ingresados correctamente, en caso de mas problemas pongase en contacto con el programador");
        }
    }
?>