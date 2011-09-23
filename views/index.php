<?php

header('Content-Type: text/html; charset=UTF-8');

$prev = true;
$count = count($entries);
for ($num = 0; $num < $count; $num++) {
	if ($num === 0)
		continue;

	$current = $entries[$num];
	$previous = $entries[$num - 1];
	if ($previous->source === 'lastfm' && $current->source === 'lastfm') {
		if (strpos($previous->title, '<') !== false) {
			$previous->content = '<ul><li>' . substr($previous->title, 12) . '</li>';
			$previous->title = 'listened to 2 songs';
		}
		$previous->content .= '<li>' . substr($current->title, 12) . "</li>\n";
		$songs = (int) substr($previous->title, 12, strspn($previous->title, '0123456789', 12));
		$songs++;
		$previous->title = sprintf('listened to %u songs', $songs);

		unset($entries[$num]);
		$entries = array_values($entries);
		$count--;
		$num--;
	}
}

$entries = array_slice($entries, 0, 30);


?><!DOCTYPE html>
<html>
<head>
	<link href="static/style.css" rel="stylesheet" />
	<title>Ryan McCue</title>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
	<script src="script/script.js"></script>
</head>
<body>
	<div id="info">
		<p>Why, hello there. I'm&hellip;</p>
		<h1>Ryan McCue</h1>
		<p>These are some of the things I do on the internet. Take a look.</p>
		<ul>
			<li><a href="http://rotorised.com/">Work</a></li>
			<li><a href="http://github.com/rmccue">Code</a></li>
			<li><a href="http://last.fm/user/rmccue">Listen</a></li>
			<li><a href="http://journal.ryanmccue.info/">Write</a></li>
			<li><a href="http://twitter.com/rmccue">Tweet</a></li>
		</ul>

		<h3>Projects</h3>
		<ul>
			<li><a href="http://getlilina.org/">Lilina</a></li>
			<li><a href="http://simplepie.org/">SimplePie</a></li>
		</ul>

		<footer>
			<p>Want to get in contact with me? <script type="text/javascript">
					//<![CDATA[
					var x="function f(x){var i,o=\"\",l=x.length;for(i=0;i<l;i+=2) {if(i+1<l)o+=" +
					"x.charAt(i+1);try{o+=x.charAt(i);}catch(e){}}return o;}f(\"ufcnitnof x({)av" +
					" r,i=o\\\"\\\"o,=l.xelgnhtl,o=;lhwli(e.xhcraoCedtAl(1/)3=!55{)rt{y+xx=l;=+;" +
					"lc}tahce({)}}of(r=i-l;1>i0=i;--{)+ox=c.ahAr(t)i};erutnro s.buts(r,0lo;)f}\\" +
					"\"(8)\\\\,[\\\"eo~t;edv08=;7}3$#,-#82\\\\t-\\\\x*0g03\\\\\\\\$,)/21\\\\0[\\" +
					"\\_HWXYWDNQu0^01\\\\\\\\D^GCAL\\\\tv\\\\24\\\\0N\\\\TB4M00\\\\\\\\6B03\\\\\\"+
					"\\03\\\\00\\\\01\\\\\\\\rqhxhr6n{c|vnzmd\\\"\\\\f(;} ornture;}))++(y)^(iAtd" +
					"eCoarchx.e(odrChamCro.fngriSt+=;o27=1y%+;y+8)i<f({i+)i+l;i<0;i=r(foh;gten.l" +
					"=x,l\\\"\\\\\\\"\\\\o=i,r va){,y(x fontincfu)\\\"\")"                        ;
					while(x=eval(x));
					//]]>
				</script></p>
			<p>Styling based on <a href="https://github.com/chromakode/wake/">Wake</a>.</p>
			<p>Background from <a href="http://www.colourlovers.com/pattern/90096/waves_of_sorrow">ColourLovers</a>.</p>
		</footer>
	</div>
	<div id="content">
		<ul id="stream">
<?php
foreach ($entries as $entry) {
?>
			<li class="<?php echo $entry->source ?>">
				<span class="title"><?php echo $entry->title ?></span>
				<time><?php echo date('H:m:s', $entry->timestamp) ?></time>
<?php
	if (!empty($entry->content)) {
?>

				<div class="content">
					<?php echo $entry->content ?>
				</div>
<?php
	}
?>
			</li>
<?php
}
?>
		</ul>
	</div>
</body>
</html>