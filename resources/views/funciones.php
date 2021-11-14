<?php

    require("Administracion_de_datos.php");

    function crearmatriz()
    {
        $data1=lectura_automata("AFD_status.txt");
        $data=lectura_caminos("AFD_relleno.txt");
        $matriz=array();
        $aux=array();

        for($i=0;$i<$data1["Cnodos"];$i++)
        {
            for($j=0;$j<$data1["Cnodos"];$j++)
            {
                array_push($aux,array());
            }
            array_push($matriz,$aux);
        }

        for($k=0;$k<sizeof($data["conexiones"]);$k++)
        {
            array_push($matriz[$data["conexiones"][$k][0]][$data["conexiones"][$k][2]],$data["conexiones"][$k][1]);
        }

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
        
        print($auto);
    }
?>