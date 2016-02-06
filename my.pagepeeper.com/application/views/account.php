<div class="page-content">
    <div class="header">
        <h2>Account <strong>Settings</strong></h2>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel">
                <div style="background-color: #66bb6a; display: table-cell; vertical-align: middle; padding: 16px;">
                    <i class="fa fa-credit-card fa-2x" style="color: #ffffff;"></i>
                </div>
                <div class="panel-content" style="padding-left: 20px; display: table-cell;">
                    <h4 style="margin-top: 0px;">You are currently on a <b>Stalker</b> subscription at no cost</h4>
                </div>
            </div>

            <div class="panel">
                <div class="panel-header">
                    <h3>Account <strong>Details</strong></h3>
                </div>
                <div class="panel-content">
                    <div class="row">
                        <div class="col-md-4">
                            <img src="https://s.gravatar.com/avatar/<?php echo md5($this->session->userdata('email')); ?>?s=200&d=mm" class="img-responsive" alt="Profile Picture">
                            <br /><a href="http://en.gravatar.com/" target="_blank"><button type="button" class="btn btn-primary" style="margin-left: 3px;"><i class="icon-picture"></i> Update via Gravatar</button></a>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="form-label">Username</label>
                                <input type="text" class="form-control" placeholder="Enter your username"<?php if (strlen($user->username)>0) { echo ' value="'.$user->username.'"'; } ?>>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Full Name</label>
                                <input type="text" class="form-control" placeholder="Enter your full name"<?php if (strlen($user->name)>0) { echo ' value="'.$user->name.'"'; } ?>>
                            </div>
                            <div class="form-group">
                                <label class="form-label">E-mail Address</label>
                                <input type="text" class="form-control" placeholder="Enter your e-mail address"<?php if (strlen($user->email)>0) { echo ' value="'.$user->email.'"'; } ?>>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Phone Number</label>
                                <input type="text" class="form-control" placeholder="Enter your phone number"<?php if (strlen($user->phone)>0) { echo ' value="'.$user->phone.'"'; } ?>>
                            </div>
                            <div class="form-group">
                                <label class="form-label">New Password</label>
                                <input type="password" class="form-control" placeholder="********">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" placeholder="********">
                            </div>
                            <div class="form-group">
                                <button style="margin-top: 8px;" type="submit" class="btn btn-primary">Update Details</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--
            <div class="panel">
                <div class="panel-header">
                    <h3>Plan <strong>Details</strong></h3>
                </div>
                <div class="panel-content">
                    <div class="row plans pricing-table num-plan-3 plan-separated plan-shadow">
                        <div class="col-sm-12">
                            <div class="plans clearfix">
                                <div class="plan">
                                    <div class="plan-header bg-primary">
                                        <div class="title"><span class="f-30">Free</span></div>
                                        <div class="price f-11"><span class="amount">$0</span><span class="">/month</span></div>
                                    </div>
                                    <div class="description">
                                        <div class="p-item">
                                            <p class="plan-item f-15"><b>1</b> Visual Check</p>
                                        </div>

                                        <div class="p-item">
                                            <p class="plan-item f-15"><b>3</b> Code Checks</p>
                                        </div>

                                        <div class="p-item">
                                            <p class="plan-item f-15"><b>0</b> SMS Alerts</p>
                                        </div>

                                        <div class="p-item">
                                            <p class="plan-item f-15"><b>1</b> Change Point</p>
                                        </div>

                                        <div class="p-item">
                                            <p class="plan-item f-15">No Support</p>
                                        </div>

                                        <div class="text-center plan-bottom-btn p-b-10"><a class="btn btn-default f-15">Currently on this plan</a></div>
                                    </div>
                                </div>
                                <div class="plan">
                                    <div class="plan-header bg-primary">
                                        <div class="title"><span class="f-30">Enthusiast</span></div>
                                        <div class="price f-11"><span class="amount">$5</span><span class="">/month</span></div>

                                    </div>
                                    <div class="description">
                                        <div class="p-item">
                                            <p class="plan-item f-15"><b>3</b> Visual Check</p>
                                        </div>

                                        <div class="p-item">
                                            <p class="plan-item f-15"><b>10</b> Code Checks</p>
                                        </div>

                                        <div class="p-item">
                                            <p class="plan-item f-15"><b>5</b> SMS Alerts</p>
                                        </div>

                                        <div class="p-item">
                                            <p class="plan-item f-15"><b>5</b> Change Points</p>
                                        </div>

                                        <div class="p-item">
                                            <p class="plan-item f-15">Email Support</p>
                                        </div>

                                        <div class="text-center plan-bottom-btn p-b-10"><a class="btn btn-primary f-15" href="#">Change to this Plan</a></div></div>
                                </div>
                                <div class="plan">
                                    <div class="plan-header bg-primary">
                                        <div class="title"><span class="f-30">Stalker</span></div>
                                        <div class="price f-11"><span class="amount">$20</span><span class="">/month</span></div>
                                    </div>
                                    <div class="description">
                                        <div class="p-item">
                                            <p class="plan-item f-15"><b>15</b> Visual Check</p>
                                        </div>

                                        <div class="p-item">
                                            <p class="plan-item f-15"><b>50</b> Code Checks</p>
                                        </div>

                                        <div class="p-item">
                                            <p class="plan-item f-15"><b>25</b> SMS Alerts</p>
                                        </div>

                                        <div class="p-item">
                                            <p class="plan-item f-15"><b>25</b> Change Points</p>
                                        </div>

                                        <div class="p-item">
                                            <p class="plan-item f-15">Email Support</p>
                                        </div>

                                        <div class="text-center plan-bottom-btn p-b-10"><a class="btn btn-primary f-15" href="#">Change to this Plan</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            -->
        </div>
    </div>
</div>