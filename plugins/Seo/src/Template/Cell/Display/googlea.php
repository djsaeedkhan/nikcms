<?php
use Cake\Routing\Router;
use Cake\I18n\Time;
include_once __DIR__ . '/../../../vendor/vendor/autoload.php';
include_once __DIR__. '/../../../vendor/base.php';

$analytics = initializeAnalytics($options);
$profile = getFirstProfileId($analytics);
//$results = getResults($analytics, $profile);
//printResults($results);
/* function getResults($analytics, $profileId) {
  // Calls the Core Reporting API and queries for the number of sessions
  // for the last seven days.
   return $analytics->data_ga->get(
       'ga:' . $profileId,
       '7daysAgo',
       'today',
       'ga:sessions');
} */

//-------------------------------------------------------------------------------
$optParams = array('dimensions' => 'rt:medium');
try {
  $results3 = $analytics->data_realtime->get(
    'ga:'.$profile,
    'rt:pageviews',
    $optParams);
  // Success. 
} catch (apiServiceException $e) {
  // Handle API service exceptions.
  $error = $e->getMessage();
}
//--pr($results3->getTotalsForAllResults());// تعداد کل بازدید ها
//-------------------------------------------------------------------------------
$optParams = array('dimensions' => 'rt:pagePath');
try {
  $results2 = $analytics->data_realtime->get(
    'ga:'.$profile,
    'rt:pageviews',
    $optParams);
  // Success. 
} catch (apiServiceException $e) {
  $error = $e->getMessage();
}
//pr($results2->getRows()); // صفحات بازدید شده

//-------------------------------------------------------------------------------
$optParams = array('dimensions' => 'rt:userType');
try {
  $results1 = $analytics->data_realtime->get(
    'ga:'.$profile,
    'rt:activeUsers',
    $optParams);
  // Success. 
} catch (apiServiceException $e) {
  // Handle API service exceptions.
  $error = $e->getMessage();
}
//pr($results1); // کاربران فعال//active//return
?>
<div class="row">


