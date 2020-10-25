<?php
/**
 * LIB PHP Framework Updater
 *
 * @charset   UTF-8N
 * @package   LIB
 * @copyright Copyright (c) 2019 Barman Soft, Inc.
 * @license   https://libframework.org/license.html The Clear BSD License
 * @version   LIB PHP Framework 3.2.191206
 */
ini_set("error_reporting", E_ALL & ~E_WARNING & ~E_NOTICE & ~E_DEPRECATED & ~E_USER_DEPRECATED);
ini_set("mbstring.http_input", "auto");
ini_set("mbstring.http_output", "UTF-8");
ini_set("mbstring.internal_encoding", "UTF-8");
session_cache_limiter("nocache");
session_start();

define("DEPLOY", "https://libframework.org/deploy/request/");
function exception_error_handler($severity, $message, $file, $line) {
	if (!(error_reporting() & $severity)) return;
	throw new ErrorException($message, 0, $severity, $file, $line);
}
set_error_handler("exception_error_handler");

class Filter {
	/**
	 * note: 正規表現用エンコーディングが適切でないと正常に動作しない（ini_set()によるmbstring.internal_encoding指定で設定される）
	 * var_dump(mb_regex_encoding());
	 */
	public static function trimSpace($s, $all = false, $exp = "[ 　\t\r\n\0]") {
		if ($all) return mb_ereg_replace($exp, "", $s);
		else return mb_ereg_replace("^{$exp}+|{$exp}+$", "", $s);
	}
	public static function get($s = null, $max = 100, $exp = null, $conv = null, $default = null) {
		if (is_null($s)) return "";
		$exp = ($exp !== null) ? $exp : "[<>&$,'\"]";

		$s = Filter::trimSpace(mb_substr($s, 0, $max));
		$s = str_replace(array("\r\n", "\r"), "\n", $s);
		if ($conv) $s = mb_convert_kana($s, $conv);

		if ($exp!=="") {
			$s = str_replace("\\", "", $s);
			$s = mb_ereg_replace($exp, "", $s);
		}
		if ($default !== null && $s==="") {
			$s = $default;
		}
		return $s;
	}
	public static function isMail(string $string) {
		$exp = "/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/";
		return (preg_match($exp, $string));
	}
	public static function setValue($dest, $stor, $values) {
		$s = file_get_contents($dest);
		foreach ($values as $k => $v) {
			if (!$v) return false;
			$s = str_replace($k, $v, $s);
		}
		file_put_contents($stor, $s);
		return true;
	}
}
class Page {
	var $message;
	var $path;
	var $text;
	/**
	 * Constructor
	 */
	public function __construct() {
		// note: Initialize the property.
		$this->path = __DIR__. "/libframework.zip";
		if (isset($_GET["ja"])) {
			$this->text["C01"] = "インストールを開始しました。しばらくお待ちください・・・";
			$this->text["M01"] = "インストールは成功しました。";
			$this->text["E01"] = "インストールパッケージが不明です。";
			$this->text["E02"] = "インストールファイルが開けません。";
		} else {
			$this->text["C01"] = "Installation has started. Please wait···";
			$this->text["M01"] = "Installation was successful.";
			$this->text["E01"] = "Installation package is unknown.";
			$this->text["E02"] = "Can not open the installation file.";
		}
		// note: Setup event
		if ($_POST["action"] == "update") {
			$data["package"] = Filter::get($_POST["package"], 100, "[^0-9a-zA-Z_]");
			if (!$data["package"]) $this->response($this->text["E01"], false);
			if (!$this->update($data)) $this->response($this->message, false);
			else $this->response($this->text["M01"], true);
		}
	}
	/**
	 * Return JSON data to the browser.
	 */
	public function response($response, $succeed) {
		if (is_array($response)) {
			$response["status"] = ($succeed) ? "SUCCEED" : "FAILURE";
			echo json_encode($response);
			exit();
		} else {
			$array["status"] = ($succeed) ? "SUCCEED" : "FAILURE";
			$array["text"] = $response;
			echo json_encode($array);
			exit();
		}
	}
	/**
	 * Download the package.
	 */
	function download($package) {
		$data["function"] = "download";
		$data["package"] = "{$package}_update";
		$tmp = tmpfile();
		try {
			$ch = curl_init(DEPLOY);
			curl_setopt($ch, CURLOPT_FAILONERROR, true);
			curl_setopt($ch, CURLOPT_FILE, $tmp);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			curl_setopt($ch, CURLOPT_USERPWD, "DEPLOY:y8SjK61mNHgA");
			
			if (!curl_exec($ch)) throw new Exception(curl_error($ch));
			$file = stream_get_meta_data($tmp);
			
			$finfo = new finfo(FILEINFO_MIME_TYPE);
			if ($finfo->file($file["uri"]) == "text/plain") throw new Exception(file_get_contents($file["uri"]));
			
			rename($file["uri"], $this->path);
			return true;
		} catch (Exception $ex) {
			$this->message = $ex->getMessage();
			return false;
		} finally {
			if ($ch) curl_close($ch);
		}
	}
	/**
	 * Extract the downloaded file.
	 */
	function update($data) {
		if (!$this->download($data["package"])) return false;
		try {
			$zip = new ZipArchive();
			if (!$zip->open($this->path)) throw new Exception($this->text["E02"]);
			$zip->extractTo(__DIR__);
			$zip->close();

			return true;
		} catch (Exception $ex) {
			$this->message = $ex->getMessage();
			return false;
		}
	}
}
$page = new Page();
?><!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="application-name" content="LIB PHP Framework">
		<meta name="copyright" content="Copyright &copy; 2019 Barman Soft, In. All Rights Reserved.">
		<title>LIB PHP Framework Updater</title>
		<link href="https://libframework.org/deploy/css/common.css" rel="stylesheet" type="text/css" media="all">
		<script type="text/javascript" src="https://libframework.org/deploy/js/jquery-1.12.0.min.js"></script>
		<link rel="icon" href="https://libframework.org/deploy/favicon.ico">
		<script>
		$(function() {
			$.ajaxSetup({
				error: function(xhr, status) {
					console.log(xhr.responseText);
					alert("$.ajax error: " + status);
					location.reload();
				}
			});
			var data = {};
			data.package = "<?= $_POST["package"] ?>";
			data.action = "update";
			$.post(location.href, data, function(res) {
				setTimeout(function() {
					if (res.status == "SUCCEED") {
						alert("<?= $page->text["M01"] ?>");
						location.href = "Lib/index.html?update";
					} else {
						alert(res.text);
						$("form#progress").hide();
						$("form#back p").html(res.text);
						$("form#back").show();
					}
				}, 500);
			}, "json");
			$("form#back button").on("click", function() {
				location.href = "Lib";
				return false;
			});
		});
		</script>
	</head>

	<body>
		<div>
			<header>
				<h1>Installation</h1>
			</header>
			<section>
				<form id="back" style="display:none">
					<div>
						<p></p>
					</div>
					<div>
						<button>Back</button>
					</div>
				</form>
				<form id="progress">
					<div>
						<p><?= $page->text["C01"] ?></p>
					</div>
					<div>
						<img src="https://libframework.org/deploy/image/load.gif">
					</div>
				</form>
			</section>
		</div>
	</body>
</html>