<!-- support editor var.200114 -->
<div class="editor">
	<input type="checkbox" id="auto_save"><label for="auto_save"></label>
	<p>Auto save is off.</p>
	<button id="auto_save_save">Save</button>
</div>
<script>
$(function() {
	setInterval(function() { saveText(true); }, 1000 * 60);
	setEditor(editor);
	if (typeof editor2 !== "undefined") setEditor(editor2);
	if (typeof editor3 !== "undefined") setEditor(editor3);
	$(".editor button#auto_save_save").on("click", function() {
		if (!isLocked()) return false;
		saveText(false); return false;
	});
	$(".editor input[type='checkbox']").on("change", function() {
		if (!isLocked()) return false;
		var s = ($(".editor input[type='checkbox']").prop("checked")) ? "on." : "off.";
		$(".editor p").html("Auto save is " + s );
	});
});
function saveText(autosave) {
	if (autosave && (!$(".editor").prev().data("changed") != "" || !$(".editor input[type='checkbox']").prop("checked"))) return;
	var data = {};
	data.ROWID = $(".editor").prev().data("rowid");
	data.field = $(".editor").prev().data("field");
	if ($(".editor").prev().data("type") == "page") {
		$("textarea[name=content]").val(editor.getValue());
		data.content = $("textarea[name=content]").val();
		$("textarea[name=style]").val(editor2.getValue());
		data.style = $("textarea[name=style]").val();
		$("textarea[name=script]").val(editor3.getValue());
		data.script = $("textarea[name=script]").val();
	} else {
		$(".editor").prev().val(editor.getValue());
		data.content = $(".editor").prev().val();
	}
	data.action = "autoSave";

	$.post("support_editor.html", data, function(res) {
		$(".editor").prev().data("changed", "");
		if (res.indexOf("SUCCEED:") > -1) $(".editor p").html(res.replace("SUCCEED:", ""));
		else alert(res);
	}, "html");
}
function setEditor(editor) {
	editor.getSession().on("change", function() { $(".editor").prev().data("changed", "changed"); });
	editor.commands.addCommand({
		name: "save",
		bindKey: { win: "Ctrl-S", mac: "Command-S" },
		exec: function() {
			saveText(false);
		}
	});
	editor.commands.addCommand({
		name: "selectall",
		bindKey: { win: "Ctrl-A", mac: "Command-A" },
		exec: function() {}
	});
	editor.commands.addCommand({
		name: "lib-gotolinestart",
		bindKey: { win: "Ctrl-A", mac: "Command-A" },
		exec: function() {
			editor.execCommand("gotolinestart");
		}
	});
	editor.commands.addCommand({
		name: "lib-gotolineend",
		bindKey: { win: "Ctrl-E", mac: "Command-E" },
		exec: function() {
			editor.execCommand("gotolineend");
		}
	});
	editor.commands.addCommand({
		name: "gotomatchingbracket",
		bindKey: { win: "Ctrl-P" },
		exec: function() {}
	});
	editor.commands.addCommand({
		name: "lib-golineup",
		bindKey: { win: "Ctrl-P", mac: "Command-P" },
		exec: function() {
			editor.execCommand("golineup");
		}
	});
	editor.commands.addCommand({
		name: "lib-golinedown",
		bindKey: { win: "Ctrl-N", mac: "Command-N" },
		exec: function() {
			editor.execCommand("golinedown");
		}
	});
	editor.commands.addCommand({
		name: "lib-gotoleft",
		bindKey: { win: "Ctrl-B", mac: "Command-B" },
		exec: function() {
			editor.execCommand("gotoleft");
		}
	});
	editor.commands.addCommand({
		name: "removeline",
		bindKey: { win: "Ctrl-D", mac: "Command-D" },
		exec: function() {}
	});
	editor.commands.addCommand({
		name: "lib-removewordright",
		bindKey: { win: "Ctrl-D", mac: "Command-D" },
		exec: function() {
			editor.execCommand("removewordright");
		}
	});
}
</script>
<style>
section form dl.textarea dd {
	position: relative;
}
</style>
<!-- support editor -->