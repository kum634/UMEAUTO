<?php
/**
 * header.inc
 *
 * @charset    UTF-8N
 * @package    Lib
 * @copyright  Copyright (c) 2016-2020 Barman Soft, Inc.
 * @license    https://libframework.org/license.html The Clear BSD License
 * @version    Lib Framework v3.2.200419
 */
?>
<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=1280,initial-scale=1,minimum-scale=1,maximum-scale=10,user-scalable=yes">
		<title><?= $page->title ?><?= DOMAIN ?></title>
		<link href="<?= $page->path ?>Lib/css/common.css" rel="stylesheet" type="text/css" media="all">
		<link rel="icon" href="<?= $page->path ?>Lib/favicon.ico">
		<script type="text/javascript" src="<?= $page->path ?>Lib/js/jquery-1.12.0.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.3.3/ace.js"></script>
		<script>
		$.ajaxSetup({
			beforeSend: function() { $("img.load").show(); },
			complete: function() { $("img.load").hide(); },
			error: function(xhr) { console.log("xhr.responseText: " + xhr.responseText); alert("Ajax Error: " + xhr.statusText); }
		});
		function translate($region) {
			$(".lang", $region).each(function() { console.log($(this).html()); });
		}
		$(function() {
			$("header nav #config").on("click", function() { $("div.dialog").load("dialog/config.html"); $("div.dialog").show("fast"); });
			$("div.dialog").on("click", "header a", function() { $("div.dialog > div").hide("fast"); });
		});
		</script>
	</head>
	<body>
		<img class="load" style="display:none" src="<?= $page->path ?>Lib/image/common/load.gif">
		<div class="dialog" style="display:none"></div>
		<header>
			<div class="wrap clearfix">
				<nav>
					<ul>
						<li id="trace"><a href="<?= $page->path ?>Lib/Trace/index.html" target="_blank">Trace</a></li>
						<li id="session"><a href="<?= $page->path ?>Lib/Trace/cache.html" target="_blank">Cache</a></li>
						<?php	if (in_array($_SERVER["SCRIPT_NAME"], ["/Lib/event.html", "/Lib/event_edit.html", "/Lib/page.html"])) {	?>
						<li><a href="<?= $page->path ?>Lib/Trace/codeview.html?page=<?= ($_SERVER["SCRIPT_NAME"] == "/Lib/page.html") ? $_GET["ROWID"] : $_GET["page"] ?>" target="_blank">CodeView</a></li>
						<?php } ?>
						<li><a href="<?= $page->path ?>Lib/Trace/phpinfo.html" target="_blank">phpinfo</a></li>
						<li><a href="https://libframework.org/reference/" target="_blank">Reference</a></li>
						<li id="config">Config</li>
					</ul>
				</nav>
			</div>
		</header>