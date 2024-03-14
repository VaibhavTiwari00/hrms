 <style>
     .break-button {
         width: 300px;
     }
 </style>
 <div id="break_start" class="modal custom-modal fade" role="dialog">
     <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <!-- <h5 class="modal-title">Lunch Timer</h5> -->
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close_break">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <div class="modal-body">
                 <?php
                    $check_value_break = check_break_by_date($DB, date('y-m-d'));
                    $total_break_time = get_break_time_acc_date($DB, date('y-m-d'));
                    ?>
                 <div class="title_timer" style="display:flex;justify-content:center;">
                     Total Break Timing: <span id="total_break_time"> <?= $total_break_time  ?></span>
                 </div>

                 <div class="row" style="display:flex;justify-content:center;">
                     <div class="container_timer">
                         <div class="title_timer">Break Timer:</div>
                         <div class="clock">
                             <div class="hours">
                                 <span id="hourss">00</span>
                                 <p>HOURS</p>
                             </div>
                             <div class="minutes">
                                 <span id="minutess">00</span>
                                 <p>MINS</p>
                             </div>
                             <div class="seconds">
                                 <span id="secondss">00</span>
                                 <p>SECS</p>
                             </div>
                         </div>
                     </div>
                     <p id="startTime"></p>
                     <p id="stopTime"></p>
                     <div class="submit-section ">
                         <button class="btn btn-primary btn-lg break-button" id="startBtnbreak">Start</button>
                     </div>
                     <div class="submit-section ">
                         <button class="btn btn-danger btn-lg break-button" id="stopBtnbreak">Stop</button>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>