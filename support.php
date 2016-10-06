<?php
    require 'header.php';

    $unassigned = 0;
    $mine = 0;
    $assigned = 0;
    $closed = 0;
    $spam = 0;

    $customer_name = "John Doe";
    $email_subject = "Lorem Ipsum";
    $email_body = "It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).";
    $ticket_number = "26191";
    $ticket_updated_at = "10/29/2016";

?>
    <style>
        .left_container {
            height: 500px; 
            width: 200px !important;
            margin: 0; 
            background-color: #e6e6e6;
        }
        .middle_container {
            height: 500px;
            width: 700px !important;
            margin:0;
            background-color: #f2f2f2;
        }
        .right_container {
            height: 500px; 
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
        
    </style>

    <div class="container_12 boxsummary">
        <div class="full-width-div">        
            <div class="container_12">
                <div class="grid_4 left_container">
                    <div class="folders">
                        <a href="#unassigned">
                            <button onclick="openFolder(1)"><i class="glyphicon glyphicon-envelope"></i>
                                Unassigned<span><?=$unassigned?></span>
                            </button>
                        </a>
                        <a href="#mine">
                            <button onclick="openFolder(2)"><i class="glyphicon glyphicon-inbox"></i>
                                Mine<span><?=$mine?></span>
                            </button>
                        </a>
                        <a href="#assigned">
                            <button onclick="openFolder(3)"><i class="glyphicon glyphicon-user"></i>
                                Assigned<span><?=$assigned?></span>
                            </button>
                        </a>
                        <a href="#closed">
                            <button onclick="openFolder(4)"><i class="glyphicon glyphicon-trash"></i>
                                Closed<span><?=$closed?></span>
                            </button>
                        </a>
                        <a href="#spam">
                            <button onclick="openFolder(5)"><i class="glyphicon glyphicon-ban-circle"></i>
                            Spam<span><?=$spam?></span></button>
                        </a>
                    </div>
                </div>
                <div class="grid_4 middle_container">
                    <table id="datatable" class="table">
                        <thead>
                            <tr>
                                <th><input type="checkbox"></th>
                                <th>Customer</th>
                                <th>Conversation</th>
                                <th>Number</th>
                                <th>Last Update</th>
                            </tr>
                        </thead>
                        <tbody id="list_unassigned" class="folder_list_hide">
                            <?php $i=0; while($i < 6) { ?>
                            <tr onclick="document.location = '#<?=$i?>';">
                                <td><input type="checkbox"></td>
                                <td><?=$customer_name?></td>
                                <td>
                                    <div class="table_email_content">
                                        <b><?=$email_subject?></b><br/>
                                        <?=$email_body?>
                                    </div>
                                </td>
                                <td><?=$ticket_number.$i?></td>
                                <td><?=$ticket_updated_at?></td>
                            </tr>
                            <?php $i++; } ?>
                        </tbody>
                        <div id="list_mine" class="folder_list_hide">
                           
                        </div>
                        <div id="list_assigned" class="folder_list_hide">
                            
                        </div>
                        <div id="list_closed" class="folder_list_hide">
                           
                        </div>
                        <div id="list_spam" class="folder_list_hide">
                            
                        </div>
                    </table>
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
            $('#datatable').DataTable({
                "bPaginate": false,
                "bFilter": false, 
                "bInfo": false,
                "order": [],
                "columnDefs": [ {
                  "targets"  : [0,1,2],
                  "orderable": false,
                }]
            });
        } );
        function openFolder($folder) {
            $('#list_unassigned').addClass('folder_list_hide');
            $('#list_mine').addClass('folder_list_hide');
            $('#list_assigned').addClass('folder_list_hide');
            $('#list_closed').addClass('folder_list_hide');
            $('#list_spam').addClass('folder_list_hide');
            if($folder == 1) {
                $('#list_unassigned').removeClass('folder_list_hide');
            } else if($folder == 2) {
                $('#list_mine').removeClass('folder_list_hide');
            } else if($folder == 3) {
                $('#list_assigned').removeClass('folder_list_hide');
            } else if($folder == 4) {
                $('#list_closed').removeClass('folder_list_hide');
            } else {
                $('#list_spam').removeClass('folder_list_hide');
            }
        }
    </script>
