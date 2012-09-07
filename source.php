<?php
// $Id$
$_SERVER['BASE_PAGE'] = 'source.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/include/prepend.inc';
$SIDEBAR_DATA = '
<h3>Our source is open</h3>
<p>
 The syntax highlighted source is automatically generated by PHP from
 the plaintext script.
 If you\'re interested in what\'s behind the several functions we
 used, you can always take a look at the source of the following files:
</p>

<ul class="toc">
 <li><a href="/source.php?url=/include/prepend.inc">prepend.inc</a></li>
 <li><a href="/source.php?url=/include/site.inc">site.inc</a></li>
 <li><a href="/source.php?url=/include/mirrors.inc">mirrors.inc</a></li>
 <li><a href="/source.php?url=/include/countries.inc">countries.inc</a></li>
 <li><a href="/source.php?url=/include/languages.inc">languages.inc</a></li>
 <li><a href="/source.php?url=/include/langchooser.inc">langchooser.inc</a></li>
 <li><a href="/source.php?url=/include/ip-to-country.inc">ip-to-country.inc</a></li>
 <li><a href="/source.php?url=/include/layout.inc">layout.inc</a></li>
 <li><a href="/source.php?url=/include/last_updated.inc">last_updated.inc</a></li>
 <li><a href="/source.php?url=/include/shared-manual.inc">shared-manual.inc</a></li>
 <li><a href="/source.php?url=/include/manual-lookup.inc">manual-lookup.inc</a></li>
</ul>

<p>
 Of course, if you want to see the <a href="/source.php?url=/source.php">source
 of this page</a>, we have it available.
 You can also browse the Git repository for this website on
 <a href="http://git.php.net/?p=web/php.git;a=summary">git.php.net</a>.
</p>
';
site_header("Show Source", array("current" => "community"));

// No file param specified
if (!isset($_GET['url']) || (isset($_GET['url']) && !is_string($_GET['url']))) {
    echo "<h1>No page URL specified</h1>";
    site_footer();
    exit;
}

echo "<h1>Source of: " . htmlentities($_GET['url'], ENT_IGNORE, 'UTF-8') . "</h1>"; 

// Get dirname of the specified URL part
$dir = dirname($_GET['url']);

// Some dir was present in the filename
if (!empty($dir) && !preg_match("!^(\\.|/)$!", $dir)) {

    // Check if the specified dir is valid
    $legal_dirs = array("/manual", "/include", "/stats", "/error", "/license", "/conferences", "/archive", "/releases", "/security", "/reST");
    if ((preg_match("!^/manual/!", $dir) || in_array($dir, $legal_dirs)) &&
        strpos($dir, "..") === FALSE) {
        $page_name = $_SERVER['DOCUMENT_ROOT'] . $_GET['url'];
    } else { $page_name = FALSE; }

} else {
    $page_name = $_SERVER['DOCUMENT_ROOT'] . '/' . basename($_GET['url']);
}

// Provide some feedback based on the file found
if (!$page_name || @is_dir($page_name)) {
    echo "<p>Invalid file or folder specified</p>\n";
} elseif (file_exists($page_name)) {
    highlight_php(join("", file($page_name)));
} else {
    echo "<p>This file does not exist.</p>\n";
}

site_footer();
