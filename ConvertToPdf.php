<?php
require_once 'dompdf/autoload.inc.php';

use Dompdf\Dompdf; //подключаем библиотеку dompdf_1-0-2

$folder = 'D:\Folder'; //путь к файлу что конвертируем в pdf

function showTree($folder, $space) {
    /* Получаем полный список файлов и каталогов внутри $folder */
    $files = scandir($folder);
    foreach($files as $file) {
        /* Отбрасываем текущий и родительский каталог */
        if (($file == '.') || ($file == '..')) continue;
        $f0 = $folder.'/'.$file; //Получаем полный путь к файлу(папке)
        /* Если это директория */
        if (is_dir($f0)) {
            /* Выводим, делая заданный отступ, название директории */
            echo $space.$file."<br/>";
            /* С помощью рекурсии выводим содержимое полученной директории */
            showTree($f0 , $space.'&nbsp;&nbsp;');
        }
        /* Если это файл, то просто  выводим название файла */
        else echo Name($f0).$space.$file."<br/>"; //1. переименовываем txt|php|html в html
        //else echo fileToPdf($f0).$space.$file."<br/>"; //2. конвертируем html в df
    }
}


showTree($folder, ""); //выводим каталог


                                        //переименовываем txt|php|html в html
function Name($filename)
{
     rename($filename,preg_replace('"\.(txt|php|html)$"', '.html', $filename));
}


                                        //конвертирует html в pdf
function fileToPdf($path_file)
{
    $type_file = pathinfo($path_file,PATHINFO_EXTENSION);
    if( $type_file == 'html')
    {
        $file_name = pathinfo($path_file, PATHINFO_FILENAME); //получаем название
        $html = file_get_contents($path_file);//получаем содержимое файла
        $dompdf = new DOMPDF();
        $dompdf->loadHtml($html); //загружаем полученный html файл
        $dompdf->render();
        $output = $dompdf->output();
        $path =  dirname($path_file).'/'."{$file_name}.pdf"; //получаем путь и правильно переименованный файл в формат pdf
        file_put_contents($path, $output);
    }
}

