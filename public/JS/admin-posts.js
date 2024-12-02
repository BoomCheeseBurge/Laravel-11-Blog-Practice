
window.addEventListener('reinitTooltips', event => {
    // anything you want to initialize

    // let tooltips = FlowbiteInstances.getInstances('Tooltip');

    // console.log(tooltips);

    // for (const key in tooltips) {

    //     if (tooltips.hasOwnProperty(key)) {
    //         console.log(key, tooltips[key]);
    //     }
    // }

    // re-initialize tooltip object
    // tooltip.init();
});

// --------------------------------------------------------------------------------------------------------------------------------

// Table Column Resize

class Resize {

	constructor() {

		this.resizeColumn = this.resizeColumn.bind(this);

		// Column that is going to be resized
		this.columnResizing = null;

		// Negative offset calculated by column size
		// minus the total X coordinate of the screen.
		this.columnResizingOffset = 0;

		// Function in charge of adding the resize events
		this.AddResizingEvent();
	}

	//
	AddResizingEvent() {

		document.querySelectorAll('thead th').forEach(th => {

			// 'grip' is the element that will enable the cursor to drag and resize the header
			let grip = document.createElement('div');
			grip.style.height = document.querySelector('table').offsetHeight+'px';
			grip.classList.add('grip');

			th.appendChild(grip);

			grip.addEventListener('mousedown', (e) => {

				this.columnResizing = th;
				this.columnResizingOffset = th.offsetWidth - e.pageX;

				// The added class below will allow to draw a tracking line while resizing
				this.columnResizing.classList.add('resizing');

				// Call the 'resizeColumn' callback function when the mouse is dragging the grip element
				document.addEventListener('mousemove', this.resizeColumn);

				//When the mouse click is released, the targeted header should stop resizing,
				// and remove the tracking line
				document.addEventListener('mouseup', () => {
					document.removeEventListener('mousemove', this.resizeColumn);
					this.columnResizing.classList.remove('resizing');
				});
			});
		});
	}

	// Function responsible for updating the size of the column while the 'grip' element is being dragged
	resizeColumn(e) {
		this.columnResizing.style.minWidth = this.columnResizingOffset + e.pageX + 'px';
	}
}

new Resize();

setTimeout(() => {
	Livewire.hook('commit', ({ component, commit, respond, succeed, fail }) => {
		succeed(({ snapshot, effect }) => {
			queueMicrotask(() => {
				initFlowbite();
			})
		})
	})
}, 1000);
