<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Visit;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Expr\FuncCall;

class VisitApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $entry_date = Carbon::now();
        $request->merge(['entry_date' => $entry_date]);
        $visit = Visit::create($request->all()); 
        return response()->json([
            'data' => $visit,
            'message' => 'creado'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $visit = Visit::find($id);
        $departure_date = Carbon::now();
        $stay_in_minutes = Carbon::parse($visit->entry_date)->diffInMinutes($departure_date);

        $visit->departure_date = $departure_date;
        $visit->stay_in_minutes = $stay_in_minutes;
        $visit->save();


        $value_of_minute = 58;
        $visit->vehicle->total_minutes += $stay_in_minutes;
        if ($visit->vehicle->typeVehicle->name == 'Residente') {
            $visit->vehicle->value_for_pay = $value_of_minute * $visit->vehicle->total_minutes;
        } else {
            $visit->vehicle->value_for_pay = 0;
        }

        $visit->vehicle->save();

        return response()->json([
            'data' => $visit,
            'message' => 'creado'
        ], 200);
    }

    public function fizzBuzz()
    {
        $result = [];

        for ($i = 1; $i < 100; $i++) {

            $a = $i % 3;
            $b =  $i % 5;
            $rta = '';

            if ($a == 0) {
                $rta .= 'fizz';
            }

            if ($b == 0) {
                $rta .= 'buzz';
            }

            array_push($result,  $i . ' ' .  $rta);
        }

        return response()->json([
            'data' => $result,
            'mesagge' => 'fizzBuzz  '


        ]);
    }

    public function anagram(Request $request)
    {
        $a = $request->string1;
        $b = $request->string2;
        $count = 0;

        if ($a == $b) {
            return response()->json(false);
        }

        for ($i = 0; $i < strlen($a); $i++) {

            for ($j = 0; $j < strlen($b); $j++) {
                if ($a[$i] == $b[$j]) {
                    Log::info('si');
                    $b = substr_replace($b, "-", $j, 1);
                    $count++;
                } else {
                    Log::info('no');
                }
            }
            Log::info('********************************************');
        }

        if ($count == strlen($a) && strlen($a) == strlen($b)) {
            return response()->json(true);
        } else {
            return response()->json(false);
        }
    }

    public function number_prime()
    {
        $result = [];
        for ($n = 2; $n < 100; $n++) {
            $validate_number = true;
            for ($i = 2; $i < $n; $i++) {
                if ($n %  $i == 0) {
                    $validate_number = false;
                    break;
                }
            }

            if ($validate_number) {
                Log::info("si soy primo " . $n);
                $result[$n] =  'si soy primo';
            } else {
                Log::info("no soy primo " . $n);
                $result[$n] = 'no soy primo';
            }
        }

        return response()->json([
            'data'    => $result,
            'message' => 'resultado'
        ], 200);
    }

    public function polygon(Request $request)
    {
        Log::info($request->poligono);
        switch ($request->poligono) {
            case 'Triangulo':
                $area = ($request->dato1 * $request->dato2) / 2;
                return response()->json([
                    'data'    => $area,
                    'message' => 'resultado'
                ], 200);
                break;

            case 'Cuadrado':
                $area = $request->dato1 * $request->dato2;
                //A = l * l
                # code...
                return response()->json([
                    'data'    => $area,
                    'message' => 'resultado'
                ], 200);
                break;

            case 'Rectangulo':
                $area =  $request->dato1 *  $request->dato2;
                # code...
                return response()->json([
                    'data'    => $area,
                    'message' => 'resultado'
                ], 200);
                break;

            default:
                return response()->json([
                    'data'    => null,
                    'message' => 'datos incorrectos, verificalos e intenta de nuevo'
                ], 200);
                break;
                break;
        }
    }

    public function ratio()
    {
        $size = getimagesize("https://images.unsplash.com/photo-1503023345310-bd7c1de61c7d");

        preg_match_all('/\d+/', $size[3], $matches);

        $width = (int) $matches[0][0];
        $height = (int) $matches[0][1];

        do {
            $module = $width % $height;
            $width = $height;
            if ($module != 0) {
                $height = $module;
            }
        } while ($module != 0);

        $ratio = "El ratio de la imagen es: " . (int) $matches[0][0] /  $height . ":" . (int) $matches[0][1]  / $height;

    }

    public function countingWords(Request $request)
    {
        $string = mb_strtolower($request->string);
        $string_remove_comma = str_replace(',', '', $string);
        $words = explode(" ", $string_remove_comma);
        $result = [];

        foreach ($words as $key => $word) {
            $result[$word] = 1;
            foreach ($words as $key_comparate => $word_comparate) {

                if ($word == $word_comparate && $key_comparate != $key) {
                    $result[$word]++;
                }
            }
        }
        return response()->json([
            'data'    => $result,
            'message' => 'datos'
        ], 200);
    }

    public function matriz()
    {
        $matriz = array(
            array(0, 0, 0, 0),
            array(0, 0, 0, 0),
            array(0, 0, 0, 0),
            array(0, 0, 0, 0)
        );
        // $index = 0;

        foreach ($matriz as $key => $array_of_matriz) {
            foreach ($array_of_matriz as $key2 => $value) {

                if ($key == $key2) {
                    $matriz[$key][$key2] = 1;
                }
            }
        }

        Log::info($matriz);
    }

    public function matrizTable()
    {
        $matriz = [];

        for ($table = 1; $table < 11; $table++) {
            $grupo = [];

            for ($i = 1; $i < 11; $i++) {
                $result =  $table * $i;
                $grupo[] = [$table, $i, $result];
            }

            $matriz[] = $grupo;
        }


        foreach ($matriz as $key => $array_matriz) {
            foreach ($array_matriz as $key_2 => $array) {

                Log::info($array[0] . ' * ' . $array[1] . ' = ' . $array[2]);
            }
            Log::info('***************');
        }
        return $matriz;
    }

    public function decimalTobinary()
    {
        $number = 28;
        $result = [];



        do {
            array_unshift($result, $number % 2);
            $number = intval($number / 2);
            Log::info($number);
        } while ($number != 0);

        dd(implode("", $result));
    }

    public function morseCode(Request $request)
    {
        $abcedario = [
            'a' => '.-',
            'b' => '-...',
            'c' => '-.-.',
            'ch' => '----',
            'd' => '-..',
            'e' => '.',
            'f' => '..-.',
            'g' => '--.',
            'h' => '....',
            'i' => '..',
            'j' => '.---',
            'k' => '-.-',
            'l' => '.-..',
            'm' => '--',
            'n' => '-.',
            'o' => '---',
            'p' => '.--.',
            'q' => '--.-',
            'r' => '.-.',
            's' => '...',
            't' => '-',
            'u' => '..-',
            'v' => '...-',
            'x' => '-..-',
            'y' => '-.--',
            'z' => '--..',
            '0' => '-----',
            '1' => '.----',
            '2' => '..---',
            '3' => '...--',
            '4' => '....-',
            '5' => '.....',
            '6' => '-....',
            '7' => '--...',
            '8' => '---..',
            '9' => '----.',
            '.' => '.-.-.-',
            ',' => '--..--',
            '?' => '..--..',
            '"' => '.-..-.',
            ' ' => ' ',
        ];

        $string =  str_split(mb_strtolower($request->text));
        $result = "";

        foreach ($string as $key => $letter) {
            $result .= $abcedario[$letter] . " ";
        }

        return response()->json([
            'data'    => $result,
            'message' => 'datos'
        ], 200);
    }
}
