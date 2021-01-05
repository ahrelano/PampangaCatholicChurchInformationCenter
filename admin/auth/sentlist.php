<?php
$sent = $con->query("SELECT * FROM mail WHERE sender = '$username' ORDER BY `time` DESC");
while ($rowsent = $sent->fetch_array()){
?>
                      <div class="message">
                        <a href="#<?php echo $rowsent['id']; ?>" data-toggle="modal" class="list-group-item">
                            <div class="checkbox hidden-xs hidden-sm visible-md-inline-block visible-lg-inline-block">
                                <label>
                                    <input type="checkbox">
                                </label>
                            </div>
                            <span class="name"><b><?php echo $rowsent['sender']; ?></b><small class="hidden-xs hidden-sm"><devbizznex@zoho.com></small></span> <span class="title"><?php echo $rowsent['subject']; ?></span> <span class="text-muted text">- <?php echo $rowsent['message']; ?></span> <span class="badge"><?php echo $rowsent['date']; ?></span>
                               </a>
                    </div>


                          <!-- Inbox Modal -->
                          <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="<?php echo $rowsent['id']; ?>" class="modal fade" style="display: none;">
                              <div class="modal-dialog">
                                  <div class="modal-content">
                                      <div class="modal-header">
                                          <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                          <h4 class="modal-title"><?php echo $rowsent['sender']; ?></h4>
                                      </div>
                                      <div class="modal-body">
                                          <form role="form" class="form-horizontal">
                                              <div class="form-group">
                                                  <label class="col-lg-2 control-label">Subject</label>
                                                  <div class="col-lg-10">
                                                      <input type="text" id="subject" name="subject" value="<?php echo $rowsent['subject']; ?>" class="form-control" disabled>
                                                      <label><?php echo $rowsent['date']; ?></label>
                                                  </div>
                                              </div>
                                              <div class="form-group">
                                                  <label class="col-lg-2 control-label">Message</label>
                                                  <div class="col-lg-10">
                                                      <textarea rows="10" cols="30" placeholder="<?php echo $rowsent['message']; ?>" class="form-control" id="message" name="message" disabled></textarea>
                                                  </div>
                                              </div>

                                              <div class="form-group">
                                                  <div class="col-lg-offset-2 col-lg-10">
                                                      <span class="btn green fileinput-button">
                                                        <i class="fa fa-plus fa fa-white"></i>
                                                        <span>Attachment</span>
                                                        <input type="file" name="files[]" multiple="">
                                                      </span>
                                                      <button id="signUpBtn" class="btn btn-send" type="submit" disabled>Reply</button>
                                                  </div>
                                              </div>
                                          </form>
                                      </div>
                                  </div><!-- /.modal-content -->
                              </div><!-- /.modal-dialog -->
                          </div><!-- /.modal -->
                            <?php
                          }
                            ?>
