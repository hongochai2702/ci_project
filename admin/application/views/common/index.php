<?php $this->load->view('common/header'); ?>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php $this->load->view('common/menu'); ?>
        <div class="content-wrapper">
            <section class="content-header">
            <h1><?php echo lang('index_heading');?></h1>
             <p><?php echo lang('index_subheading');?></p>
            </section>
            <!-- Modal -->
            <div class="modal fade bs-example-modal-lg" id="news_events_modal" tabindex="-1" role="dialog" aria-labelledby="news_events_modalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">News &amp; Events Form</h4>
                        </div>
                        <div class="modal-body">
                            <form role="form" id="news_event_form" class="form-horizontals" role="form" name="news_event_form">
                                <span id="news_event_ajax_reciever">
                                    <div class="form-group">
                                        <label for="inputSubjectTitle">Subject / Title</label>
                                        <input required id= "inputSubjectTitle" name= "inputSubjectTitle" type="text" class="form-control"   placeholder="Title / Subject ">
                                    </div>
                                    <div class="form-group">
                                        <label for="inputContent">Body</label>
                                        <textarea required name ="inputContent" id="inputContent" class="form-control elibrary_editors" rows="3" placeholder="Content of the news/ Event"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputContent">Status</label>
                                        <select class="form-control" id="news_status" name="news_status">
                                            <?php ?>
                                        </select>
                                    </div>
                                    <input type = "hidden" name="hidden_news_key" id="hidden_news_key" value="hidden_news_key" />
                                    <button type="submit" name="saveRecord" class="btn btn-primary">Save Record</button>  <span class="pull-right" id="hidden_news_key_ajax_res"> </span>
                                </span>
                            </form>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

            <div class="modal fade" id="deleteNewsModal" tabindex="-1" role="dialog" aria-labelledby="deleteNewsModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content " >
                        <form id="deleteNewsModalFormID" target=" " method="post" name="deleteNewsModalFormID"  >


                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title">Delete Record</h4>
                            </div>
                            <div class="modal-body" id="needed"><span id="deleteResponse"> 
                                    <div class="alert alert-info"> Are you sure you want to delete this record? </div> </span>
                                <button type="button" class="btn btn-primary" data-dismiss="modal">No, Not now </button>
                                <input type= "hidden" name="newsDeleteHiddenID" value="0" id="newsDeleteHiddenID" />
                                <input id="deleteNewsModalIDSubmit" type="submit" class="btn btn-danger" value="Yes, proceed."  name= "deleteNewsModalIDSubmit"/>
                            </div>
                            <div class="modal-footer">
                            </div>
                        </form>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
             <div class="content">
            <div class="row">
            <div class="col-lg-4">  <a  data-toggle="modal" href="#news_events_modal" type="button" class="btn btn-success">Create New +</a></div>
            <div class="col-lg-4">
<?php echo anchor('common/login/create_user', lang('index_create_user_link'),array('class' => 'btn btn-success') )?>
            </div>
            <div class="col-lg-4">
<?php echo anchor('common/login/create_group', lang('index_create_group_link'),array('class'=> 'btn btn-success'))?>
            </div>
            </div></br>
            <div class="panel panel-primary">
                <div class="panel-heading">News &amp; Events Record List</div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-condensed table-hover dataTables" id="dataTables-libraryList">
                            <thead>
                            
                                <tr>
                                    <th><?php echo lang('index_fname_th');?></th>
                                    <th><?php echo lang('index_lname_th');?></th>
                                    <th><?php echo lang('index_email_th');?></th>
                                    <th><?php echo lang('index_groups_th');?></th>
                                    <th><?php echo lang('index_status_th');?></th>
                                    <th><?php echo lang('index_action_th');?></th>
                                </tr>
                                <?php foreach ($users as $user): ?>
                                  <tr>
                                    <th><?php echo htmlspecialchars($user->first_name,ENT_QUOTES,'UTF-8');?></th>
                                    <th><?php echo htmlspecialchars($user->last_name,ENT_QUOTES,'UTF-8');?></th>
                                    <th><?php echo htmlspecialchars($user->email,ENT_QUOTES,'UTF-8');?></th>
                                    <th>
                                        <?php foreach ($user->groups as $group):?>
                                            <?php echo anchor("common/login/edit_group/".$group->id, htmlspecialchars($group->name,ENT_QUOTES,'UTF-8')) ;?> 
                                        <?php endforeach?>
                                    </th>
                                    <th><?php echo ($user->active) ? anchor("common/login/deactivate/".$user->id, lang('index_active_link')) : anchor("common/login/activate/". $user->id, lang('index_inactive_link'));?></th>
                                    <th><?php echo anchor("common/login/edit_user/".$user->id, 'Edit') ;?></th>
                                </tr>
                                <?php endforeach; ?>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
       </div>
        </div>
    </div>
</body>