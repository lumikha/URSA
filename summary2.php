<?php
    require 'header.php';
    require 'gmail_get_messages2.php';
    $em_check = array();
    foreach ($result_db_customers['Items'] as $obj) {
        if($obj['customer_email']['S']){
            array_push($em_check, array(
                "email" => $obj['customer_email']['S'],
                "id" => $obj['chargify_id']['S'],
                "bname" => $obj['business_name']['S'],
                "fname" => $obj['customer_first_name']['S'],
                "lname" => $obj['customer_last_name']['S'],
                "bphone" => $obj['business_phone_no']['S']
            ));
        }
    }
?>
    <style>

        .modal.fade .modal-dialog {
            -webkit-transform: scale(0.1);
            -moz-transform: scale(0.1);
            -ms-transform: scale(0.1);
            transform: scale(0.1);
            top: 300px;
            opacity: 0;
            -webkit-transition: all 0.3s;
            -moz-transition: all 0.3s;
            transition: all 0.3s;
        }

        .modal.fade .modal-dialog {
            -webkit-transform: scale(0.1);
            -moz-transform: scale(0.1);
            -ms-transform: scale(0.1);
            transform: scale(0.1);
            top: 300px;
            opacity: 0;
            -webkit-transition: all 0.3s;
            -moz-transition: all 0.3s;
            transition: all 0.3s;
        }

        .modal.fade.in .modal-dialog {
            -webkit-transform: scale(1);
            -moz-transform: scale(1);
            -ms-transform: scale(1);
            transform: scale(1);
            -webkit-transform: translate3d(0, -300px, 0);
            transform: translate3d(0, -300px, 0);
            opacity: 1;
        }

        input[readonly], span[readonly] {
            background-color: #fff !important;
        }
    </style>

    <div class="container_12 boxsummary">
    <div class="modal fade" id="viewTicket" tabindex="-1" role="dialog">
        <div id="modal_dialog" class="modal-dialog modal-md" >
            <div class="modal-content">
                <span>
                          
                </span>
                <div class="modal-body">
                    <input type="type" id="cID" hidden>
                    <div class="row">
                        <div class="col-md-4">
                            <label>Ticket Entry No.</label>
                            <input type="text" class="form-control" id="tNo" value="" style="text-align: center; font-weight: bold;" readonly>
                        </div>
                        <div class="col-md-6">
                            <label style="display: none;">Ticket ID</label>
                            <input type="text" class="form-control" id="tID" value="" style="text-align: center; font-weight: bold; display: none;" readonly>
                        </div>
                        <div class="col-md-2 text-right" style="top:-20px">
                            <a id="expand" href="#"><span id="glyph_resize" class="btn btn-info btn-sm glyphicon glyphicon-resize-full " aria-hidden="true"></span></a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label>Subject</label>
                            <input type="text" class="form-control" id="tSubj" name="ticket_subject" readonly>
                        </div>
                    </div>
                    <style>
                        #attID {
                            background-image: url('img/35.gif');
                            background-color: #f2f2f2;
                            background-repeat: no-repeat;
                            background-size: 50px;
                            background-position: center; 
                            border: 1 solid #fff2e6;
                            height: 200px;
                            box-shadow: 9px 9px 10px #818181;
                            -webkit-box-shadow: 9px 9px 10px #818181;
                            -moz-box-shadow: 9px 9px 10px #818181;
                            /*border-radius: 5px;*/
                            cursor: pointer;
                            transition: 0.3s;
                        }

                        #attID:hover {
                            -webkit-filter: brightness(50%);
                        }

                        .preview-modal {
                            display: none; 
                            position: fixed; 
                            z-index: 1060 !important;
                            padding-top: 100px; 
                            left: 0;
                            top: 0;
                            width: 100%;
                            height: 100%;
                            overflow: auto;
                            background-color: rgb(0,0,0);
                            background-color: rgba(0,0,0,0.9);
                        }

                        .preview-modal-content {
                            margin: auto;
                            display: block;
                            width: 80%;
                            max-width: 700px;
                        }

                        #caption {
                            margin: auto;
                            display: block;
                            width: 80%;
                            max-width: 700px;
                            text-align: center;
                            color: #ccc;
                            padding: 10px 0;
                            height: 150px;
                        }

                        .preview-modal-content, #caption {
                            -webkit-animation-name: zoom;
                            -webkit-animation-duration: 0.6s;
                            animation-name: zoom;
                            animation-duration: 0.6s;
                        }

                        @-webkit-keyframes zoom {
                            from {-webkit-transform:scale(0)}
                            to {-webkit-transform:scale(1)}
                        }

                        @keyframes zoom {
                            from {transform:scale(0)}
                            to {transform:scale(1)}
                        }

                        .preview-close {
                            position: absolute;
                            top: 15px;
                            right: 35px;
                            color: #f1f1f1;
                            font-size: 40px;
                            font-weight: bold;
                            transition: 0.3s;
                        }

                        .preview-close:hover,
                        .preview-close:focus {
                            color: #bbb;
                            text-decoration: none;
                            cursor: pointer;
                        }

                        @media only screen and (max-width: 700px){
                            .preview-modal-content {
                                width: 100%;
                            }
                        }

                        
                    </style>
                    <div class="row">
                        <div class="col-md-12">
                            <label>Message</label>
                            <div id="tBody" class="form-control" readonly style="overflow:auto;height:300px; background-color: #fff;">
                                <span id="tMsg" style="height: auto;" readonly></span> 
                                <span id="tMsgAtt"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <center>
                            <a href="#" class="btn btn-danger open-modal-updTicket">Update Ticket</a>
                            <button class="btn btn-danger" onclick="gotoCustomerPage()">Go to Customer Page</button>
                        </center>
                    </div>
                    <div class="row">
                            <style>
                                #magic_buttons button {
                                    background-color: #e6e6e6;
                                    width: 100%;
                                    text-align: left;
                                }
                                #magic_buttons button:hover {
                                    background-color: #ffffff;
                                }
                                #magic_buttons p {
                                    background-color: #f2f2f2;
                                    padding: 5px;
                                }
                                #lbl_th span {
                                    background-color: #f2f2f2;
                                    padding: 5px;
                                }
                            </style>
                        <label class="col-md-12">Thread(s)</label>
                        <div id="lbl_th" class="col-md-12">
                        </div>
                        <div id="magic_buttons" class="col-md-12">
                        </div>
                    </div>
                </div>
        
            </div>
        </div>
    </div>

    <div class="modal fade" id="updateTicket" tabindex="-1" role="dialog">
        <div id="modal_cont" class="modal-dialog modal-md">
            <div class="modal-content">
                                    
                <div class="modal-body">
                    <form method="POST">
                        <input type="type" id="cID_new_thread" name="cTID" hidden>
                        <div class="row">
                            <div class="col-md-6">
                                <label>New Thread Type</label>
                                <div class="radio" style="margin-left: 30px;">
                                    <label><input type="radio" id="rad1" name="type" value="note" onclick="tType(1);">Note</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <label><input type="radio" id="rad2" name="type" value="message" onclick="tType(2);">Message</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>New Status</label>
                                <select class="form-control" id="commit_status" name="status">
                                    <optgroup label="Status">
                                        <option value="" disabled selected>No Change</option>
                                        <option value="active">Active</option>
                                        <option value="pending">Pending</option>
                                        <option value="closed">Closed</option>
                                        <option value="spam">Spam</option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label>Message</label>
                                <textarea class="form-control" id="commit_msg" name="message" style="height: 300px;"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <center>
                                <input type="Submit" class="btn btn-danger" name="new_thread" value="Create Thread">
                            </center>
                        </div>
                    </form>
                </div>
        
            </div>
        </div>
    </div>

    <div id="attModal" class="preview-modal">
        <span class="preview-close">×</span>
        <img class="preview-modal-content" id="img01">
        <div id="caption"></div>
    </div>
    <div class="full-width-div">        
     <div class="container_12" style="margin-top:-1em;">
    <div id="boxes" class="row text-center">
        <div class="grid_2 push_1 alpha" style="padding: 1em;margin-right:1em;margin-bottom:1em;border:solid #A60800 2px;color:#A60800"><a href="#" onclick="return addTicket();"><strong>Ticket</strong></a></div>
        <div class="grid_2 push_1 omega" style="padding: 1em;margin-right:1em;margin-bottom:1em;border:solid #340570 2px;color:#340570"><strong>Talkdesk</strong></div>
        
    </div>
    </div>
    </div>
    <div class="container_12">

        <div class="grid_5 push_1 alpha" style="overflow-y: scroll; overflow-x: hidden; height: 550px; padding-left:0em; margin-left:auto;">



        <?php 
        

            foreach($arr_msgs as $a_m) { 
                $mID = $a_m['id'];
                $sbj = $a_m['subject'];
                $bdy = htmlentities($a_m['body']);
                $ats_title = "";
                $ats = "";
                
                if($a_m['attachments']) {
                    $ats_title = "<br/><b>Attachments</b><br/><br/>";
                }
                foreach($a_m['attachments'] as $am_ats) {
                    $ats .= htmlentities($am_ats);
                }
                
                $em_cnt=0;
                while(!empty($em_check[$em_cnt])) {
                    if($a_m['email'] == $em_check[$em_cnt]['email']) {
                        $cID = $em_check[$em_cnt]['id'];
                        $bn = $em_check[$em_cnt]['bname'];
                        $fn = $em_check[$em_cnt]['fname'];
                        $ln = $em_check[$em_cnt]['lname'];
                        $bp = $em_check[$em_cnt]['bphone'];
        ?>
                        <div class="container_12">
                            <div class="grid_1 alpha round-div">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            </div>
                            <div class="grid_2 omega">
                                <a href="#" class="open-modal" data-cid="<?=$cID?>" data-id="<?=$mID?>" data-no="" data-subject="<?=$sbj?>" data-mes="<?=$bdy?>" data-atturl="<?=$ats_title.$ats?>" data-threadmsg="">
                                <strong><?php echo $bn; ?></strong></a> <br>
                                <?php
                                    echo $fn." ".$ln."<br>".
                                         $bp."<br>".
                                         $cID;
                                ?>
                            </div>
                        </div><br/>
        <?php 
                    }
                    $em_cnt++;
                }
            } 

            
        ?>

        </div>
    </div>
   </div>
   

