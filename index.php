<?php
date_default_timezone_set('America/Sao_Paulo');
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

$title = "Simple Scraper by Ramon Kayo";
$description = "Simple Scraper is a PHP class to scrape Open Graph Protocol and other micro/meta data.";

?>
<!DOCTYPE html>
<html lang="en-US" xmlns:fb="http://ogp.me/ns/fb#">
<head>
	<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
	<link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:400,700,300' rel='stylesheet' type='text/css'>
	<link rel="canonical" href="http://code.ramonkayo.com/simple-scraper/" />
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"/>
	<link rel="stylesheet" type="text/css" href="css/style.css"/>
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/jquery.easing.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<meta name="description" content="<?php echo $description ?>">
	<meta name="keywords" content="scrape, scraper, simple scraper, facebook scrape, twitter scrape, microdata, metadata, meta, plugin, php">
	<meta property="fb:profile_id" content="100006394837452"/> 
	<meta property="og:url" content="http://code.ramonkayo.com/simple-scraper/" />
	<meta property="og:site_name" content="<?php echo $title ?>" />
	<meta property="og:type" content="article"/> 
	<meta property="og:article:author" content="http://www.facebook.com/ramonztro"/> 
	<meta property="og:title" content="<?php echo $title ?>" />
	<meta property="og:description" content="<?php echo $description ?>" />
	<meta property="og:image" content="http://code.ramonkayo.com/simple-scraper/img/ramonkayo_scrape.jpg" />
	<title><?php echo $title ?></title>
</head>
<body>
	<script>(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=551918161560361";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
	</script>
<!-- --------------------------------------------------------------------------------------------------------------- -->
	<nav class="main-nav navbar navbar-default navbar-fixed-top" role="navigation">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
				    <!-- Brand and toggle get grouped for better mobile display -->
				    <div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#main-nav-links">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="#home">Simple Scraper</a>
				    </div><!-- .navbar-header -->
					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse" id="main-nav-links">
						<ul class="nav navbar-nav">
							<li><a class="main-nav-link" href="#demo"><span class="glyphicon glyphicon-play"></span> Demo</a></li>
							<li><a class="main-nav-link" href="#usage"><span class="glyphicon glyphicon-pencil"></span> Usage</a></li>
							<li><a class="main-nav-link" href="#api"><span class="glyphicon glyphicon-list"></span> API</a></li>
							<li><a class="main-nav-link" href="#license"><span class="glyphicon glyphicon-briefcase"></span> License</a></li>
							<li><a class="main-nav-link" href="#discussion"><span class="glyphicon glyphicon-comment"></span> Discussion</a></li>
						</ul><!-- .navbar-nav -->
					</div><!-- .navbar-collapse -->
				</div><!-- .col -->
			</div><!-- .row -->
		</div><!-- .container -->
	</nav><!-- .main-nav -->
<!-- --------------------------------------------------------------------------------------------------------------- -->
	<section class="content-section" id="home">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<header id="heroshot" class="jumbotron centered">
						<h1>Simple Scraper</h1>
						<p>
							A PHP class to fetch Open Graph Protocol data,
							Twitter Card data and/or meta tags data.
						</p>
						<a href="https://github.com/ramonkayo/simple-scraper" target="_blank" class="btn btn-lg btn-success">
							<span class="glyphicon glyphicon-cloud-download"></span> Download from GitHub
						</a>
					</header>
				</div><!-- .col -->
			</div><!-- .row -->
			<div class="row">
				<div class="col-xs-12 col-sm-6">
					<h2>Intro</h2>
					<p>
						Wether you're building a crawler tool or a simple post system, you'll probably need this class.
					</p>
					<p>
						You know when you paste a link on a Facebook status, then Facebook sums the content up into a box
						containing an image, a title and a description? 
						Simple scraper helps you to do exactly that.
					</p>
					<p>
						This is a class developed in PHP to scrape meta content on demand
						as Facebook and Twitter do. The class itself only do the back-end
						work (fetchs the data). The front-end is not included, but you will 
						find an example in this page that shows both working together.
					</p>
					<p>
						Just include the class file and you're good to go!
					</p>
				</div><!-- .col -->
				<div class="col-xs-12 col-sm-6">
					<h2>About</h2>
					<p>
						This is an open source project and it is licensed under the terms of MIT License.
						Feel free to adapt and redistribute - as long as you don't make commercial use of it.
					</p>
					<p>
						You can contribute to the project by warning me about bugs or
						forking the project on GitHub.
					</p>
					<blockquote>
						<p>
							Empowerment of individuals is a key part of what makes open source work, since in the end, innovations tend to come from small groups, not from large, structured efforts.
						</p>
						<br/>
						<footer>Tim O'Reilly</footer>
					</blockquote>
				</div><!-- .col -->
			</div><!-- .row -->
		</div><!-- .container -->
	</section><!-- #home -->
<!-- --------------------------------------------------------------------------------------------------------------- -->
	<section class="content-section" id="social">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<h2 id="social-title">Recommend it:</h2>
					<span class="social-item social-facebook">
						<fb:like href="http://code.ramonkayo.com/simple-scraper/" layout="button_count" action="like" show_faces="false" share="false"></fb:like>
					</span><!-- .social-facebook -->
					<span class="social-item social-twitter">
						<a href="https://twitter.com/share" class="twitter-share-button" data-url="http://code.ramonkayo.com/simple-scraper/" data-text="Thanks @ramonztro for Simple Scraper!" data-lang="en">Tweetar</a>
						<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
					</span><!-- .social-twitter -->
					<span class="social-item social-plus">
						<div class="g-plusone" data-size="medium" data-annotation="none" data-href="http://code.ramonkayo.com/simple-scraper/"></div>
						<script type="text/javascript">window.___gcfg = {lang: 'pt-BR'};(function() {var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true; po.src = 'https://apis.google.com/js/platform.js'; var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);})();</script>
					</span><!-- .social-plus -->
				</div><!-- .col -->
			</div><!-- .row -->
		</div><!-- .container -->
	</section><!-- #social -->
