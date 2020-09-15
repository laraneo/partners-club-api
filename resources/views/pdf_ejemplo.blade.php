<!DOCTYPE html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    </head>
    <style>
        /** Define the margins of your page **/
        .header {
            position: fixed;
            top: -60px;
            left: 0px;
            right: 0px;
            height: 50px;

            /** Extra personal styles **/
            background-color: #03a9f4;
            color: white;
            line-height: 35px;
        }

        .footer {
            position: fixed; 
            bottom: -60px; 
            left: 0px; 
            right: 0px;
            height: 30px; 
            /** Extra personal styles **/
            text-align: center;
        }
        .page-number:before {
            content: "Pagina " counter(page);
        }
    </style>
    <script type="text/php">
        if (isset($pdf)) {
            if($PAGE_COUNT > 0) {
            $text = "page {PAGE_NUM} / {PAGE_COUNT}";
            $size = 10;
            $font = $fontMetrics->get_font("helvetica", "bold");
            $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
            $y = 15;
            $x = 520;
            $pdf->page_text($x, $y, $text, $font, $size);
            }
        }
        
    </script>
    <body>
    <div>{{ $titulo }}</div>
    <div>{{ $titulo }}</div>
    <div>{{ $titulo }}</div>
    <div>{{ $titulo }}</div>
    <div>{{ $titulo }}</div>
    <div>{{ $titulo }}</div>
    <div>{{ $titulo }}</div>
    <div>{{ $titulo }}</div>
    <div>{{ $titulo }}</div>
    <div>{{ $titulo }}</div>
    <div>{{ $titulo }}</div>
    <div>{{ $titulo }}</div>
    <div>{{ $titulo }}</div>
    <div>{{ $titulo }}</div>
    <div>{{ $titulo }}</div>
    <div>{{ $titulo }}</div>
    <div>{{ $titulo }}</div>
    <div>{{ $titulo }}</div>
    <div>{{ $titulo }}</div>
    <div>{{ $titulo }}</div>
    <div>{{ $titulo }}</div>
    <div>{{ $titulo }}</div>
    <div>{{ $titulo }}</div>
    <div>{{ $titulo }}</div>
    <div>{{ $titulo }}</div>
    <div>{{ $titulo }}</div>
    <div>{{ $titulo }}</div>
    <div>{{ $titulo }}</div>
    <div>{{ $titulo }}</div>
    <div>{{ $titulo }}</div>
    <div>{{ $titulo }}</div>
    <div>{{ $titulo }}</div>
    <div>{{ $titulo }}</div>
    <div>{{ $titulo }}</div>
    <div>{{ $titulo }}</div>
    <div>{{ $titulo }}</div>
    <div>{{ $titulo }}</div>
    <div>{{ $titulo }}</div>
    <div>{{ $titulo }}</div>
    <div>{{ $titulo }}</div>
    <div>{{ $titulo }}</div>
    <div>{{ $titulo }}</div>
    <div>{{ $titulo }}</div>
    <div>{{ $titulo }}</div>
    <div>{{ $titulo }}</div>
    <div>{{ $titulo }}</div>
    <div>{{ $titulo }}</div>
    <div>{{ $titulo }}</div>
    <div>{{ $titulo }}</div>
    <div>{{ $titulo }}</div>
    <div>{{ $titulo }}</div>
    <div>{{ $titulo }}</div>
    <div>{{ $titulo }}</div>
    <div>{{ $titulo }}</div>
    <div>{{ $titulo }}</div>
    <div>{{ $titulo }}</div>
    <div>{{ $titulo }}</div>
    <div>{{ $titulo }}</div>
    <div>{{ $titulo }}</div>
    <div>{{ $titulo }}</div>
    <div>{{ $titulo }}</div>
    <div>{{ $titulo }}</div>
    <div>{{ $titulo }}</div>
    <div>{{ $titulo }}</div>
    </body>
</html>
