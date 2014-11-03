$(function(){
	$('#submit').click(function(){
		if ($('#url')[0].checkValidity() && $.trim($('#url').val())) {
			var url = $('#url').val();
			$('#url').prop('disabled', true);
			$('#submit').prop('disabled', true);
			$.post(
				'doscrape.php',
				{'url' : url},
				function(json) {
					console.log(json);
					if (json.success) {
						if ($.trim(json.ogp.title) != '') {
							$('#scraped-content').fadeOut('slow', function(){
								$('#scraped-content-title').text(json.ogp.title);
								$('#scraped-content-title').attr('href', json.ogp.url);
								$('#scraped-content-description').text(json.ogp.description);
								$('#scraped-content-image').attr('src', json.ogp.image);
								$('#variables-content').text(json.dump);
								$('#scraped-content').fadeIn();
							});
						} else {
							$('#scraped-content').fadeOut('slow', function(){
								$('#scraped-content-title').text('Title will appear here...');
								$('#scraped-content-title').attr('href', 'javascript:void(0)');
								$('#scraped-content-description').text('... and description here');
								$('#scraped-content-image').attr('src', 'img/example.jpg');
								$('#variables-content').text(json.dump);
								$('#scraped-content').fadeIn();
							});
						}
						$('#url').val('').prop('disabled', false);
						$('#submit').prop('disabled', false);
					} else {
						alert('Something went wrong. Please, look the console.');
						console.log(json.log);
					}
				},
				'json'
			);
		} else {
			alert('Invalid URL.');
		}
		return false;
	});
	
	$('.main-nav-link, .navbar-brand, #cta-button').click(function(event){
		var anchor = $(this);
        $('html, body').stop().animate({
            scrollTop: $(anchor.attr('href')).offset().top - 50
        }, 1500,'easeInOutExpo');
        
        $('.navbar-collapse').removeClass('in');
        $('.main-nav li').removeClass('active');
        anchor.parent().addClass('active');
        return false;
    });
});