<?php
    require 'header.php';

    $unassigned = 12;
    $mine = 0;
    $assigned = 5;
    $closed = 30;
    $spam = 0;

    $customer_name = "John Doe";
    $email_subject = "Lorem Ipsum";
    $email_body = "It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).";
    $ticket_number = 26191;
    $ticket_updated_at = "10/29/2016";

?>
    <style>
        .left_container {
            height: 500px; 
            width: 200px !important;
            margin: 0; 
            background-color: #f3f3f3;
        }
        .middle_container {
            min-height: 500px;
            max-height: 750px;
            height: auto;
            width: 700px !important;
            margin:0;
            margin-bottom: 20px;
            background-color: #fafafa;
        }
        .right_container {
            min-height: 500px;
            max-height: 750px;
            height: auto; 
            width: 150px; 
            margin:0; 
            background-color: #e6e6e6;
        }
        .folders {
            padding-top: 20px;
        }
        .folders a {
            text-decoration: none;
            width: 100%;
            font-size: 15px;
        }
        .folders button {
            background: none;
            border: none;
            text-align: left;
            padding-top: 5px;
            padding-bottom: 5px;
            margin-bottom: 2px;
            width: 100%;
        }
        .folders button:hover {
            background-color: #01295F;
            color: #fff;
        }
        .folders button:focus {
            background-color: #01295F;
            color: #fff;
            outline: none;
        }
        .folders_button_active {
            background-color: #01295F !important;
            color: #fff !important;
            font-weight: bold;
        }
        .folders button i {
            padding-right: 10px;
        }
        .folders button span {
            float: right;
        }
        .folder_list_hide {
            display: none;
        }
        .table thead tr th{
            font-weight: bold;
        }
        .table tbody tr {
            cursor: pointer;
        }
        .table tbody tr:hover {
            background-color: #e6f1ff;
        }
        .table tr th:first-child() {
            width: 1px;
        }
        .table tr th:nth-child(2) {
            width: 100px;
        }
        .table tr th:nth-child(3) {
            width: 400px;
        }
        .table tr td:first-child() {
            width: 1px;
        }
        .table tr td:nth-child(2) {
            width: 100px;
        }
        .table tr td:nth-child(3) {
            width: 400px;
        }
        .table_email_content {
            min-height: 38px;
            height: 38px;
            overflow: hidden;
        }
        .dataTables_filter {
            padding-right: 10px;
        }
        .dataTables_filter input {
            width: 200px !important;
        }
        table.dataTable thead th.sorting:after {
            content: "";
        }
        table.dataTable thead th.sorting_asc:after {
            content: "\27A4";
            transform: rotate(-90deg);
            margin-left: 10px !important;
        }
        table.dataTable thead th.sorting_desc:after {
            content: "\27A4";
            transform: rotate(90deg);
        }
        .dataTables_info {
            padding-left: 20px;
        }
        #list_mine .dataTables_empty {
            height: 370px !important;
            background: url(img/chill_bear.jpg);
            background-size: 90%;
            background-position: center; 
            background-repeat: no-repeat;
            cursor: default;
        }
        .pagination {
            padding-right: 20px;
        }
        .pagination li {
            display: inline-block;
            margin: 0;
        }
        .pagination li a {
            background-color: transparent;
            font-size: 20px;
            margin-top: -8px;
            color: #cccccc;
            border: none;
        }
        .pagination li a:hover {
            background-color: transparent;
            font-weight: bold;
        }
        
    </style>

    <div class="container_12 boxsummary">
        <div class="full-width-div">        
            <div class="container_12">
                <div class="grid_4 left_container">
                    <div class="folders">
                        <a href="#unassigned">
                            <button id="btn_fldr_1" onclick="openFolder(1, <?=$unassigned?>, '#datatable_unassigned')"><i class="glyphicon glyphicon-envelope"></i>
                                Unassigned<span><?=$unassigned?></span>
                            </button>
                        </a>
                        <a href="#mine">
                            <button id="btn_fldr_2" onclick="openFolder(2, <?=$mine?>, '#datatable_mine')"><i class="glyphicon glyphicon-inbox"></i>
                                Mine<span><?=$mine?></span>
                            </button>
                        </a>
                        <a href="#assigned">
                            <button id="btn_fldr_3" onclick="openFolder(3, <?=$assigned?>, '#datatable_assigned')"><i class="glyphicon glyphicon-user"></i>
                                Assigned<span><?=$assigned?></span>
                            </button>
                        </a>
                        <a href="#closed">
                            <button id="btn_fldr_4" onclick="openFolder(4, <?=$closed?>, '#datatable_closed')"><i class="glyphicon glyphicon-trash"></i>
                                Closed<span><?=$closed?></span>
                            </button>
                        </a>
                        <a href="#spam">
                            <button id="btn_fldr_5" onclick="openFolder(5, <?=$spam?>, '#datatable_spam')"><i class="glyphicon glyphicon-ban-circle"></i>
                            Spam<span><?=$spam?></span></button>
                        </a>
                    </div>
                </div>
                <div class="grid_4 middle_container">
                    
                        <div id="list_unassigned" class="folder_list_hide">
                            <table id="datatable_unassigned" class="table">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox"></th>
                                        <th title="Sort">Customer</th>
                                        <th>Conversation</th>
                                        <th title="Sort">Number</th>
                                        <th title="Sort">Last Update</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=0; while($i < $unassigned) { ?>
                                    <tr onclick="document.location = '#<?=$i?>';">
                                        <td><input type="checkbox"></td>
                                        <td><?=$customer_name."U".$i?></td>
                                        <td>
                                            <div class="table_email_content">
                                                <b><?=$email_subject?></b><br/>
                                                <?=$email_body?>
                                            </div>
                                        </td>
                                        <td><?=$ticket_number+$i?></td>
                                        <td><?=$ticket_updated_at?></td>
                                    </tr>
                                    <?php $i++; } ?>
                                </tbody>
                            </table>
                        </div>
                        <div id="list_mine" class="folder_list_hide">
                            <table id="datatable_mine" class="table">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox"></th>
                                        <th title="Sort">Customer</th>
                                        <th>Conversation</th>
                                        <th title="Sort">Number</th>
                                        <th title="Sort">Last Update</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $j=0; while($j < $mine) { ?>
                                    <tr onclick="document.location = '#<?=$i?>';">
                                        <td><input type="checkbox"></td>
                                        <td><?=$customer_name."M"?></td>
                                        <td>
                                            <div class="table_email_content">
                                                <b><?=$email_subject?></b><br/>
                                                <?=$email_body?>
                                            </div>
                                        </td>
                                        <td><?=$ticket_number.$i?></td>
                                        <td><?=$ticket_updated_at?></td>
                                    </tr>
                                    <?php $j++; } ?>
                                </tbody>
                            </table>
                        </div>
                        <div id="list_assigned" class="folder_list_hide">
                            <table id="datatable_assigned" class="table">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox"></th>
                                        <th title="Sort">Customer</th>
                                        <th>Conversation</th>
                                        <th title="Sort">Number</th>
                                        <th title="Sort">Last Update</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $k=0; while($k < $assigned) { ?>
                                    <tr onclick="document.location = '#<?=$i?>';">
                                        <td><input type="checkbox"></td>
                                        <td><?=$customer_name."A"?></td>
                                        <td>
                                            <div class="table_email_content">
                                                <b><?=$email_subject?></b><br/>
                                                <?=$email_body?>
                                            </div>
                                        </td>
                                        <td><?=$ticket_number.$i?></td>
                                        <td><?=$ticket_updated_at?></td>
                                    </tr>
                                    <?php $k++; } ?>
                                </tbody>
                            </table>
                        </div>
                        <div id="list_closed" class="folder_list_hide">
                            <table id="datatable_closed" class="table">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox"></th>
                                        <th title="Sort">Customer</th>
                                        <th>Conversation</th>
                                        <th title="Sort">Number</th>
                                        <th title="Sort">Last Update</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $l=0; while($l < $closed) { ?>
                                    <tr onclick="document.location = '#<?=$i?>';">
                                        <td><input type="checkbox"></td>
                                        <td><?=$customer_name."C"?></td>
                                        <td>
                                            <div class="table_email_content">
                                                <b><?=$email_subject?></b><br/>
                                                <?=$email_body?>
                                            </div>
                                        </td>
                                        <td><?=$ticket_number.$i?></td>
                                        <td><?=$ticket_updated_at?></td>
                                    </tr>
                                    <?php $l++; } ?>
                                </tbody>
                            </table>
                        </div>
                        <div id="list_spam" class="folder_list_hide">
                            <table id="datatable_spam" class="table">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox"></th>
                                        <th title="Sort">Customer</th>
                                        <th>Conversation</th>
                                        <th title="Sort">Number</th>
                                        <th title="Sort">Last Update</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $m=0; while($m < $spam) { ?>
                                    <tr onclick="document.location = '#<?=$i?>';">
                                        <td><input type="checkbox"></td>
                                        <td><?=$customer_name."S"?></td>
                                        <td>
                                            <div class="table_email_content">
                                                <b><?=$email_subject?></b><br/>
                                                <?=$email_body?>
                                            </div>
                                        </td>
                                        <td><?=$ticket_number.$i?></td>
                                        <td><?=$ticket_updated_at?></td>
                                    </tr>
                                    <?php $m++; } ?>
                                </tbody>
                            </table>
                        </div>
                        
                    
                </div>

                <!--<div class="grid_4 right_container">-->

            </div>
         </div> 
    </div>
   

