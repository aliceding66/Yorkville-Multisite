//JQuery for the home page carousel slider.

$(function () {
    
	//Clone the first and last item and add them to the end and begining.
	//This is to simulate a circular carousel instead of having the animation
	//reverse back to the front.
	var firstItem = $("li.carouselItem").first().clone();
	var lastItem = $("li.carouselItem").last().clone();
	$("li.carouselItem").last().after( firstItem );
	$("li.carouselItem").first().before( lastItem); 
		
    //declare array variables for global use.
    carouselItems = $("li.carouselItem");
    carouselItemPosition = [];
	totalItems = $("li.carouselItem").length;

    //take all items and place in a single row 
    carouselItems.each(function (index) {
        $(this).css('left', (index-1) * 976 + 'px');
        $(this).attr('id', index );
        if (index == 1)
            $(this).addClass('current'); //Assign the first item as current.
        carouselItemPosition[index] = ((index-1) * 976);
    });

    //Begin an interval to automatically slide the images.
    windowSlideTime = 10000; //Sliding timer
    windowSlide = window.setInterval('slideRight()', windowSlideTime);
});

function slideRight() {
    
    //Local variable
    var currentItem = parseInt($("li.carouselItem.current").attr('id'));

	//If we have reached the last item (ie the cloned of the first item, code 
	//resets the carousel to the first Item, to reset the rotation. 
	//This creates the effect of a circulating carousel.
	if ( currentItem == totalItems - 1 ) {
		carouselItems.each(function (index) {
		
			carouselItemPosition[index] = (index-1) * 976; //reset all positions
			$(this).css( 'left', carouselItemPosition[index] ) //move carousel back to the first item
			
		})
		//assign first item back to being the current
		$(this).removeClass('current'); 
		$("li.carouselItem:nth-child(3)").addClass('current');
	}    
	
	//Section goes through every image and moves it to the left by 976px.
    carouselItems.each(function (index) {

		carouselItemPosition[index] = carouselItemPosition[index] - 976;

		if (parseInt($(this).attr('id')) == currentItem) {
			$(this).removeClass('current');
			$(this).next().addClass('current');
		}
        //causes animation.
        $(this).stop().animate({ left: carouselItemPosition[index] }, 1000, 'swing');
    })
	
    //Reset the interval.
    window.clearInterval(windowSlide);
    windowSlide = window.setInterval('slideRight()', windowSlideTime);
}


function slideLeft() {

    //Local variable
    var currentItem = parseInt($("li.carouselItem.current").attr('id'));
	
	//If we have reached the first item (ie the cloned of the last item, code 
	//resets the carousel to the before last Item, to reset the rotation. 
	//This creates the effect of a circulating carousel.
	if (currentItem == 0) {
		carouselItems.each(function (index) {
			carouselItemPosition[index] = -((totalItems * 976) - (976 * (index + 2)));
			$(this).css( 'left', carouselItemPosition[index] )
		})
		$(this).removeClass('current'); 
		
		//assign the before last item back to being the current
		$("li.carouselItem:nth-child(" + (totalItems - 2) + ")").addClass('current');
	}
	
    //Section goes through every image and moves it to the left by 976px.
    carouselItems.each(function (index) {
		
		//Code retracts 976px to all images and moves current class to the prev item.
		carouselItemPosition[index] = carouselItemPosition[index] + 976;

		if (parseInt($(this).attr('id')) == currentItem) {
			$(this).removeClass('current');
			$(this).prev().addClass('current');
		}
        //causes animation.
        $(this).stop().animate({ left: carouselItemPosition[index] }, 1000, 'swing');
    })

    //Reset the interval.
    window.clearInterval(windowSlide);
    windowSlide = window.setInterval('slideRight()', windowSlideTime);
}