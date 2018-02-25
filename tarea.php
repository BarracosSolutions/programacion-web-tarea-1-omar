<?php 
    //Lenght Constants
    define("MILIMETROS_A_METROS",0.001);
    define("CENTIMETROS_A_METROS",0.01);
    define("KILOMETROS_A_METROS",1000); 
    define("METROS_A_PULGADAS",39.4);
    define("METROS_A_PIES",3.2808);
    define("METROS_A_YARDAS",1.0936);
    define("METROS_A_BRAZAS",0.5468);
    define("KILOMETROS_A_MILLAS_TIERRA",0.6214);
    define("KILOMETROS_A_MILLAS_MAR_EU",0.5399);
    define("KILOMETROS_A_MILLAS_MAR_RU",0.5396);

    //Area constants
    define("CENTIMETROS3_A_METROS3",0.000001);
    define("METROS3_A_PIES3",35.3145);
    define("METROS3_A_YARDAS3",1.3079);
    define("METROS3_A_GALONES_EU",264.178);
    define("METROS3_A_GALONES_RU",219.976);
    define("METROS3_A_PULGADAS3",61000);

    //Types of conversion
    $conversion_types_array = array("Longitud","Superficie","Volumen","Capacidad","Peso","Velocidad Potencia");
    //Measures array
    $lenght_measure_array   = array("Milímetros","Centrímetros","Metros","Kilómetros","Pulgadas","Pies",
                                    "Yardas","Brazas","Millas Tierra","Millas Mar (EU)","Millas Mar (RU)");
    $area_measure_array     = array("Milímetros²","Centímetros²","Metros²","Kilómetros²",
                                    "Hectáreas²","Pulgadas²","Pies²","Yardas²","Acres","Millas²");
    $volume_measure_array   = array("Centímetros³","Metros³","Pulgadas³","Pies³","Yardas³",
                                    "Galones (EU)","Galones (RU)");
    $capacity_measure_array = array("Litros","Hectolitros","Pulgadas³","Pies³","Galones (EU)","Pintas líquidas",
                                    "Quarter líquidas", "Galones (EU)", "Galones (RU)", "Bushels (EU)", "Bushels (RU)");
    $weight_measure_array   = array("Gramos", "Kilogramos","Toneladas³","Onzas (Av.)","Onzas (Troy)","Libras (Av.)",
                                    "Libras (Troy)","Libras","Toneladas (EU)","Toneladas (RU)");
    $speed_measure_array    = array("Kilómetros hora","Caballos de vapor","Millas por hora","Nudos","Caballos de fuerza"); 
    
    function isMetricTypeSelected(){
        return (isset($_GET["metric-type"]))? true : false;
    }

    function isConversionFormSubmitted(){
        return (isset($_GET["metric-type"]) && isset($_GET["from-measure"]) && isset($_GET["from-measure-value"]))? true : false;
    }

    function areMeasuresSelected(){
        return isset($_GET["from-measure"]) && isset($_GET["to-measure"])? true : false;
    }

    function createConversionSelect(){
        global $conversion_types_array;
        foreach($conversion_types_array as $conversion_type){
            if(isMetricTypeSelected()){
                echo "<option " . ($_GET["metric-type"] === $conversion_type ? "selected=selected" : "" ) . ">" . $conversion_type;
            }
            else{
                echo "<option>".$conversion_type;
            }
            echo "</option>";
        }
    }

    function areMetricsSelectedEqual($from_measure, $to_measure){
        return ($from_measure === $to_measure)? true : false;
    }

    function calculateLenghtConversion($from_measure,$from_measure_value,$to_measure){
        $result_in_kilometers;
        $result_in_meters;
        if($from_measure === "Millas Tierra" || $from_measure === "Millas Mar (EU)" || $from_measure === "Millas Mar (RU)"){
            if($from_measure === "Millas Tierra" ) {  $result_in_kilometers = ($from_measure_value / KILOMETROS_A_MILLAS_TIERRA); }
            else if($from_measure === "Millas Mar (EU)") { $result_in_kilometers = ($from_measure_value / KILOMETROS_A_MILLAS_MAR_EU); }
            else if($from_measure === "Millas Mar (RU)") { $result_in_kilometers = ($from_measure_value / KILOMETROS_A_MILLAS_MAR_RU); }

            if($to_measure === "Kilómetros") { return $result_in_kilometers; }
            else if($to_measure === "Millas Tierra" || $to_measure === "Millas Mar (EU)" || $to_measure === "Millas Mar (RU)" ){
                //Para cuando el to son igual millas
                if($to_measure === "Millas Tierra")         { return ($result_in_kilometers * KILOMETROS_A_MILLAS_TIERRA); }
                else if($to_measure === "Millas Mar (EU)")  { return ($result_in_kilometers * KILOMETROS_A_MILLAS_MAR_EU); }
                else                                        { return ($result_in_kilometers * KILOMETROS_A_MILLAS_MAR_RU); }
            }
            else{
                $result_in_meters = ( $result / KILOMETROS_A_METROS );
                if($to_measure === "Milímetros")        { return ( $result_in_meters / MILIMETROS_A_METROS ); }
                else if($to_measure === "Centrímetros") { return ( $result_in_meters / CENTIMETROS_A_METROS );}
                else if($to_measure === "Pulgadas")     { return ( $result_in_meters * METROS_A_PULGADAS );   }
                else if($to_measure === "Pies")         { return ( $result_in_meters * METROS_A_PIES );       }
                else if($to_measure === "Yardas")       { return ( $result_in_meters * METROS_A_YARDAS );     }
                else if($to_measure === "Brazas")       { return ( $result_in_meters * METROS_A_BRAZAS );     }
                else{ /*Cuando el to sean metros*/       return    $result_in_meters;                         }
             }
        }
        else{
            if($from_measure === "Milímetros")          { $result_in_meters = $from_measure_value * MILIMETROS_A_METROS;    }
            else if($from_measure === "Centrímetros")   { $result_in_meters = $from_measure_value * CENTIMETROS_A_METROS;   }
            else if($from_measure === "Metros")         { $result_in_meters = $from_measure_value;                          }
            else if($from_measure === "Kilómetros")     { $result_in_meters = $from_measure_value / KILOMETROS_A_METROS;    }
            else if($from_measure === "Pulgadas")       { $result_in_meters = $from_measure_value / METROS_A_PULGADAS;      }
            else if($from_measure === "Pies")           { $result_in_meters = $from_measure_value / METROS_A_PIES;          }
            else if($from_measure === "Yardas")         { $result_in_meters = $from_measure_value / METROS_A_YARDAS;        }
            else if($from_measure === "Brazas")         { $result_in_meters = $from_measure_value / METROS_A_BRAZAS;        }

            if($to_measure === "Millas Tierra" || $to_measure === "Millas Mar (EU)" || $to_measure === "Millas Mar (RU)"){
                $result_in_kilometers = $result_in_meters / KILOMETROS_A_METROS;
                if($to_measure === "Millas Tierra")         { return ($result_in_kilometers * KILOMETROS_A_MILLAS_TIERRA); }
                else if($to_measure === "Millas Mar (EU)")  { return ($result_in_kilometers * KILOMETROS_A_MILLAS_MAR_EU); }
                else                                        { return ($result_in_kilometers * KILOMETROS_A_MILLAS_MAR_RU); }
            }
            else{
                if($to_measure === "Milímetros")        { return ( $result_in_meters / MILIMETROS_A_METROS ); }
                else if($to_measure === "Centrímetros") { return ( $result_in_meters / CENTIMETROS_A_METROS );}
                else if($to_measure === "Kilómetros")   { return ( $result_in_meters / KILOMETROS_A_METROS);  }
                else if($to_measure === "Pulgadas")     { return ( $result_in_meters * METROS_A_PULGADAS );   }
                else if($to_measure === "Pies")         { return ( $result_in_meters * METROS_A_PIES );       }
                else if($to_measure === "Yardas")       { return ( $result_in_meters * METROS_A_YARDAS );     }
                else if($to_measure === "Brazas")       { return ( $result_in_meters * METROS_A_BRAZAS );     }
                else{ /*Cuando el to sean metros*/       return    $result_in_meters;                         }
            }
        }
    }

    function calculateAreaConversion($from_measure,$from_measure_value,$to_measure){
        $result_in_kilometers2;
        $result_in_meters2;
        return 0;

    }

    function calculateVolumeConversion($from_measure,$from_measure_value,$to_measure){
        $result_in_meters3;
        if($from_measure === "Centímetros³")        { $result_in_meters3    = $from_measure_value * CENTIMETROS3_A_METROS3;}
        else if($from_measure === "Pulgadas³")      { $result_in_meters     = $from_measure_value * METROS3_A_PULGADAS3;}
        else if($from_measure === "Pies³")          { $result_in_meters3    = $from_measure_value * METROS3_A_PIES3;}
        else if($from_measure === "Yardas³")        { $result_in_meters3    = $from_measure_value * METROS3_A_YARDAS3;}
        else if($from_measure === "Galones (EU)")   { $result_in_meters3    = $from_measure_value * METROS3_A_GALONES_EU;}
        else if($from_measure === "Galones (RU)")   { $result_in_meters3    = $from_measure_value * METROS3_A_GALONES_RU;}
        else /*Cuando el from es metros*/           { $result_in_meters3    = $from_measure_value;}

        if($to_measure === "Metros³")               { return $result_in_meters3; }
        else if($to_measure === "Centímetros³")     { return $result_in_meters3 / CENTIMETROS3_A_METROS3;}
        else if($to_measure === "Pulgadas³")        { return $result_in_meters3 / METROS3_A_PULGADAS3;}
        else if($to_measure === "Pies³")            { return $result_in_meters3 / METROS3_A_PIES3;}
        else if($to_measure === "Yardas³")          { return $result_in_meters3 / METROS3_A_YARDAS3;}
        else if($to_measure === "Galones (EU)")     { return $result_in_meters3 / METROS3_A_GALONES_EU;}
        else if($to_measure === "Galones (RU)")     { return $result_in_meters3 / METROS3_A_GALONES_RU;}

    }

    function calculateCapacityConversion($from_measure,$from_measure_value,$to_measure){
        $result_in_kilometers2;
        $result_in_meters2;
        return 0;
    }

    function calculateWeightConversion($from_measure,$from_measure_value,$to_measure){
        $result_in_kilometers2;
        $result_in_meters2;
        return 0;
    }

    function calculateSpeedConversion($from_measure,$from_measure_value,$to_measure){
        $result_in_kilometers2;
        $result_in_meters2;
        return 0;
    }

    function showsConverterForm(){
        if(isConversionFormSubmitted()){
            $conversion_result;
            $from_measure       = $_GET["from-measure"];
            $to_measure         = $_GET["to-measure"];
            $from_measure_value = $_GET["from-measure-value"];
            $from_select        = 1;
            $to_select          = 2;
            
            if(areMetricsSelectedEqual($from_measure,$to_measure)){
                $conversion_result = $from_measure_value; 
            }
            else{
                switch ($_GET["metric-type"]){
                    case "Longitud":
                        $conversion_result = calculateLenghtConversion($from_measure,$from_measure_value,$to_measure);
                        break;
                    case "Superficie":
                        $conversion_result = calculateAreaConversion($from_measure,$from_measure_value,$to_measure);
                        break;
                    case "Volumen":
                        $conversion_result = calculateVolumeConversion($from_measure,$from_measure_value,$to_measure);
                        break;
                    case "Capacidad":
                        $conversion_result = calculateCapacityConversion($from_measure,$from_measure_value,$to_measure);
                        break;
                    case "Peso":
                        $conversion_result = calculateWeightConversion($from_measure,$from_measure_value,$to_measure);
                        break;
                    case "Velocidad Potencia":
                        $conversion_result = calculateSpeedConversion($from_measure,$from_measure_value,$to_measure);
                        break;
                }
            }
            
            echo "<form action='" . $_SERVER["PHP_SELF"] ."' method='get'>";
            echo "<div class='form-row'>";
            echo "<div class='form-group col-md-2'>";
            echo "<label for='from-measure'>De:</label>";
            echo "<select class='form-control' id='from-measure' name='from-measure'>";
            echo createWeightAndMeasureSelect($from_select);
            echo "</select>";
            echo "</div>";
            echo "<div class='form-group col-md-2'>";
            echo "<label for='from-measure-value'>Valor:</label>";
            echo "<input type='number' class='form-control' id='from-measure-value' name='from-measure-value' value=". $_GET["from-measure-value"] .">";
            echo "</div>";
            echo "<div class='form-group col-md-2'>";
            echo "<label for='to-measure'>A:</label>";
            echo "<select class='form-control' id='to-measure' name='to-measure'>";
            echo createWeightAndMeasureSelect($to_select);
            echo "</select>";
            echo "</div>";
            echo "<div class='form-group col-md-2'>";
            echo "<label for='to-measure-value'>Valor:</label>";
            echo "<input type='number' class='form-control' id='to-measure-value' name='to-measure-value' value=". $conversion_result ." disabled>";
            echo "</div>";
            echo "</div>";
            echo "<input id='metric' name='metric-type' type='hidden' value=". $_GET["metric-type"] . ">";
            echo "<button type='submit' class='btn btn-primary'>Calcular</button>";
            echo "</form>";
        }
        else if(isMetricTypeSelected()){
            echo "<form action='" . $_SERVER["PHP_SELF"] ."' method='get'>";
            echo "<div class='form-row'>";
            echo "<div class='form-group col-md-2'>";
            echo "<label for='from-measure'>De:</label>";
            echo "<select class='form-control' id='from-measure' name='from-measure'>";
            echo createWeightAndMeasureSelect($from_select);
            echo "</select>";
            echo "</div>";
            echo "<div class='form-group col-md-2'>";
            echo "<label for='from-measure-value'>Valor:</label>";
            echo "<input type='number' class='form-control' id='from-measure-value' name='from-measure-value'>";
            echo "</div>";
            echo "<div class='form-group col-md-2'>";
            echo "<label for='to-measure'>A:</label>";
            echo "<select class='form-control' id='to-measure' name='to-measure'>";
            echo createWeightAndMeasureSelect($to_select);
            echo "</select>";
            echo "</div>";
            echo "<div class='form-group col-md-2'>";
            echo "<label for='to-measure-value'>Valor:</label>";
            echo "<input type='number' class='form-control' id='to-measure-value' name='to-measure-value' disabled>";
            echo "</div>";
            echo "</div>";
            echo "<input id='metric' name='metric-type' type='hidden' value=". $_GET["metric-type"] . ">";
            echo "<button type='submit' class='btn btn-primary'>Calcular</button>";
            echo "</form>";
        }
    }

    function createWeightAndMeasureSelect($select_type){
        global $lenght_measure_array;
        global $area_measure_array;
        global $volume_measure_array;
        global $capacity_measure_array;
        global $weight_measure_array;
        global $speed_measure_array;
        $data_array;
        if(isMetricTypeSelected()){
            switch ($_GET["metric-type"]){
                case "Longitud":
                    $data_array = $lenght_measure_array;
                    break;
                case "Superficie":
                    $data_array = $area_measure_array;
                    break;
                case "Volumen":
                    $data_array = $volume_measure_array;
                    break;
                case "Capacidad":
                    $data_array = $capacity_measure_array;
                    break;
                case "Peso":
                    $data_array = $weight_measure_array;
                    break;
                case "Velocidad Potencia":
                    $data_array = $speed_measure_array;
                    break;
            }
            //Fill selects
            foreach($data_array as $data){
                if(areMeasuresSelected()){
                    echo "<option ";
                    if($select_type == 1){
                        echo $_GET["from-measure"] === $data ? "selected=selected" : "";
                    }
                    else{
                        echo $_GET["to-measure"] === $data ? "selected=selected" : "";
                    }
                    echo ">". $data;
                }
                else{
                    echo "<option>" . $data;
                }

                echo "</option>";
            }
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Metric Converter</title>
</head>
<body>
    <header>
        <nav class="navbar navbar-dark bg-dark">
            <span class="navbar-brand mb-0 h1">Convertido de Medidas</span>
        </nav>
    </header>
    <main class="container">
        <section style="margin: 5%;">
            <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" metod="get">
                <div class="form-group">
                    <label for="metric-type"> Seleccione un tipo de conversión
                    <select class="form-control" id="metric-type" name="metric-type">
                        <?php 
                            createConversionSelect();
                        ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Check</button>
            </form>
        </section>
        <section style="margin: 5%;">
            <?php
                showsConverterForm();
            ?>
        </section>
    </main>
    <footer class=".bg-secondary" style="position:absolute; width: 100%; bottom:0;">
        <div class="footer-copyright py-3 text-center">
            <div class="container-fluid">
            © 2018 Tarea de Programación Web. Ing.Omar Segura. </a>
            </div>
        </div>
    </footer>
</body>
</html>