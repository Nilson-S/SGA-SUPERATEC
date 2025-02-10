<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificado de Finalización</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 0;
            padding: 0;
            background-size: cover;
        }

        .certificado {
            border: 15px solid #0073AA;
            padding: 50px;
            width: 80%;
            margin: 40px auto;
            background: white;
            text-align: center;
            position: relative;
        }

        .encabezado {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .logo {
            width: 100px;
            height: auto;
        }

        h1 {
            font-size: 36px;
            color: #0073AA;
            text-transform: uppercase;
            margin: 20px 0;
        }

        .nombre {
            font-size: 28px;
            font-weight: bold;
            text-transform: uppercase;
            margin: 20px 0;
            color: #333;
        }

        .detalle {
            font-size: 20px;
            color: #555;
        }

        .firma {
            margin-top: 50px;
            font-size: 18px;
            text-align: center;
        }

        .footer {
            margin-top: 30px;
            font-size: 14px;
            color: #777;
        }

        .linea {
            display: block;
            width: 250px;
            border-top: 2px solid #000;
            margin: 20px auto 5px;
        }
        .fondo {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: -1;
        opacity: 0.2; /* Ajusta la opacidad si lo deseas */
    }
    </style>
</head>

<body>
    <img src="{{ public_path('images/superatec.jpg') }}" class="fondo">
    <div class="certificado">
        <!-- Encabezado con logo -->
        <div class="encabezado">
            <img src="{{ public_path('images/logopng.png') }}" alt="Logo SuperaTec" class="logo">
            <h1>CERTIFICADO DE FINALIZACIÓN</h1>
        </div>

        <p class="detalle">Se otorga el presente certificado a:</p>
        <p class="nombre">{{ $calificacion->alumno->nombres }} {{ $calificacion->alumno->apellidos }}</p>

        <p class="detalle">Por haber aprobado satisfactoriamente el curso:</p>
        <p class="nombre">{{ $calificacion->curso->nombre }}</p>

        <p class="detalle">Con una calificación de <strong>{{ $calificacion->calificacion }}</strong></p>
        <p class="detalle">Fecha de finalización:
            <strong>{{ \Carbon\Carbon::parse($calificacion->created_at)->format('d/m/Y') }}</strong></p>

        <div class="firma">
            <span class="linea"></span><br>
            <strong>Director Académico</strong>
        </div>

        <div class="footer">
            <p>Instituto SuperaTec - Formación Académica</p>
            <p>www.superatec.edu.ve | contacto@superatec.edu.ve</p>
        </div>
    </div>
</body>

</html>
