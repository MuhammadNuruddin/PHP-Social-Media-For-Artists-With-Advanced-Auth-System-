<?php
$file = file_get_contents('json.json');
$file_decode = json_decode($file,TRUE);

$test_array = array();

$students = $file_decode['marksheet']['students'];
// var_dump($students);
foreach ($students as $key => $value) {
    foreach($value['exam_result'] as $row => $data){
        // var_dump($data);
        foreach($data as $info => $get) {
            // var_dump($get);
            // array_push($score_info,$get);
            if($get['exam_group_class_batch_exams_id'] == 1) {
                // assignment
                array_push($test_array, array("assignment" => array(
                    'name' => $get['name'], 'exam_group_class_batch_exams_id' => $get['exam_group_class_batch_exams_id'], 'get_marks' => $get['get_marks']
                )));
            }
            if($get['exam_group_class_batch_exams_id'] == 2) {
                // test
                array_push($test_array, array("test" => array(
                    'name' => $get['name'], 'exam_group_class_batch_exams_id' => $get['exam_group_class_batch_exams_id'], 'get_marks' => $get['get_marks']
                )));
            }
            if($get['exam_group_class_batch_exams_id'] == 4) {
                // exam
                array_push($test_array, array("exam" => array(
                    'name' => $get['name'], 'exam_group_class_batch_exams_id' => $get['exam_group_class_batch_exams_id'], 'get_marks' => $get['get_marks']
                )));
            }
        }
    }
}




$exist = array();
$subject = array();
$dat = array();

foreach($test_array as $test => $value) {
    // var_dump($value);

    foreach($value as $data => $datum) {
    
        // array_push($subject, $datum['name']);
        if(in_array($datum['name'],$subject)) {
            array_push($exist, $datum['name']);
            array_replace($exist,$subject);
        }else {
            array_push($subject,$datum['name']);
        }
        array_push($dat, $datum);
}

}
// var_dump($dat);
?>


<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8">
	<title>Report Card</title>
    <style type="text/css" rel="stylesheet">
    * {
        box-sizing: border-box;
    }
    html {
        margin:0;
        padding:0;
    }
  body{
  padding: 0;
  margin: 0;
  font-family:helvetica;
  width:100%;
  }
  h1,h2,h3,h4,h5,h6 {
      margin:0;
  }
  .wrapper {
      margin: 0rem auto;
  }
  .top_info {
      padding: 1rem;
      text-align: center;
      line-height: 1.3;
      border: 2px solid silver;
  }
  .top_info h5 {
      font-size: .9rem;
      font-weight:500;
  }
  .top_info .school_name {
      margin-bottom:0.6rem;
      font-size: 1.3rem;
  }
  .top_info .session_info {
      margin-top: .6rem;
  }
  .top {
      display: flex;
      justify-content: space-between;
  }
  .top h4 {
      font-size:0.9rem;
  }
   table thead {
      padding-left:0;
  }
   .t-head {
    border:2px solid silver;
    padding:.5rem;
  }

   .t-head table thead tr th.p-r{
    padding-left:5rem !important;

  }
  .t-head table thead tr td {
      text-align:right;
      padding-left:2rem;
  }

  th {

text-align: left;}
table.table_wrapper {
    width:100%;
    border-collapse:collapse;
    margin-top:.2rem;
}
table.table_wrapper td {
    text-align:center;
    border:2px solid silver;
}
table.table_wrapper th {
    border:2px solid silver;
    padding-left:.2rem;
}
table.table_wrapper tbody {
    border:1px solid silver;
}
table.table_wrapper tbody tr:nth-child(1) {
    text-align:center;
}
table.table_wrapper tbody tr:nth-child(1) td {
    padding:.2rem;
    font-weight:bold;
    font-size:0.9rem;
}
table.table_wrapper tbody th.subjects {
    text-align:center;
    font-weight:bold;
}
.master_details {
    padding:1rem;
    /* border:2px solid silver; */
    padding-bottom:0px;
}
.master_details .top h5 {
    font-size: 1rem;
    margin-top:.5rem;
}
.master_details .grade_details h5 {
    font-size:1rem;
    font-weight:500;
    /* word-spacing:.5rem; */
    margin:.1rem 0;
}
table.first_table {
    width:60%;
    border: 2px solid silver;
    padding:.2rem;
    border-collapse:collapse;
}
table.first_table th,tr {
    border:1px solid silver;
    padding:2px;
    font-size:0.9rem;
}
table.first_table th:nth-child(2),td {
    text-align:center;
}
.table_group {
    width: 40%;
    margin-left:5rem;
}
table.second_table {
    width:100%;
    border: 2px solid silver;
    padding:.2rem;
    border-collapse:collapse;
}
table.second_table th,tr {
    border:1px solid silver;
    padding:2px;
    font-size:0.9rem;
}
table.second_table th:nth-child(2),td {
    text-align:center;
}

