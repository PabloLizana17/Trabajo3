<?php
    use Illuminate\Foundation\Inspiring;
    use Illuminate\Support\Facades\Artisan;
    use Illuminate\Support\Facades\Log;

    function lectura_Aut($archivo)
    {
        Log::info("Lectura de archivo iniciada");

        $fp = fopen ($archivo,"r");
        $i = 0 ;
        $datos = array();
        while (!feof($fp)){
            $linea = fgets($fp);
            array_push($datos,$linea);
        }

        Log::info("Lectura de archivo terminada con exito");

            return $datos;
    }
    

    function lectura_automata($archivo)
    {
        Log::info("Inicio lectura de AFD");
        $arreglo = lectura_Aut($archivo);
        $data = array();

        $data['Cnodos']= intval($arreglo[0]);
        $i=0;
        $str="";
        while($arreglo[1][$i] != ',')
        {
            $str=$str.$arreglo[1][$i];
            $i++;
            
        }
        $data['inicio'] = intval($str); 
        $str= "";
        $i++;
        $aux = array();
        while($i<strlen($arreglo[1]))
        {
            while($i<strlen($arreglo[1]))
            {
                if($arreglo[1][$i] != ',')
                {
                $str=$str.$arreglo[1][$i];
                $i++;
                }
                else
                {   
                    array_push($aux,$str);
                    $str="";
                    $i++;
                }
            }
            
           array_push($aux,intval($str));
           $str="";        

       }
       $data['Fin'] = $aux;

       Log::info("Lectura de AFD terminada con exito");

       return $data;
    }

    function lectura_caminos($archivo)
    {
        Log::info("Inicio lectura de conexiones en AFD");

        $arreglo = lectura_Aut($archivo);
        $data = array();
        $data["caminos"]= array();
        $i=0;
        while(($i*2)+1<sizeof($arreglo)-1)
        {
            $a = trim($arreglo[($i*2)+1]);
            array_push($data['caminos'],$a);
            $i++;
        }

        $i=0;
        $data['caminos'] = array_unique($data['caminos']);

        $data['conexiones'] = array();

        while($i<sizeof($arreglo)-1)
        {
            
            $aux = array();
            $j=0;
            $str ='';
            
            
            while($arreglo[$i][$j] != ',')
            {
                $str=$str.$arreglo[$i][$j];
                $j++;

            }
            $aux[0]=intval($str);
            $j++;
            $str= "";

            while($j<strlen($arreglo[$i])-1)
            {
                $str=$str.$arreglo[$i][$j];
                $j++;
            }
            $aux[2]=intval($str);
            $i++;
            $aux[1]=trim($arreglo[$i]);
            array_push($data['conexiones'],$aux);
            
              
            $i++; 
        }

        Log::info("Lectura de caminos en AFD terminada con exito");

        return $data;

    }

    function lectura_ap($archivo)
    {
        log::info("Inicio lectura de AP");
        $arreglo = lectura_Aut($archivo);
        $data = array();
        $data['cantidad']= intval($arreglo[0]);
        $i=0;
        $str="";
        while($arreglo[1][$i] != ',')
        {
            $str=$str.$arreglo[1][$i];
            $i++;
            
        }
        $data['inicio'] = intval($str); 
        $str= "";
        $i++;
        while($i<strlen($arreglo[1]))
        {
            $str=$str.$arreglo[1][$i];
            $i++;
        }
        $data['fin'] = intval($str);

        Log::info("Lectura de AP terminada con exito");

        return $data;

    }

    function lectura_datos_ap($archivo)
    {
        log::info("Inicio lectura de datos AP");
        $arreglo = lectura_Aut($archivo);
        $data = array();
        $i=0;
        $data['conexiones']= array();
        $data['inicios']= array();
        $data['fines']= array();
        while($i<sizeof($arreglo)-1)
        {
            $aux = array();
            $j=0;
            $str = '';
            while($arreglo[$i][$j] != ',')
            {
                $str=$str.$arreglo[$i][$j];
                $j++;

            }
            $j++;
            array_push($data['inicios'],intval($str));
            $str= "";
            while($j<strlen($arreglo[$i]))
            {
                $str=$str.$arreglo[$i][$j];
                $j++;
            }
            array_push($data['fines'],intval($str));
            $i++;
            array_push($data['conexiones'],$arreglo[$i]);
            $i++;
        }

        Log::info("Lectura de datos AP terminada con exito");

        return $data;
        
    }





    ?>





   


