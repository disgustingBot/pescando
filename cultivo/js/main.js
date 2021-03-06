

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
      let intersection = [...elemento.classList].filter(value => dont_remove.includes(value));
      // console.log(intersection);
      elemento.classList = []
      intersection.forEach( item => { elemento.classList.add(item) });
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
var middle_screen_timeout;

const alt_ficha = (slug, timer = false) =>{
  let is_ficha_open = (document.querySelector('.general').classList.contains(slug)) ? true : false;

  altClassFromSelector(slug, '.general', ['general'])
  load_images(slug)
  reset_obses()

  if (timer) {
    try { clearTimeout(middle_screen_timeout) } catch {}
    if (is_ficha_open) { return }

    try { sendMessage(document.querySelector('.luke_specie.' + slug).dataset.code) } catch (e) {  }
    middle_screen_timeout = setTimeout(()=>{
      middle_screen_timeout = undefined;
      alt_ficha(slug);
    },timer)
  }
}


const load_images = slug => {
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
}



const reset_obses = _ => {
    // reset obses
    try { clearTimeout(obse_timeout) } catch {}
    obseController.obses.forEach( obse =>{
      obse.observe.forEach( item => { obse.observer.disconnect() });
    })
    obseController.obses=[];
    obse_timeout = setTimeout(()=>{ obseController.setup() },1400)
}




var alphabet = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];



const open_category = slug =>{
  filtered_species = get_species_by_category(slug)

  // get just one occurrence of the first letters
  let full_letters = [...new Set(filtered_species.map(specie => specie.slug[0]))]
  // get the empty letters
  let empty_letters = alphabet.filter(letter => !full_letters.includes(letter))

  // clear the empty classes
  if (document.querySelector('.luke_item.last')) {
    altClassFromSelector('last', '.luke_item.last')
  }
  altClassFromSelector('empty', '.luke_item.empty')
  altClassFromSelector('full', '.luke_item.full')

  add_full_class_to_letters( full_letters )
  add_empty_class_to_letters( empty_letters )

  let full_items = document.querySelectorAll('.luke_item.full')
  // console.log(full_items);
  let last_full = full_items[full_items.length - 1];
  // console.log(last_full);
  last_full.classList.add('last')

  // selects indexed letter in HTML
  let letter = document.querySelector('.luke_item.'+full_letters[0])
  // let letter = document.querySelector('.luke_scroll > :nth-child('+index+')')
  // scrolls to the letter
  document.querySelector('.luke_viw').scrollLeft = letter.offsetLeft;
  // activates the category selection
  altClassFromSelector(slug, '.anakin', ['anakin'])
}


const get_species_by_category = slug => {
  // get's the corresponding species to that category
  let filtered_species = species.filter( specie => (specie.category == slug) ? slug : false )
  // return sorted by letter
  return filtered_species.sort((a, b) => a.slug.localeCompare(b.slug))
}

const add_empty_class_to_letters = letters => {
  letters.forEach( letter => {
    altClassFromSelector('empty', '.luke_item.'+letter)
  });
}

const add_full_class_to_letters = letters => {
  letters.forEach( letter => {
    altClassFromSelector('full', '.luke_item.'+letter)
  });
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
      // console.log(this.obses);
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
if(typeof(redirect_time) !== 'undefined') {
  let current_time = 0;

  setInterval(() => {
    current_time++;
    console.log(current_time+' >= '+redirect_time);
    if(current_time >= redirect_time) {
      const urlSearchParams = new URLSearchParams(window.location.search);
      const params = Object.fromEntries(urlSearchParams.entries());
      // console.log(params.central);

      reset_current_time();
      central = (params.central == 1) ? '?central=1' : '';
      window.location.href = 'inc.session.end.php' + central;
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
}
