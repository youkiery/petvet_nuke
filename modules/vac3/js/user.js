var keypress = 0;
var blur = 0;

$(document).ready(() => {
  $(".suggest_input").keyup(() => {
    if (!keypress) {
      keypress = 1
      setTimeout(() => {
        keypress = 0
      }, 1000)
    }
  })
  $(".suggest_input").focus((e) => {
    e.target.parentElement.lastElementChild.style.display = "block";
  })
  $(".suggest_input").blur((e) => {
    console.log(e);
    
    e.target.parentElement.lastElementChild.style.display = "block";
  })
})

// .forEach(element => {
//   element.setEventListener("click", () => {
//     console.log(2);
    
//   })
// });

// customer_name.addEventListener("keyup", (e) => {
//   showSuggest(e.target.getAttribute("id"), true);
// })

// customer_phone.addEventListener("keyup", (e) => {
//   showSuggest(e.target.getAttribute("id"), false);
// })

// suggest_name.addEventListener("mouseenter", (e) => {
//   blur = false;
// })
// suggest_name.addEventListener("mouseleave", (e) => {
//   blur = true;
// })
// customer_name.addEventListener("focus", (e) => {
//   suggest_name.style.display = "block";
// })
// customer_name.addEventListener("blur", (e) => {
//   if(blur) {
//     suggest_name.style.display = "none";
//   }
// })
// suggest_phone.addEventListener("mouseenter", (e) => {
//   blur = false;
// })
// suggest_phone.addEventListener("mouseleave", (e) => {
//   blur = true;
// })
// customer_phone.addEventListener("focus", (e) => {
//   suggest_phone.style.display = "block";
// })
// customer_phone.addEventListener("blur", (e) => {
//   if(blur) {
//     suggest_phone.style.display = "none";
//   }
// })