<?php
    require "footer.php";
?>

    <script>
        $(document).ready(function() {
            $('#datatable_unassigned').DataTable({
                "bPaginate": true,
                "pagingType": "full_numbers",
                "language": {
                    "paginate": {
                        "first": "&lt;&lt;",
                        "previous": "&lt;",
                        "next": "&gt;",
                        "last": "&gt;&gt;"
                    },
                    "sInfo": "_TOTAL_ total <b>unassigned</b> tickets | Viewing <b>_START_</b> - <b>_END_</b>"
                },
                "lengthChange": false,
                "bFilter": true, 
                "bInfo": true,
                "order": [3, 'asc'],
                "columnDefs": [ {
                  "targets"  : [0,2],
                  "orderable": false,
                }]
            });
            $('#datatable_mine').DataTable({
                "bPaginate": true,
                "pagingType": "full_numbers",
                "language": {
                    "paginate": {
                        "first": "&lt;&lt;",
                        "previous": "&lt;",
                        "next": "&gt;",
                        "last": "&gt;&gt;"
                    },
                    "sInfo": "_TOTAL_ total <b>mine</b> tickets | Viewing <b>_START_</b> - <b>_END_</b>"
                },
                "lengthChange": false,
                "bFilter": true, 
                "bInfo": true,
                "order": [3, 'asc'],
                "columnDefs": [ {
                  "targets"  : [0,2],
                  "orderable": false,
                }]
            });
            $('#datatable_assigned').DataTable({
                "bPaginate": true,
                "pagingType": "full_numbers",
                "language": {
                    "paginate": {
                        "first": "&lt;&lt;",
                        "previous": "&lt;",
                        "next": "&gt;",
                        "last": "&gt;&gt;"
                    },
                    "sInfo": "_TOTAL_ total <b>assigned</b> tickets | Viewing <b>_START_</b> - <b>_END_</b>"
                },
                "lengthChange": false,
                "bFilter": true, 
                "bInfo": true,
                "order": [3, 'asc'],
                "columnDefs": [ {
                  "targets"  : [0,2],
                  "orderable": false,
                }]
            });
            $('#datatable_closed').DataTable({
                "bPaginate": true,
                "pagingType": "full_numbers",
                "language": {
                    "paginate": {
                        "first": "&lt;&lt;",
                        "previous": "&lt;",
                        "next": "&gt;",
                        "last": "&gt;&gt;"
                    },
                    "sInfo": "_TOTAL_ total <b>closed</b> tickets | Viewing <b>_START_</b> - <b>_END_</b>"
                },
                "lengthChange": false,
                "bFilter": true, 
                "bInfo": true,
                "order": [3, 'asc'],
                "columnDefs": [ {
                  "targets"  : [0,2],
                  "orderable": false,
                }]
            });
            $('#datatable_spam').DataTable({
                "bPaginate": true,
                "pagingType": "full_numbers",
                "language": {
                    "paginate": {
                        "first": "&lt;&lt;",
                        "previous": "&lt;",
                        "next": "&gt;",
                        "last": "&gt;&gt;"
                    },
                    "sInfo": "_TOTAL_ total <b>spam</b> tickets | Viewing <b>_START_</b> - <b>_END_</b>"
                },
                "lengthChange": false,
                "bFilter": true, 
                "bInfo": true,
                "order": [3, 'asc'],
                "columnDefs": [ {
                  "targets"  : [0,2],
                  "orderable": false,
                }]
            });
        });

        $(document).on('click', '.sorting', function () {
            activeFolder();
        });

        $(document).on('click', '.sorting_asc', function () {
            activeFolder();
        });

        $(document).on('click', '.sorting_desc', function () {
            activeFolder();
        });

        $(document).on('click', '.paginate_button', function () {
            activeFolder();
        });

        function openFolder(folder, tickets, table) {
            $('#list_unassigned').addClass('folder_list_hide');
            $('#list_mine').addClass('folder_list_hide');
            $('#list_assigned').addClass('folder_list_hide');
            $('#list_closed').addClass('folder_list_hide');
            $('#list_spam').addClass('folder_list_hide');
            $('#btn_fldr_1').removeClass('folders_button_active');
            $('#btn_fldr_2').removeClass('folders_button_active');
            $('#btn_fldr_3').removeClass('folders_button_active');
            $('#btn_fldr_4').removeClass('folders_button_active');
            $('#btn_fldr_5').removeClass('folders_button_active');

            $(table+'_filter input').val(null);
            $(table+'_filter input').trigger("keyup");

            $('.paginate_button').css("display", "none");
            if($(table+'_first').hasClass("disabled")) {
                $(table+'_first').css("display", "none");
                $(table+'_previous').css("display", "none");
            } else {
                $(table+'_first').css("display", "inline-block");
                $(table+'_previous').css("display", "inline-block");
            }

            if($(table+'_next').hasClass("disabled")) {
                $(table+'_next').css("display", "none");
                $(table+'_last').css("display", "none");
            } else {
                $(table+'_next').css("display", "inline-block");
                $(table+'_last').css("display", "inline-block");
            }

            var rows  = tickets;
            if(rows > 10) {
                $(table+'_paginate').css("display", "block");
                $(table+'_info').css("display", "block");
            } else {
                $(table+'_paginate').css("display", "none");
                $(table+'_info').css("display", "none");
            }

            if(folder == 1) {
                $('#list_unassigned').removeClass('folder_list_hide');
                $('#btn_fldr_1').addClass('folders_button_active');
            } else if(folder == 2) {
                $('#list_mine').removeClass('folder_list_hide');
                $('#btn_fldr_2').addClass('folders_button_active');
            } else if(folder == 3) {
                $('#list_assigned').removeClass('folder_list_hide');
                $('#btn_fldr_3').addClass('folders_button_active');
            } else if(folder == 4) {
                $('#list_closed').removeClass('folder_list_hide');
                $('#btn_fldr_4').addClass('folders_button_active');
            } else {
                $('#list_spam').removeClass('folder_list_hide');
                $('#btn_fldr_5').addClass('folders_button_active');
            }
        }

        function activeFolder() {
            var activeFolderNow = "";
            if(!$('#list_unassigned').hasClass("folder_list_hide")) {
                activeFolderNow = "#datatable_unassigned";
            }else if(!$('#list_mine').hasClass("folder_list_hide")) {
                activeFolderNow = "#datatable_mine";
            }else if(!$('#list_assigned').hasClass("folder_list_hide")) {
                activeFolderNow = "#datatable_assigned";
            }else if(!$('#list_closed').hasClass("folder_list_hide")) {
                activeFolderNow = "#datatable_closed";
            }else{
                activeFolderNow = "#datatable_spam";
            }

            $('.paginate_button').css("display", "none");
            if($( activeFolderNow+'_first' ).hasClass("disabled")) {
                $( activeFolderNow+'_first' ).css("display", "none");
                $( activeFolderNow+'_previous' ).css("display", "none");
            } else {
                $( activeFolderNow+'_first' ).css("display", "inline-block");
                $( activeFolderNow+'_previous' ).css("display", "inline-block");
            }

            if($( activeFolderNow+'_next' ).hasClass("disabled")) {
                $( activeFolderNow+'_next' ).css("display", "none");
                $( activeFolderNow+'_last' ).css("display", "none");
            } else {
                $( activeFolderNow+'_next' ).css("display", "inline-block");
                $( activeFolderNow+'_last' ).css("display", "inline-block");
            }
        }
    </script>