table.third_table {
    width:100%;
    border: 2px solid silver;
    padding:.2rem;
    border-collapse:collapse;
    margin-top:1.5rem;
}
table.third_table th,tr {
    border:1px solid silver;
    padding:2px;
    font-size:0.9rem;
}
table.third_table td {
    text-align:left;
}
.bottom_info {
    padding:.5rem;
    margin-top:.8rem;
    border:1px solid silver;
}
.bottom_info h5 {
    margin-bottom:.5rem;
}
    </style>
</head>
<body>
<div class="wrapper">
<div class="top_info">
<h4 class="school_name">AISHA AUDI SCHOOL</h4>
<h5>MOTTO:HONESTY, PERSERVERANCE AND FAITH</h5>
<h5>OFF HABIBU SHUAIBU SECRETARIAT ROAD BY EASTERN BYE-PASS P.O.BOX 250</h5>
<h5>MINNA, NIGER STATE</h5>
<h5 class="session_info">CUMMULATIVE REPORT SHEET FOR 2019/2020 ACADEMIC SESSION</h5>
</div>
<div class="t-head">
<table>
<thead>

<div class="top" style="width:60%;margin-top:0.4rem">

<h4>NAME:HASSAN MUHAMMAD RAHAMA</h4>
<h4></h4>
<h4 style="text-align:right">Final Grade:A1</h4>
</div>

<tr>
<th scope="row">Class</th>
<td>PRY 4A</td>
<th scope="row" class="p-r">Final Position</th>
<td>18th</td>
</tr>

<tr>
<th scope="row">Admission No.</th>
<td>AAB</td>
<th scope="row" class="p-r">Final Average</th>
<td>78.90</td>
</tr>

<tr>
<th scope="row">Session</th>
<td>2019/2020</td>
<th scope="row" class="p-r">Class Average</th>
<td>80.00</td>
</tr>

<tr>
<th scope="row">Term</th>
<td>THIRD</td>
<th scope="row" class="p-r">Highest Ave. in class</th>
<td>89.89</td>
</tr>

<tr>
<th scope="row">No. in class</th>
<td>20</td>
<th scope="row" class="p-r">Lowest Ave. in class</th>
<td>34.89</td>
</tr>
</thead>
</table>
</div>
<table class="table_wrapper">

<!-- table body -->
<tbody class="table_content">
<!-- rows for headings -->
<tr>
<th scope="row" class="subjects">Subject</th>
<td>T1<br />(10)</td>
<td>ASS<br />(10)</td>
<td>MIT<br />(20)</td>
<td>EXAM<br />(60)</td>
<td>TOTAL<br />(L)</td>
<td>1ST<br />TERM</td>
<td>2ND<br />TERM</td>
<td>AVE.<br />(100%)</td>
<td><br />GRD</td>
<td><br />POS</td>
<td>OUT<br />OF</td>
<td>LOW <br />IN <br />CLASS<br />8</td>
<td>HIGH <br />IN <br />CLASS<br />8</td>
<td>CLASS<br />8 AVE</td>
<td>COMMENTS</td>
</tr>

<!-- rows heading -->
<!-- rows for data and subjects -->
<!-- <tr>
    <th scope="row">MATHEMATICS</th>
    <td>4</td>
    <td>6</td>
    <td>13</td>
    <td>49</td>
    <td>45</td>
    <td>45</td>
    <td>34</td>
    <td>23</td>
    <td>B2</td>
    <td>23</td>
    <td>22.4</td>
    <td>23</td>
    <td>24</td>
    <td>76</td>
    <td></td>
</tr> -->
<?php
$output = '';
$assignment = array();
$test = array();
$exam = array();
foreach($subject as $subj) {
$output.='<tr>
    <th scope="row">'.$subj.'</th>
    <td></td>
    ';
foreach($dat as $row => $value) {
    if(in_array($value['name'], $subject) && $value['exam_group_class_batch_exams_id'] == 1) {
        
        if($subj == $value['name']) {
            array_push($assignment, array($value['name'], $value['get_marks']));
            // echo '<td>'.$value['name'].'</td>';
        }       
    }

    if(in_array($value['name'], $subject) && $value['exam_group_class_batch_exams_id'] == 2) {
        
        if($subj == $value['name']) {
            array_push($test, array($value['name'], $value['get_marks']));
            // echo '<td>'.$value['name'].'</td>';
        }       
    }

    if(in_array($value['name'], $subject) && $value['exam_group_class_batch_exams_id'] == 4) {
        
        if($subj == $value['name']) {
            array_push($exam, array($value['name'], $value['get_marks']));
            // echo '<td>'.$value['name'].'</td>';
        }       
    }


    // var_dump($value['name']);
}
$output.= '<td>';
foreach($assignment as $assign => $value) {
    // var_dump($value[$subj]);
    // var_dump($value[0]);
    if($value[0] == $subj) {
        $output.= ''.$value[1].'</td>';
    }
    
    
}
$output.= '<td>';
foreach($test as $t => $value) {
    // var_dump($value[$subj]);
    // var_dump($value[0]);
    if($value[0] == $subj) {
        $output.= ''.$value[1].'</td>';
    }
    
    
}
$output.= '<td>';
foreach($exam as $ex => $value) {
    // var_dump($value[$subj]);
    // var_dump($value[0]);
    if($value[0] == $subj) {
        $output.= ''.$value[1].'</td>';
    }
    
    
}
$output.= '
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>';
}
echo $output;
// var_dump($exam);
// var_dump($subject);
?>

