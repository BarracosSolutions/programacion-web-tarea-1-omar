<?php 
    //Lenght Constants
    define("MILIMETROS_A_PULGADAS",0.0394);
    define("CENTIMETROS_A_PULGADAS",0.394);
    define("METROS_A_PIES",3.2808);
    define("METROS_A_YARDAS",1.0936);
    define("METROS_A_BRAZAS",0.5468);
    define("KILOMETROS_A_MILLAS_TIERRA",0.6214);
    define("KILOMETROS_A_MILLAS_MAR_EU",0.5399);
    define("KILOMETROS_A_MILLAS_MAR_RU",0.5396);
    //Types of conversion
    $conversion_types_array = array("Longitud","Superficie","Volumen","Capacidad","Peso","Velocidad Potencia");
    //Measures array
    $lenght_measure_array   = array("Milímetros","Centrímetros","Metros","Kilómetros","Pulgadas","Pies",
                                    "Yardas","Brazas","Millas Tierra","Millas Mar (EU)","Millas Mar (RU)");
    $area_measure_array     = array("Milímetros&sup2;","Centímetros&sup2;","Metros&sup2;","Kilómetros&sup2;",
                                    "Hectáreas&sup2;","Pulgadas&sup2;","Pies&sup2;","Yardas&sup2;","Acres","Millas&sup2;");
    $volume_measure_array   = array("Centímetros&sup3;","Metros&sup3;","Pulgadas&sup3;","Pies&sup3;","Yardas&sup3;",
                                    "Galones (EU)","Galones (RU)");
    $capacity_measure_array = array("Litros","Hectolitros","Pulgadas&sup3;","Pies&sup3;","Galones (EU)","Pintas líquidas",
                                    "Quarter líquidas", "Galones (EU)", "Galones (RU)", "Bushels (EU)", "Bushels (RU)");
    $weight_measure_array   = array("Gramos", "Kilogramos","Toneladas&sup3;","Onzas (Av.)","Onzas (Troy)","Libras (Av.)",
                                    "Libras (Troy)","Libras","Toneladas (EU)","Toneladas (RU)");
    $speed_measure_array    = array("Kilómetros hora","Caballos de vapor","Millas por hora","Nudos","Caballos de fuerza"); 
    
    function isMetricTypeSelected(){
        return (isset($_GET["metric-type"]))? true : false;
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

    function createWeightAndMeasureSelect(){
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
                echo "<option>" . $data ."</option>";
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
            <span class="navbar-brand mb-0 h1">Metric Converter</span>
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
        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="get">
            <div class="form-group">
                <label for="from-measure"> De:
                <select class="form-control" id="from-measure" name="from-measure">
                    <?php 
                        createWeightAndMeasureSelect();
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="to-measure"> A:
                <select class="form-control" id="to-measure" name="to-measure">
                    <?php 
                        createWeightAndMeasureSelect();
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Calcular</button>
        </form>
        <section>
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