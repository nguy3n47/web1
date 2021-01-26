<?php
require_once 'init.php';
$subjects = getAllSubjects();
$allUsers = getAllUsers();

if (isset($_POST['submit'])) {
    $maso = $_POST['maso'];
    $hoten = $_POST['hoten'];
    $diachi = $_POST['diachi'];
    $sdt = $_POST['sdt'];
    $email = $_POST['email'];
    $thang = $_POST['thang'];
    $nam = $_POST['nam'];
    $ngay = $_POST['ngay'];
    $email = $_POST['email'];
    $date = str_replace("/", "-", strval($ngay). '/' .strval($thang). '/' .strval($nam));
    $time = strtotime($date);
    $birth = date('Y-m-d',$time);
    if (empty($maso) || empty($hoten) || empty($diachi) || empty($sdt)) {
        $error = 'Mã số hoặc họ tên hoặc địa chỉ hoặc số điện thoại rỗng';
    }
    else if($thang < 1 || $thang > 12 || $nam < 0)
    {
        $error = 'Ngày tháng năm sinh không hợp lệ';
    }
    else if(!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        $error = 'Email không hợp lệ';
    }
    else{
        $existsUser = findUserById($maso);
        if ($existsUser){
            // do something
            $register = getRegistrationSubjectsById($maso);
            $temp = array();
            $selectSubjects = (array) $_POST['selectSubjects'];
            if($register){
                foreach ($register as $r){
                    if(in_array($r['subject_id'], $selectSubjects)){
                        $temp[] = $r['name'];
                    }
                }
                if ($temp) {
                    $error = 'Lỗi, Các môn đã được đăng ký: '.join(", ",$temp);
                } else {
                    foreach ((array) $_POST['selectSubjects'] as $item) {
                        $registration = registrationSubjects($maso, $item);
                    }
                    $success = 'Thành công';
                    header("Refresh:3");
                }
            }
            else{
                foreach ((array) $_POST['selectSubjects'] as $item) {
                    $registration = registrationSubjects($maso, $item);
                }
                $success = 'Thành công';
                header("Refresh:3");
            }
        }
        else{
            $gioitinh = $_POST['gioitinh'];
            $user = createUser($maso, $hoten, $diachi, $sdt, $gioitinh, $email, $birth);
                foreach ((array) $_POST['selectSubjects'] as $item) {
                    $registration = registrationSubjects($maso, $item);
                }
            $success = 'Thành công';
            header("Refresh:3");
        }   
    }
}

?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DKHP</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
    <!-- Bootstrap core CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/css/mdb.min.css" rel="stylesheet">
    <!-- JQuery -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" />
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/js/mdb.min.js"></script>
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdn.jsdelivr.net/npm/promise-polyfill"></script>
</head>

<style>
    tr:hover {
        background-color: #dfe6e9
    }

    select.first-opt-hidden option:first-of-type {
        display:none;
    }

    td.highlight {
    background-color: whitesmoke !important;
    }

    table.dataTable thead .sorting:after,
    table.dataTable thead .sorting:before,
    table.dataTable thead .sorting_asc:after,
    table.dataTable thead .sorting_asc:before,
    table.dataTable thead .sorting_asc_disabled:after,
    table.dataTable thead .sorting_asc_disabled:before,
    table.dataTable thead .sorting_desc:after,
    table.dataTable thead .sorting_desc:before,
    table.dataTable thead .sorting_desc_disabled:after,
    table.dataTable thead .sorting_desc_disabled:before {
    bottom: .5em;
    }
