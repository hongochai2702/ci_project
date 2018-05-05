<!-- start: DASHBOARD TITLE -->
<section id="page-title" class="padding-top-15 padding-bottom-15">
  <div class="row">
    <div class="col-sm-7">
      <h1 class="mainTitle" translate="dashboard.WELCOME" translate-values="{ appName: app.name }">WELCOME TO CLIP-TWO</h1>
      <span class="mainDescription">overview &amp; stats </span>
    </div>
    <div class="col-sm-5">
      <!-- start: MINI STATS WITH SPARKLINE -->
      <!-- /// controller:  'SparklineCtrl' -  localtion: assets/js/controllers/dashboardCtrl.js /// -->
      <ul class="mini-stats pull-right" ng-controller="SparklineCtrl">
        <li>
          <div class="sparkline">
            <span jq-sparkline ng-model="sales" type="bar" height="20px" bar-color="#D43F3A"></span>
          </div>
          <div class="values">
            <strong class="text-dark">18304</strong>
            <p class="text-small no-margin">
              Sales
            </p>
          </div>
        </li>
        <li>
          <div class="sparkline">
            <span jq-sparkline ng-model="earnings" type="bar" height="20px" bar-color="#5CB85C"></span>
          </div>
          <div class="values">
            <strong class="text-dark">&#36;3,833</strong>
            <p class="text-small no-margin">
              Earnings
            </p>
          </div>
        </li>
        <li>
          <div class="sparkline">
            <span jq-sparkline ng-model="referrals" type="bar" height="20px" bar-color="#46B8DA"></span>
          </div>
          <div class="values">
            <strong class="text-dark">&#36;848</strong>
            <p class="text-small no-margin">
              Referrals
            </p>
          </div>
        </li>
      </ul>
      <!-- end: MINI STATS WITH SPARKLINE -->
    </div>
  </div>
</section>
<!-- end: DASHBOARD TITLE -->
<!-- start: FEATURED BOX LINKS -->
<div class="container-fluid container-fullw bg-white">
  <div class="row">
    <div class="col-sm-4">
      <div class="panel panel-white no-radius text-center">
        <div class="panel-body">
          <span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i class="fa fa-smile-o fa-stack-1x fa-inverse"></i> </span>
          <h2 class="StepTitle">Manage Users</h2>
          <p class="text-small">
            To add users, you need to be signed in as the super user.
          </p>
          <p class="links cl-effect-1">
            <a href>
              view more
            </a>
          </p>
        </div>
      </div>
    </div>
    <div class="col-sm-4">
      <div class="panel panel-white no-radius text-center">
        <div class="panel-body">
          <span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i class="fa fa-paperclip fa-stack-1x fa-inverse"></i> </span>
          <h2 class="StepTitle">Manage Orders</h2>
          <p class="text-small">
            The Manage Orders tool provides a view of all your orders.
          </p>
          <p class="cl-effect-1">
            <a href>
              view more
            </a>
          </p>
        </div>
      </div>
    </div>
    <div class="col-sm-4">
      <div class="panel panel-white no-radius text-center">
        <div class="panel-body">
          <span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i class="fa fa-terminal fa-stack-1x fa-inverse"></i> </span>
          <h2 class="StepTitle">Manage Database</h2>
          <p class="text-small">
            Store, modify, and extract information from your database.
          </p>
          <p class="links cl-effect-1">
            <a href>
              view more
            </a>
          </p>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- end: FEATURED BOX LINKS -->
<!-- start: FIRST SECTION -->

<!-- end: FIRST SECTION -->
<!-- start: SECOND SECTION -->

