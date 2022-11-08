var CYGNET = {
	init: function () {
		// init code goes here
		CYGNET.researchAnnouncementsListing;
		CYGNET.researchAnnouncementsListing.init();
		//CYGNET.newsdetailSlider();
		CYGNET.pressReleaseList;
		CYGNET.pressReleaseList.init();

		CYGNET.searchResultList;
		CYGNET.searchResultList.init();
		CYGNET.popupVideo();
		CYGNET.youTubesMakeDynamic();
		
		// Push all external facing URLs to new window
		var links = jQuery("a[href^='http']");
		var domain = document.location.host;
		links.each(function (index, link) {
			if (!jQuery(link).attr("href").match(domain)) {
				jQuery(link).attr("target", "_blank");
			}
		});
	},

	/*
	Function Name : blogStickySidebar
	script to make for sticky Sidebar and sticky share button
	@version: 04-11-2019 updated
	*/
	blogStickySidebar: function () {
		if (jQuery('.sidebar').length > 0) {
			var stickySidebar = new StickySidebar('.sidebar', {
				topSpacing: 122,
				bottomSpacing: 20,
				resizeSensor: true,
				containerSelector: false,
				stickyClass: 'is-affixed',
				containerSelector: '.article-container',
				innerWrapperSelector: '.sidebar-inner',

			})
			stickySidebar.updateSticky();
		}
		if (jQuery('.blog-share-social').length > 0) {
			var stickySidebar = new StickySidebar('.blog-share-social', {
				topSpacing: 142,
				bottomSpacing: 20,
				resizeSensor: true,
				containerSelector: false,
				stickyClass: 'is-affixed-2',
				containerSelector: '.blog-detail',
				innerWrapperSelector: '.sidebar-social',

			})
			stickySidebar.updateSticky();
		}
	},
	
	/* Listing using AJAX */
	researchAnnouncementsListing: {
		/*
		Register all events or call some functions on page load.
		*/
		init: function () {
			//Load content on page load
			if (jQuery('.casestudy-page-listing').length > 0) {
				CYGNET.researchAnnouncementsListing.caseStudyListing(jQuery('.submit-all-filter').serialize(), 1);

			} else if (jQuery('.blog-page-listing').length > 0) {
				CYGNET.researchAnnouncementsListing.blogListing(jQuery('.submit-all-filter').serialize(), 1);

			} else if (jQuery('.whitepaper-page-listing').length > 0) {
				CYGNET.researchAnnouncementsListing.whitePaperListing(jQuery('.submit-all-filter').serialize(), 1);

			} else if (jQuery('.ebook-page-listing').length > 0) {
				CYGNET.researchAnnouncementsListing.ebookListing(jQuery('.submit-all-filter').serialize(), 1);

			} else if (jQuery('.webinar-page-listing').length > 0) {
				CYGNET.researchAnnouncementsListing.webinarsListing(jQuery('.submit-all-filter').serialize(), 1);

			} else if (jQuery('.ourleaders-page-listing').length > 0) {
				CYGNET.researchAnnouncementsListing.leadersListing(jQuery('.submit-all-filter').serialize(), 1);

			} else if (jQuery('.in-the-news-page-listing').length > 0) {
				CYGNET.researchAnnouncementsListing.inthenewsListing(jQuery('.submit-all-filter').serialize(), 1);
			}

			//Clear all the filters on button click
			jQuery('#clear-filter-research').click(CYGNET.researchAnnouncementsListing.clearAllFilters);

			//Cleck event for pagination page number click
			jQuery(document).on('click', '.pagination-link', CYGNET.researchAnnouncementsListing.processPageNumber);

			// Button click filter
			jQuery('#filter_submit').click(CYGNET.researchAnnouncementsListing.processFieldData);
		},

		/*
		Submit all filter data on checkbox change or textfield blur event.
		*/
		processFieldData: function (event) {
			jQuery('.wrapper-first-second-section').addClass('hidden');
			var currentPage = (event.data == null) ? 1 : (event.data);
			var formData = jQuery('.submit-all-filter').serialize();

			//Load content on filter condition
			if (jQuery('.casestudy-page-listing').length > 0) {
				CYGNET.researchAnnouncementsListing.caseStudyListing(formData, currentPage);

			} else if (jQuery('.blog-page-listing').length > 0) {
				CYGNET.researchAnnouncementsListing.blogListing(formData, currentPage);

			} else if (jQuery('.whitepaper-page-listing').length > 0) {
				CYGNET.researchAnnouncementsListing.whitePaperListing(formData, currentPage);

			} else if (jQuery('.ebook-page-listing').length > 0) {
				CYGNET.researchAnnouncementsListing.ebookListing(formData, currentPage);

			} else if (jQuery('.webinar-page-listing').length > 0) {
				CYGNET.researchAnnouncementsListing.webinarsListing(formData, currentPage);

			} else if (jQuery('.ourleaders-page-listing').length > 0) {
				CYGNET.researchAnnouncementsListing.leadersListing(formData, currentPage);

			} else if (jQuery('.in-the-news-page-listing').length > 0) {
				CYGNET.researchAnnouncementsListing.inthenewsListing(formData, currentPage);
			}
		},

		/*
		Clear all filter on button click.
		*/
		clearAllFilters: function () {
			//Load content on clear button click
			jQuery('.filter-by-industry').val('').trigger('change');
			jQuery('.filter-by-solution').val('').trigger('change');
			jQuery('.filter-by-country').val('').trigger('change');
			jQuery('.filter-by-category').val('').trigger('change');

			if (jQuery('.casestudy-page-listing').length > 0) {
				CYGNET.researchAnnouncementsListing.caseStudyListing();

			} else {
				CYGNET.researchAnnouncementsListing.blogListing();
			}
		},

		/*
		Case Study Listing by AJAX
		*/
		caseStudyListing: function (formData, currentPage) {
			var pageNumber = (typeof currentPage == 'undefined') ? 1 : currentPage;
			var industryId = jQuery('.filter-by-industry').val();
			var solutionId = jQuery('.filter-by-solution').val();
			var countryId = jQuery('.filter-by-country').val();

			jQuery.ajax({
				url: ajaxPath.ajaxurl,
				type: "POST",
				data: {
					'action': 'get_casestudy_listing_data',
					'form_data': formData,
					'current_page': pageNumber,
					'flag': 'casestudy_listing',
					'ind_term_id': industryId ? industryId : '',
					'sol_term_id': solutionId ? solutionId : '',
					'con_term_id': countryId ? countryId : ''
				},
				success: function (response) {
					jQuery('.casestudy-container').html(response);
					return false;
				}
			});
		},

		/*
		Blog Listing by AJAX
		*/
		blogListing: function (formData, currentPage) {
			var pageNumber = (typeof currentPage == 'undefined') ? 1 : currentPage;
			var categoryId = jQuery('.filter-by-category').val();

			jQuery.ajax({
				url: ajaxPath.ajaxurl,
				type: "POST",
				data: {
					'action': 'get_casestudy_listing_data',
					'form_data': formData,
					'current_page': pageNumber,
					'flag': 'blog_listing',
					'category_id': categoryId ? categoryId : ''
				},
				success: function (response) {
					jQuery('.blog-container').html(response);
					return false;
				}
			});
		},

		/*
		White Paper Listing by AJAX
		*/
		whitePaperListing: function (formData, currentPage) {
			var pageNumber = (typeof currentPage == 'undefined') ? 1 : currentPage;

			jQuery.ajax({
				url: ajaxPath.ajaxurl,
				type: "POST",
				data: {
					'action': 'get_casestudy_listing_data',
					'form_data': formData,
					'current_page': pageNumber,
					'flag': 'whitepaper_listing'
				},
				success: function (response) {
					jQuery('.whitepaper-container').html(response);
					return false;
				}
			});
		},

		/*
		Webinars Listing by AJAX
		*/
		webinarsListing: function (formData, currentPage) {
			var pageNumber = (typeof currentPage == 'undefined') ? 1 : currentPage;

			jQuery.ajax({
				url: ajaxPath.ajaxurl,
				type: "POST",
				data: {
					'action': 'get_casestudy_listing_data',
					'form_data': formData,
					'current_page': pageNumber,
					'flag': 'webinar_listing'
				},
				success: function (response) {
					jQuery('.webinars-container').html(response);
					return false;
				}
			});
		},

		/*
		eBooks Listing by AJAX
		*/
		ebookListing: function (formData, currentPage) {
			var pageNumber = (typeof currentPage == 'undefined') ? 1 : currentPage;

			jQuery.ajax({
				url: ajaxPath.ajaxurl,
				type: "POST",
				data: {
					'action': 'get_casestudy_listing_data',
					'form_data': formData,
					'current_page': pageNumber,
					'flag': 'ebook_listing'
				},
				success: function (response) {
					jQuery('.ebook-container').html(response);
					return false;
				}
			});
		},

		/*
		Our Leaders Listing by AJAX
		*/
		leadersListing: function (formData, currentPage) {
			var pageNumber = (typeof currentPage == 'undefined') ? 1 : currentPage;

			jQuery.ajax({
				url: ajaxPath.ajaxurl,
				type: "POST",
				data: {
					'action': 'get_casestudy_listing_data',
					'form_data': formData,
					'current_page': pageNumber,
					'flag': 'ourleaders_listing'
				},
				success: function (response) {
					jQuery('.our-leaders-container').html(response);
					return false;
				}
			});
		},

		/*
		In the News Listing by AJAX
		*/
		inthenewsListing: function (formData, currentPage) {
			var pageNumber = (typeof currentPage == 'undefined') ? 1 : currentPage;

			jQuery.ajax({
				url: ajaxPath.ajaxurl,
				type: "POST",
				data: {
					'action': 'get_casestudy_listing_data',
					'form_data': formData,
					'current_page': pageNumber,
					'flag': 'in_the_news_listing'
				},
				success: function (response) {
					jQuery('.in-the-news-container').html(response);
					return false;
				}
			});
		},

		/*
		Send page number to the ajax processing data.
		*/
		processPageNumber: function (event) {
			//var pageNumberClicked = jQuery(event.target).data('page_num');
			var pageNumberClicked = jQuery(event.target.closest('.pagination-link')).data('page_num');
			var objPageNumber = {
				data: pageNumberClicked
			};
			var headerHeight = jQuery(".header").outerHeight();
			
			if (jQuery(".in-the-news-page-listing, .ourleaders-page-listing, .whitepaper-page-listing").length > 0){
				jQuery('html, body').animate({
					scrollTop: jQuery(".in-the-news-page-listing, .ourleaders-page-listing, .whitepaper-page-listing").offset().top - headerHeight - 120
				}, 700);
			}
			else{
				jQuery('html, body').animate({
					scrollTop: jQuery(".blog-page-listing, .webinar-page-listing, .ebook-page-listing, .casestudy-page-listing").offset().top - headerHeight - 120
				}, 700);
			}
			CYGNET.researchAnnouncementsListing.processFieldData(objPageNumber);
		}
	},

	/* Press Release Listing by AJAX */
	pressReleaseList: {
		init: function () {
			//Load content on page load
			if (jQuery('.press-release-page-listing').length > 0) {
				CYGNET.pressReleaseList.pressReleaseListing(jQuery('.submit-all-filter').serialize(), 1);
			}

			//Click event for pagination page number click
			jQuery(document).on('click', '.pagination-links', CYGNET.pressReleaseList.processPageNumber);
		},

		/*
		Submit all filter data on checkbox change or textfield blur event.
		*/
		processFieldData: function (event) {
			jQuery('.wrapper-first-second-section').addClass('hidden');
			var currentPage = (event.data == null) ? 1 : (event.data);
			var formData = jQuery('.submit-all-filter').serialize();

			//Load content on filter condition
			if (jQuery('.press-release-page-listing').length > 0) {
				CYGNET.pressReleaseList.pressReleaseListing(formData, currentPage);
			}
		},

		pressReleaseListing: function (formData, currentPage) {
			var pageNumber = (typeof currentPage == 'undefined') ? 1 : currentPage;

			jQuery.ajax({
				url: ajaxPath.ajaxurl,
				type: "POST",
				data: {
					'action': 'get_press_release_listing',
					'form_data': formData,
					'current_page': pageNumber,
					'flag': 'press_release_listing'
				},
				success: function (response) {
					jQuery('.press-release-container').html(response);
					return false;
				}
			});
		},

		/*
		Send page number to the ajax processing of research-list data.
		*/
		processPageNumber: function (event) {
			//var pageNumberClicked = jQuery(event.target).data('page_num');
			var pageNumberClicked = jQuery(event.target.closest('.pagination-links')).data('page_num');
			var objPageNumber = {
				data: pageNumberClicked
			};
			var headerHeight = jQuery(".header").outerHeight();
			jQuery('html, body').animate({
				scrollTop: jQuery(".press-release-page-listing").offset().top - headerHeight - 120
			}, 700);
			CYGNET.pressReleaseList.processFieldData(objPageNumber);
		}
	},

	/* Search Result Listing by AJAX */
	searchResultList: {
		init: function () {
			// Button click filter
			jQuery('#search_btn').click(CYGNET.searchResultList.processFieldData);
		
			jQuery("#search-input-form, #search-input").submit(function (event) {
				event.preventDefault();
					CYGNET.searchResultList.processFieldData;
				//console.log(CYGNET.searchResultList.processFieldData);
				//console.log("test3");
				 });
		
			//Click event for pagination page number click
			jQuery(document).on('click', '.pagination-lnk', CYGNET.searchResultList.processPageNumber);
		},

		/*
		Submit all filter data on checkbox change or textfield blur event.
		*/
		processFieldData: function (event) {
			var currentPage = (event.data == null) ? 1 : (event.data);
			var keyword = jQuery('.submit-all-filter').serialize();

			//Load content on filter condition
			if (jQuery('.search-page-listing').length > 0) {
				CYGNET.searchResultList.searchResultListing(keyword, currentPage);
			}
		},

		searchResultListing: function (keyword, currentPage) {
			var pageNumber = (typeof currentPage == 'undefined') ? 1 : currentPage;
			var keyword = jQuery('#search-input').val();
			jQuery.ajax({
				url: ajaxPath.ajaxurl,
				type: "POST",
				data: {
					'action': 'get_search_result_listing',
					'keyword': keyword,
					'current_page': pageNumber,
					'flag': 'search_result'
				},
				success: function (response) {
					jQuery('.search-container').html(response);
					return false;
				}
			});
		},

		/*
		Send page number to the ajax processing of research-list data.
		*/
		processPageNumber: function (event) {
			//var pageNumberClicked = jQuery(event.target).data('page_num');
			var pageNumberClicked = jQuery(event.target.closest('.pagination-lnk')).data('page_num');
			var objPageNumber = {
				data: pageNumberClicked
			};
			CYGNET.searchResultList.processFieldData(objPageNumber);
		}
	},
	
	/* Function Name : popupVideo
		you tube video load after button click in
		@version: 2018-09-10 updated
	*/
	popupVideo: function () {
		if (jQuery(".watch-video").length) {
			var videoModal = document.getElementById('videoModal')
			videoModal.addEventListener('show.bs.modal', function () {
				var theModal = "#videoModal",
					videoSRC = jQuery(".watch-video").attr("data-theVideo"),
					videoSRCauto = videoSRC;
				jQuery(theModal + ' iframe').attr('src', videoSRCauto + "?autoplay=1&amp;modestbranding=1&amp;showinfo=0");
				videoModal.addEventListener('hide.bs.modal', function () {
					jQuery(theModal + ' iframe').attr('src', "");
				});
			})
		}
	},
	
	/* Function Name : youTubesMakeDynamic
		you tube video load after button click
		@version: 2018-09-10 updated
	*/
	youTubesMakeDynamic: function () {
		if (jQuery(".youtube-custom").length) {
			var ytIframes = jQuery('iframe[data-src*="youtube.com"]');
			ytIframes.each(function (i, e) {
				var ytFrame = jQuery(e);
				var ytKey; var tmp = ytFrame.attr('data-src').split(/\//); tmp = tmp[tmp.length - 1]; tmp = tmp.split('?'); ytKey = tmp[0];
				var ytLoader = jQuery('<div class="ytLoader">');
				ytLoader.append(jQuery('<div class="cover-bg d-block h-100" style="background-image: url(https://i.ytimg.com/vi/' + ytKey + '/sddefault.jpg);">'));
				ytLoader.append(jQuery('<svg class="playBtn" xmlns="http://www.w3.org/2000/svg" width="68" height="68" viewBox="0 0 68 68"> <g transform="translate(0 0)"><path d="M325.812-115.873a34.038,34.038,0,0,0-34,34,34.037,34.037,0,0,0,34,34,34.038,34.038,0,0,0,34-34A34.038,34.038,0,0,0,325.812-115.873Zm0,65.167a31.2,31.2,0,0,1-31.167-31.167,31.2,31.2,0,0,1,31.167-31.166,31.2,31.2,0,0,1,31.166,31.166A31.2,31.2,0,0,1,325.812-50.706Z" transform="translate(-291.812 115.873)" /><path d="M337.078-84.814l-19.833-12.75a1.416,1.416,0,0,0-1.444-.053,1.415,1.415,0,0,0-.738,1.244v25.5a1.415,1.415,0,0,0,.738,1.244,1.416,1.416,0,0,0,.678.173,1.407,1.407,0,0,0,.767-.226l19.833-12.75a1.417,1.417,0,0,0,.65-1.191A1.419,1.419,0,0,0,337.078-84.814Z" transform="translate(-289.562 117.623)" /></g></svg>'));
				ytLoader.data('ytFrame', ytFrame);
				ytFrame.replaceWith(ytLoader);
				ytLoader.click(function () {
					var ytFrame = ytLoader.data('ytFrame');
					ytFrame.attr('src', ytFrame.attr('data-src') + '?autoplay=1');
					ytLoader.replaceWith(ytFrame);
					jQuery(".video-box-img").addClass("remove-blue-bg");
				});
			});
		}
	},
	
};