<?php
    require "footer.php";
?>

<script>
    $(document).ready(function(){
        $('#viewTicket').on('hidden.bs.modal', function (e) {
            $("#magic_buttons").empty();
            $("#lbl_th").empty();
            $("#id_you_like_div_none").empty();
        })

        $('#viewTicket').on('shown.bs.modal', function () {
            $('#tBody').scrollTop(0);
        })

        $('#updateTicket').on('hidden.bs.modal', function (e) {
            $('#rad1').removeAttr('checked');
            $('#rad2').removeAttr('checked');
            document.getElementById("commit_status").value = "";
            $('#commit_subj').prop('disabled', false);
            document.getElementById("commit_subj").value = "";
            document.getElementById("commit_msg").value = "";
        })
    });

    function preview(imgsrc, imgttl) {
        var modal = document.getElementById('attModal');
        var img = document.getElementById('attID');
        var modalImg = document.getElementById("img01");
        var captionText = document.getElementById("caption");
            
        modal.style.display = "block";
        modalImg.src = imgsrc;
        captionText.innerHTML = imgttl;
            
        var span = document.getElementsByClassName("preview-close")[0];

        span.onclick = function() {
            modal.style.display = "none";
        }
    }
    
    function testClick(val) {
        if(document.getElementById('id_you_like_div_'+val).style.display == "block") {
            document.getElementById('id_you_like_div_'+val).style.display = "none";
        } else {
            document.getElementById('id_you_like_div_'+val).style.display = "block";
        }
    }

    $(document).on("click", ".open-modal", function (e) {
        e.preventDefault();
        var _self = $(this);
            tID = _self.data('id'),
            tNo = _self.data('no'),
            tSubj = _self.data('subject'),
            tMsg = _self.data('mes'),
            tMsgAtt = _self.data('atturl'),
            cID = _self.data('cid'),
            threads = _self.data('threadmsg');
        $("#tID").val(tID);
        $("#tNo").val(tNo);
        $("#tSubj").val(tSubj);
        $("#tMsg").html(tMsg);
        $("#tMsgAtt").html(tMsgAtt);
        $("#cID").val(cID);

        if(threads) {
            fields = threads.split("~^^^~");

            var i = 0;
            while(fields[i]) {
                field_type = fields[i].split("||+||");
                var btn = document.createElement("BUTTON");
                btn.setAttribute("id", "id_you_like_"+i);
                btn.setAttribute("class", "form-control");
                btn.setAttribute("onclick", "testClick("+i+")");
                document.getElementById('magic_buttons').appendChild(btn);
                document.getElementById('id_you_like_'+i).innerHTML = field_type[0] + field_type[1];
                var current = document.getElementById('id_you_like_'+i);
                var el = document.createElement("SPAN");
                el.setAttribute("id", "id_you_like_div_"+i);
                el.setAttribute("style", "display: none");
                insertAfter(current, el);
                document.getElementById('id_you_like_div_'+i).innerHTML = field_type[2];
                var element = document.getElementById("magic_buttons");
                i++;
            }
            $('#id_you_like_'+(i-1)).remove();
            $('#id_you_like_div_'+(i-1)).remove();
            if(i == 1) {
                var no = document.createElement("SPAN");
                no.setAttribute("id", "id_you_like_div_none");
                no.setAttribute("class", "col-md-12");
                document.getElementById('lbl_th').appendChild(no);
                document.getElementById('id_you_like_div_none').innerHTML = "<span>No thread(s) found.</span";
            }
        }

        $("#viewTicket").modal('show');
    });

    $(document).on("click", ".open-modal-updTicket", function (e) {
        document.getElementById('cID_new_thread').value = document.getElementById('tID').value;
        $("#updateTicket").modal('show');
    });

    function gotoCustomerPage() {
        var cID = document.getElementById('cID').value;
        var tID = document.getElementById('tID').value;
        window.open('customer?id='+cID+'&ticket_id='+tID);
    }

    function tType(tVal) {
        if(tVal == 1) {
            $('#commit_subj').prop('disabled', true);
        } else {
            $('#commit_subj').prop('disabled', false);
        }
    }

    function insertAfter(referenceNode, newNode) {
        referenceNode.parentNode.insertBefore(newNode, referenceNode.nextSibling);
    }
    $('#expand').click(function(){
        if($('#modal_dialog').hasClass('modal-md')){
            $('#glyph_resize').removeClass('glyphicon-resize-full');
            $('#glyph_resize').addClass('glyphicon-resize-small');
            $('#modal_dialog').removeClass('modal-md');
            $('#modal_cont').removeClass('modal-md');
            $('#modal_dialog').addClass('modal-lg');
            $('#modal_cont').addClass('modal-lg');
        }else{
            $('#glyph_resize').removeClass('glyphicon-resize-small');
            $('#glyph_resize').addClass('glyphicon-resize-full');
            $('#modal_dialog').removeClass('modal-lg');
            $('#modal_cont').removeClass('modal-lg');
            $('#modal_dialog').addClass('modal-md');
            $('#modal_cont').addClass('modal-md');
        }
    });
</script>

