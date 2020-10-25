<?php
/**
 * LIB PHP Framework Installer
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
		else {
			$s = mb_ereg_replace("^{$exp}+|{$exp}+$", "", $s);
			return mb_ereg_replace("^{$exp}+|{$exp}+$", "", $s);
		}
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
			$this->text["C01"] = "メールアドレスを入力してください。";
			$this->text["C02"] = "メールアドレスを確認しています。しばらくお待ちください・・・";
			$this->text["C03"] = "<span></span>さんこんにちわ。 初期設定に必要な情報を入力してください。<br>この情報が外部のサーバーに送信されることはありません。";
			$this->text["C04"] = "インストールを開始しました。しばらくお待ちください・・・";
			$this->text["M01"] = "メールアドレスを入力してください。";
			$this->text["M02"] = "インストールは成功しました。";
			$this->text["E01"] = "入力内容を確認してください。";
			$this->text["E02"] = "インストールファイルが開けません。";
		} else {
			$this->text["C01"] = "Please enter your e-mail address.";
			$this->text["C02"] = "Now verifying your registration. Please wait···";
			$this->text["C03"] = "Hi <span></span>. Please enter the necessary information for initial setup.<br>This information is never sent to an external server.";
			$this->text["C04"] = "Installation has started. Please wait···";
			$this->text["M01"] = "Please enter your e-mail address.";
			$this->text["M02"] = "Installation was successful.";
			$this->text["E01"] = "Please check your entries.";
			$this->text["E02"] = "Can not open the installation file.";
		}
		// note: Authentication event
		if ($_POST["action"] == "auth") {
			$data = array();
			$data["email"] = Filter::get($_POST["email"], 100, "[^0-9a-zA-Z\-_.@]", "a");
			if (!$data["email"] || !Filter::isMail($data["email"])) $this->response($this->text["E01"], false);

			$this->auth($data, $res) or $this->response($this->message, false);
			die($res);
		}
		// note: Setup event
		if ($_POST["action"] == "setup") {
			$data = array();
			$data["domain"] = Filter::get($_POST["domain"], 100, "[^0-9a-zA-Z\-_.]", "a");
			$data["ssl_url"] = Filter::get($_POST["ssl_url"], 100, "[^0-9a-zA-Z/\-_.:]", "a");
			$data["db_host"] = Filter::get($_POST["db_host"], 100, "[^0-9a-zA-Z\-_.]", "a");
			$data["db_name"] = Filter::get($_POST["db_name"], 100);
			$data["db_user"] = Filter::get($_POST["db_user"], 100);
			$data["db_pass"] = Filter::get($_POST["db_pass"], 100);
			$data["basic_user"] = Filter::get($_POST["basic_user"], 20);
			$data["basic_pass"] = Filter::get($_POST["basic_pass"], 20);
			$data["package"] = Filter::get($_POST["package"], 100, "[^0-9a-zA-Z_]");
			$data["email"] = Filter::get($_POST["email"], 100, "[^0-9a-zA-Z\-_.@]", "a");
			foreach ($data as $k => $v) { if (!$v) $this->response($this->text["E01"], false); }

			$this->setup($data, $res) or $this->response($this->message, false);
			die($res);
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
	 * Inquires for information about registration on the Deploy server.
	 */
	function auth($data, &$res) {
		$data["function"] = "getUser";
		$data["package"] = "basepack";
		try {
			$ch = curl_init(DEPLOY);
			curl_setopt($ch, CURLOPT_FAILONERROR, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			curl_setopt($ch, CURLOPT_USERPWD, "DEPLOY:y8SjK61mNHgA");
			$res = curl_exec($ch);
			
			if (!$res) throw new Exception(curl_error($ch));
			return true;
		} catch(Exception $ex) {
			$this->message = $ex->getMessage();
			return false;
		} finally {
			if ($ch) curl_close($ch);
		}
	}
	/**
	 * Download the package.
	 */
	function download($package) {
		$data["function"] = "download";
		$data["package"] = $package;
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
	 * Extract the downloaded file and set the connection information.
	 */
	function setup($data, &$res) {
		if (!$this->download($data["package"])) return false;
		try {
			$zip = new ZipArchive();
			if (!$zip->open($this->path)) throw new Exception($this->text["E02"]);
			$zip->extractTo(__DIR__);
			$zip->close();

			// note: Set Basic Authenticationn
			$val = array();
			$val["{#dir}"] = __DIR__. "/Lib";
			Filter::setValue("Lib/.htaccess", "Lib/.htaccess", $val);
			$val = array();
			$val["{#user}"] = $data["basic_user"];
			$val["{#passwd}"] = password_hash($data["basic_pass"], PASSWORD_BCRYPT);
			Filter::setValue("Lib/.htpasswd", "Lib/.htpasswd", $val);

			// note: Save configuration
			$val = array();
			$val["{#domain}"] = $data["domain"];
			$val["{#ssl_url}"] = rtrim($data["ssl_url"], "/");
			$val["{#db_host}"] = $data["db_host"];
			$val["{#db_name}"] = $data["db_name"];
			$val["{#db_user}"] = $data["db_user"];
			$val["{#db_pass}"] = $data["db_pass"];
			$val["{#lang}"] = (isset($_GET["ja"])) ? "ja" : "en";
			$val["{#email}"] = $data["email"];
			$val["{#package}"] = $data["package"];
			Filter::setValue("Lib/Conf.inc", "Lib/Conf.inc", $val);

			// note: Check connection
			$ch = curl_init("{$data["ssl_url"]}/Lib/login.html?connect");
			curl_setopt($ch, CURLOPT_FAILONERROR, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_USERPWD, "{$data["basic_user"]}:{$data["basic_pass"]}");
			$res = curl_exec($ch);

			if (!$res) throw new Exception(curl_error($ch));
			return true;
		} catch (Exception $ex) {
			$this->message = $ex->getMessage();
			return false;
		} finally {
			if ($ch) curl_close($ch);
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
		<title>LIB PHP Framework Installer</title>
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
			$("form#auth button").on("click", function() {
				$(this).prop("disabled", true);
				$(this).closest("form").hide();
				$("form#progress").show("fast");

				var $button = $(this);
				$.post(location.href, $.param({action:$(this).data("action")}) + "&" + $(this).closest("form").serialize(), function(res) {
					setTimeout(function() {
						$("form#progress").hide();
						if (res.status == "SUCCEED") {
							$("form#setup input[name=email]").val($("form#auth input[name=email]").val());
							$("form#setup input[name=package]").val(res.package);
							$("form#setup p span").html(res.name);
							$("form#setup").show("fast");
						} else {
							alert(res.text);
							$button.prop("disabled", false);
							$button.closest("form").show();
						}
					}, 500);
				}, "json");
				return false;
			});
			$("form#setup button").on("click", function() {
				$(this).prop("disabled", true);
				$(this).closest("form").hide();
				$("form#progress p").html("<?= $page->text["C04"] ?>");
				$("form#progress").show("fast");
				
				var $button = $(this);
				$.post(location.href, $.param({action:$(this).data("action")}) + "&" + $(this).closest("form").serialize(), function(res) {
					setTimeout(function() {
						$("form#progress").hide();
						if (res.status == "SUCCEED") {
							alert("<?= $page->text["M02"] ?>");
							location.href = "Lib/login.html";
						} else {
							alert(res.text);
							$button.prop("disabled", false);
							$button.closest("form").show();
						}
					}, 500);
				}, "json");
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
				<form id="auth" method="POST">
					<div>
						<p><?= $page->text["C01"] ?></p>
					</div>
					<div>
						<dl>
							<dt>E-mail</dt>
							<dd><input type="text" name="email" maxlength="100"></dd>
						</dl>
					</div>
					<div>
						<button data-action="auth">Start</button>
					</div>
				</form>
				<form id="progress" style="display:none">
					<div>
						<p><?= $page->text["C02"] ?></p>
					</div>
					<div>
						<img src="https://libframework.org/deploy/image/load.gif">
					</div>
				</form>
				<form id="setup" method="POST" style="display:none">
					<div>
						<p><?= $page->text["C03"] ?></p>
					</div>
					<div>
						<dl>
							<dt>Domain name</dt>
							<dd>
								<input type="text" name="domain" maxlength="100">
							</dd>
						</dl>
						<dl>
							<dt>SSL URL</dt>
							<dd>
								<input type="text" name="ssl_url" maxlength="100">
							</dd>
						</dl>
						<dl>
							<dt>MySQL host name</dt>
							<dd>
								<input type="text" name="db_host" maxlength="100">
							</dd>
						</dl>
						<dl>
							<dt>MySQL database name</dt>
							<dd>
								<input type="text" name="db_name" maxlength="100">
							</dd>
						</dl>
						<dl>
							<dt>MySQL user name</dt>
							<dd>
								<input type="text" name="db_user" maxlength="100">
							</dd>
						</dl>
						<dl>
							<dt>MySQL password</dt>
							<dd>
								<input type="text" name="db_pass" maxlength="100">
							</dd>
						</dl>
						<dl>
							<dt>Basic Authentication user name</dt>
							<dd>
								<input type="text" name="basic_user" maxlength="100">
							</dd>
						</dl>
						<dl>
							<dt>Basic Authentication password</dt>
							<dd>
								<input type="text" name="basic_pass" maxlength="100">
							</dd>
						</dl>
					</div>
					<div>
						<input type="hidden" name="email">
						<input type="hidden" name="package">
						<button data-action="setup">Setup</button>
					</div>
				</form>
			</section>
		</div>
	</body>
</html>