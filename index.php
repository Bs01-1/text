<?php

    if($_POST['send_coder']){
        $input = mb_str_split(mb_strtoupper($_POST['coder']));

        $symbols = ['А' => '=', 'Б' => '**', 'В' => ')(', 'Г' => '#', 'Д' => "\"|\"", 'Е' => '><', 'Ё' => '~', 'Ж' => '&',
            'З' => '!!', 'И' => '<>', 'Й' => '(*)', 'К' => '%', 'Л' => 'Z', 'М' => '@', 'Н' => '}{', 'О' => '^V', 'П' => 'G',
            'Р' => '{}', 'С' => '[]', 'Т' => "\$", 'У' => '//', 'Ф' => '+', 'Х' => '|||', 'Ц' => 'W', 'Ч' => ':|:', 'Ш' => 'F',
            'Щ' => '№', 'Ъ' => "\\\"", 'Ы' => 'i' ,'Ь' => '{?}', 'Э' => '```', 'Ю' => ']|[', 'Я' => 'L', ' ' => ' ', '.' => '.', ',' => ',',
            '!' => '!'];

        $result = [];
        foreach ($input as $char) {
            foreach ($symbols as $key => $value){
                if ($char === $key) {
                    array_push($result, $value);
                }
            }
        }

        $coder = htmlspecialchars(implode($result));
    }

if($_POST['send_decoder']){
    $input = $_POST['decoder'];

    $symbols = ['=' => 'А', '**' => 'Б', ')(' => 'В', '#' => 'Г', "\"|\"" => 'Д', '><' => 'Е', '~' => 'Ё', '&' => 'Ж',
        '!!' => 'З', '<>' => 'И', '(*)' => 'Й', '%' => 'К', 'Z' => 'Л', '@' => 'М', '}{' => 'Н', '^V' => 'О', 'G' => 'П',
        '{}' => 'Р', '[]' => 'С', "\$" => "Т", "//" => 'У', '+' => 'Ф', '|||' => 'Х', 'W' => 'Ц', ':|:' => 'Ч', 'F' => 'Ш',
        '№' => 'Щ', "\\\"" => "Ъ", 'i' => 'Ы' ,'{?}' => 'Ь', '```' => 'Э', ']|[' => 'Ю', 'L' => 'Я', ' ' => ' ', '.' => '.', ',' => ',',
        '!' => '!'];

    $result = [];

    function str($count)
    {
        global $result;
        global $input;
        global $symbols;

        for ($i = 0; $i < $count; $i++)
            $char = $char . $input[$i];

        $bool = false;
        foreach ($symbols as $key => $value) {
            if ($key == $char) {
                $bool = true;
                array_push($result, $value);
                $input = substr($input, $count);
                $char = '';
                $count = 1;
                break;
            }
        }

        if (mb_strlen($input) == 0)
            echo '';
        elseif ($count >= 4) {
            array_push($result, '{Символ не найден}');
            $input = substr($input, $count);
            str($count = 1);
        }
        elseif ($bool === false) {
            str($count + 1);
        } else {
            str($count);
        }
    }
    str(1);

    $decoder = htmlspecialchars(implode($result));
}
?>

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="style.css">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    </head>
    <body>
        <div class="main-wrapper">
            <form class="form_coder" action="" method="post">
                <div class="coder_name">Кодер</div>
                <input required type="text" name="coder" placeholder="Для русских буковок" class="input">
                <input type="submit" name="send_coder" class="input" value="Отправить">
                <input type="text" value="<?=$coder?>" placeholder="Закодированый текст" class="input" onFocus="this.select()" id="coder">
                <button class="input" onclick="cut()">ВЫРЕЗАТЬ</button>
            </form>
            <script>
                function cut(){
                    let input = document.getElementById('coder');
                    input.select();
                    input.setSelectionRange(0, 99999)
                    document.execCommand("copy");
                    alert("Скопированный текст : \n" + input.value);
                }
            </script>
            <hr>
            <form class="form_decoder" action="" method="post">
                <div class="decoder_name">Де-кодер</div>
                <input required type="text" name="decoder" placeholder="Для символов" class="input">
                <input type="submit" name="send_decoder" class="input" value="Отправить">
                <textarea class="input" onFocus="this.select()" placeholder="Раскодированный текст" id="decoder"><?=$decoder?></textarea>
                <button class="input" onclick="cutq()">ВЫРЕЗАТЬ</button>
            </form>
            <script>
                function cutq(){
                    let input = document.getElementById('decoder');
                    input.select();
                    input.setSelectionRange(0, 99999)
                    document.execCommand("copy");
                    alert("Скопированный текст : \n" + input.value);
                }
            </script>
        </div>
    </body>
</html>