<!-- data and subject rows -->
</tbody>
</table>
<div class="master_details">
<div class="top" style="width:95%">
<h5>GRADE DETAILS</h5>
<h5>No. Of Subjects: 14</h5>
</div>
<div class="grade_details">
<h5>A1 = 75-100, B2 = 70-74, B3 = 65-69, C4 = 60-64, C6 = 50-54, D7 = 45-49, E8 = 40-44, F9 = 0-39</h5>
</div>

<div class="top">
<!-- FIRST TABLE -->
<table class="first_table">
<tr>
<th scope="col">AFFECTIVE TRAITS</th>
<th scope="col">RATING</th>
</tr>
<tr>
<th scope="row">PUNCTUALITY</th>
<td>3</td>
</tr>
<tr>
<th scope="row">ATTENDANCE</th>
<td>5</td>
</tr>
<tr>
<th scope="row">RELIABILITY</th>
<td>4</td>
</tr>
<tr>
<th scope="row">NEATNESS</th>
<td>5</td>
</tr>
<tr>
<th scope="row">POLITENESS</th>
<td>5</td>
</tr>
<tr>
<th scope="row">HONESTY</th>
<td>5</td>
</tr>
<tr>
<th scope="row">RELATIONSHIP WITH STUDENTS</th>
<td>4</td>
</tr>
<tr>
<th scope="row">SELF CONTROL</th>
<td>5</td>
</tr>
<tr>
<th scope="row">ATTENTIVENESS</th>
<td>4</td>
</tr>
<tr>
<th scope="row">PERSERVERANCE</th>
<td>4</td>
</tr>
</table>
<!-- FIRST TABLE -->
<div class="table_group">
<!-- SECOND TABLE -->
<table class="second_table">
<tr>
<th scope="col">PSYCHOMOTOR</th>
<th scope="col">RATING</th>
</tr>
<tr>
<th scope="row">HANDWRITING</th>
<td>3</td>
</tr>
<tr>
<th scope="row">GAMES</th>
<td>5</td>
</tr>
<tr>
<th scope="row">SPORT</th>
<td>4</td>
</tr>
<tr>
<th scope="row">DRAWING AND PAINTING</th>
<td>3</td>
</tr>
<tr>
<th scope="row">CRAFT</th>
<td>4</td>
</tr>

</table>
<!-- SECOND TABLE -->


<!-- THIRD TABLE -->
<table class="third_table">
<tr>
<th scope="col">SCALE</th>
</tr>
<tr>
<td>5 - Excellence degree of observable trait</td>
</tr>
<tr>
<td>4 - Good level of observable trait</td>
</tr>
<tr>
<td>3 - Fair but acquirable level of observable trait</td>
</tr>
<tr>
<td>2 - Poor level of observable trait</td>
</tr>
<tr>
<td>1 - No observable trait</td>
</tr>

</table>
<!-- THIRD TABLE -->
</div>


</div>
</div>

<div class="bottom_info">
<h5>FORM TEACHER: <strong>ISHOLA GRACE TEMITOPE</strong></h5>
<h5>FORM TEACHER'S REMARK: <strong>A very good performance, keep it up in your next class. PROMOTED!</strong></h5>
<h5>PRINCIPAL'S REMARK: <strong>He can do better in his new class. Good result!</strong></h5>
<h5>Next Term Begins: <strong>January 04, 2021</strong></h5>
</div>

<!--  -->
</div>
<!-- <script src="./bootstrap/js/jquery-3.3.1.min.js"></script>
<script>
$(document).ready(function(){
    $.get({
        url: 'test/ConnectedExams.json',
        dataType: 'JSON',
        success:function(response) {
            let array = [];
            let container = $('.table_content');
            
            let exam_subject = [];
            let score = [];
            let subjects = [];
            for(item in response) {
                array.push(response[item]);
            }

            let exam = Object.entries(array);
            for( item in exam[3]) {
                exam_subject.push(exam[3][item]);
                // console.log(exam[3][item]);
            }
            let data = Object.entries(exam_subject[1]);
            
            let students = data[1][1][0].exam_result;
            let exams = data[2][1];
            for(item in students) {
                // console.log(students[item]);
                for(itemx in students[item]) {
                    subjects.push(students[item][itemx].name);
                    score.push(students[item][itemx]);
                    // console.log(students[item][itemx]);
                    
                }
            }



            let subject_name = [...new Set(subjects)];
                    // console.log(subject_name);
            // console.log(students,exams);
            for (let index = 0; index < subject_name.length; index++) {
                container.append(`
            <tr>
            <th scope="row">${subject_name[index]}</th>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            </tr>
            `);                
                
            }
        }
    });
})
</script> -->
</body>
</html>
