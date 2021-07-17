

window.onload=()=>{
  // alert('hi there')
  // obseController.setup();
  // set_obses();
  obseController.setup();
}



/*
=altClassFromSelector

alternates a class from a selector of choice, for example:
<div class="someButton" onclick="altClassFromSelector('activ', '#navBar')"></div>
*/
const altClassFromSelector = ( clase, selector, dont_remove = false )=>{
  const selected = [...document.querySelectorAll(selector)];
  selected.forEach(elemento => {
    // const x = d.querySelector(selector);
    // dont_remove should be an array of classes to mantain, then remove all other classes
    if(dont_remove){
      elemento.classList.forEach( item =>{
        if( dont_remove.findIndex( element => element == item) == -1 && item!=clase ){
          elemento.classList.remove(item);
        }
      });
    }

    if(elemento.classList.contains(clase)){
      if(dont_remove){
        if( dont_remove.findIndex( element => element == clase) == -1 ){
          elemento.classList.remove(clase)
        }
      } else {
        elemento.classList.remove(clase)
      }
    }else{
      if(clase){
        elemento.classList.add(clase)
      }
    }
  })
}






const back_btn = () => {
  obseController.obses.forEach( obse =>{
    obse.observe.forEach( item => { obse.observer.disconnect() });
  })
  obseController.obses=[];
  try { clearTimeout(obse_timeout) } catch {}
  obse_timeout = setTimeout(()=>{ obseController.setup() },1400)

  if (document.querySelector('.general').classList.length != 1) {
    altClassFromSelector('', '.general', ['general'])
    return
  } else {
    altClassFromSelector('', '.anakin', ['anakin'])
  }
}



var obse_timeout;
var ficha_timeout;

const alt_ficha = (slug, timer = false) =>{
  obseController.obses.forEach( obse =>{
    obse.observe.forEach( item => { obse.observer.disconnect() });
  })
  obseController.obses=[];
  altClassFromSelector(slug, '.general', ['general'])
  let map     = document.querySelector('.leia.' + slug + ' .leia_map')
  let icon    = document.querySelector('.leia.' + slug + ' .leia_hier_icon')
  let image   = document.querySelector('.leia.' + slug + ' .leia_image')
  let map_big = document.querySelector('.leia.' + slug + ' .magnified_map_img')
  map.setAttribute('src', map.dataset.url)
  icon.setAttribute('data', icon.dataset.url)
  image.setAttribute('src', image.dataset.url)
  map_big.setAttribute('src', map_big.dataset.url)
  if (document.querySelector('.leia.' + slug + ' .magnified_map').classList.contains('active')) {
    document.querySelector('.leia.' + slug + ' .magnified_map').classList.remove('active')
  }
  // console.log(image);
  try { clearTimeout(obse_timeout) } catch {}
  try { clearTimeout(ficha_timeout) } catch {}
  obse_timeout = setTimeout(()=>{ obseController.setup() },1400)
  if (timer) { setTimeout(()=>{ alt_ficha(slug) },timer) }
}








const open_category = slug =>{
  // get's the corresponding species to that category
  let filtered_species = species.filter( specie => (specie.category == slug) ? slug : false )
  // sort by letter
  filtered_species = filtered_species.sort((a, b) => a.slug.localeCompare(b.slug))
  // get index of first letter, according to HTML logic (2 elements per letter and starting from 1 not 0)
  let index = (alphabet.indexOf(filtered_species[0].slug[0]) + 1) * 2
  // selects indexed letter in HTML
  let letter = document.querySelector('.luke_scroll > :nth-child('+index+')')
  // scrolls to the letter
  document.querySelector('.luke_viw').scrollLeft = letter.offsetLeft;
  // activates the category selection
  altClassFromSelector(slug, '.anakin', ['anakin'])
}




/*

OBSE:
funcion para activar y desactivar elementos usando scroll como disparador

*/
// const set_obses = () => {
  obseController = {
    obses:[],
    setup:()=>{
      this.obses = [];
      if (document.querySelectorAll('.Obse')) {
        var obses = document.querySelectorAll('.Obse');
        obses.forEach( obse => {
          obseController.obses.unshift(new Obse(obse))
        });
      }
      console.log(this.obses);
    },
    unobserve:()=>{
      console.log(this.obses);
    }
  }
// }
class Obse {
	constructor(element){
		this.j = 1;
		this.id = element.id;
		this.observe = document.querySelectorAll(element.dataset.observe);
		this.unobserve = element.dataset.unobserve;
    // console.log(element);

    let side = 0;
    // console.log(element.dataset.rootWidth);
    if ( element.dataset.rootWidth ) {
      let width = element.dataset.rootWidth;
      // let total = window.innerWidth;
      let total = element.offsetWidth;
      side = (total - width) / 2;
    }
    // console.log(side);
    // console.log("0px -"+side+"px 0px -"+side+"px");

    // this.options = { root: null, threshold: 1, rootMargin: "-"+side+"px 0px -"+side+"px 0px" };
		this.options = { root: element, threshold: 0.1, rootMargin: "0px -"+side+"px 0px -"+side+"px" };
		this.observer = new IntersectionObserver(function(entries, observer){
			entries.forEach(entry => {
        let clase = (entry.target.dataset.clase) ? entry.target.dataset.clase : 'observed';
        // console.log('hi');
				// const x = d.querySelector('#'+this.id);
				if(entry.isIntersecting){
          // console.log(entry.target);
					// if(!reverse){
					element.classList.add(clase)
					// } else {
						// x.classList.remove('observed')
						// }
					if(this.unobserve=='true'){observer.unobserve(entry.target)}
				} else {
				// if(!reverse){
					element.classList.remove(clase)
					// } else {
						// x.classList.add('observed')
						// }
				}
			})
		}, this.options);
    // console.log(this.observer.root);

		this.activate();

	}

	activate(){
		// console.log()
		// d.querySelectorAll(observado).forEach(e => {
    this.observe.forEach( item => {
      this.observer.observe(item);
    });

		// })
	}
}


function in_animate_screen(e) {
  e.preventDefault();
  altClassFromSelector('in_animate_screen_display', '.in_animate_screen');

  setTimeout(() => {
    location.href = e.target.href;
  }, 500);
}

function out_animate_screen() {
  altClassFromSelector('in_animate_screen_display', '.in_animate_screen');

  setTimeout(() => {
    let in_animate_screen = document.querySelector('.in_animate_screen');
    in_animate_screen.remove();
  }, 1000);
}







obseController.setup();



// Start interactivity timer
let current_time = 0;
let is_video_playing = false;

setInterval(() => {
  if(is_video_playing) reset_current_time();
  else current_time++;

  if(current_time >= redirect_time) {
    reset_current_time();
    window.location.href = 'index.php';
  }
}, 1000);

reset_timer_events = ['click', 'touchstart']
reset_timer_events.forEach(event => {
  window.addEventListener(event, () => {
    reset_current_time();
  });
});

// Reset current time
const reset_current_time = () => { current_time = 0; }
