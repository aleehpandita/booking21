var Loader = (function() {
  var loaderElement = document.getElementById('loader')

  /*var eventFunction = function (e) {
    getElement(id).classList.remove('visivility')
  }*/
  var getElement = (id) => {
    if (id) {
      return document.getElementById(id)
    }
    return document.getElementById('loader')
  }
  const html = `<div class="spinner-grow m-auto text-color1" role="status"><span class="visually-hidden">Loading...</span></div>`
  return {
    open: function (id) {
      getElement(id).innerHTML = html
      getElement(id).classList.remove('animate__zoomOut')
      getElement(id).classList.add('visivility', 'animate__zoomIn')
    },
    close: function(id) {
      getElement(id).addEventListener('animationend', (e) => {
        getElement(id).classList.remove('visivility')
      }, {once : true});
      getElement(id).classList.add('animate__zoomOut')
    }
  }
}())
export default Loader