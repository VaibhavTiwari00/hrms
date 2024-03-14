  <div id="lunch_start" class="modal custom-modal fade" role="dialog">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <!-- <h5 class="modal-title">Lunch Timer</h5> -->
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <?php
                    if (check_lunch_by_date($DB, date('y-m-d')) == 1) {
                    ?>
                      <div class="title_timer" style="display:flex;justify-content:center;">Already Taken</div>

                  <?php } else { ?>
                      <div class="row" style="display:flex;justify-content:center;">
                          <div class="container_timer">
                              <div class="title_timer">Lunch Timer:</div>
                              <div class="clock">
                                  <div class="hours">
                                      <span id="hours">00</span>
                                      <p>HOURS</p>
                                  </div>
                                  <div class="minutes">
                                      <span id="minutes">00</span>
                                      <p>MINS</p>
                                  </div>
                                  <div class="seconds">
                                      <span id="seconds">00</span>
                                      <p>SECS</p>
                                  </div>
                              </div>
                          </div>

                          <div class="submit-section ">
                              <button class="btn btn-primary " id="startBtn">Start</button>
                          </div>
                      </div>
                  <?php } ?>



              </div>
          </div>
      </div>
  </div>