</style>
    <div class="container-fluid">
        <div class="container-fluid">
            <h1 style="text-align: center;color:white;background-color:blue; padding: 10px;">ĐĂNG KÝ HỌC PHẦN</h1>
            <div class="mt-3" style="border-top:1px solid"></div>
        </div>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        <?php if (isset($success)): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $success; ?>
            </div>
        <?php endif; ?>
        <div class="container-fluid center mt-5" style="width:50%">
            <form method="post" class="text-center" action="" style="color: #757575;">

                <!-- Maso -->
                <div class="md-form material-tooltip-main" data-toggle="tooltip">
                    <input type="text" id="materialLoginFormMaso" class="form-control" name="maso">
                    <label for="materialLoginFormMaso">Mã số</label>

                </div>

                <!-- Hoten -->
                <div class="md-form material-tooltip-main" data-toggle="tooltip">
                    <input type="text" id="materialLoginFormHoten" class="form-control" name="hoten">
                    <label for="materialLoginFormHoten">Họ và tên</label>

                </div>

                <!-- diachi -->
                <div class="md-form material-tooltip-main" data-toggle="tooltip">
                    <input type="text" id="materialLoginFormdiachi" class="form-control" name="diachi">
                    <label for="materialLoginFormdiachi">Địa chỉ</label>

                </div>

                <!-- SDT -->
                <div class="md-form material-tooltip-main" data-toggle="tooltip">
                    <input maxlength="10" type="tel" id="materialLoginFormSDT" pattern="[0-9]{10}" class="form-control" name="sdt">
                    <label for="materialLoginFormSDT">Số điện thoại</label>

                </div>
                <label class="pr-2 ml-0">Giới tính: </label>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" class="custom-control-input" id="defaultInlineNam" value="Nam" name="gioitinh">
                    <label class="custom-control-label" for="defaultInlineNam">Nam</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" class="custom-control-input" id="defaultInlineNu" value="Nữ" name="gioitinh">
                    <label class="custom-control-label" for="defaultInlineNu">Nữ</label>
                </div>

            <div class="form-row ml-0">
                <label class="pr-2">Ngày sinh: </label>
                <div class="col">
                <select class="select form-control first-opt-hidden" name="thang">
                    <option></option>
                    <?php for( $m=1; $m<=12; ++$m ) { 
                    $month_label = date('F', mktime(0, 0, 0, $m, 1));
                    ?>
                    <option value="<?php echo $m; ?>"><?php echo $month_label; ?></option>
                    <?php } ?>
                </select> 
                </div>
                <div class="col">
                <select class="select form-control first-opt-hidden" name="ngay">
                    <option></option>
                    <?php 
                    $start_date = 1;
                    $end_date   = 31;
                    for( $j=$start_date; $j<=$end_date; $j++ ) {
                        echo '<option value='.$j.'>'.$j.'</option>';
                    }
                    ?>
                </select>
                </div>
                <div class="col">
                <select class="select form-control first-opt-hidden" name="nam">
                    <option></option>
                    <?php 
                    $year = date('Y');
                    $min = $year - 60;
                    $max = $year;
                    for( $i=$max; $i>=$min; $i-- ) {
                        echo '<option value='.$i.'>'.$i.'</option>';
                    }
                    ?>
                </select>
                </div>
                <label>( MM/DD/YYYY )</label>
            </div>
            <div class="md-form material-tooltip-main" data-toggle="tooltip">
                    <input type="text" id="materialLoginFormemail" class="form-control" name="email">
                    <label for="materialLoginFormemail">Email</label>

                </div>
            <div class="container mt-5">
            <div class="row">
                <div class="col-5">
                    <select id="list1" class="custom-select" multiple="multiple" style="height: 250px; width: 100%;">
                        <?php foreach ($subjects as $subject) : ?>
                            <option value=<?php echo $subject['id'] ?>><?php echo $subject['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-2">
                    <button type="button" style="height: 50px; width: 50px;" id="but1" class="btn  px-3"><i class="fas fa-angle-right" aria-hidden="true"></i></button>
                    <button type="button" style="height: 50px; width: 50px;" id="but2" onclick="listboxSelectDeselect1_2('list1', true);" class="btn  px-3"><i class="fas fa-angle-double-right" aria-hidden="true"></i></button>
                    <button type="button" style="height: 50px; width: 50px;" id="but3" class="btn  px-3"><i class="fas fa-angle-left" aria-hidden="true"></i></button>
                    <button type="button" style="height: 50px; width: 50px;" id="but4" onclick="listboxSelectDeselect2_1('list2', true);" class="btn  px-3"><i class="fas fa-angle-double-left" aria-hidden="true"></i></button>

                </div>
                <div class="col-4">
                    <select id="list2" name="selectSubjects[]" class="custom-select" multiple="multiple" style="height: 250px; width: 100%;">
                    </select>
                </div>
                <div class="col-1">
                    <button type="button" onclick="clickOke('list2', true)" class="btn  px-3">OK</button>
                </div>
            </div>
            <div class="row">
                <div class="col mr-2" style="text-align:right">
                    <button type="submit" name="submit" class="btn px-3 ">Đăng ký</button>
                </div>
                <div class="col " style="text-align:left">
                    <button type="button" id="delete" class="btn px-3 ">Xóa</button>
                </div>
            </div>
        </div>
        <div class="mt-3" style="border-top:1px solid;"></div>
        <div class="container mt-3">
            <table id="dtBasicExample" class="row-border hover order-column" cellspacing="0">
                <thead>
                    <tr>
                        <th class="th-sm" scope="col">Mã số</th>
                        <th class="th-sm" scope="col">Họ và tên</th>
                        <th class="th-sm" scope="col">Giới tính</th>
                        <th class="th-sm" scope="col">Ngày sinh</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($allUsers as $user) : ?>
                        <tr>
                            <td><?php echo $user['id'] ?></td>
                            <td><?php echo $user['name'] ?></td>
                            <td><?php echo $user['gender'] ?></td>
                            <td><?php echo date("d-m-Y", strtotime($user['birth']))?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        </form>         
        </div> 
        <div class="m-5 "></div>
    </div>
    <script>
    $(document).ready(function () {
    $('#dtBasicExample').DataTable();
    $('.dataTables_length').addClass('bs-select');
    });

    $(document).ready(function() {
    var table = $('#dtBasicExample').DataTable();
     
    $('#dtBasicExample tbody')
        .on( 'mouseenter', 'td', function () {
            var colIdx = table.cell(this).index().column;
 
            $( table.cells().nodes() ).removeClass( 'highlight' );
            $( table.column( colIdx ).nodes() ).addClass( 'highlight' );
        } );
    } );

     function listboxSelectDeselect1_2(listID, isSelect) {
      var listbox = document.getElementById(listID);
      for (var count = 0; count < listbox.options.length; count++) {
        listbox.options[count].selected = isSelect;
      }
      return !$('#list1 option:selected').remove().appendTo('#list2');

    }

    function listboxSelectDeselect2_1(listID, isSelect) {
      var listbox = document.getElementById(listID);
      for (var count = 0; count < listbox.options.length; count++) {
        listbox.options[count].selected = isSelect;
      }
      return !$('#list2 option:selected').remove().appendTo('#list1');

    }
            
    $(function()
    {
        $("#but1").click(function()
        {
            $("#list1 option:selected").each(function()
            {
                $(this).remove().appendTo($("#list2"));
            });
        });

       

        $("#but3").click(function()
        {
            $("#list2 option:selected").each(function()
            {
                $(this).remove().appendTo($("#list1"));
            });
        });

        $("#delete").click(function()
        {
            $("#list2 option:selected").each(function()
            {
                $(this).remove().appendTo($("#list1"));
            });
        });
    });

    function clickOke(listID, isSelect) {
        
        var listbox = document.getElementById(listID);
        selected = new Array();
        for (var count = 0; count < listbox.options.length; count++) {
            listbox.options[count].selected = isSelect;
            if(listbox.options[count].selected)
                selected.push(listbox.options[count].innerHTML);
        }
        var str = '';

        Swal.fire({
        icon: 'question',
        title: 'Các môn đã chọn',
        text: selected.join(", ")
        })
    }

    $('select[name=nam]').on('change', function(){
        checkTotalDay();
    });
    $('select[name=thang]').on('change', function(){
        checkTotalDay();
    });

    function checkTotalDay() {
        var year = $('select[name=nam]').val();
        var month = $('select[name=thang]').val();
        var totalDate = 31;
        if(year !== '' && month !== '') {
            totalDate = new Date(year, month, 0).getDate();
        }
        $('select[name=ngay]').empty();
        for(var i = 1; i <= totalDate; i++) {
        $('select[name=ngay]').append("<option value='"+i+"'>"+i+"</option>");
        }
    }
</script>