<div class="col-lg-8 col-md-6 col-12">
  <div class="card card-statistics">
    <div class="card-header">
        <h4 class="card-title"><?= __d('Seo','آمار لحظه ای')?></h4>
        <div class="d-flex align-items-center">
            <p class="card-text font-small-2 mr-25 mb-0">Google Analytics</p>
        </div>
    </div>
    <div class="card-body statistics-body" style="padding-top: 0 !important;">

        <div class="row">
            <div class="col-xl-4 col-sm-6 col-12 mb-2 mb-xl-0">
              <div class="media">
                <div class="avatar bg-light-info mr-2">
                  <div class="avatar-content">
                    <i data-feather="user" class="avatar-icon"></i>
                  </div>
                </div>
                <div class="media-body my-auto">
                  <h4 class="font-weight-bolder mb-0">
                    <?php 
                    $tmp = $results1->getTotalsForAllResults();
                    if(isset($tmp['rt:activeUsers']))
                      echo $tmp['rt:activeUsers'];
                    else echo '-' ?>
                  </h4>
                  <p class="card-text font-small-3 mb-0"><?= __d('Seo','تعداد کاربر آنلاین')?></p>
                </div>
              </div>
            </div>
            
            <!-- --------------------------------------------------------->
            <div class="col-xl-4 col-sm-6 col-12 mb-2 mb-xl-0">
              <div class="media">
                <!-- <div class="avatar bg-light-primary rounded mr-1">
                  <div class="avatar-content">
                    <i data-feather="calendar" class="avatar-icon font-medium-3"></i>
                  </div>
                </div> -->
                <div class="media-body">
                  <h41 class="font-weight-bolder mb-0">
                  <?php 
                    if(($tmp = $results1->getRows())){
                      foreach($tmp as $tp){
                        if(isset($tp[0]) and $tp[0] == 'NEW')
                          echo '<span class="mb-1">'.__d('Seo','کاربر جدید').'  : '.$tp[1].'</span>';

                        if(isset($tp[0]) and $tp[0] == 'RETURN')
                          echo ' / <span class="mb-1">'.__d('Seo','کاربر مجدد') .': '.$tp[1].'</span>';
                      }
                    } else echo '-';?>
                  </h41> 
                  <p class="card-text font-small-3 mb-0"><?= __d('Seo','بازدید کنندگان')?></p>                 
                </div>
              </div>
            </div>

            <!-- --------------------------------------------------------->
            <div class="col-xl-4 col-sm-6 col-12 mb-2 mb-sm-0">
              <div class="media">
                <!-- <div class="avatar bg-light-danger mr-2">
                  <div class="avatar-content">
                    <i data-feather="box" class="avatar-icon"></i>
                  </div>
                </div> -->
                <div class="media-body my-auto">
                    <h4 class="font-weight-bolder mb-0">
                      <?php 
                      if(($tmp = $results3->getTotalsForAllResults())){
                        echo isset($tmp['rt:pageviews'])?$tmp['rt:pageviews']:'-';
                      }?>
                    </h4>
                    <p class="card-text font-small-3 mb-0"><?= __d('Seo','تعداد بازدید کاربران آنلاین')?></p>
                </div>
              </div>
            </div>
            <!-- --------------------------------------------------------->
        </div>
    </div>
  <?php
  $analytics2 = initializeAnalytics1($options);

  function getReport($analytics,$view_id=null,$start='today' , $end='today') {

    // Replace with your view ID, for example XXXX.
    //$VIEW_ID = '228229264';
	$VIEW_ID = null
	if(isset($options['ga_viewid']) and $options['ga_viewid'] != '')
    	$VIEW_ID = $view_id;

    // Create the DateRange object.
    $dateRange = new Google_Service_AnalyticsReporting_DateRange();
    /* $dateRange->setStartDate("10daysAgo");
    $dateRange->setEndDate("today"); */
    $dateRange->setStartDate($start);
    $dateRange->setEndDate($end);


    // Create the Metrics object.
    $sessions = new Google_Service_AnalyticsReporting_Metric();
    $sessions->setExpression("ga:sessions");
    $sessions->setAlias("sessions");

    // Create the ReportRequest object.
    $request = new Google_Service_AnalyticsReporting_ReportRequest();
    $request->setViewId($VIEW_ID);
    $request->setDateRanges($dateRange);
    $request->setMetrics(array($sessions));

    $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
    $body->setReportRequests( array( $request) );
    return $analytics->reports->batchGet( $body );
  }

  function initializeAnalytics($options = null){
	if(isset($options['ga_key_json']))
    	$KEY_FILE_LOCATION = $options['ga_key_json'];
	//$KEY_FILE_LOCATION = __DIR__ . '/../../../vendor/ace-tranquility-340822-5ac7cd56e1a7.json';
    $client = new Google_Client();
    $client->setApplicationName("testservice");
    $client->setAuthConfig($KEY_FILE_LOCATION);
    $client->setScopes(['https://www.googleapis.com/auth/analytics.readonly']);
    $analytics = new Google_Service_Analytics($client);
    return $analytics;
  }

  function initializeAnalytics1($options = null){
	if(isset($options['ga_key_json']))
		$KEY_FILE_LOCATION = $options['ga_key_json'];
    //$KEY_FILE_LOCATION = __DIR__ . '/../../../vendor/ace-tranquility-340822-5ac7cd56e1a7.json';
    // Create and configure a new client object.
    $client = new Google_Client();
    $client->setApplicationName("testservice");
    $client->setAuthConfig($KEY_FILE_LOCATION);
    $client->setScopes(['https://www.googleapis.com/auth/analytics.readonly']);
    $analytics = new Google_Service_AnalyticsReporting($client);
    return $analytics;
  }

  function getFirstProfileId($analytics) {
    $accounts = $analytics->management_accounts->listManagementAccounts();
    if (count($accounts->getItems()) > 0) {
      $items = $accounts->getItems();
      $firstAccountId = $items[0]->getId();
      $properties = $analytics->management_webproperties->listManagementWebproperties($firstAccountId);

      if (count($properties->getItems()) > 0) {
        $items = $properties->getItems();
        $firstPropertyId = $items[0]->getId();

        $profiles = $analytics->management_profiles->listManagementProfiles($firstAccountId, $firstPropertyId);
        if (count($profiles->getItems()) > 0) {
          $items = $profiles->getItems();
          return $items[0]->getId();
        } else {
          throw new Exception('No views (profiles) found for this user.');
        }
      } else {
        throw new Exception('No properties found for this user.');
      }
    } else {
      throw new Exception('No accounts found for this user.');
    }
  }

  function printResults($reports) {
    return isset($reports['reports'][0]['data']['totals'][0]['values'][0])?
      $reports['reports'][0]['data']['totals'][0]['values'][0]:
      '-';
  }
  ?>

    <div class="card-header">
        <h4 class="card-title"><?= __d('Seo','آمار بازدید سایت')?></h4>
        <div class="d-flex align-items-center">
            <p class="card-text font-small-2 mr-25 mb-0"></p>
        </div>
    </div>
    <div class="card-body statistics-body" style="padding-top: 0 !important;">

        <div class="row">
            <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-0">
              <div class="media">
                <div class="avatar bg-light-info mr-2">
                  <div class="avatar-content">
                    <i data-feather="user" class="avatar-icon"></i>
                  </div>
                </div>
                <div class="media-body my-auto">
                  <h4 class="font-weight-bolder mb-0">
                    <?php 
                    $response = getReport($analytics2);
                    echo printResults($response);
                    ?>
                  </h4>
                  <p class="card-text font-small-3 mb-0"><?= __d('Seo','بازدید امروز')?></p>
                </div>
              </div>
            </div>
            
            <!-- --------------------------------------------------------->
            <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-0">
              <div class="media">
                <div class="avatar bg-light-primary rounded mr-1">
                  <div class="avatar-content">
                    <i data-feather="calendar" class="avatar-icon font-medium-3"></i>
                  </div>
                </div>
                <div class="media-body my-auto">
                  <h4 class="font-weight-bolder mb-0">
                    <?php 
                    $response = getReport($analytics2,'7daysAgo','today');
                    echo printResults($response);
                    ?>
                  </h4>
                  <p class="card-text font-small-3 mb-0"><?= __d('Seo','هفت روز اخیر')?></p>
                </div>
              </div>
            </div>

            <!-- --------------------------------------------------------->
            <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-sm-0">
              <div class="media">
                <div class="avatar bg-light-danger mr-2">
                  <div class="avatar-content">
                    <i data-feather="box" class="avatar-icon"></i>
                  </div>
                </div>
                <div class="media-body my-auto">
                    <h4 class="font-weight-bolder mb-0">
                    <?php
                    $response = getReport($analytics2,date('Y-m-01'),'today');
                    echo printResults($response);
                    ?>
                    </h4>
                    <p class="card-text font-small-3 mb-0"><?= __d('Seo','ماه جاری')?></p>
                </div>
              </div>
            </div>

            <!-- --------------------------------------------------------->
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="media">
                    <div class="avatar bg-light-success mr-2">
                        <div class="avatar-content">
                            <i data-feather="dollar-sign" class="avatar-icon"></i>
                        </div>
                    </div>
                    <div class="media-body my-auto">
                        <h4 class="font-weight-bolder mb-0">
                        <?php
                        $now = new Time(date('Y-m-01'));
                        $now->modify('-1 months');
                        $response = getReport($analytics2,$now->format('Y-m-d'),date('Y-m-01'));
                        echo printResults($response);
                        ?>
                        </h4>
                        <p class="card-text font-small-3 mb-0"><?= __d('Seo','ماه گذشته')?></p>
                    </div>
                </div>
            </div>
            <!-- --------------------------------------------------------->

        </div>
    </div>
  </div>
</div>

<div class="col-lg-4 col-md-6 col-12">
  <div class="card card-developer-meetup">
      <div class="card-body">
          <div class="meetup-header d-flex align-items-center">
              
              <div class="my-auto">
                  <h4 class="card-title mb-25"><?= __d('Seo','صفحات درحال بازدید')?></h4>
                  <p class="card-text mb-0"></p>
              </div>
          </div>

          <?php if($results2->getRows()):$i=0;foreach($results2->getRows() as $res):if($i<4): $i++;?>
          <div class="media">
            <div class="avatar bg-light-primary rounded mr-1">
                <div class="avatar-content">
                  <i data-feather="trending-up" class="avatar-icon"></i>
                </div>
            </div>

            <div class="media-body">
                <h6 class="mb-0"><?= Router::url($res[0],false)?></h6>
                <small><?=$res[1]?> <?= __d('Seo','بازدید')?></small>
            </div>
          </div>
          <?php endif;endforeach;endif;?>
          
          
      </div>
  </div>
</div>
<!--/ Developer Meetup Card -->
</div>