<!-- end: THIRD SECTION -->
<!-- start: FOURTH SECTION -->
<div class="container-fluid container-fullw bg-white">
  <div class="row">
    <div class="col-xs-12 col-sm-4">
      <div class="row">
        <!-- /// controller:  'SparklineCtrl' -  localtion: assets/js/controllers/dashboardCtrl.js /// -->
        <div ng-controller="SparklineCtrl">
          <div class="col-md-12">
            <div class="panel panel-white no-radius">
              <div class="panel-body padding-20 text-center">
                <div class="space10">
                  <h5 class="text-dark no-margin">Today</h5>
                  <h2 class="no-margin"><small>$</small>1,450</h2>
                  <span class="badge badge-success margin-top-10">253 Sales</span>
                </div>
                <div class="sparkline space10">
                  <span jq-sparkline ng-model="sales" type="line" width="80%" height="47px" line-color="#8e8e93" highlight-line-color="#c2c2c5" highlight-spot-color="#CE4641" max-spot-color="#5CB85C" min-spot-color="#D9534F" spot-radius="4" fill-color="transparent" resize="true"></span>
                </div>
                <span class="text-white-transparent"><i class="fa fa-clock-o"></i> 1 hour ago</span>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="panel panel-white no-radius">
              <div class="panel-body padding-20 text-center">
                <div class="space10">
                  <h5 class="text-dark no-margin">Today</h5>
                  <h2 class="no-margin"><small>$</small>1,450</h2>
                  <span class="badge badge-danger margin-top-10">253 Sales</span>
                </div>
                <div class="sparkline space10">
                  <span jq-sparkline ng-model="referrals" type="line" width="80%" height="47px" line-color="#8e8e93" highlight-line-color="#c2c2c5" highlight-spot-color="#CE4641" max-spot-color="#5CB85C" min-spot-color="#D9534F" spot-radius="4" fill-color="transparent" resize="true"></span>
                </div>
                <span class="text-white-transparent"><i class="fa fa-clock-o"></i> 1 hour ago</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xs-12 col-sm-4">
      <div class="panel panel-white no-radius">
        <div class="panel-heading border-bottom">
          <h4 class="panel-title">Activities</h4>
        </div>
        <div class="panel-body">
          <ul class="timeline-xs margin-top-15 margin-bottom-15">
            <li class="timeline-item success">
              <div class="margin-left-15">
                <div class="text-muted text-small">
                  2 minutes ago
                </div>
                <p>
                  <a class="text-info" href>
                    Steven
                  </a>
                  has completed his account.
                </p>
              </div>
            </li>
            <li class="timeline-item">
              <div class="margin-left-15">
                <div class="text-muted text-small">
                  12:30
                </div>
                <p>
                  Staff Meeting
                </p>
              </div>
            </li>
            <li class="timeline-item danger">
              <div class="margin-left-15">
                <div class="text-muted text-small">
                  11:11
                </div>
                <p>
                  Completed new layout.
                </p>
              </div>
            </li>
            <li class="timeline-item info">
              <div class="margin-left-15">
                <div class="text-muted text-small">
                  Thu, 12 Jun
                </div>
                <p>
                  Contacted
                  <a class="text-info" href>
                    Microsoft
                  </a>
                  for license upgrades.
                </p>
              </div>
            </li>
            <li class="timeline-item">
              <div class="margin-left-15">
                <div class="text-muted text-small">
                  Tue, 10 Jun
                </div>
                <p>
                  Started development new site
                </p>
              </div>
            </li>
            <li class="timeline-item">
              <div class="margin-left-15">
                <div class="text-muted text-small">
                  Sun, 11 Apr
                </div>
                <p>
                  Lunch with
                  <a class="text-info" href>
                    Nicole
                  </a>
                  .
                </p>
              </div>
            </li>
            <li class="timeline-item warning">
              <div class="margin-left-15">
                <div class="text-muted text-small">
                  Wed, 25 Mar
                </div>
                <p>
                  server Maintenance.
                </p>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="col-xs-12 col-sm-4">
      <!-- /// controller:  'ChatCtrl' -  localtion: assets/js/controllers/chatCtrl.js /// -->
      <div ng-controller="ChatCtrl">
        <div class="panel panel-white no-radius">
          <div class="panel-heading border-bottom">
            <h4 class="panel-title">Chat</h4>
          </div>
          <div class="panel-body no-padding">
            <div class="panel-scroll height-330" id="chatBox" perfect-scrollbar wheel-propagation="false" suppress-scroll-x="true">
              <clip-chat messages="chat" id-self="selfIdUser" id-other="otherIdUser"></clip-chat>
            </div>
          </div>
          <chat-submit submit-function="sendMessage" ng-model="chatMessage" scroll-element="#chatBox"></chat-submit>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- end: FOURTH SECTION -->
