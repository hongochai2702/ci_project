

<div id="contact-us" ng-controller="CtrlContact">
<div class="right-section" id="form-elements">
                        <form id="form_contact">
                            <h4><?php echo $text_contact; ?></h4>
                            <p><?php echo $text_message; ?></p>
                            <div class="row">
                            <div class="col-md-12 center"><div id="result"></div> </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="<?php echo $entry_name; ?>" required="required" id="name" name="name">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="email" class="form-control" placeholder="<?php echo $entry_email; ?>" required="required" id="email" name="email">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="<?php echo $entry_phone; ?>" required="required" id="phone" name="phone">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="<?php echo $entry_enquiry; ?>" required="required" id="subject" name="subject">
                                    </div>
                                </div>

                            </div>

                            <div class="form-group">
                                <textarea class="form-control" placeholder="<?php echo $entry_message; ?>" required="required" id="message" name="message"></textarea>
                            </div>
                            <button  class="btn button" id="submit_btn" ng-click="sendContact();"><?php echo $button_submit; ?></button>
                        </form>
</div>
</div>
<script type="text/javascript">
    var action_contact = '<?php echo $action; ?>'
</script>