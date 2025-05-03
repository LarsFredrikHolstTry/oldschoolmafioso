<?php

function showBBcodes($text) {
	// BBcode array
	$find = array(
		'~\[center\](.*?)\[/center\]~s',
		'~\[b\](.*?)\[/b\]~s',
		'~\[i\](.*?)\[/i\]~s',
		'~\[u\](.*?)\[/u\]~s',
		'~\[quote\](.*?)\[/quote\]~s',
		'~\[size=(.*?)\](.*?)\[/size\]~s',
		'~\[color=(.*?)\](.*?)\[/color\]~s',
		'~\[url=((?:ftp|https?)://.*?)\](.*?)\[/url\]~s',
		'~\[img\](https?://.*?\.(?:jpg|jpeg|gif|png|bmp))\[/img\]~s',
        '~\[size1\](.*?)\[/size\]~s',
        '~\[size2\](.*?)\[/size\]~s',
        '~\[quote=(.*?)\](.*?)\[/quote\]~s'

	);
	// HTML tags to replace BBcode
	$replace = array(
		'<center>$1</center>',
		'<b>$1</b>',
		'<i>$1</i>',
		'<span style="text-decoration:underline;">$1</span>',
		'<pre>$1</'.'pre>',
		'<span style="font-size:$1px;">$2</span>',
		'<span style="color:$1;">$2</span>',
		'<a href="$1" target="_blank" style="text-decoration: none; color: white;">$2</a>',
		'<img style="max-width: 100%; height: auto;" src="$1" alt="" />',
        '<span style="font-size: 9px">$1</span>',
        '<span style="font-size: 11px">$1</span>',
        '<div class="quote pad_10 mar_5" style="margin-bottom: 10px">
            <span style="color:#5e5e5e">Sitat av $1:</span><br><br>
            <span>"$2"</span>
        </div>'

	);
	// Replacing the BBcodes with corresponding HTML tags
	return preg_replace($find,$replace,$text);
}

?>