<?php
/**
 * 文字コード UTF-8N 改行コードLF
 * インクルードヘッダー
 *
 * @package    Lib
 * @copyright  Copyright (c) 2016-2020 Barman Soft, Inc.
 * @license    https://libframework.org/license.html The Clear BSD License
 * @version    Lib Framework v3.2.200419
 */
?>
<script>
$(function() {
	$("#user button").on("click", function() {
		location.href = "login.html?$$";
	});
	$("#menu").on("mouseenter", "a", function() {
		$(this).attr("href", $(this).attr("href").split('#')[0] + "#" + $("#menu").scrollTop());
	});
	var scrollMenu = function() {
		if (location.hash == "" || $("#menu").hasClass("scroll")) return;
		$("#menu").scrollTop(location.hash.split('#')[1]);
		$("#menu").addClass("scroll");
	};
	$("#menu .caption label").on("click", function() {
		var button = $(this);
		var target = $($(this).data("target"));
		if (target.css("display") == "block") {
			target.hide();
			button.removeClass("open").addClass("close");
			return;
		}
		$.post("index.html", { "action" : $(this).data("action") }, function(res) {
				if (res.status != "SUCCEED") { alert(res.text); return; }
				$("#menu ul").hide();
				$("#menu .caption label").removeClass("open").addClass("close");
				target.html(res.html);
				target.show();
				button.removeClass("close").addClass("open");
				scrollMenu();
			}, "json");
	});
});
</script>
<div id="user">
	<label>User&nbsp;<?= $_SESSION[DOMAIN]["Lib.user"]["user_name"] ?></label>
	<label>LoginTime&nbsp;<?= $_SESSION[DOMAIN]["Lib.user"]["time"] ?></label>
	<button>logout</button>
</div>
<div class="group">For Developers</div>
<div class="caption dev"><a href="user_list.html">Users</a><label data-target="#ul_user" data-action="load_user" class="close"></label></div>
<ul id="ul_user">
</ul>
<div class="caption"><a href="template_list.html">Templates</a><label data-target="#ul_temp" data-action="load_temp"  class="close"></label></div>
<ul id="ul_temp">
</ul>
<div class="caption"><a href="page_list.html">Pages</a><label data-target="#ul_page" data-action="load_page" class="close"></label></div>
<ul id="ul_page">
</ul>
<div class="caption"><a href="css_list.html">CSS Files</a><label data-target="#ul_css" data-action="load_css" class="close"></label></div>
<ul id="ul_css">
</ul>
<div class="caption"><a href="js_list.html">JS Files</a><label data-target="#ul_js" data-action="load_js" class="close"></label></div>
<ul id="ul_js">
</ul>
<div class="group mt">Image Folder</div>
<div class="caption"><a href="image.html?folder=common">common</a></div>
<?php if (method_exists("Lib\Fixed", "folder")) { foreach (Lib\Fixed::folder() as $k => $v) { ?>
<div class="caption"><a href="image.html?folder=<?= $v ?>"><?= $v ?></a></div>
<?php }} ?>
<div class="group mt">Contents Category</div>
<?php foreach (Lib\Fixed::category() as $k => $v) { ?>
<div class="caption"><a href="item_list.html?category=<?= $k ?>"><?= $v ?></a></div>
<?php } ?>
<div class="group mt">Management Tools</div>
<div class="caption"><a href="todo_list.html">Todo List</a></div>
<div class="caption"><a href="note_list.html">Release Notes</a></div>
<div class="group mt">Application Setting</div>
<div class="caption dev"><a href="fixed_list.html">Static Arrays</a></div>
<div class="caption"><a href="auth_basicdisplay.html">Auth Basic Display API</a></div>
