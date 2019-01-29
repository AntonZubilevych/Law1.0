<?php
/**
 * Created by PhpStorm.
 * User: anton
 * Date: 21.01.19
 * Time: 22:59
 */

namespace App\Services;


use function PHPSTORM_META\map;

class Converter
{
    private $cyrilic = [
        'а','б','в','г','д','е','ё','ж','з','и','й','к','л','м','н','о','п',
        'р','с','т','у','ф','х','ц','ч','ш','щ','ъ','ы','ь','э','ю','я','ї','і','u',
        'А','Б','В','Г','Д','Е','Ё','Ж','З','I','Ї','И','Й','К','Л','М','Н','О','П',
        'Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Ъ','Ы','Ь','Э','Ю','Я'
    ];

    private  $latine = [
        'a','b','v','g','d','e','io','zh','z','i','y','k','l','m','n','o','p',
        'r','s','t','u','f','h','ts','ch','sh','sht','a','i','y','e','yu','ya','i','i','y',
        'A','B','V','G','D','E','Io','Zh','Z','I','I','I','Y','K','L','M','N','O','P',
        'R','S','T','U','F','H','Ts','Ch','Sh','Sht','A','I','Y','e','Yu','Ya'
    ];


    public  function toLatin(string $rawWord) : string
    {
        $url = str_replace( $this->cyrilic,$this->latine, $rawWord);
        return $url;
    }

    public function createUri(string $rawWord) : string
    {
        $output = $this->toLatin($rawWord);
        return $this->clean($output);
    }

    private function clean(string $input):string
    {
        $input = mb_strtolower($input);
        $input = preg_replace("/[^a-z0-9-s,]/i", "_", $input);
        return preg_replace("/_+/ui", "_", $input);
    }

    public  function toCirilic(string $rawWord) : string
    {
        return str_replace($this->latine, $this->cyrilic, $rawWord);
    }

    static function shorter(string $input, int $length = 500, bool $ellipses = true, bool $stripHtml = true): ?string
    {
        //strip tags, if desired
        if ($stripHtml) {
            $input = strip_tags($input);
        }

        //no need to trim, already shorter than trim length
        if (strlen($input) <= $length) {
            return $input;
        }

        //find last space within length
        $lastSpace = strrpos(substr($input, 0, $length), ' ');
        $trimmedText = substr($input, 0, $lastSpace);

        //add ellipses (...)
        if ($ellipses) {
            $trimmedText .= '...';
        }

        return $trimmedText;
    }

    static function callbackShorter(array  $array): ?array
    {
        array_map(function ($obj){
           return  $obj->setText(Converter::shorter($obj->getText()));
        },$array);

        return $array;
    }

}