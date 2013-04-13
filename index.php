<?php 
	$html = '
    &lt;div id="scraped"&gt;
        &lt;figure&gt;
            &lt;img id="image" src="img/image.jpg"&gt;
        &lt;/figure&gt;
        &lt;div&gt;
            &lt;h4&gt;
                &lt;a id="title" href="javascript:void(0)"&gt;
                    Title will appear here...
                &lt;/a&gt;
            &lt;/h4&gt;
        &lt;p id="description"&gt;... and description here&lt;/p&gt;
    &lt;/div&gt;
	';
	
	$javascript = '
    &lt;script type="text/javascript" src="js/jquery.min.js"&gt;
    &lt;/script&gt;
    &lt;script type="text/javascript"&gt;
    $(function(){
        $(\'#submit\').click(function(){
            $.post(
                \'doscrape.php\',
                {\'url\' : $(\'#url\').val()},
                function(json) {
                    if (json.success) {
                        $(\'#title\').text(json.ogp.title);
                        $(\'#title\').attr(\'href\', json.ogp.url);
                        $(\'#description\').text(json.ogp.description);
                        $(\'#image\').attr(\'src\', json.ogp.image);
                        $(\'#dump\').text(json.dump);
                    } else {
                        alert(\'Something went wrong.\');
                        console.log(json.log);
                    }
                },
                \'json\'
            );
            return false;
        });
    });
    &lt;/script&gt;
	';
	
	$php = '
    &lt;?php 
        //doscrape.php
        require_once \'SimpleScraper.class.php\';
        $url = isset($_REQUEST[\'url\']) ? $_REQUEST[\'url\'] : \'\';
        try {
            $scraper = new SimpleScraper($url);
            $data = $scraper-&gt;getAllData();
            $response = array(
                \'success\' =&gt; true,
                \'ogp\' =&gt; $data[\'ogp\'],
                \'dump\' =&gt; print_r($data, true)
            );
        } catch (Exception $e) {
            $response = array(
                \'success\' =&gt; false,
                \'message\' =&gt; \'Something went wrong.\',
                \'log\' =&gt; "$e"
            );
        }
        echo json_encode($response); 
    ?&gt;
	';
?>
<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8"/>
		<link rel=”canonical” href=”http://www.workster.com.br/simple-scraper/” />
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"/>
		<link rel="stylesheet" type="text/css" href="css/style.css"/>
		<script type="text/javascript" src="js/jquery.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		<script type="text/javascript" src="js/jquery.easing.js"></script>
		<script type="text/javascript" src="js/script.js"></script>
		<meta property="og:url" content="http://www.workster.com.br/simple-scraper/" />
		<meta property="og:site_name" content="Simple Scraper" />
		<meta property="og:title" content="Simple Scraper by Workster" />
		<meta property="og:description" content="Simple Scraper is a PHP class to scrape Open Graph Protocol and other micro/meta data." />
		<meta property="og:image" content="http://www.workster.com.br/assets/workster-logo.png" />
		<title>Simple Scraper Demo</title>
		<style type="text/css">
		</style>
	</head>
	<body id="home">
<!-- ############################################################################################################### -->
		<div class="navbar navbar-fixed-top">
			<nav class="navbar-inner">
				<div class="container">
					<div class="row row-nav">
						<div class="span12 navscroll">
							<a class="brand" href="#home">Simple Scraper</a>
							<ul class="nav pull-right">
								<li><a href="#home"><i class="icon-home"></i> Home</a></li>
								<li><a href="#intro"><i class="icon-align-left"></i> Intro</a></li>
								<li><a href="#usage"><i class="icon-pencil"></i> Usage</a></li>
								<li><a href="#demo"><i class="icon-play"></i> Demo</a></li>
								<li><a href="#methods"><i class="icon-list"></i> Methods</a></li>
								<li><a href="#license"><i class="icon-briefcase"></i> License</a></li>
								<li><a href="#credits"><i class="icon-thumbs-up"></i> Credits</a></li>
							</ul>
						</div><!-- .span12 -->
					</div><!-- .row -->
				</div><!-- .container -->
			</nav><!-- navbar-inner -->
		</div><!-- navbar -->
<!-- ############################################################################################################### -->
		<div class="container">
<!-- --------------------------------------------------------------------------------------------------------------- -->
			<div class="row">
				<div class="span12">
					<header class="hero-unit">
						<h1>Simple Scraper</h1>
						<p>
							A PHP class to fetch Open Graph Protocol data,
							Twitter Card data and/or meta tags data.
						</p>
						<a href="https://github.com/ramaismon/simple-scraper" target="_blank" class="btn btn-large btn-success">
							Download from GitHub
						</a>
					</header>
				</div>
			</div><!-- .row -->
<!-- --------------------------------------------------------------------------------------------------------------- -->
			<div id="intro" class="row">
				<section class="span6">
					<h2>Intro</h2>
					<p>
						This is a class developed in PHP to scrape meta content on demand
						as Facebook and Twitter do. The class itself, only do the back-end
						work of fetching the data and the front-end is not included.
						Anyway, you will find an example in this page that shows both
						working together.
					</p>
					<p>
						You can contribute to the project by warning me about bugs or
						forking the project on GitHub.
					</p>
					<p>
						You can adapt it as you prefer, since
						it is under the terms of MIT License.
					</p>
				</section>
				<section class="span6">
					<h2>Thank or curse me:</h2>
					<a class="twitter-timeline" href="https://twitter.com/ramaismon" data-widget-id="322926143655251968">Tweets de @ramaismon</a>
					<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
				</section>
			</div><!-- .row -->
<!-- --------------------------------------------------------------------------------------------------------------- -->
			<div id="usage" class="row">
				<section class="span12">
					<h2>Usage</h2>
					<h3>HTML</h3>
					<pre><?php echo $html ?></pre>
                        <h3>JavaScript</h3>
						<pre><?php echo $javascript ?></pre>
                        <h3>PHP</h3>
    					<pre><?php echo $php ?></pre>
				</section>
			</div><!-- .row -->
<!-- --------------------------------------------------------------------------------------------------------------- -->
			<div id="demo" class="row">
				<section class="span12">
					<h2>Demo</h2>
				</section>
				<section class="span6">
					<h3>Input:</h3>
					<p>
						Paste an URL of any site that contains Open Graph Protocol microdata and then press
						"Scrape!". Results will appear on the right.
					</p>
					<p>
						<i><strong>OBS:</strong> If you want, you can use this site (http://www.workster.com.br/simple-scraper/)</i>
					</p>
					<form class="form form-inline">
						<label><strong>URL:</strong> <input id="url" type="url" placeholder="type your URL"/></label>
						<button id="submit" type="submit" value="Scrape!" class="btn btn-success">Scrape!</button>
					</form>
				</section>
				<section class="span6">
					<h3>Result:</h3>
					<div class="tabbable">
						<ul class="nav nav-tabs">
							<li class="active"><a href="#scraped" data-toggle="tab">Result</a></li>
							<li><a href="#varcontent" data-toggle="tab">Variable Content</a></li>
						</ul>
						<div class="tab-content">
							<div id="scraped" class="well tab-pane active">
								<div id="scraped-content">
									<figure id="image-wrap">
										<img id="image" src="img/image.jpg">
									</figure>
									<div>
										<h4>
											<a id="title" href="javascript:void(0)" target="_blank">
												Title will appear here...
											</a>
										</h4>
										<p id="description">... and description here</p>
									</div>
								</div>
							</div>
							<div id="varcontent" class="tab-pane" >
								<pre id="dump"></pre>
							</div>
						</div>
					</div><!-- .tabbable -->
				</section>
			</div><!-- .row -->
<!-- --------------------------------------------------------------------------------------------------------------- -->
			<div id="methods" class="row">
				<section class="span12">
					<h2>Methods</h2>
					<dl class="code">
						<dt><code>array SimpleScraper::getOGP(void)</code></dt>
						<dd>
							Returns an array containing OGP meta values. 
							The array is indexed by the property attribute of the meta tag.
						</dd>
						<dt><code>array SimpleScraper::getTwitter(void)</code></dt>
						<dd>
							Returns an array containing Twitter meta values. 
							The array is indexed by the name attribute of the meta tag.
						</dd>
						<dt><code>array SimpleScraper::getMeta(void)</code></dt>
						<dd>
							Returns an array containing non OGP and non TwitterCard meta values. 
							The array is indexed by the name attribute of the meta tag.
						</dd>
						<dt><code>array SimpleScraper::getAllData(void)</code></dt>
						<dd>
							Returns an array containing three arrays. The indexes are 'ogp', 'twitter' and 'meta' and
							they correspond to the arrays returned by <code>SimpleScraper::getOGP(void)</code>,
							<code>SimpleScraper::getTwitter(void)</code> and <code>SimpleScraper::getMeta(void)</code>
							respectively.
						</dd>
						<dt><code>string SimpleScraper::getHTTPCode(void)</code></dt>
						<dd>
							Returns the HTTP code of the response that SimpleScraper got when crawled the URL.
						</dd>
						<dt><code>string SimpleScraper::getContentType(void)</code></dt>
						<dd>
							Returns the MIME type of the response that SimpleScraper got when crawled the URL.
						</dd>
						<dt><code>string SimpleScraper::getContent(void)</code></dt>
						<dd>
							Returns the content of the response that SimpleScraper got when crawled the URL.
							Notice that this can be other MIME types other than 'text/html'.
						</dd>
					</dl>
				</section>
			</div><!-- .row -->
<!-- --------------------------------------------------------------------------------------------------------------- -->
			<div id="license" class="row">
				<section class="span12">
					<h2>License</h2>
					<p>
						<strong>SimpleScraper.class.php</strong>
					</p>
					<p>
						<strong>Copyright (c) 2013 Ramon Kayo</strong>
					</p>
					<p>
						Permission is hereby granted, free of charge, to any person obtaining a copy 
						of this software and associated documentation files (the "Software"), to     
						deal in the Software without restriction, including without limitation the   
						rights to use, copy, modify, merge, publish, distribute, sublicense, and/or  
						sell copies of the Software, and to permit persons to whom the Software is   
						furnished to do so, subject to the following conditions:  
					</p>
					<p>
						The above copyright notice and this permission notice shall be included in   
						all copies or substantial portions of the Software.  
					</p>
					<p>
						THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR   
						IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,     
						FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE  
						AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER       
						LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING      
						FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS 
						IN THE SOFTWARE.
					</p>
				</section>
			</div><!-- .row -->
<!-- --------------------------------------------------------------------------------------------------------------- -->
			<div id="credits" class="row">
				<section class="span12">
					<h2>Credits</h2>
					<ul>
						<li>
							<strong><a href="http://twitter.github.io/bootstrap/" target="_blank" rel="nofollow">Twitter Bootstrap:</a></strong> 
							This site was coded lightning-fast thanks to Bootstrap.
						</li>
						<li>
							<strong><a href="http://glyphicons.com/" target="_blank" rel="nofollow">Glyphicons:</a></strong> 
							We use awesome icons thanks to Glyphicons.
						</li>
						<li>
							<strong><a href="http://stackoverflow.com/" target="_blank" rel="nofollow">StackOverflow:</a></strong> 
							I don`t know what I would do without StackOverflow.
						</li>
					</ul>
				</section>
			</div><!-- .row -->
		</div><!-- .container -->
<!-- --------------------------------------------------------------------------------------------------------------- -->
		<footer class="navbar navbar-fixed-bottom">
			<nav class="navbar-inner">
				<div class="container">
					<div class="row row-nav">
						<div class="span12">
							<ul class="nav pull-right">
								<li><a href="http://www.workster.com.br" target="_blank">dev@workster</a></li>
							</ul>
						</div><!-- .span12 -->
					</div><!-- .row -->
				</div><!-- .container -->
			</nav><!-- navbar-inner -->
		</footer>
	</body>
</html>