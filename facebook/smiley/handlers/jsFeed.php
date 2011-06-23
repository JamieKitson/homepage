<?php
  /*
   * jsFeed.php - Setting status from js
   *
   */
require_once '../constants.php';
require_once LIB_PATH.'moods.php';
$fb     = get_fb();

// The smiley that was chosen
$picked = $_POST['picked'];
$old = $fb->api_client->data_getUserPreference(0);
$fb->api_client->data_setUserPreference(0, '' . $picked . $old);

