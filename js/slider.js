var slider2 = document.getElementById('sliderDouble');

noUiSlider.create(slider2, {
	start: [ 0, 100 ],
	connect: true,
	range: {
		min:  0,
		max:  100
	}
});