

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





var obse_timeout;

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




const alt_ficha = slug =>{
  obseController.obses.forEach( obse =>{
    obse.observe.forEach( item => { obse.observer.disconnect() });
  })
  obseController.obses=[];
  altClassFromSelector(slug, '.general', ['general'])
  let map   = document.querySelector('.leia.' + slug + ' .leia_map')
  let icon  = document.querySelector('.leia.' + slug + ' .leia_hier_icon')
  let image = document.querySelector('.leia.' + slug + ' .leia_image')
  map.setAttribute('src', map.dataset.url)
  icon.setAttribute('data', icon.dataset.url)
  image.setAttribute('src', image.dataset.url)
  // console.log(image);
  try { clearTimeout(obse_timeout) } catch {}
  obse_timeout = setTimeout(()=>{ obseController.setup() },1400)
}






/*

OBSE:
funcion para activar y desactivar elementos usando scroll como disparador

*/
// const set_obses = () => {
  obseController = {
    obses:[],
    setup:()=>{
      // console.log(this.obses);
      this.obses = [];
      if (document.querySelectorAll('.Obse')) {
        var obses = document.querySelectorAll('.Obse');
        obses.forEach( obse => {
          obseController.obses.unshift(new Obse(obse))
        });
      }
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
