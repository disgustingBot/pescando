

window.onload=()=>{
  // alert('hi there')
    in_animate_screen();
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
  // altClassFromSelector('', '.anakin', ['anakin'])
  altClassFromSelector('', '.shape_screen', ['shape_screen'])
}


let letterController = {
  select: letter =>{
    // console.log(letter);
    altClassFromSelector(letter, '.luke', ['luke'])
  }
}



function in_animate_screen() {
  setTimeout(() => {
    altClassFromSelector('in_animate_screen_display', '.in_animate_screen');
  }, parseFloat(500));
}

// Singleton https://stackoverflow.com/questions/1635800/javascript-best-singleton-pattern
class Anim_Zoom {
  #anim_time;
  #anim_zoom;

  constructor(anim_time = 1, anim_zoom = 2) {
    const instance = this.constructor.instance;

    if (instance) {
      return instance;
    }

    this.constructor.instance = this;

    //
    this.#set_origin();
    this.#anim_time = anim_time;
    this.#anim_zoom = anim_zoom;
  }

  // Info de los textos en el SVG
  #texts      = [...document.querySelectorAll('.shape_screen_img text')];
  #texts_info = this.#texts.map((text) => {
    // Posición de textos en SVG (e es x, f es y)
    const { e, f } = text.transform.baseVal.consolidate().matrix;
    // Tamaño de textos en SVG
    const { width, height } = text.getBBox();
  
    return { e, f, width, height };
  });

  // Centro de la pantalla
  #shape_img    = document.querySelector('.shape_screen_img');
  #shape_styles = window.getComputedStyle(this.#shape_img);
  #shape_svg    = document.querySelector('.shape_screen_img svg');
  #shape_center = {
    x: parseFloat(this.#shape_img.clientWidth) / 2,
    y: parseFloat(this.#shape_img.clientHeight) / 2,
  };
  
  // Set origin al centro de pantalla
  #set_origin = () => {
    this.#shape_img.transformOrigin = `${this.#shape_center.x}px ${this.#shape_center.y}px`;
  }

  // Muestra un punto en el origin
  view_origin = () => {
    let test_circle = document.createElement('div');
    test_circle.className = 'test_circle';
    test_circle.style.left = `${this.#shape_center.x}px`;      
    test_circle.style.top = `${this.#shape_center.y}px`;

    this.#shape_img.appendChild(test_circle);
  }

  // Animacion de zoom
  // Parametro (por ahora): index de la opción a la que se quiere ir
  anim_to_option = (option_index) => {
    // Dirección y distancia de la opción hacia el centro
    let vector_to_center = {
      x : this.#shape_center.x - this.#texts_info[option_index].e - parseFloat(this.#shape_styles.paddingLeft) - this.#texts_info[option_index].width / 2,
      y : this.#shape_center.y - this.#texts_info[option_index].f - parseFloat(this.#shape_styles.paddingTop) + this.#texts_info[option_index].height / 2,
    }
  
    this.#shape_svg.style.transition = `${this.#anim_time}s`;
    this.#shape_svg.style.transform = `translate(${vector_to_center.x}px, ${vector_to_center.y}px)`;
  
    this.#shape_img.style.transition = `${this.#anim_time}s`;
    this.#shape_img.style.transform = `scale(${this.#anim_zoom})`;
  }

  anim_to_center = () => {
    this.#shape_svg.style.transition = `${this.#anim_time}s`;
    this.#shape_svg.style.transform = 'translate(0, 0)';
  
    this.#shape_img.style.transition = `${this.#anim_time}s`;
    this.#shape_img.style.transform = 'scale(1)';
  }
}

// console.log(new Anim_Zoom() === new Anim_Zoom());
let anim_zoom = new Anim_Zoom();

// setTimeout solo para el ejemplo (no es necesario)
setTimeout(() => {
  // Ejemplo in
  anim_zoom.anim_to_option(0);
}, 2000);

setTimeout(() => {
  // Ejemplo out
  anim_zoom.anim_to_center();
}, 4000);

setTimeout(() => {
  // Ejemplo in
  anim_zoom.anim_to_option(7);
}, 6000);

setTimeout(() => {
  // Ejemplo out
  anim_zoom.anim_to_center();
}, 8000);

setTimeout(() => {
  // Ejemplo in
  anim_zoom.anim_to_option(4);
}, 10000);

setTimeout(() => {
  // Ejemplo out
  anim_zoom.anim_to_center();
}, 12000);
