@extends('layouts.app')

@section('content')
<div class="container">


    <main class="col-md-1 ms-sm-auto col-lg-10 px-md-4">
        <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Old Dash</h1>

        </div>
    </main>

    <?php
function otrab($n,$k) {
return (strtotime($k)-strtotime($n))/86400;
 }
function na4isleniya($zp) {
    return array_sum($zp);
}
//    НИЖЕ можно менять
 $n='17-01-2023';   //  начало каденции
$k='27-03-2023';    //  конец каденции
$salary=70; //зарплата сутки
$ost=311; //остаток с прошлой каденции
$zp=[
        '17-01'=>350,
        '23-01'=>403,
        '30-01'=>402,
        '02-02'=>450,
        '10-02'=>445,
        '16-02'=>400,
        '22-02'=>360,
        '03-03'=>400,
        '10-03'=>518,
        '17-03'=>300,
        // '16-12'=>400,
        // '21-12'=>800,
        // '01-09'=>-30,//догруз
        // '02-09'=>350,
        // '09-09'=>455,
        // '14-09'=>1200,
    ];
///  ВЫШЕ можно менять
$na4isl=na4isleniya($zp);
$otrab=otrab($n,$k)+1;  //не включает один день.т.к.считает с 0 00 до 0 00
$dolg=($otrab*$salary+$ost)-$na4isl;
echo '<b>na4alo kadencii: </b>'.$n.'<br>'.'<b>konec kadencii: </b>'.$k.'<hr>';
echo 'otrabotano za kadenciu  '.$otrab.'<hr>';
echo 'zarabotano za kadenciu  '.($otrab*$salary).'<hr>';
echo 'ostatok s prowloj kadencii  '.$ost.'<hr>';
echo 'na4isleno (za minusom pokupok za nali4nye)  '.$na4isl.'<hr>'.'<hr>';
 //echo 'doplata s 01-01-2022==  '.'<b>130</b>'.'<hr>';
echo '<b>ostatok itogo:  '.'<i>'.$dolg.'</i>'.'</b>'.'<hr>'.'<hr>';
echo '<ul>';
foreach ($zp as $key => $value) {
    echo '<li>'.$key.' =>   '.' <b>'.$value.'</b>'.'</li>';
}echo '</ul>';
?>
</div>
@endsection
