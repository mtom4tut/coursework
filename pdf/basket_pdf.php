<?php
session_start();
require_once("/OpenServer/domains/coursework/fpdf/fpdf.php");

$link = mysqli_connect('localhost','root','root', 'coursework');
if(mysqli_errno($link))
{
    echo 'Ошибка: Не удалось установить соединение с базой данных.';
    exit;
}
mysqli_set_charset($link, "utf8");
$iduser = $_SESSION['user']['id'];
$result = mysqli_query($link, "SELECT g.title, g.price, (g.price -(g.price*(s.discount / 100))), s.discount, s.bonuses from goods g join shopping_cart sc on g.id = sc.id_good left join stock s on g.id = s.id_good WHERE sc.id_user = '$iduser' ");
$data = mysqli_fetch_all($result);


// Начало конфигурации
$textColour = array( 0, 0, 0 );
$headerColour = array( 100, 100, 100 );
$tableHeaderTopTextColour = array( 255, 255, 255 );
$tableHeaderTopFillColour = array(  54, 207, 133);
$tableHeaderTopСomponentTextColour = array( 0, 0, 0 );
$tableHeaderTopСomponentFillColour = array( 143, 173, 204 );
$tableHeaderLeftTextColour = array( 99, 42, 57 );
$tableHeaderLeftFillColour = array( 184, 207, 229 );
$tableBorderColour = array( 50, 50, 50 );
$tableRowFillColour = array( 242, 255, 249);

$reportName = "Корзина";
$reportNameYPos = 30;
$logoFile = "logo.png";
$logoXPos = 65;
$logoYPos = 10;
$logoWidth = 80;
$columnLabels = array("Название", "Цена без скидки","Цена со скидкой", "Скидка", "Бонусы");

$chartColours = array(
                  array( 255, 100, 100 ),
                  array( 255, 100, 100 ),
                  array( 100, 255, 100 ),
                  array( 100, 100, 255 ),
                  array( 100, 100, 255 ),
                );
// Конец конфигурации


// Создаем титульную страницу
$pdf = new FPDF( 'P', 'mm', 'A4' );

// Устанавлваем цвет текста
$pdf->SetTextColor($textColour[0], $textColour[1], $textColour[2]);

// Создаем страницу
$pdf->AddPage();
// Логотип
$pdf->Image( $logoFile, $logoXPos, $logoYPos, $logoWidth );


// Название отчета

$pdf->AddFont('DejaVuSerif', '', 'DejaVuSerif.php');
$pdf->SetFont( 'DejaVuSerif', '', 24 );

// Добавляем текст
$pdf->Ln( $reportNameYPos );

// Создаем колонтитул и вводный текст
$pdf->SetTextColor( $headerColour[0], $headerColour[1], $headerColour[2] );
$pdf->SetFont( 'DejaVuSerif', '', 17 );
$pdf->Cell( 0, 15, $reportName, 0, 0, 'C' );

$pdf->SetTextColor( $textColour[0], $textColour[1], $textColour[2] );
$pdf->SetFont( 'DejaVuSerif', '', 20 );



$pdf->SetDrawColor( $tableBorderColour[0], $tableBorderColour[1], $tableBorderColour[2] );
$pdf->Ln( 15 );

// Создаем строку заголовков таблицы
$pdf->SetFont( 'DejaVuSerif', '', 12 );

// Остальные ячейки заголовков
$pdf->SetTextColor( $tableHeaderTopTextColour[0], $tableHeaderTopTextColour[1], $tableHeaderTopTextColour[2] );
$pdf->SetFillColor( $tableHeaderTopFillColour[0], $tableHeaderTopFillColour[1], $tableHeaderTopFillColour[2] );

$pdf->Cell( 70, 12, $columnLabels[0], 1, 0, 'C', true );
$pdf->Cell( 40, 12, $columnLabels[1], 1, 0, 'C', true );
$pdf->Cell( 40, 12, $columnLabels[2], 1, 0, 'C', true );
$pdf->Cell( 20, 12, $columnLabels[3], 1, 0, 'C', true );
$pdf->Cell( 20, 12, $columnLabels[4], 1, 0, 'C', true );
$pdf->Ln( 12);

// Создаем строки с данными

$fill = false;
$row = 0;

foreach ( $data as $dataRow ) {

    // Создаем ячейки с данными
    $pdf->SetTextColor( $textColour[0], $textColour[1], $textColour[2] );
    $pdf->SetFillColor( $tableRowFillColour[0], $tableRowFillColour[1], $tableRowFillColour[2] );
    $pdf->SetFont( 'DejaVuSerif', '', 10 );

    $pdf->Cell( 70, 10, ($dataRow[0]), 1, 0, 'C', true );
    $pdf->Cell( 40, 10, ($dataRow[1]), 1, 0, 'C', true );
    $pdf->Cell( 40, 10, ($dataRow[2]), 1, 0, 'C', true );
    $pdf->Cell( 20, 10, ($dataRow[3]), 1, 0, 'C', true );
    $pdf->Cell( 20, 10, ($dataRow[4]), 1, 0, 'C', true );
    $row++;
    $pdf->Ln( 10);
}
$totalSum = $_SESSION['buy']['price'];

    $pdf->SetFont( 'DejaVuSerif', '', 15 );
    $pdf->SetTextColor( $tableHeaderLeftTextColour[0], $tableHeaderLeftTextColour[1], $tableHeaderLeftTextColour[2] );
    $pdf->SetFillColor( $tableHeaderLeftFillColour[0], $tableHeaderLeftFillColour[1], $tableHeaderLeftFillColour[2] );
    $pdf->Cell( 70, 10, "Итоговая сумма", 1, 0, 'C', $fill );

    $pdf->SetTextColor( $textColour[0], $textColour[1], $textColour[2] );
    $pdf->SetFillColor( $tableRowFillColour[0], $tableRowFillColour[1], $tableRowFillColour[2] );
    $pdf->SetFont( 'DejaVuSerif', '', 15);
    $pdf->Cell( 120, 10, ($totalSum. ' руб.'), 1, 0, 'R', $fill);
    $pdf->Ln( 10);

      $total_bonus = $_SESSION['buy']['bonus'];
    $pdf->SetFont( 'DejaVuSerif', '', 15 );
    $pdf->SetTextColor( $tableHeaderLeftTextColour[0], $tableHeaderLeftTextColour[1], $tableHeaderLeftTextColour[2] );
    $pdf->SetFillColor( $tableHeaderLeftFillColour[0], $tableHeaderLeftFillColour[1], $tableHeaderLeftFillColour[2] );
    $pdf->Cell( 70, 10, "Бонусов за покупку: ", 1, 0, 'C', $fill );

    $pdf->SetTextColor( $textColour[0], $textColour[1], $textColour[2] );
    $pdf->SetFillColor( $tableRowFillColour[0], $tableRowFillColour[1], $tableRowFillColour[2] );
    $pdf->SetFont( 'DejaVuSerif', '', 15);
    $pdf->Cell( 120, 10, ($total_bonus), 1, 0, 'R', $fill);

  /***
  Выводим PDF
***/

$pdf->Output( "report.pdf", "I" );

?>
