<?php
include('vendor/autoload.php');
$config = require_once('config.php');
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

        <?php $generator = new CodeGenerator(); ?>
        <?php echo $generator->generateHtml(Request::getCurrentRequest(), $config['modules']); ?>
    </div>

    <script>
        $('.nav-tabs a').click(function (e) {
            e.preventDefault();
            $(this).tab('show');
        });

        $('.nav-tabs a[href="#class"]').tab('show');
        SyntaxHighlighter.all();
    </script>
	</body>
</html>
