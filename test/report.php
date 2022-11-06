
<style type="text/css">
    @media print {
        .pagebreak { page-break-before: always; } /* page-break-after works, as well */
    }
</style>
<?php
if (empty($marksheet)) {
    ?>
    <div class="alert alter-info">
        <?php echo $this->lang->line('no_record_found'); ?>
    </div>
    <?php
} else {
        if ($marksheet['exam_connection'] == 1) {
            foreach ($marksheet['students'] as $student_key => $student_value) {
                $percentage_total = 0; ?>

                <style type="text/css" rel="stylesheet">
                    * {
                        box-sizing: border-box;
                    }

                    html {
                        margin: 0;
                        padding: 0;
                    }

                    body {
                        padding: 0;
                        margin: 0;
                        font-family: helvetica;
                        width: 100%;
                    }

                    h1, h2, h3, h4, h5, h6 {
                        margin: 0;
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
                        font-weight: 500;
                    }

                    .top_info .school_name {
                        margin-bottom: 0.6rem;
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
                        font-size: 0.9rem;
                    }

                    table thead {
                        padding-left: 0;
                    }

                    .t-head {
                        border: 2px solid silver;
                        padding: .5rem;
                    }

                    .t-head table thead tr th.p-r {
                        padding-left: 5rem !important;

                    }

                    .t-head table thead tr td {
                        text-align: right;
                        padding-left: 2rem;
                    }

                    th {

                        text-align: left;
                    }

                    table.table_wrapper {
                        width: 100%;
                        border-collapse: collapse;
                        margin-top: .2rem;
                    }

                    table.table_wrapper td {
                        text-align: center;
                        border: 2px solid silver;
                    }

                    table.table_wrapper th {
                        border: 2px solid silver;
                        padding-left: .2rem;
                    }

                    table.table_wrapper tbody {
                        border: 1px solid silver;
                    }

                    table.table_wrapper tbody tr:nth-child(1) {
                        text-align: center;
                    }

                    table.table_wrapper tbody tr:nth-child(1) td {
                        padding: .2rem;
                        /* font-weight: bold; */
                        font-size: 0.9rem;
                    }

                    table.table_wrapper tbody th.subjects {
                        text-align: center;
                        /* font-weight: bold; */
                    }

                    .master_details {
                        padding: 1rem;
                        /* border:2px solid silver; */
                        padding-bottom: 0px;
                    }

                    .master_details .top h5 {
                        font-size: 1rem;
                        margin-top: .5rem;
                    }

                    .master_details .grade_details h5 {
                        font-size: 1rem;
                        font-weight: 500;
                        /* word-spacing:.5rem; */
                        margin: .1rem 0;
                    }

                    table.first_table {
                        width: 60%;
                        border: 2px solid silver;
                        padding: .2rem;
                        border-collapse: collapse;
                    }

                    table.first_table th, tr {
                        border: 1px solid silver;
                        padding: 2px;
                        font-size: 0.9rem;
                    }

                    table.first_table th:nth-child(2), td {
                        text-align: center;
                    }

                    .table_group {
                        width: 40%;
                        margin-left: 5rem;
                    }

                    table.second_table {
                        width: 100%;
                        border: 2px solid silver;
                        padding: .2rem;
                        border-collapse: collapse;
                    }

                    table.second_table th, tr {
                        border: 1px solid silver;
                        padding: 2px;
                        font-size: 0.9rem;
                    }

                    table.second_table th:nth-child(2), td {
                        text-align: center;
                    }

                    table.third_table {
                        width: 100%;
                        border: 2px solid silver;
                        padding: .2rem;
                        border-collapse: collapse;
                        margin-top: 1.5rem;
                    }

                    table.third_table th, tr {
                        border: 1px solid silver;
                        padding: 2px;
                        font-size: 0.9rem;
                    }

                    table.third_table td {
                        text-align: left;
                    }

                    .bottom_info {
                        padding: .5rem;
                        margin-top: .8rem;
                        border: 1px solid silver;
                    }

                    .bottom_info h5 {
                        margin-bottom: .5rem;
                    }
                </style>

                <div class="wrapper">
                    <!-- School Information -->
                    <div class="top_info">
                        <h4 class="school_name"><?php echo $template->heading?></h4>
                        <h5><?php echo $template->title; ?></h5>
                        <h5><?php $template->exam_name; ?></h5>
                        <h5>MINNA, NIGER STATE</h5>
                        <h5 class="session_info">REPORT SHEET FOR FIRST TERM, 2021/2022</h5>
                    </div>

                    <!-- Student Information -->
                    <div class="t-head">
                        <table>
                            <thead>
                                <tr>
                                    <th scope="row">Name </th>
                                    <td><?php echo $student_value['firstname'] . ' ' . $student_value['lastname']; ?></td>
                                    <th scope="row" class="p-r">Final Grade</th>
                                    <td>A1 - test</td>
                                </tr>

                                <tr>
                                    <th scope="row">Class </th>
                                    <td><?php echo $student_value['class'] . ' ' . $student_value['section']; ?></td>
                                    <th scope="row" class="p-r">Final Position</th>
                                    <td>18th -test</td>
                                </tr>

                                <tr>
                                    <th scope="row">Admission No. </th>
                                    <td><?php echo $student_value['admission_no']; ?></td>
                                    <th scope="row" class="p-r">Final Average</th>
                                    <td>78.90-test</td>
                                </tr>

                                <tr>
                                    <th scope="row">Session</th>
                                    <td>2021/2022-test</td>
                                    <th scope="row" class="p-r">Class Average</th>
                                    <td>80.00-test</td>
                                </tr>

                                <tr>
                                    <th scope="row">Term</th>
                                    <td>FIRST-test</td>
                                    <th scope="row" class="p-r">Highest Ave. in class</th>
                                    <td>89.89-test</td>
                                </tr>

                                <tr>
                                    <th scope="row">No. in class</th>
                                    <td>20-test</td>
                                    <th scope="row" class="p-r">Lowest Ave. in class</th>
                                    <td>34.89-test</td>
                                </tr>
                            </thead>
                        </table>
                    </div>

                    <!-- Scores and grading Table -->
                    <table class="table_wrapper">

                        <!-- table body -->
                        <tbody>

                            <?php
                                $total_max_marks     = 0;
                                $total_obtain_marks  = 0;
                                $total_points        = 0;
                                $total_hours         = 0;
                                $total_quality_point = 0;
                                $result_status       = 1;
                                $absent_status       = false; 

                                ?>

                                <tr>
                                    <td>SUBJECTS</td>
                                    <?php
                                        foreach ($marksheet['exams'] as $exam_key => $exam_value) {                                        
                                            ?>
                                                <td><?php echo $exam_value->exam; ?></td>
                                                <?php
                                        }?>
                                </tr>

                            <!-- <tr> -->
                                <?php                               
                                
                                foreach ($marksheet['exams'] as $exam_key => $exam_value) {
                                    
                                    foreach ($student_value['exam_result']['exam_result_' . $exam_value->id] as $exam_result_key => $exam_result_value) {
                                    
                                        foreach ($student_value['exam_result'] as $exams_key => $exams_value) 
                                        {
                                            // $total_max_marks    = $total_max_marks + $exam_result_value->max_marks;
                                                // $total_obtain_marks = $total_obtain_marks + $exam_result_value->get_marks;

                                                if ($exam_result_value->attendence == 'absent') {
                                                    $absent_status = true;
                                                } 
                                                
                                                echo $exam_result_value
                                                ?>                                            
                                            <?php
                                            }
                                    }
                                // }
                            ?>
                            <!-- </tr> -->
                            <!-- rows for headings -->
                            <!-- <tr>
                                <th scope="row" class="subjects">Subject</th>
                                <td>T1<br/>(10)</td>
                                <td>ASS<br/>(10)</td>
                                <td>MIT<br/>(20)</td>
                                <td>EXAM<br/>(60)</td>
                                <td>TOTAL<br/>(L)</td>
                                <td>1ST<br/>TERM</td>
                                <td>2ND<br/>TERM</td>
                                <td>AVE.<br/>(100%)</td>
                                <td><br/>GRD</td>
                                <td><br/>POS</td>
                                <td>OUT<br/>OF</td>
                                <td>LOW <br/>IN <br/>CLASS<br/>8</td>
                                <td>HIGH <br/>IN <br/>CLASS<br/>8</td>
                                <td>CLASS<br/>8 AVE</td>
                                <td>COMMENTS</td>
                            </tr> -->
                            <!-- rows heading -->
                            <!-- rows for data and subjects -->
                            <!-- <tr>
                                <th scope="row">NATIONAL VALUE</th>
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
                            </tr>

                            <tr>
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
                            </tr>

                            <tr>
                                <th scope="row">PHE</th>
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
                            </tr>

                            <tr>
                                <th scope="row">HAUSA</th>
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
                            </tr>

                            <tr>
                                <th scope="row">FRENCH</th>
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
                            </tr>

                            <tr>
                                <th scope="row">BASIC SCIENCE</th>
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
                            </tr>

                            <tr>
                                <th scope="row">HAND WRITING</th>
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
                            </tr>

                            <tr>
                                <th scope="row">CREATIVE ART</th>
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
                            </tr>

                            <tr>
                                <th scope="row">RELIGION</th>
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
                            </tr>

                            <tr>
                                <th scope="row">QUANTITATIVE <br/>REASONING</th>
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
                            </tr>

                            <tr>
                                <th scope="row">PRE-VOCATIONAL <br/>STUDIES</th>
                                <td>6</td>
                                <td>8</td>
                                <td>13</td>
                                <td>49</td>
                                <td>45</td>
                                <td>56</td>
                                <td>34</td>
                                <td>45</td>
                                <td>A1</td>
                                <td>23</td>
                                <td>45.4</td>
                                <td>43</td>
                                <td>56</td>
                                <td>67</td>
                                <td></td>
                            </tr>

                            <tr>
                                <th scope="row">VERBAL REASONING</th>
                                <td>2</td>
                                <td>10</td>
                                <td>13</td>
                                <td>49</td>
                                <td>56</td>
                                <td>45</td>
                                <td>34</td>
                                <td>45</td>
                                <td>E8</td>
                                <td>23</td>
                                <td>67.4</td>
                                <td>23</td>
                                <td>24</td>
                                <td>56</td>
                                <td></td>
                            </tr>

                            <tr>
                                <th scope="row">COMPUTER SCIENCE</th>
                                <td>5</td>
                                <td>7</td>
                                <td>13</td>
                                <td>49</td>
                                <td>45</td>
                                <td>45</td>
                                <td>56</td>
                                <td>23</td>
                                <td>D7</td>
                                <td>23</td>
                                <td>22.4</td>
                                <td>45</td>
                                <td>24</td>
                                <td>78</td>
                                <td></td>
                            </tr>

                            <tr>
                                <th scope="row">ENGLISH GRAMMAR,<br/>PRONUC. <br/>COMPOSITION <br/> COMPREHENSION</th>
                                <td>4</td>
                                <td>6</td>
                                <td>13</td>
                                <td>49</td>
                                <td>45</td>
                                <td>45</td>
                                <td>45</td>
                                <td>23</td>
                                <td>C2</td>
                                <td>23</td>
                                <td>87.4</td>
                                <td>45</td>
                                <td>24</td>
                                <td>45</td>
                                <td></td>
                            </tr> -->

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
                        <h5>FORM TEACHER'S REMARK: <strong>A very good performance, keep it up in your next class. PROMOTED!</strong>
                        </h5>
                        <h5>PRINCIPAL'S REMARK: <strong>He can do better in his new class. Good result!</strong></h5>
                        <h5>Next Term Begins: <strong>January 04, 2021</strong></h5>
                    </div>
                    
                </div>


                <div class="pagebreak"> </div>
                <?php
            }
        }
    }
?>