<!-- --------------------------------------------------------------------------------------------------------------- -->
	<section class="content-section" id="demo">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<h2>Demo</h2>
				</div><!-- .col -->
			</div><!-- .row -->
			<div class="row">
				<div class="col-xs-12 col-sm-6">
					<h3>Input:</h3>
					<p>
						Paste an URL of any site that uses Open Graph Protocol and press
						"Scrape!". Results will appear on the right.
					</p>
					<p>
						<i><strong>OBS:</strong> If you want, you can use this site (http://code.ramonkayo.com/simple-scraper)</i>
					</p>
					<form class="form form-inline">
						<div class="form-group">
    						<label for="url"><strong>URL:</strong></label>
    						<input class="form-control" id="url" type="url" placeholder="type your URL" value="http://code.ramonkayo.com/simple-scraper"/>
  						</div>
						<button id="submit" type="submit" value="Scrape!" class="btn btn-success">Scrape!</button>
					</form>
				</div><!-- .col -->
				<div class="col-xs-12 col-sm-6">
					<h3>Result:</h3>
					<!-- Nav tabs -->
					<ul class="nav nav-tabs">
  						<li class="active"><a href="#scraped" data-toggle="tab">Scraped</a></li>
						<li><a href="#variables" data-toggle="tab">Variable Content</a></li>
					</ul><!-- .nav-tabs -->
					<!-- Tab panes -->
					<div class="tab-content">
  						<div class="tab-pane active" id="scraped">
  							<div id="scraped-content">
								<figure id="scraped-content-image-wrap">
									<img id="scraped-content-image" src="img/example.jpg">
								</figure>
								<div>
									<h4>
										<a id="scraped-content-title" href="javascript:void(0)" target="_blank">
											Title will appear here...
										</a>
									</h4>
									<p id="scraped-content-description">... and description here</p>
								</div>
							</div><!-- #scraped-content -->
  						</div><!-- #scraped -->
 						<div class="tab-pane" id="variables">
  							<pre id="variables-content">Nothing yet. Scrape something.</pre><!-- #variables-content -->
 						</div><!-- #variables -->
					</div><!-- .tab-content -->
				</div><!-- .col -->
			</div><!-- .row -->
		</div><!-- .container -->
	</section><!-- #demo -->
<!-- --------------------------------------------------------------------------------------------------------------- -->
	<section class="content-section" id="usage">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<h2>Usage</h2>
					<h3>HTML</h3>
					<pre><?php echo $html ?></pre>
                    <h3>JavaScript</h3>
					<pre><?php echo $javascript ?></pre>
                    <h3>PHP</h3>
    				<pre><?php echo $php ?></pre>
				</div><!-- .col -->
			</div><!-- .row -->
		</div><!-- .container -->
	</section><!-- #usage -->
<!-- --------------------------------------------------------------------------------------------------------------- -->
	<section class="content-section" id="api">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<h2>API</h2>
					<dl class="api">
						<dt><code>array SimpleScraper::getOgp(void)</code></dt>
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
						<dt><code>string SimpleScraper::getHttpCode(void)</code></dt>
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
				</div><!-- .col -->
			</div><!-- .row -->
		</div><!-- .container -->
	</section><!-- #api -->
<!-- --------------------------------------------------------------------------------------------------------------- -->
	<section class="content-section" id="cta">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 centered">
					<a href="#social" id="cta-button" class="btn btn-lg btn-info"><span class="glyphicon glyphicon-thumbs-up"></span> Like it?</a>
				</div><!-- .col -->
			</div><!-- .row -->
		</div><!-- .container -->
	</section><!-- #social -->
<!-- --------------------------------------------------------------------------------------------------------------- -->
	<section class="content-section" id="license">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<h2>License</h2>
					<p>
						<strong>SimpleScraper.class.php</strong> -
						<strong>Copyright (c) 2013-<?php echo date('Y')?> Ramon Kayo</strong>
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
				</div><!-- .col -->
			</div><!-- .row -->
		</div><!-- .container -->
	</section><!-- #license -->
<!-- --------------------------------------------------------------------------------------------------------------- -->
	<section class="content-section" id="credits">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<h2>Credits</h2>
					<ul>
						<li>
							<strong><a href="http://www.getbootstrap.com/" target="_blank" rel="nofollow">Twitter Bootstrap:</a></strong> 
							This site was coded lightning-fast thanks to Bootstrap. Consider using it on your projects. It's awesome! 
						</li>
						<li>
							<strong><a href="http://glyphicons.com/" target="_blank" rel="nofollow">Glyphicons:</a></strong> 
							We use awesome icons thanks to Glyphicons. You're free to use they're icons as part of the Bootstrap framework. :)
						</li>
						<li>
							<strong><a href="http://stackoverflow.com/" target="_blank" rel="nofollow">StackOverflow:</a></strong> 
							I don't know what I would do without StackOverflow. Believe me: no programmer would. 
						</li>
					</ul>
				</div><!-- .col -->
			</div><!-- .row -->
		</div><!-- .container -->
	</section><!-- #credits -->
<!-- --------------------------------------------------------------------------------------------------------------- -->
	<section class="content-section" id="discussion">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<h2>Discussion</h2>
					<div id="disqus_thread"></div>
					<script type="text/javascript">
				        /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
				        var disqus_shortname = 'coderamonkayocom'; // required: replace example with your forum shortname
				
				        /* * * DON'T EDIT BELOW THIS LINE * * */
				        (function() {
				            var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
				            dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
				            (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
				        })();
				    </script>
    				<noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
    				<a href="http://disqus.com" class="dsq-brlink">comments powered by <span class="logo-disqus">Disqus</span></a>
				</div><!-- .col -->
			</div><!-- .row -->
		</div><!-- .container -->
	</section><!-- #discussion -->
<!-- --------------------------------------------------------------------------------------------------------------- -->
</body>
</html>