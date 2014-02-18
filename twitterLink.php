<?php

function linkify_twitter_status($status_text)
{
  // linkify URLs
  $status_text = preg_replace(
    '/(https?:\/\/\S+)/',
    '<a class="twitterpost" href="\1">\1</a>',
    $status_text
  );

  // linkify twitter users
  $status_text = preg_replace(
    '/(^|\s)@(\w+)/',
    '\1<a class="twitterpost" href="http://twitter.com/\2">@\2</a>',
    $status_text
  );

  // linkify tags
  $status_text = preg_replace(
    '/(^|\s)#(\w+)/',
    '\1<a class="twitterpost" href="http://search.twitter.com/search?q=%23\2">#\2</a>',
    $status_text
  );

  return $status_text;
}

?>
