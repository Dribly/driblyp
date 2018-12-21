
// require('./components/like_button');
import TapPage from './components/TapPage'
import ReactDOM from 'react-dom'
import React from 'react'
// import TapPage from 'components/like_button'


// if ( document.querySelector('#clock_container')) {
    // find element by id
    const element =  document.querySelector('#clock_container')
    // create new props object with element's data-attributes
    // result: {tsId: "1241"}
console.log(element.dataset)
    const props = Object.assign({}, element.dataset)

    // render element with props (using spread)
    ReactDOM.render(<TapPage {...props}/>, element);
// }
// const domContainer   = document.querySelector('#clock_container');
// ReactDOM.render(<TapPage />, domContainer);