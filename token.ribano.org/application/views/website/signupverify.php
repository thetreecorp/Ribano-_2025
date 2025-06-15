        <div class="reg-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 offset-md-4 mt-50 mb-70">

                        <!-- alert message -->
                        <?php if ($this->session->flashdata('message') != null) {  ?>
                        <div class="alert alert-info alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <?php echo $this->session->flashdata('message'); ?>
                        </div>
                        <?php } ?>

                        <?php if ($this->session->flashdata('exception') != null) {  ?>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <?php echo $this->session->flashdata('exception'); ?>
                        </div>
                        <?php } ?>

                        <?php if (validation_errors()) {  ?>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <?php echo validation_errors(); ?>
                        </div>
                        <?php } ?>

                        <h3 class="text-center mb-4">Account Activation</h3>

                        <?php echo form_open('signup-verify'); ?>

                        <div class="form-group">
                            <select class="form-control" name="verifymedia" id="verifymedia">
                                <?php if (!empty($verifyinfoemail->sign_up)) { ?>
                                <option value="email">Email</option>
                                <?php }
                                if (!empty($verifyinfosms->sign_up)) { ?>
                                <option value="sms">SMS</option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group" id="showphonenumber">
                            <input type="text" class="form-control" name="phonenumber" id="phonenumber"
                                placeholder="Your Phone Number" />
                        </div>

                        <div class="form-group">
                            <button class="btn btn-success" type="submit">Submit</button>
                        </div>

                        <?php echo form_close(); ?>

                    </div>
                </div>
            </div>
        </div>