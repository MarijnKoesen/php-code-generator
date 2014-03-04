<?php
require_once('vendor/autoload.php');
$config = require_once('config.php');
if (file_exists('config.local.php')) {
    $userConfig = require_once('config.local.php');
    $config['modules'] = array_merge($config['modules'], $userConfig['modules']);
}
?>

<html>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="libs/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="libs/bootstrap/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="libs/syntaxhighlighter_3.0.83/styles/shCoreDefault.css"/>
    <link rel="stylesheet" href="libs/syntaxhighlighter_3.0.83/styles/shThemeGithub.css"/>
    <link rel="stylesheet" href="css/style.css">

    <script src="libs/jquery/jquery.min.js"></script>
	<script src="libs/bootstrap/js/bootstrap.min.js"></script>

    <script type="text/javascript" src="libs/syntaxhighlighter_3.0.83/scripts/shCore.js"></script>
    <script type="text/javascript" src="libs/syntaxhighlighter_3.0.83/scripts/shBrushPhp.js"></script>

	<body>

    <div id="main">
        <h1>CodeGenerator</h1>

        <?php $generator = new codegenerator\CodeGenerator(); ?>
        <?php echo $generator->generateHtml(codegenerator\Request::getCurrentRequest(), $config['modules']); ?>
    </div>

    <script>
        $('.nav-tabs a').click(function (e) {
            e.preventDefault();
            $(this).tab('show');
        });

        var activeTab = 'Input';
        if (window.location.href.match(/#/)) {
            activeTab = window.location.href.replace(/.*#/, '');
        }
        $('.nav-tabs a[href="#' + activeTab + '"]').tab('show');
        SyntaxHighlighter.all();
    </script>
	</body>
</html>
