$( document ).ready(function() {

	$('#search_input').keyup(function() {
//		console.log( $(this).val() );
		if( $(this).val().length >= 2 ) {
			var ajaxUrl;
			var searchInput = $(this).val();
			if( $('#index_bool').val() == 1 ) {
				ajaxUrl = 'backend/ajax/search.php';
			} else {
				ajaxUrl = '../../backend/ajax/search.php';
			}
//			console.log("ajaxUrl: " + ajaxUrl);
			$.ajax({
				method: 'POST',
				url: ajaxUrl,
				dataType: 'json',
				data: { search: searchInput },
				success: function(answer) {
//					console.log(answer);
					if(answer.status == true) {
						$('#search_result').html('');
						var htmlString = '';
						var articleId;
						var articleLink;
						var articleTitleSubtitle;
						var regexp = new RegExp(searchInput, 'gi');
						var arrayMatch, countArrayMatch;
						var arraySplit, countArraySplit;
						var highlightedText;
						for(var i=0; i < answer.data.length; i++) {
							articleId = answer.data[i].id;
							if( $('#index_bool').val() == 1 ) {
								articleLink = 'frontend/html/article.php?id=';
							} else {
								articleLink = 'article.php?id=';
							}
							articleTitleSubtitle = answer.data[i].title_subtitle;
							arrayMatch = articleTitleSubtitle.match(regexp);
							arraySplit = articleTitleSubtitle.split(regexp);
							countArrayMatch = arrayMatch.length;
							countArraySplit = arraySplit.length;
							console.log(arrayMatch);
							console.log('length of arrayMatch: ' + countArrayMatch);
							console.log(arraySplit);
							console.log('length of arraySplit: ' + countArraySplit);
							highlightedText = '';
							for(var j=0; j<countArraySplit; j++) {
								if (typeof arrayMatch[j] == 'undefined') {
									highlightedText = highlightedText + arraySplit[j];
								} else {
									highlightedText = highlightedText + arraySplit[j] + '<span class="search-highlight">' + arrayMatch[j] + '</span>';
								}
							}
							console.log('highlighted text: ' + highlightedText);
//							htmlString = htmlString + '<a class="search-link" href="'+articleLink+articleId+'">'+articleTitleSubtitle+'</a><br/>';
							htmlString = htmlString + '<a class="search-link" href="'+articleLink+articleId+'">'+highlightedText+'</a><br/>';
						}
						$('#search_result').html(htmlString);
						$('#search_result').show();
					} else {
						$('#search_result').hide();
						$('#search_result').html('');
					}
				}
			});
		} else {
			$('#search_result').hide();
			$('#search_result').html('');
		}
	});

	$(document).click(function() {
		    $('#search_result').hide();
	});

});
